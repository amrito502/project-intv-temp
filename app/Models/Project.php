<?php

namespace App\Models;

use App\Helper\Array\Flatten;
use Illuminate\Support\Facades\Auth;
use App\Helper\Project\ProjectHelper;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function toggleDashboardStatus()
    {
        if ($this->show_dashboard) {
            $this->show_dashboard = False;
        } else {
            $this->show_dashboard = True;
        }

        $this->save();
    }


    public function projectUnit(): HasMany
    {
        return $this->hasMany(ProjectUnit::class, 'project_id', 'id');
    }

    public function project_wise_budgets(): HasMany
    {
        return $this->hasMany(ProjectWiseBudget::class, 'project_id', 'id');
    }

    public function projectTowers(): HasMany
    {
        return $this->hasMany(ProjectTower::class, 'project_id', 'id');
    }


    public function ScopeGetRoleWiseAll($query)
    {
        if(Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])){
            return $query->where('company_id', Auth::user()->company_id);
        }else{
            return $query->where('company_id', Auth::user()->company_id)->whereIn('id', Auth::user()->userProjectIds());
        }

    }


    public function projectMaterialIds()
    {

        $itemIds = [];

        $projectHelper = new ProjectHelper($this->id);

        // budget Item Ids
        array_push($itemIds,  $projectHelper->budgetHeadIdsToMaterialIds($projectHelper->budgetItemsBudgetHeadIds()));

        // lifting Item Ids
        array_push($itemIds, $projectHelper->liftingMaterialIds());

        // issued item ids
        array_push($itemIds, $projectHelper->materialIssueItemIds());

        // receive item ids
        array_push($itemIds, $projectHelper->materialReceiveItemIds());

        // flatten array
        $itemIds = Flatten::ArrayFlatten($itemIds);

        // unique items
        $itemIds = array_unique($itemIds);

        return $itemIds;
    }

    public static function datatable()
    {

        $project = Project::with(['projectUnit.unit', 'projectTowers'])->where('company_id', Auth::user()->company_id);

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $project = $project->whereIn('id', Auth::user()->userProjectIds());
        }

        return DataTables::eloquent($project)
            ->addIndexColumn()
            ->addColumn('towers', function ($row) {
                $towers = "";

                if (!$row->projectTowers) {
                    return $towers;
                }

                foreach ($row->projectTowers as $tower) {
                    $towers .= $tower->name . ", ";
                }

                return $towers;
            })
            ->addColumn('company_name', function ($row) {

                $company = Company::where('id', $row->company_id)->select(['name'])->first();

                return $company->name;
            })
            ->addColumn('branch_name', function ($row) {

                $branch = Branch::where('id', $row->branch_id)->select(['branch_name'])->first();

                return $branch->branch_name;
            })
            ->addColumn('units', function ($row) {

                $projectUnits = '';

                foreach ($row->projectUnit as $unit) {
                    $projectUnits .= $unit->unit->name . ', ';
                }

                return $projectUnits;
            })
            ->addColumn('dashboard_status_ui', function ($row) {
                $status = $row->show_dashboard;
                $checked = "";

                if ($status) {
                    $checked = "checked";
                }

                $slide_button = '<div class="toggle">
                  <label>
                    <input onclick="toggleDashboardStatus(' . $row->id . ')" type="checkbox" ' . $checked . '><span class="button-indecator"></span>
                  </label>
                </div>';

                return $slide_button;
            })
            ->addColumn('action', function ($row) {

                $btn = '<div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Action
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';

                if (Auth::user()->can('edit project')) {
                    $btn = $btn . '<a href="' . route('project.edit', $row->id) . '" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a>';
                }

                if (Auth::user()->can('delete project')) {
                    $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='dropdown-item'><i class='fa fa-trash' aria-hidden='true'></i> Delete</button>";
                }

                $btn = $btn . '
                </div>
                </div>';

                return $btn;
            })
            ->rawColumns(['dashboard_status_ui', 'action'])
            ->toJson();
    }
}
