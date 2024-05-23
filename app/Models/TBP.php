<?php

namespace App\Models;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TBP extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function costHead(): HasOne
    {
        return $this->hasOne(BudgetHead::class, 'id', 'budget_head_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TBPItem::class, 'tbp_id', 'id');
    }

    public function grandTotalApprovedAmount()
    {
        $total = 0;

        if($this->items){

            foreach ($this->items as $item) {
                $total += $item->payment_amount;
            }
        }

        return $total;
    }

    public function grandTotalPaidAmount()
    {
        $total = 0;

        if($this->items){

            foreach ($this->items->where('payment_status', 1) as $item) {
                $total += $item->payment_amount;
            }
        }

        return $total;
    }


    public static function datatable()
    {
        $tbp = TBP::with(['project', 'vendor', 'costHead'])->where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $tbp = $tbp->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($tbp)
            ->addIndexColumn()
            ->addColumn('bill_amount', function ($row) {
                return $row->grandTotalApprovedAmount();
            })
            ->addColumn('cost_head', function ($row) {
                return $row->costHead->name;
            })
            ->addColumn('formatted_date', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->addColumn('tower_list', function ($row) {

                // get item consumption Ids
                $consumptionItemIds = $row->items->pluck('consumption_item_id')->toArray();

                // get consumption Ids from consumption items
                $consumptionIds = DailyConsumptionItem::whereIn('id', $consumptionItemIds)->pluck('daily_consumption_id')->toArray();

                // get tower Ids from consumption Ids
                $towerIds = DailyConsumption::whereIn('id', $consumptionIds)->pluck('tower_id')->toArray();

                // get tower names from tower Ids
                $towerNames = ProjectTower::whereIn('id', $towerIds)->pluck('name')->toArray();

                return $towerNames;

            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('print tbp')) {
                    $btn = $btn . '<a target="_blank" href="' . route('tbp.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';
                }

                if (Auth::user()->can('delete tbp')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->rawColumns(['action', 'material_list'])
            ->toJson();
    }


    public static function datatablePayment()
    {
        $tbp = TBP::with(['project', 'vendor'])->where('company_id', Auth::user()->company_id)->whereHas('items' , function($q){
            $q->where('payment_status', 0);
        });

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $tbp = $tbp->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($tbp)
            ->addIndexColumn()
            ->addColumn('formatted_date', function ($row) {
                return date('d-m-Y', strtotime($row->created_at));
            })
            ->addColumn('requisition_amount', function ($row) {
                return $row->grandTotalApprovedAmount();
            })
            ->addColumn('approved_amount', function ($row) {
                return $row->grandTotalPaidAmount();
            })
            ->addColumn('cost_head', function ($row) {
                $budgetHead = BudgetHead::find($row->budget_head_id);
                return $budgetHead->name;
            })
            ->addColumn('action', function ($row) {

                $btn = '<a href="' . route('tbp.payView', $row->id) . '" class="btn btn-primary">
                         Pay</a>';

                // $btn = '<div class="dropdown show">
                // <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                //   Action
                // </a>
                // <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                // if (Auth::user()->can('print tbp')) {
                //     $btn = $btn . '<a target="_blank" href="' . route('tbp.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                //         Print</a>';
                // }

                // if (Auth::user()->can('delete tbp')) {
                //     $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                // }

                // $btn = $btn . '
                // </div>
                // </div>';

                return $btn;
            })
            ->toJson();
    }
}
