<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use App\Models\MaterialRequisitionCommunication;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialRequisition extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(MaterialRequisitionItem::class, 'material_requisition_id', 'id');
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

            if ($item->payment_status == 0) {
                continue;
            }

            $total += $item->approved_amount;
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

    public function comments(): HasMany
    {
        return $this->hasMany(MaterialRequisitionCommunication::class, 'material_requisition_id', 'id');
    }

    public static function datatable()
    {

        $materialrequisitions = self::where('company_id', Auth::user()->company_id)
            ->with(['tower', 'unit'])
            ->orderBy('date', 'desc');

        if (!Auth::user()->can('Can Approve Cash Requisition')) {
            $materialrequisitions = $materialrequisitions->where('created_by', Auth::user()->id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialrequisitions = $materialrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($materialrequisitions)
            ->addIndexColumn()
            ->addColumn('date_formatted', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->addColumn('tower_name', function ($row) {
                return $row->tower?->name;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if ($row->status == "Pending") {

                    if (Auth::user()->can('edit materialrequisition')) {
                        $btn = $btn . '<a href="' . route('materialrequisition.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                    }

                    if (Auth::user()->can('delete materialrequisition')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                    }
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }

    public static function datatableApproveStepOne()
    {

        $materialrequisitions = self::where('company_id', Auth::user()->company_id)->where('status', 'Pending')->with(['project', 'unit', 'tower', 'unit'])->orderBy('date', 'desc');

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialrequisitions = $materialrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($materialrequisitions)
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
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if ($row->status == "Pending") {

                    $btn = $btn . '<a href="' . route('material.requisitioncommunication.details', $row->id) . '" class="dropdown-item"><i class="fa fa-comment" aria-hidden="true"></i>
                        Comment</a>';

                    $btn = $btn . '<a href="' . route('material.requisition.approve.step.one.details', $row->id) . '" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i>
                        Approve</a>';
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }


    public static function datatableApproveStepTwo()
    {

        $materialrequisitions = self::where('company_id', Auth::user()->company_id)->where('status', 'ApprovedOne')->with(['project', 'unit', 'tower', 'unit'])->orderBy('date', 'desc');

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $materialrequisitions = $materialrequisitions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($materialrequisitions)
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
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                $btn = $btn . '<a href="' . route('material.requisition.approve.step.two.details', $row->id) . '" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i>
                        Approve</a>';

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }
}
