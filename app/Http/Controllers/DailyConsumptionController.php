<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Project;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use App\Models\ProjectTower;
use Illuminate\Http\Request;
use App\Models\DailyConsumption;
use App\Models\DailyConsumptionItem;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\DailyConsumptionTable;

use App\Helper\Ui\FlashMessageGenerator;
use App\Helper\DailyConsumption\ValidationHelper;

class DailyConsumptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Local Issue')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return DailyConsumption::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.dailyconsumption.dailyconsumption_index', compact('projects'));
    }

    public function system_serial($company_id = null)
    {

        $companyId = $company_id ? $company_id : Auth::user()->company_id;

        $company = Company::findOrFail($companyId);

        $consumptionQty = DailyConsumption::where('company_id', $companyId)->count();
        $consumptionQty++;

        return $company->prefix . '/lis/' . $consumptionQty;
    }

    public function create()
    {
        if (!Auth::user()->can('create local issue')) {
            return redirect(route('home'));
        }

        if (Auth::user()->hasRole('Software Admin')) {
            $system_serial = "";
        } else {
            $system_serial = $this->system_serial();
        }

        $data = (object)[
            'title' => 'Create Local Issue',
            'system_serial' => $system_serial,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'projects' => Project::GetRoleWiseAll()->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
        ];

        return view('dashboard.dailyconsumption.create_dailyconsumption', compact('data'));
    }

    public function store(Request $request)
    {

        if (!Auth::user()->can('create local issue')) {
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

        $DailyConsumption = DailyConsumption::create([
            'system_serial' => $this->system_serial($company_id),
            'project_id' => $request->project,
            'unit_id' => $request->unit_id,
            'tower_id' => $request->tower,
            'date' => $request->date,
            'logistics_associate_id' => $request->logistics_associate,
            'truck_no' => $request->truck_no,
            'issue_by_name' => $request->issue_by,
            'company_id' => $company_id,
            'created_by' => Auth::user()->id,
        ]);


        $i = 0;
        foreach ($request->budgetHeadIds as $budgetHeadId) {
            DailyConsumptionItem::create([
                'daily_consumption_id' => $DailyConsumption->id,
                'budget_head_id' => $budgetHeadId,
                'consumption_qty' => 0,
                'issue_qty' => $request->consumption_qty[$i],
            ]);
            $i++;
        }

        return redirect(route('dailyconsumption.edit', $DailyConsumption->id));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit local issue')) {
            return redirect(route('home'));
        }

        $dailyConsumption = DailyConsumption::where('id', $id)->with(['project', 'unit', 'tower'])->first();
        $dailyconsumptionItems = DailyConsumptionItem::where('daily_consumption_id', $id)->with(['budgetHead'])->get();

        $budgetHeads = BudgetHead::where(function ($query) {
            return $query->where('company_id', Auth::user()->company_id)->orWhere('company_id',  0);
        })
            ->where('type', 'Material')
            ->get();


        $DailyConsumptionTable = new DailyConsumptionTable($dailyConsumption->project_id, [$dailyConsumption->unit_id]);
        $budgetHeadSelect = $DailyConsumptionTable->generateMaterialSelect();

        $data = (object) [
            'title' => 'Edit Local Issue',
            'dailyConsumption' => $dailyConsumption,
            'dailyconsumptionItems' => $dailyconsumptionItems,
            'project' => Project::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'budgetHeads' => $budgetHeads,
            'budgetHeadSelect' => $budgetHeadSelect,
            'projectTowers' => ProjectTower::where('project_id', $dailyConsumption->project_id)->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
        ];


        return view('dashboard.dailyconsumption.edit_dailyconsumption', compact('data'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('edit local issue')) {
            return redirect(route('home'));
        }

        // insert in master table
        $company_id = $request->company ? $request->company : Auth::user()->company_id;
        DailyConsumption::findOrFail($id)->update([
            'tower_id' => $request->tower[0],
            'date' => $request->date,
            'logistics_associate_id' => $request->logistics_associate,
            'truck_no' => $request->truck_no,
            'issue_by_name' => $request->issue_by,
            'company_id' => $company_id,
        ]);

        DailyConsumptionItem::where('daily_consumption_id', $id)->delete();
        $i = 0;
        foreach ($request->budgetHeadIds as $budgetHeadId) {
            DailyConsumptionItem::create([
                'daily_consumption_id' => $id,
                'budget_head_id' => $budgetHeadId,
                'issue_qty' => $request->consumption_qty[$i],
                'consumption_qty' => 0,
            ]);
            $i++;
        }

        return redirect(route('dailyconsumption.index'));
    }


    public function destroy($id)
    {

        if (!Auth::user()->can('delete local issue')) {
            return false;
        }

        DailyConsumptionItem::where('daily_consumption_id', $id)->delete();
        DailyConsumption::where('id', $id)->delete();

        return true;
    }

    public function dailyConsumptionAutoCalculateForm(Request $request, $id)
    {

        $unitConfig = (object)[];

        if ($request->has('unitConfig')) {
            $unitConfig = json_decode($request->unitConfig);
        }

        if ($id == 8) {
            return view('dashboard.dailyconsumption.partials.forms.create.pile_ratio_form', compact('unitConfig'))->render();
        }

        if ($id == 9) {
            return view('dashboard.dailyconsumption.partials.forms.create.cap_ratio_form', compact('unitConfig'))->render();
        }

        if ($id == 10) {
            return view('dashboard.dailyconsumption.partials.forms.create.soil_excavation_form', compact('unitConfig'))->render();
        }

        if ($id == 11) {
            return view('dashboard.dailyconsumption.partials.forms.create.footing_work_form', compact('unitConfig'))->render();
        }

        if ($id == 12) {
            return view('dashboard.dailyconsumption.partials.forms.create.column_form', compact('unitConfig'))->render();
        }

        if ($id == 13) {
            return view('dashboard.dailyconsumption.partials.forms.create.beam_form', compact('unitConfig'))->render();
        }

        if ($id == 14) {
            return view('dashboard.dailyconsumption.partials.forms.create.slab_form', compact('unitConfig'))->render();
        }

        if ($id == 15) {
            return view('dashboard.dailyconsumption.partials.forms.create.guide_wall_form', compact('unitConfig'))->render();
        }

        if ($id == 16) {
            return view('dashboard.dailyconsumption.partials.forms.create.wall_form', compact('unitConfig'))->render();
        }

        if ($id == 17) {
            return view('dashboard.dailyconsumption.partials.forms.create.pluster_form', compact('unitConfig'))->render();
        }

        if ($id == 18) {
            return view('dashboard.dailyconsumption.partials.forms.create.brick_soiling_form', compact('unitConfig'))->render();
        }

        if ($id == 19) {
            return view('dashboard.dailyconsumption.partials.forms.create.sand_filling_form', compact('unitConfig'))->render();
        }

        if ($id == 20) {
            return view('dashboard.dailyconsumption.partials.forms.create.tiles_form', compact('unitConfig'))->render();
        }
    }


    public function print($id)
    {
        $dailyConsumption = DailyConsumption::where('id', $id)->with(['items.budgetHead', 'project', 'unit', 'tower', 'issue_by', 'receive_by'])->first();
        $company = Company::findOrFail($dailyConsumption->company_id);

        $data = (object)[
            'dailyConsumption' => $dailyConsumption,
            'company' => $company,
        ];

        $pdf = PDF::loadView('dashboard.dailyconsumption.dailyconsumption_print', compact('data'));
        return $pdf->stream('daily_consumption_invoice.pdf');
    }


    public function receiveList()
    {
        if (!Auth::user()->can('Local Receive')) {
            return redirect(route('home'));
        }

        $dailyConsumptions = DailyConsumption::where('company_id', Auth::user()->company_id)
            ->where('status', 0)
            ->with(['project', 'unit', 'tower', 'items', 'items.budgetHead'])
            ->orderBy('date', 'desc');

        if (!Auth::user()->hasRole(['Software Admin', 'SuperAdmin', 'Company Admin'])) {
            $dailyConsumptions = $dailyConsumptions->whereIn('project_id', Auth::user()->userProjectIds());
        }

        $dailyConsumptions = $dailyConsumptions->get();

        $data = (object)[
            'localIssues' => $dailyConsumptions,
        ];

        return view('dashboard.dailyconsumption.dailyconsumption_receive_list', compact('data'));
    }

    public function receiveView($id)
    {

        $dailyConsumption = DailyConsumption::where('id', $id)->with(['project', 'unit', 'tower', 'logisticsAssociate'])->first();
        $dailyconsumptionItems = DailyConsumptionItem::where('daily_consumption_id', $id)->with(['budgetHead'])->get();

        $data = (object)[
            'dailyConsumption' => $dailyConsumption,
            'dailyconsumptionItems' => $dailyconsumptionItems,
        ];

        return view('dashboard.dailyconsumption.receive_dailyconsumption', compact('data'));

    }


    public function receiveSave($id, Request $request)
    {

        $request->validate([
            'receive_by' => 'required',
            'consumption_qty.*' => 'required',
        ]);


        // save master data
        $dailyConsumption = DailyConsumption::findOrFail($id);
        $dailyConsumption->status = 1;
        $dailyConsumption->received_by = Auth::user()->id;
        $dailyConsumption->receive_by_name = $request->receive_by;
        $dailyConsumption->save();


        // update Items data

        foreach ($request->consumption_qty as $consumptionId => $consumption_qty) {
            DailyConsumptionItem::where('id', $consumptionId)->update(['consumption_qty' => $consumption_qty]);
        }


        return redirect(route('dailyconsumption.receiveList'));

    }

}
