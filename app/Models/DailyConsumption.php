<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyConsumption extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function logisticsAssociate(): HasOne
    {
        return $this->hasOne(Vendor::class, 'id', 'logistics_associate_id');
    }

    public function issue_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function receive_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'received_by');
    }

    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function unit(): HasOne
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(DailyConsumptionItem::class, 'daily_consumption_id', 'id');
    }

    public function grandTotalIssueQty()
    {
        $total = 0;

        if ($this->items) {

            foreach ($this->items as $item) {
                $total += $item->consumption_qty;
            }
        }

        return $total;
    }

    public function grandTotalIssueAmount()
    {
        $total = 0;

        if ($this->items) {

            foreach ($this->items as $item) {
                $total += $item->consumption_qty * $item->budgetHead->materialInfo()->price();
            }
        }

        return $total;
    }

    public static function datatable()
    {

        $branch = DailyConsumption::where('company_id', Auth::user()->company_id)
            ->with(['project', 'unit', 'tower', 'items', 'items.budgetHead'])
            ->orderBy('date', 'desc');

        if (request()->project_id) {
            $branch = $branch->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $branch = $branch->whereIn('project_id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($branch)
            ->addIndexColumn()
            ->addColumn('materials', function ($row) {

                $materials = '';

                if ($row->items) {

                    foreach ($row->items as $item) {
                        $materials .= $item->budgetHead->materialInfo()->name . ' (' . $item->budgetHead->materialInfo()->materialUnit->name . ')'  . ' - ' . $item->issue_qty . '<br>';
                    }
                }

                return $materials;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if ($row->status == 0) {
                    if (Auth::user()->can('edit local issue')) {
                        $btn = $btn . '<a href="' . route('dailyconsumption.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                    }
                }


                if (Auth::user()->can('print local issue')) {
                    $btn = $btn . '<a href="' . route('dailyconsumption.print', $row->id) . '" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i>
                        Print</a>';
                }

                if ($row->status == 0) {
                    if (Auth::user()->can('delete local issue')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                    }
                }

                $btn = $btn . '
                </div>
                </div>';


                return $btn;
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
            ->addColumn('date', function ($row) {
                return date('d-m-Y', strtotime($row->date));
            })
            ->rawColumns(['action', 'materials'])
            ->toJson();
    }
}
