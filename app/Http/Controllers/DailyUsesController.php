<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Project;
use App\Models\Material;
use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use App\Models\ProjectTower;
use Illuminate\Http\Request;
use App\Models\DailyUseItems;
use App\Models\ProjectWiseBudget;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Helper\Ui\DailyConsumptionTable;
use App\Helper\Ui\FlashMessageGenerator;
use App\Helper\DailyUse\ValidationHelper;

class DailyUsesController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Daily Consumption')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return DailyUses::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.dailyuses.dailyuses_index', compact('projects'));
    }

    public function system_serial($company_id = null)
    {

        $companyId = $company_id ? $company_id : Auth::user()->company_id;

        $company = Company::findOrFail($companyId);

        $consumptionQty = DailyUses::where('company_id', $companyId)->count();
        $consumptionQty++;

        return $company->prefix . '/dc/' . $consumptionQty;
    }

    public function create()
    {
        if (!Auth::user()->can('create daily use')) {
            return redirect(route('home'));
        }

        if (Auth::user()->hasRole('Software Admin')) {
            $system_serial = "";
        } else {
            $system_serial = $this->system_serial();
        }

        $data = (object)[
            'title' => 'Create Daily Consumption',
            'system_serial' => $system_serial,
            'units' => MaterialUnit::all(),
            'projects' => Project::GetRoleWiseAll()->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
        ];

        return view('dashboard.dailyuses.create_dailyuses', compact('data'));
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('create daily use')) {
            return redirect(route('home'));
        }

        $project = Project::findOrFail($request->project);

        $validationArr = [
            'project' => 'required',
            'unit_id' => 'required',
        ];

        if ($project->project_type == 'tower') {
            $validationArr['tower'] = 'required';
        }

        $request->validate($validationArr);

        // validate consumption Condition
        $consumptionValidator = new ValidationHelper($request);
        $validationResult = $consumptionValidator->validate();

        if ($validationResult['error']) {
            FlashMessageGenerator::generate('danger', $validationResult['errorMsg']);
            return back();
        }


        // insert in master table
        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $DailyConsumption = DailyUses::create([
            'system_serial' => $this->system_serial($company_id),
            'project_id' => $request->project,
            'unit_id' => $request->unit_id,
            'tower_id' => $request->tower,
            'date' => $request->date,
            'logistics_associate_id' => $request->logistics_associate,
            'truck_no' => $request->truck_no,
            'pile_no' => $request->pile_no,
            'working_length' => $request->working_length,
            'site_engineer' => $request->site_engineer,
            'epc_engineer' => $request->epc_engineer,
            'department_engineer' => $request->department_engineer,
            'company_id' => $company_id,
            'created_by' => Auth::user()->id,
        ]);


        $i = 0;
        foreach ($request->budgetHeadIds as $budgetHeadId) {
            DailyUseItems::create([
                'daily_use_id' => $DailyConsumption->id,
                'budget_head_id' => $budgetHeadId,
                'use_qty' => $request->consumption_qty[$i],
                'remarks' => $request->remarks[$i],
            ]);
            $i++;
        }

        return redirect(route('dailyuses.edit', $DailyConsumption->id));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit daily use')) {
            return redirect(route('home'));
        }

        $dailyConsumption = DailyUses::where('id', $id)->with(['project', 'unit', 'tower'])->first();
        $dailyconsumptionItems = DailyUseItems::where('daily_use_id', $id)->with(['budgetHead'])->get();

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            ->where('type', 'Material')
            ->get();

        $DailyConsumptionTable = new DailyConsumptionTable($dailyConsumption->project_id, [$dailyConsumption->unit_id]);
        $budgetHeadSelect = $DailyConsumptionTable->generateMaterialSelect();

        $data = (object) [
            'title' => 'Edit Daily Consumption',
            'dailyConsumption' => $dailyConsumption,
            'dailyconsumptionItems' => $dailyconsumptionItems,
            'project' => Project::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'budgetHeads' => $budgetHeads,
            'budgetHeadSelect' => $budgetHeadSelect,
            'projectTowers' => ProjectTower::where('project_id', $dailyConsumption->project_id)->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
        ];


        return view('dashboard.dailyuses.edit_dailyuses', compact('data'));
    }


    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit daily use')) {
            return redirect(route('home'));
        }

        // insert in master table
        $company_id = $request->company ? $request->company : Auth::user()->company_id;
        DailyUses::findOrFail($id)->update([
            'tower_id' => $request->tower[0],
            'date' => $request->date,
            'logistics_associate_id' => $request->logistics_associate,
            'truck_no' => $request->truck_no,
            'pile_no' => $request->pile_no,
            'working_length' => $request->working_length,
            'site_engineer' => $request->site_engineer,
            'epc_engineer' => $request->epc_engineer,
            'department_engineer' => $request->department_engineer,
            'company_id' => $company_id,
        ]);

        DailyUseItems::where('daily_use_id', $id)->delete();
        $i = 0;
        foreach ($request->budgetHeadIds as $budgetHeadId) {
            DailyUseItems::create([
                'daily_use_id' => $id,
                'budget_head_id' => $budgetHeadId,
                'use_qty' => $request->consumption_qty[$i],
                'remarks' => $request->remarks[$i],
            ]);
            $i++;
        }

        return redirect(route('dailyuses.index'));
    }


    public function destroy($id)
    {
        if (!Auth::user()->can('delete daily use')) {
            return false;
        }

        DailyUseItems::where('daily_use_id', $id)->delete();
        DailyUses::where('id', $id)->delete();

        return true;
    }


    public function print($id)
    {
        $dailyuse = DailyUses::where('id', $id)->with(['items.budgetHead', 'project', 'unit', 'tower', 'createdBy'])->first();
        $company = Company::findOrFail($dailyuse->company_id);
        $tower = ProjectTower::where('id', $dailyuse->tower_id)->first();

        $projectWiseBudget = ProjectWiseBudget::where('project_id', $dailyuse->project_id)
            ->with(['items', 'items.budgetHead'])
            ->where('is_additional', 0)
            ->where('unit_id', $dailyuse->unit_id)
            ->where('tower_id', $dailyuse->tower_id)
            ->first();

        $pileNo = $projectWiseBudget->number_of_pile;

        $data = (object)[
            'dailyuse' => $dailyuse,
            'company' => $company,
            'tower' => $tower,
            'projectWiseBudget' => $projectWiseBudget,
            'pileNo' => $pileNo,
        ];

        $pdf = PDF::loadView('dashboard.dailyuses.dailyuses_print', compact('data'));
        return $pdf->stream('daily_use_invoice.pdf');
    }
}
