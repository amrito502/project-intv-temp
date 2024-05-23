<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Project;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\ProjectWiseBudget;
use App\Models\ProjectBudgetWiseRoa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\ProjectWiseBudgetItems;

class ProjectWiseBudgetController extends Controller
{

    public function index(Request $request)
    {

        if (!Auth::user()->can('Budget Prepare')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return ProjectWiseBudget::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.projectwise_budget.projectwise_budget_index', compact('projects'));
    }

    public function create()
    {

        if (!Auth::user()->can('create projectwisebudget')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            ->whereNotIn('id', [3, 4, 5, 6])
            ->get();


        $data = (object)[
            'title' => 'Create Budget Prepare',
            'projects' => $projects,
            'budgetheads' => $budgetHeads,
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.projectwise_budget.create_projectwise_budget', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create projectwisebudget')) {
            return redirect(route('home'));
        }


        $project = Project::findOrFail($request->project_id);

        $validationArr = [
            'project_id' => 'required',
            'unit_config_id' => 'required',
            'number_of_pile' => 'required',
        ];

        if ($project->project_type == 'tower') {
            $validationArr['tower'] = 'required';
        }

        $request->validate($validationArr);

        $data = [
            'project_id' => $request->project_id,
            'unit_id' => $request->unit_id,
            'unit_config_id' => $request->unit_config_id,
            'long_l' => $request->long,
            'volume' => $request->volume,
            'number_of_pile' => $request->number_of_pile,
            'tower_id' => $request->tower,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $data['created_by'] = Auth::user()->id;

        $projectwiseBudget = ProjectWiseBudget::create($data);

        $countMaterial = count($request->material_id);
        if ($request->material_id) {
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {
                $postData[] = [
                    'projectwise_budget_id' => $projectwiseBudget->id,
                    'budget_head' => $request->material_id[$i],
                    'amount' => $request->amount[$i],
                    'qty' => $request->qty[$i],
                    // 'rate' => $request->rate[$i],
                ];
            }

            ProjectWiseBudgetItems::insert($postData);
        }

        return redirect(route('projectwisebudget.index'));
    }


    public function edit($id)
    {
        if (!Auth::user()->can('edit projectwisebudget')) {
            return redirect(route('home'));
        }

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            ->whereNotIn('id', [3, 4, 5, 6])
            ->get();

        $projectwisebudget = ProjectWiseBudget::where('id', $id)->where('is_additional', 0)->with(['project', 'tower', 'unitConfig.unit', 'items.budgetHead', 'items.unit_of_measurement'])->first();

        $data = (object) [
            'title' => 'Edit Budget Prepare',
            'projectwisebudget' => $projectwisebudget,
            'projectBudgetWiseRoa' => ProjectBudgetWiseRoa::where('projectwise_budget_id', $projectwisebudget->id)->get(),
            'budgetheads' => $budgetHeads,
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.projectwise_budget.edit_projectwise_budget', compact('data'));
    }

    public function projectWiseBudgetInherit($towerID, $unitConfig, $newTower = null)
    {
        if (!Auth::user()->can('create projectwisebudget')) {
            return redirect(route('home'));
        }

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            ->whereNotIn('id', [3, 4, 5, 6])
            ->get();

        $projectwisebudget = ProjectWiseBudget::where('tower_id', $towerID)
            ->where('is_additional', 0)
            ->where('unit_config_id', $unitConfig)
            ->with(['project', 'tower', 'unitConfig.unit', 'items.budgetHead', 'items.unit_of_measurement'])
            ->first();

        $data = (object) [
            'projectwisebudget' => $projectwisebudget,
            'budgetheads' => $budgetHeads,
            'units' => MaterialUnit::all(),
            'newTower' => $newTower
        ];


        return view('dashboard.projectwise_budget.inherit_projectwise_budget', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectWiseBudget  $projectWiseBudget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectWiseBudget $projectwisebudget)
    {
        if (!Auth::user()->can('edit projectwisebudget')) {
            return redirect(route('home'));
        }

        ProjectWiseBudgetItems::where('projectwise_budget_id', $projectwisebudget->id)->delete();

        $countMaterial = count($request->material_id);
        if ($request->material_id) {
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {
                $postData[] = [
                    'projectwise_budget_id' => $projectwisebudget->id,
                    'budget_head' => $request->material_id[$i],
                    'amount' => $request->amount[$i],
                    'qty' => $request->qty[$i],
                    // 'rate' => $request->rate[$i],
                ];
            }

            ProjectWiseBudgetItems::insert($postData);
        }

        return redirect(route('projectwisebudget.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectWiseBudget  $projectWiseBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectWiseBudget $projectwisebudget)
    {

        ProjectWiseBudgetItems::where('projectwise_budget_id', $projectwisebudget->id)->delete();

        $projectwisebudget->delete();
        return true;
    }
}
