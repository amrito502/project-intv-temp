<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TBPItem;
use App\Models\Material;
use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\ProjectUnit;
use App\Models\DailyExpense;
use App\Models\ProjectTower;
use Illuminate\Http\Request;
use App\Models\DailyUseItems;
use App\Models\CashRequisition;
use App\Models\LogisticsCharge;
use App\Models\MaterialLifting;
use App\Models\DailyConsumption;
use App\Models\DailyExpenseItem;
use App\Models\CashVendorPayment;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use App\Helper\Reports\StockReport;
use App\Models\CashRequisitionItem;
use App\Models\DailyConsumptionItem;
use Illuminate\Support\Facades\Auth;
use App\Helper\Project\ProjectHelper;
use App\Models\MaterialVendorPayment;
use App\Models\ProjectWiseBudgetItems;
use App\Helper\Ui\DailyConsumptionTable;
use App\Helper\Project\BasicMaterialStock;
use App\Helper\Reports\DashBoardStockReport;
use App\Models\MaterialVendorPaymentInvoice;

class APIController extends Controller
{

    public function projectWiseUnits($projectId)
    {
        return [
            'unit_config' => UnitConfiguration::where('project_id', $projectId)->get(),
            'static_material_info' => Material::with('materialUnit')->whereIn('id', [2, 3, 5])->get(),
        ];
    }

    public function projectUnits($projectId)
    {
        return [
            'project_units' => ProjectUnit::where('project_id', $projectId)->with(['unit'])->get(),
        ];
    }

    public function projectUnitConfig($projectId, $unitId)
    {
        return [
            'unit_config' => UnitConfiguration::where('project_id', $projectId)->where('unit_id', $unitId)->get(),
            'static_material_info' => Material::with('materialUnit')->whereIn('id', [2, 3, 5])->get(),
        ];
    }

    public function projectwiseTower($projectId)
    {
        return [
            'project_towers' => ProjectTower::where('project_id', $projectId)->get(),
        ];
    }

    public function projectwiseTowerInherit($projectId)
    {

        $inheritableTowerIds = ProjectWiseBudget::where('project_id', $projectId)->whereNotNull('tower_id')->where('is_additional', 0)->select('tower_id')->get()->pluck('tower_id')->toArray();
        $inheritableUnitConfigIds = ProjectWiseBudget::where('project_id', $projectId)->whereNotNull('unit_config_id')->select('unit_config_id')->get()->pluck('unit_config_id')->toArray();

        return [
            'project_inherit_towers' => ProjectTower::whereIn('id', $inheritableTowerIds)->get(),
            'project_inherit_unit_configs' => UnitConfiguration::whereIn('id', $inheritableUnitConfigIds)->get(),
        ];
    }

    public function budgetheadById($id)
    {
        return BudgetHead::findOrFail($id);
    }

    public function projectWiseMaterial($id)
    {

        $projectWiseBudget = ProjectWiseBudget::where('project_id', $id)->where('is_additional', 0)->first();

        $budgetHeadIds = ProjectWiseBudgetItems::where('projectwise_budget_id', $projectWiseBudget->id)->get()->pluck(['budget_head'])->toArray();

        $budgetHeadNames = BudgetHead::whereIn('id', $budgetHeadIds)->where('type', 'Material')->get()->pluck(['name'])->toArray();

        $projectMaterials = Material::whereIn('name', $budgetHeadNames)->get();

        return $projectMaterials;
    }

    public function projectWiseCostHead($id)
    {

        $projectWiseBudgetIds = ProjectWiseBudget::where('project_id', $id)->where('is_additional', 0)->select('id')->get()->pluck('id')->toArray();

        $budgetHeadIds = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectWiseBudgetIds)->get()->pluck(['budget_head'])->toArray();

        $budgetHeads = BudgetHead::whereIn('id', $budgetHeadIds)->where('type', 'Cash')->get()->toArray();

