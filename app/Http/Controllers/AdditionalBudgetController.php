<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\ProjectWiseBudget;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectWiseBudgetItems;

class AdditionalBudgetController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('Additional Budget')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return ProjectWiseBudget::datatableAdditionalBudgets();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.additional_budget.additional_budget_index', compact('projects'));
    }

    public function create()
    {
        if (!Auth::user()->can('create additionalbudget')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            // ->where('type', 'Material')
            // ->whereNotIn('id', [3, 4, 5, 6])
            ->get();

        $data = (object)[
            'title' => 'Create Additional Budget',
            'projects' => $projects,
            'budgetheads' => $budgetHeads,
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.additional_budget.create_additional_budget', compact('data'));
    }

    public function store(Request $request)
    {

        $project = Project::findOrFail($request->project_id);

        $validationArr = [
            'project_id' => 'required',
            'unit_id' => 'required',
            'tower' => 'required',
            'remarks_overall' => 'required',
        ];

        if($project->project_type == 'tower'){
            $validationArr['tower'] = 'required';
        }

        $request->validate($validationArr);

        $data = [
            'project_id' => $request->project_id,
            'unit_id' => $request->unit_id,
            'unit_config_id' => 0,
            'long_l' => null,
            'volume' => null,
            'number_of_pile' => null,
            'tower_id' => $request->tower,
            'start_date' => null,
            'end_date' => null,
            'is_additional' => 1,
            'remarks' => $request->remarks_overall,
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
                    'remarks' => $request->remarks[$i],
                ];
            }

            ProjectWiseBudgetItems::insert($postData);
        }

        return redirect(route('additionalbudget.index'));
    }

    public function destroy($id)
    {

        $projectwisebudget = ProjectWiseBudget::findOrFail($id);

        ProjectWiseBudgetItems::where('projectwise_budget_id', $projectwisebudget->id)->delete();
        $projectwisebudget->delete();

        return true;
    }


}
