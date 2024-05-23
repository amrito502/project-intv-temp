<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\ProjectWiseBudgetItems;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectWiseBudget extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    public function tower(): HasOne
    {
        return $this->hasOne(ProjectTower::class, 'id', 'tower_id');
    }

    public function unitConfig(): HasOne
    {
        return $this->hasOne(UnitConfiguration::class, 'id', 'unit_config_id');
    }

    public function budget_wise_roas(): HasMany
    {
        return $this->hasMany(ProjectBudgetWiseRoa::class, 'projectwise_budget_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProjectWiseBudgetItems::class, 'projectwise_budget_id', 'id');
    }

    public function BudgetGrandTotalAmount()
    {
        $total = 0;

        if ($this->items) {

            foreach ($this->items as $item) {
                $total += $item->amount;
            }
        }

        return $total;
    }

    public function CashBudgetGrandTotalAmount()
    {
        $total = 0;

        if ($this->items) {

            foreach ($this->items as $item) {
                // if($item->budgetHead->type == "Cash"){
                $total += $item->amount;
                // }
            }
        }

        return $total;
    }

    public function BudgetGrandTotalQty()
    {
        $total = 0;

        if ($this->items) {

            foreach ($this->items as $item) {
                $total += $item->qty;
            }
        }

        return $total;
    }

    public static function datatable()
    {
        $projectwisebudget = ProjectWiseBudget::where('company_id', Auth::user()->company_id)
            ->where('is_additional', 0)
            ->with(['project', 'unitConfig', 'items'])
            ->orderBy('project_id')
            ->orderBy('unit_id');

        if (request()->project_id) {
            $projectwisebudget = $projectwisebudget->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $projectwisebudget = $projectwisebudget->whereIn('project_id', Auth::user()->userProjectIds());
        }


        return DataTables::eloquent($projectwisebudget)
            ->addIndexColumn()
            ->addColumn('project_name', function ($row) {
                return $row?->project?->project_name;
            })
            ->addColumn('unit_name', function ($row) {
                return $row?->unitConfig?->unit?->name;
            })
            ->addColumn('unit_config_name', function ($row) {
                return $row?->unitConfig?->unit_name;
            })
            ->addColumn('longOrVolume', function ($row) {
                return $row->long_l > 0 ? $row->long_l : $row->volume;
            })
            ->addColumn('dateRange', function ($row) {

                $start_date = date('d-m-Y', strtotime($row->start_date));
                $end_date = date('d-m-Y', strtotime($row->end_date));

                return '(' . $start_date . ') - (' . $end_date . ')';
            })
            ->addColumn('total_amount', function ($row) {

                $total = 0;

                foreach ($row->items as $item) {

                    $total += $item->amount;
                }

                return $total;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                // if (Auth::user()->can('edit projectwisebudget')) {
                $btn = $btn . '<a href="' . route('projectwiseroa.index', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                    ROA
                    </a>';
                // }

                if (Auth::user()->can('edit projectwisebudget')) {
                    $btn = $btn . '<a href="' . route('projectwisebudget.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete projectwisebudget')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }

    public static function datatableAdditionalBudgets()
    {
        $projectwisebudget = ProjectWiseBudget::where('company_id', Auth::user()->company_id)
        ->where('is_additional', 1)
        ->with(['project', 'tower', 'unitConfig', 'items'])
        ->orderBy('project_id')
        ->orderBy('unit_id');

        if (request()->project_id) {
            $projectwisebudget = $projectwisebudget->where('project_id', request()->project_id);
        }

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $projectwisebudget = $projectwisebudget->whereIn('project_id', Auth::user()->userProjectIds());
        }


        return DataTables::eloquent($projectwisebudget)
            ->addIndexColumn()
            ->addColumn('project_name', function ($row) {
                return $row?->project?->project_name;
            })
            ->addColumn('unit_name', function ($row) {
                return $row?->unitConfig?->unit?->name;
            })
            ->addColumn('tower_name', function ($row) {
                return $row?->tower?->name;
            })
            ->addColumn('unit_config_name', function ($row) {
                return $row?->unitConfig?->unit_name;
            })
            ->addColumn('longOrVolume', function ($row) {
                return $row->long_l > 0 ? $row->long_l : $row->volume;
            })
            ->addColumn('dateRange', function ($row) {

                $start_date = date('d-m-Y', strtotime($row->start_date));
                $end_date = date('d-m-Y', strtotime($row->end_date));

                return '(' . $start_date . ') - (' . $end_date . ')';
            })
            ->addColumn('total_amount', function ($row) {

                $total = 0;

                foreach ($row->items as $item) {

                    $total += $item->amount;
                }

                return $total;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('delete additionalbudget')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->toJson();
    }
}
