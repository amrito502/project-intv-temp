<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Project;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\MaterialRequisition;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialRequisitionItem;

class MaterialRequisitionController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Requisition')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialRequisition::datatable();
        }

        return view('dashboard.materialrequisition.materialrequisition_index');
    }

    public function approveRequisitionStepOneList(Request $request)
    {
        if (!Auth::user()->can('Material Approve')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialRequisition::datatableApproveStepOne();
        }

        return view('dashboard.materialrequisition.materialrequisition_index_approve_step_one');
    }


    public function create()
    {

        if (!Auth::user()->can('create materialrequisition')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Material')->get();

        $data = (object)[
            'serial' => MaterialRequisition::nextSerial(),
            'projects' => $projects,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'budgetHeads' => $budgetheads,
        ];

        return view('dashboard.materialrequisition.create_materialrequisition', compact('data'));

    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('create materialrequisition')) {
            return redirect(route('home'));
        }

        $request->validate([
            'date' => 'required',
        ]);


        // insert master table start
        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $data['project_id'] = $request->project_id;
        $data['unit_config_id'] = $request->unit_config_id;
        $data['tower_id'] = $request->tower;
        $data['date'] = date('Y-m-d', strtotime($request->date));
        $data['remarks'] = $request->remarks;
        $data['status'] = "Pending";
        $data['created_by'] = Auth::user()->id;

        $materialrequisition = MaterialRequisition::create($data);
        // insert master table end


        // insert items table start

        if ($request->budget_head) {

            $i = 0;
            foreach ($request->budget_head as $budget_head) {

                MaterialRequisitionItem::create([
                    'material_requisition_id' => $materialrequisition->id,
                    'budget_head_id' => $budget_head,
                    'requisition_amount' => $request->amount[$i],
                    'estimated_amount' => $request->estimated[$i],
                    'issued_amount' => $request->issued[$i],
                    'balance_amount' => $request->balance[$i],
                ]);

                $i++;
            }
        }

        // insert items table end


        return redirect(route('materialrequisition.index'));
    }


    public function edit($id)
    {
        if (!Auth::user()->can('edit materialrequisition')) {
            return redirect(route('home'));
        }

        $materialrequisition = MaterialRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead'])->first();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Material')->get();

        $data = (object)[
            'budgetHeads' => $budgetheads,
            'materialrequisition' => $materialrequisition,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materialrequisition.edit_materialrequisition', compact('data'));
    }


    public function update(Request $request, MaterialRequisition $materialrequisition)
    {
        if (!Auth::user()->can('edit materialrequisition')) {
            return redirect(route('home'));
        }

        // insert items table start

        if ($request->budget_head) {

            MaterialRequisitionItem::where('material_requisition_id', $materialrequisition->id)->delete();

            $i = 0;
            foreach ($request->budget_head as $budget_headId) {

                MaterialRequisitionItem::create([
                    'material_requisition_id' => $materialrequisition->id,
                    'budget_head_id' => $budget_headId,
                    'requisition_amount' => $request->amount[$i],
                ]);

                $i++;
            }
        }


        // insert items table end

        return redirect(route('materialrequisition.index'));
    }


    public function destroy(MaterialRequisition $materialrequisition)
    {

        if (!Auth::user()->can('delete materialrequisition')) {
            return redirect(route('home'));
        }

        MaterialRequisitionItem::where('material_requisition_id', $materialrequisition->id)->delete();
        $materialrequisition->delete();
        return true;
    }

    public function approveMaterialRequisitionStepOneView($id)
    {
        if (!Auth::user()->can('Material Requisition Approve')) {
            return back();
        }

        $materialrequisition = MaterialRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead'])->first();

        $budgetheads = BudgetHead::where(function ($query) {
            $query->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        })->where('type', 'Material')
            ->get();

        $data = (object)[
            'materialrequisition' => $materialrequisition,
            'budgetHeads' => $budgetheads,
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materialrequisition.approve_materialrequisition', compact('data'));
    }

    public function approveMaterialRequisitionStepOne(Request $request)
    {

        $request->validate([
            'materialRequisitionId' => 'required',
            'approved_amount' => 'required',
        ]);

        foreach ($request->approved_amount as $id => $approveAmount) {

            MaterialRequisitionItem::where('id', $id)->first()->update([
                'approved_amount_one' => $approveAmount,
            ]);
        }

        MaterialRequisition::where('id', $request->materialRequisitionId)->first()->update([
            'status' => 'ApprovedOne',
        ]);

        return redirect(route('approveRequisitionStepOneList'));
    }


    public function approveRequisitionStepTwoList(Request $request)
    {
        if (!Auth::user()->can('Material Final Approve')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialRequisition::datatableApproveStepTwo();
        }

        return view('dashboard.materialrequisition.materialrequisition_index_approve_step_two');
    }

    public function approveMaterialRequisitionStepTwoView($id)
    {
        if (!Auth::user()->can('Material Requisition Final Approve')) {
            return back();
        }

        $materialrequisition = MaterialRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead'])->first();

        $budgetheads = BudgetHead::where(function ($query) {
            $query->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        })->where('type', 'Material')
            ->get();

        $data = (object)[
            'materialrequisition' => $materialrequisition,
            'budgetHeads' => $budgetheads,
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materialrequisition.approve_step_two_materialrequisition', compact('data'));
    }

    public function approveMaterialRequisitionStepTwo(Request $request)
    {

        $request->validate([
            'materialRequisitionId' => 'required',
            'approved_amount' => 'required',
        ]);

        foreach ($request->approved_amount as $id => $approveAmount) {

            MaterialRequisitionItem::where('id', $id)->first()->update([
                'approved_amount_two' => $approveAmount,
            ]);
        }

        MaterialRequisition::where('id', $request->materialRequisitionId)->first()->update([
            'status' => 'ApprovedTwo',
        ]);

        return redirect(route('approveRequisitionStepTwoList'));
    }

}
