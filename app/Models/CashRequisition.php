<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashRequisition extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function items(): HasMany
    {
        return $this->hasMany(CashRequisitionItem::class, 'cash_requisition_id', 'id');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function unitConfig(): HasOne
    {
        return $this->hasOne(UnitConfiguration::class, 'id', 'unit_config_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_config_id');
    }

    public function createdby(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(RequisitionCommunication::class, 'cash_requisition_id', 'id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public function thisSerial()
    {
        return date('dmY') . $this->id;
    }

    public static function nextSerial()
    {
        $cr = self::latest()->first();
        $lastRow = 0;
        if ($cr) {
            $lastRow = $cr->id;
        }
        return date('dmY') . $lastRow + 1;
    }

    public function RequisitionTotalAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->requisition_amount;
        }

        return $total;
    }

    public function RequisitionTotalApprovedAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->approved_amount;
        }

        return $total;
    }

    public function RequisitionTotalPaidAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->totalPaid();
        }

        return $total;
    }

    public function CashBudgetHeadRequisitionTotalApprovedAmount()
    {
        $total = 0;

        foreach ($this->items as $item) {
            if ($item->budgetHead->type == "Cash") {
                $total += $item->approved_amount;
            }
        }

        return $total;
    }

    public static function datatable()
    {

        $cashrequisitions = self::where('company_id', Auth::user()->company_id)->with(['project', 'unit', 'tower', 'comments', 'unit']);

        if (!Auth::user()->can('Can Approve Cash Requisition')) {
            $cashrequisitions = $cashrequisitions->where('created_by', Auth::user()->id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $cashrequisitions = $cashrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($cashrequisitions)
            ->addIndexColumn()
            ->addColumn('date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->addColumn('project_name', function ($row) {
                return $row->project?->project_name;
            })
            ->addColumn('unit_name', function ($row) {
                return $row->unit?->name;
            })
            ->addColumn('tower_name', function ($row) {
                return $row->tower?->name;
            })
            ->addColumn('item_list', function ($row) {
                $list = "";

                foreach ($row->items as $item) {
                    $list .= $item->budgethead->name . " - " . $item->requisition_amount . "<br>";
                }

                return $list;

            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if ($row->status == "Pending") {

                    if (Auth::user()->can('edit cashrequisition')) {
                        $btn = $btn . '<a href="' . route('cashrequisition.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                    }

                    if (Auth::user()->can('delete cashrequisition')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                    }
                }

                $btn .= '<a href="' . route('requisitioncommunication.details', $row->id) . '" class="dropdown-item"><i class="fa fa-comment" aria-hidden="true"></i>
                Comment</a>';

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->rawColumns(['action', 'item_list'])
            ->toJson();
    }

    public static function approvingDatatable()
    {

        $cashrequisitions = CashRequisition::where('company_id', Auth::user()->company_id)
            ->with(['comments', 'project', 'unit', 'tower'])
            ->whereIn('status', ['Pending', 'Approved'])
            ->orderBy('status', 'desc');

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $cashrequisitions = $cashrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($cashrequisitions)
            ->addIndexColumn()
            ->addColumn('date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->addColumn('this_serial', function ($row) {
                return $row->thisSerial();
            })
            ->addColumn('unit_name', function ($row) {
                return $row->unit->name;
            })
            ->addColumn('tower', function ($row) {
                return $row->tower?->name;
            })
            ->addColumn('vendor_name', function ($row) {
                return $row->remarks;
            })
            ->addColumn('requisition_amount', function ($row) {

                if ($row->status == "Pending") {
                    return $row->RequisitionTotalAmount();
                }

                if ($row->status == "Approved") {
                    return $row->RequisitionTotalApprovedAmount();
                }
            })
            ->addColumn('action', function ($row) {

                $btn = '';
                $cashRequisitionApprovePageUrl = route('cashrequisition.approve.view', $row->id);

                $btn .= '<a class="btn btn-success" href="' . route('requisitioncommunication.details', $row->id) . '" title="Comment"><i class="fa fa-comment" aria-hidden="true"></i>(' . $row->comments->count() . ')</a>';

                if ($row->status != 'Approved') {
                    if (Auth::user()->can('Can Approve Cash Requisition')) {
                        $btn .= '<a class="btn btn-primary ml-1" href="' . $cashRequisitionApprovePageUrl . '" onclick="approveRow(' . $row->id . ')" title="Approve"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> </a>';
                    }
                }

                if ($row->status == 'Approved') {
                    if (Auth::user()->can('Can Approve Cash Requisition')) {
                        $btn .= '<a class="btn btn-primary ml-1" href="' . $cashRequisitionApprovePageUrl . '" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a>';
                    }
                }

                $btn .= '<a target="_blank" title="Requisition Print" class="btn btn-info ml-1" href="' . route('cash.requisition.print', $row->id) . '" ><i class="fa fa-print" aria-hidden="true"></i></a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public static function supplierPaymentDatatable()
    {

        $cashrequisitions = CashRequisition::where('company_id', Auth::user()->company_id)
            ->where('status', 'Approved');

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $cashrequisitions = $cashrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($cashrequisitions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $btn = '<a href="' . route('cashrequisition.payView', $row->id) . '" class="btn btn-primary"> Pay</a>';

                return $btn;

            })
            ->addColumn('formatted_date', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->addColumn('project_name', function ($row) {
                return $row->project->project_name;
            })
            ->addColumn('tower_name', function ($row) {
                return $row->tower->name;
            })
            ->addColumn('approved_amount', function ($row) {
                return $row->RequisitionTotalApprovedAmount();
            })
            ->addColumn('paid_amount', function ($row) {
                return $row->RequisitionTotalPaidAmount();
            })
            ->addColumn('requisition_items', function ($row) {
                $list = "";

                foreach ($row->items as $item) {
                    $list .= $item->budgethead->name . " - " . $item->requisition_amount . "<br>";
                }

                return $list;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