        return $budgetHeads;
    }

    public function budgetHeadToMaterialInfo($id)
    {
        $material = Material::findOrFail($id);

        return $material;
    }

    public function budgetHeadToMaterialByName($name)
    {
        $material = Material::where('name', $name)->with(['materialUnit'])->first();

        return $material;
    }

    public function projectUnitWiseBudgetHead($projectId, $unitIds)
    {

        $projectHelper = new ProjectHelper($projectId, [$unitIds]);

        $budget_heads = $projectHelper->ProjectUsedBudgetHeads();

        return $budget_heads;
    }

    public function projectUnitWiseBudgetHeadCashOnly($projectId, $unitIds)
    {

        $projectHelper = new ProjectHelper($projectId, [$unitIds]);

        $budget_heads = $projectHelper->budgetItemsTypeCash();

        return $budget_heads;
    }

    public function projectUnitWiseBudgetHeadMaterialhOnly($projectId, $unitIds)
    {

        $projectHelper = new ProjectHelper($projectId, [$unitIds]);

        $budget_heads = $projectHelper->budgetItemsTypeMaterial();

        return $budget_heads;
    }

    public function budgetHeadWiseTotalEstimated($projectId, $unitId, $budgetHeadId, $towerId = null)
    {
        $unitConfigIds = UnitConfiguration::where('project_id', $projectId)->where('unit_id', $unitId)->select('id')->get()->pluck('id')->toArray();

        $projectBudgetIds = ProjectWiseBudget::where('project_id', $projectId)->whereIn('unit_config_id', $unitConfigIds)->select('id');

        if ($towerId) {
            $projectBudgetIds = $projectBudgetIds->where('tower_id', $towerId);
        }

        $projectBudgetIds = $projectBudgetIds->get()->pluck('id')->toArray();

        $budgetTotal = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectBudgetIds)->where('budget_head', $budgetHeadId)->sum('amount');

        $budgetSum = $budgetTotal;

        return $budgetSum;
    }

    public function budgetHeadWiseTotalPaid($projectId, $unitId, $budgetHeadId)
    {
        $totalPaid = 0;
        $cashRequisitionIds = CashRequisition::where('project_id', $projectId)->where('unit_config_id', $unitId)->select('id')->get()->pluck('id')->toArray();
        $cashRequisitionItemIds = CashRequisitionItem::whereIn('cash_requisition_id', $cashRequisitionIds)->where('budget_head_id', $budgetHeadId)->select('id')->get()->pluck('id')->toArray();

        $totalPaid = CashVendorPayment::whereIn('requisition_item_id', $cashRequisitionItemIds)->sum('amount');

        return $totalPaid;
    }

    public function budgetHeadWiseTotalApproved()
    {

        $projectId = request()->projectId;
        $unitId = request()->unitId;
        $budgetHeadId = request()->budgetHeadId;
        $towerId = request()->towerId;

        $totalPaid = 0;

        $cashRequisitionIds = CashRequisition::where('project_id', $projectId)->where('unit_config_id', $unitId)->whereIn('status', ['Approved', 'Paid']);

        if ($towerId) {
            $cashRequisitionIds = $cashRequisitionIds->where('tower_id', $towerId);
        }

        $cashRequisitionIds = $cashRequisitionIds->select('id')->get()->pluck('id')->toArray();

        $totalPaid = CashRequisitionItem::whereIn('cash_requisition_id', $cashRequisitionIds)->where('budget_head_id', $budgetHeadId)->sum('approved_amount');

        return $totalPaid;
    }

    public function budgetHeadWiseTotalUsed()
    {
        $projectId = request()->projectId;
        $unitId = request()->unitId;
        $budgetHeadId = request()->budgetHeadId;
        $towerId = request()->towerId;

        $total = 0;

        $dailyexpenseIds = DailyExpense::where('project_id', $projectId)->where('unit_config_id', $unitId);

        if ($towerId) {
            $dailyexpenseIds = $dailyexpenseIds->where('tower_id', $towerId);
        }

        $dailyexpenseIds = $dailyexpenseIds->select('id')->get()->pluck('id')->toArray();

        $total = DailyExpenseItem::whereIn('daily_expense_id', $dailyexpenseIds)->where('budget_head_id', $budgetHeadId)->sum('amount');

        return $total;
    }

    public function projectUnitToBudgetHead($projectId, $unitIds)
    {

        $unitIds = explode(',', $unitIds);

        $dailyConsumption = new DailyConsumptionTable($projectId, $unitIds);

        $dailyConsumptionSelect = $dailyConsumption->generateBudgetHeadSelect();

        return $dailyConsumptionSelect;
    }


    public function projectUnitToMaterials($projectId, $unitIds)
    {

        $unitIds = explode(',', $unitIds);

        $dailyConsumption = new DailyConsumptionTable($projectId, $unitIds);

        $dailyConsumptionSelect = $dailyConsumption->generateMaterialSelect();

        return $dailyConsumptionSelect;
    }

    public function UnitConfigById($id)
    {
        return UnitConfiguration::findOrFail($id);
    }

    public function datewiseIssueProject()
    {

        $i = 1;

        $start_date = date('Y-m-d', strtotime(request()->start_date));
        $end_date = date('Y-m-d', strtotime(request()->end_date));

        $data = [];

        $projectIds = DailyConsumption::where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->where('company_id', Auth::user()->company_id)
            ->distinct(['project_id'])
            ->select('project_id')
            ->get()
            ->pluck('project_id')
            ->toArray();

        $projectIds = array_unique($projectIds);

        $projectIds = Project::whereIn('id', $projectIds)->where('show_dashboard', 1)->select('id')->get()->pluck('id')->toArray();

        foreach ($projectIds as $projectId) {

            $project = Project::with(['projectTowers'])->where('id', $projectId)->first();

            if ($project->projectTowers->count()) {

                $projectTowerIds = $project->projectTowers->pluck('id')->toArray();

                $towers = DailyConsumption::where('project_id', $project->id)
                    ->whereIn('tower_id', $projectTowerIds)
                    ->where('date', '>=', $start_date)
                    ->where('date', '<=', $end_date)
                    ->distinct(['tower_id'])
                    ->get()
                    ->pluck('tower_id')
                    ->toArray();

                $towers = array_unique($towers);

                foreach ($towers as $tower) {

                    $pt = ProjectTower::find($tower);

                    if ($pt) {

                        $data[] = [
                            'id' => $i,
                            'type' => $project->project_type,
                            'project' => $project,
                            'tower' => $pt,
                        ];

                        $i++;
                    }
                }
            } else {

                $data[] = [
                    'id' => $i,
                    'type' => $project->project_type,
                    'project' => $project,
                ];

                $i++;
            }
        }

        return $data;
    }

    public function datewiseIssueNoTowerProject()
    {

        $i = 1;

        $start_date = date('Y-m-d', strtotime(request()->start_date));
        $end_date = date('Y-m-d', strtotime(request()->end_date));

        $data = [];


        $projects = Project::GetRoleWiseAll()->where('show_dashboard', 1)->orWhere('company_id', 0)->get();

        $i = 1;
        foreach ($projects as $project) {


            $data[] = [
                'id' => $i,
                'project' => $project,
            ];

            $i++;
        }

        return $data;
    }

    public function datewiseIssueDetails()
    {

        $start_date = date('Y-m-d', strtotime(request()->start_date));
        $end_date = date('Y-m-d', strtotime(request()->end_date));
        $project_id = request()->project_id;
        $tower_id = request()->tower_id;

        $data = [];

        $projectHelper = new ProjectHelper($project_id, [], $start_date, $end_date);

        // get project used budgetHeads
        $budgetHeads = $projectHelper->ProjectUsedBudgetHeads();

        // get design ids
        $projectBudgetIds = ProjectWiseBudget::where('project_id', $project_id)->where('tower_id', $tower_id)->where('is_additional', 0)->get()->pluck('id')->toArray();

        // get local issue ids
        $localIssueIds = DailyConsumption::where('project_id', $project_id)->where('tower_id', $tower_id)->get()->pluck('id')->toArray();


        // get consumption ids
        $consumptionIds = DailyUses::where('project_id', $project_id)->where('tower_id', $tower_id)->get()->pluck('id')->toArray();


        foreach ($budgetHeads as $budgetHead) {

            if ($budgetHead->type != "Material") {
                continue;
            }

            $budgetHeadMaterialInfo = $budgetHead->materialInfo();

            // get this budgethead design qty
            $budgetHeadDesignQty = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectBudgetIds)->where('budget_head', $budgetHead->id)->sum('qty');

            // get this budgethead local issue qty
            $budgetHeadLocalIssueQty = DailyConsumptionItem::whereIn('daily_consumption_id', $localIssueIds)->where('budget_head_id', $budgetHead->id)->sum('consumption_qty');

            // get this budgethead consumption qty
            $budgetHeadConsumptionQty = DailyUseItems::whereIn('daily_use_id', $consumptionIds)->where('budget_head_id', $budgetHead->id)->sum('use_qty');

            if ($budgetHeadDesignQty == 0 && $budgetHeadLocalIssueQty == 0 && $budgetHeadConsumptionQty == 0) {
                continue;
            }

            $data[] = [
                'budgetHeadName' => $budgetHead->name,
                'uom' => $budgetHeadMaterialInfo->materialUnit->name,
                'design_qty' => round($budgetHeadDesignQty, 2),
                'local_issue' => round($budgetHeadLocalIssueQty, 2),
                'consumption' => round($budgetHeadConsumptionQty, 2),
                'stock_qty' => round($budgetHeadLocalIssueQty - $budgetHeadConsumptionQty, 2),
            ];
        }


        return $data;
    }

    public function datewiseInventoryStatus()
    {
        $start_date = date('Y-m-d', strtotime(request()->start_date));
        $end_date = date('Y-m-d', strtotime(request()->end_date));
        $project_id = request()->project_id;

        $filters = [
            'start_date' => $start_date,
            'end_date' => $end_date,
            'project' => $project_id,
            'materials' => [],
            'company_id' => Auth::user()->company_id,
        ];

        $reportGenerator = new DashBoardStockReport($filters);
        $report = $reportGenerator->generate();

        return $report;
    }

    public function getProjectMaterialStock()
    {

        $projectId = request()->project_id;
        $materialId = request()->material_id;

        $filters = [
            'project' => $projectId,
            // 'material' => $budgetHead->id,
            'material' => $materialId,
            'unit_id' => request()->unit_id,
            'tower_id' => request()->tower_id,
        ];

        $basicMaterialStock = new BasicMaterialStock($filters);

        $stockBalance = $basicMaterialStock->stockBalance();
        $budgetBalance = $basicMaterialStock->budgetBalance();

        return [
            'budget_balance' => $budgetBalance,
            'stock_balance' => $stockBalance,
        ];
    }


    public function getLogisticsChargeMaterials(Request $request)
    {
        $project_id = $request->project_id;

        $project = Project::find($project_id);

        $materialIds = $project->projectMaterialIds();

        // material Ids WithOut Logistics Charge
        $materials = Material::whereIn('id', $materialIds)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            })
            ->with(['materialUnit'])
            ->where('transportation_charge', 1)
            ->get();

        return view('dashboard.logistics_charge.logistics_charge_materials_tbody', compact('materials'));
    }


    public function getProjectMaterialLocalStock()
    {

        $projectId = request()->project_id;
        $materialId = request()->material_id;

        $filters = [
            'project' => $projectId,
            // 'material' => $budgetHead->id,
            'material' => $materialId,
            'unit_id' => request()->unit_id,
            'tower_id' => request()->tower_id,
        ];

        $basicMaterialStock = new BasicMaterialStock($filters);

        $stockBalance = $basicMaterialStock->localIssueStockQty();

        return [
            'stock_balance' => $stockBalance,
        ];
    }


    public function projectWiseLogisticsBillTable()
    {

        $projectId = request()->projectId;
        $vendorId = request()->vendorId;

        // get logistics charges
        $logisticsCharge = LogisticsCharge::with(['items'])->where('project_id', $projectId)->first();


        // get issue ids
        $issues = DailyConsumption::with(['tower'])->where('project_id', $projectId)
            ->where('logistics_associate_id', $vendorId)
            ->get();


        $issueIds = $issues->pluck('id')->toArray();

        // get already paid
        $paidConsumptionIds = TBPItem::select('consumption_item_id')->get()->pluck('consumption_item_id')->toArray();

        // get issue items
        $issueItems = DailyConsumptionItem::with(['budgetHead'])->whereIn('daily_consumption_id', $issueIds)->whereNotIn('id', $paidConsumptionIds)->get();

        return view('dashboard.tbp.partial.create_table', compact('issues', 'issueItems', 'logisticsCharge'))->render();
    }


    public function getVendorDue()
    {

        $vendorId = request()->vendorId;

        // get material lifting of this vendor sum amount

        $totalLiftingSum = 0;

        $liftings = MaterialLifting::where('vendor_id', $vendorId)->get();

        foreach ($liftings as $lifting) {
            $totalLiftingSum += $lifting->totalAmount();
        }

        // get vendor paid amount
        $materialVendorPaymentSum = MaterialVendorPayment::where('vendor_id', $vendorId)->sum('payment_amount');

        return $totalLiftingSum - $materialVendorPaymentSum;
    }


    public function projectUnitTowerWiseBudget(Request $request)
    {

        $projectWiseBudget = ProjectWiseBudget::where('project_id', $request->project_id)
            ->with(['items', 'items.budgetHead'])
            ->where('is_additional', 0)
            ->where('unit_id', $request->unit_id)
            ->where('tower_id', $request->tower_id)
            ->first();

        $materials = [];

        foreach ($projectWiseBudget->items as $item) {

            if ($item->budgetHead->type == 'Material') {
                $materials[] = $item;
            }
        }

        return [
            'projectWiseBudget' => $projectWiseBudget,
            'materials' => $materials,
        ];
    }

    public function getProjectMaterialDesignStock(Request $request)
    {
        $projectWiseBudget = ProjectWiseBudget::where('project_id', $request->project_id)
            ->with(['items', 'items.budgetHead'])
            ->where('is_additional', 0)
            ->where('unit_id', $request->unit_id)
            ->where('tower_id', $request->tower_id)
            ->first();

        $pileNo = $projectWiseBudget->number_of_pile;

        $budgetQty = $projectWiseBudget->items->where('budget_head', $request->material_id)->sum('qty');

        if ($budgetQty) {
            return $budgetQty / $pileNo;
        }

        return 0;
    }


    public function getUnpaidLiftingInvoice(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required',
            'project_id' => 'required',
        ]);

        $invoices = [];

        $alreadyPaidIds = MaterialVendorPaymentInvoice::select('lifting_id')->get()->pluck('lifting_id')->toArray();

        $unpaidLiftings = MaterialLifting::with(['liftingMaterials', 'liftingMaterials.material'])
            ->whereNotIn('id', $alreadyPaidIds)
            ->where('vendor_id', $request->vendor_id)
            ->where('project_id', $request->project_id);

        if ($request->tower_id) {
            $unpaidLiftings->where('tower_id', $request->tower_id);
        }

        $unpaidLiftings = $unpaidLiftings->get();


        foreach ($unpaidLiftings as $unpaidLifting) {

            $materials = $unpaidLifting->liftingMaterials->map(function ($item) {
                return $item->material->name . '(' . $item->material_qty . ')';
            })->implode(', ');

            $invoices[] = [
                'id' => $unpaidLifting->id,
                'date' => date('d-m-Y', strtotime($unpaidLifting->vouchar_date)),
                'serial_no' => $unpaidLifting->system_serial,
                'voucher_no' => $unpaidLifting->voucher,
                'materials' => $materials,
                'total_amount' => $unpaidLifting->totalAmount(),
            ];
        }

        return $invoices;
    }
}
