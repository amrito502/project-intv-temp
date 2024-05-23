<?php

namespace App\Helper\Reports;

use App\Models\Unit;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\DailyExpense;
use App\Models\MaterialIssue;
use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\DailyExpenseItem;
use App\Models\MaterialIssueItem;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectWiseBudgetItems;
use App\Models\MaterialLiftingMaterial;
use App\Helper\Project\MaterialConsumption;
use App\Models\BudgetHead;
use App\Models\CashRequisitionItem;
use App\Models\CashVendorPayment;
use App\Models\DailyConsumption;
use App\Models\DailyConsumptionItem;
use App\Models\SupplierPayment;
use App\Models\SupplierPaymentItem;
use App\Models\TBP;

class CashDueStatusReport
{

    public int $project_id;
    public $tower_ids;

    public $searchedBudgetIds;
    public $searchedAdditionalBudgetIds;
    public $searchedCashRequisitionIds;
    public $searchedDailyExpenseIds;

    public function __construct($filters)
    {
        $this->project_id = $filters['project_id'];
        $this->tower_ids = $filters['tower_ids'];

        $this->searchedBudgetIds = $this->searchedBudgetIds();
        $this->searchedAdditionalBudgetIds = $this->searchedBudgetIds(true);
        $this->searchedCashRequisitionIds = $this->searchedCashRequisitionIds();
        $this->searchedDailyExpenseIds = $this->searchedDailyExpenseIds();
    }


    public function searchedBudgetIds($isAdditional = false)
    {
        $projectWiseBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id);

        if ($isAdditional) {
            $projectWiseBudgetIds = $projectWiseBudgetIds->where('is_additional', 1);
        } else {
            $projectWiseBudgetIds = $projectWiseBudgetIds->where('is_additional', 0);
        }

        if ($this->tower_ids) {
            $projectWiseBudgetIds = $projectWiseBudgetIds->whereIn('tower_id', $this->tower_ids);
        }

        $projectWiseBudgetIds = $projectWiseBudgetIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return $projectWiseBudgetIds;
    }

    public function projectWiseBudgetItems()
    {

        $projectItems = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $this->searchedBudgetIds)->select('budget_head')->get()->pluck('budget_head')->toArray();

        $projectItems = array_unique($projectItems);

        // budgetHeads
        $budgetHeads = BudgetHead::whereIn('id', $projectItems)->where('type', 'Cash')->get();

        return $budgetHeads;
    }

    public function searchedCashRequisitionIds()
    {
        $cashRequisitionIds = CashRequisition::where('project_id', $this->project_id);

        if ($this->tower_ids) {
            $cashRequisitionIds = $cashRequisitionIds->whereIn('tower_id', $this->tower_ids);
        }

        $cashRequisitionIds = $cashRequisitionIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return $cashRequisitionIds;
    }

    public function cashRequisitionItemByBudgetHeadIds($budgetHeadId)
    {

        // cash requisition Item Ids
        $cashRequisitionItemIds = CashRequisitionItem::whereIn('cash_requisition_id', $this->searchedCashRequisitionIds)
            ->where('budget_head_id', $budgetHeadId)
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return $cashRequisitionItemIds;
    }

    public function searchedDailyExpenseIds()
    {
        $dailyExpenseIds = DailyExpense::where('project_id', $this->project_id);

        if ($this->tower_ids) {
            $dailyExpenseIds = $dailyExpenseIds->whereIn('tower_id', $this->tower_ids);
        }

        $dailyExpenseIds = $dailyExpenseIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return $dailyExpenseIds;
    }

    public function budgetTotal($budgetHeadId)
    {
        $budgetTotal = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $this->searchedBudgetIds)
            ->where('budget_head', $budgetHeadId)
            ->sum('amount');

        return (float)$budgetTotal;
    }

    public function additionalBudgetTotal($budgetHeadId)
    {

        $budgetTotal = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $this->searchedAdditionalBudgetIds)
            ->where('budget_head', $budgetHeadId)
            ->sum('amount');

        return (float)$budgetTotal;
    }

    public function cashRequisitionApprovedTotal($budgetHeadId)
    {
        $cashRequisitionApprovedTotal = CashRequisitionItem::whereIn('cash_requisition_id', $this->searchedCashRequisitionIds)
            ->where('budget_head_id', $budgetHeadId)
            ->sum('approved_amount');

        return (float)$cashRequisitionApprovedTotal;
    }

    public function tbpApprovedTotal($budgetHeadId)
    {

        $tbpApprovedTotal = 0;

        $tbps = TBP::where('project_id', $this->project_id)
            ->where('budget_head_id', $budgetHeadId)
            ->get();

        foreach ($tbps as $tbp) {
            $tbpApprovedTotal += $tbp->grandTotalApprovedAmount();
        }

        return (float)$tbpApprovedTotal;
    }


    public function tbpPaidTotal($budgetHeadId)
    {

        $tbpApprovedTotal = 0;

        $tbps = TBP::where('project_id', $this->project_id)
            ->where('budget_head_id', $budgetHeadId)
            ->get();

        foreach ($tbps as $tbp) {
            $tbpApprovedTotal += $tbp->grandTotalPaidAmount();
        }

        return (float)$tbpApprovedTotal;
    }

    public function dailyExpenseTotal($budgetHeadId)
    {
        $dailyExpenseTotal = DailyExpenseItem::whereIn('daily_expense_id', $this->searchedDailyExpenseIds)
            ->where('budget_head_id', $budgetHeadId)
            ->sum('amount');

        return (float)$dailyExpenseTotal;
    }

    public function supplierPaymentTotal($budgetHeadId)
    {

        $cashRequisitionItemByBudgetHeadids = $this->cashRequisitionItemByBudgetHeadIds($budgetHeadId);

        $cashVendorPaymentTotal = CashVendorPayment::whereIn('requisition_item_id', $cashRequisitionItemByBudgetHeadids)
            ->sum('amount');

        return (float)$cashVendorPaymentTotal;
    }

    public function tableData()
    {

        $tableData = [];

        // get material and self define items start
        $budgetHeads = $this->projectWiseBudgetItems();

        foreach ($budgetHeads as $budgetHead) {

            $approved = $this->tbpApprovedTotal($budgetHead->id) + $this->cashRequisitionApprovedTotal($budgetHead->id);
            $issued = $this->tbpPaidTotal($budgetHead->id) + $this->supplierPaymentTotal($budgetHead->id);
            $usage = $this->tbpPaidTotal($budgetHead->id) + $this->dailyExpenseTotal($budgetHead->id);

            $ld = [
                'head' => $budgetHead->name,
                'budget' => $this->budgetTotal($budgetHead->id),
                'additional_budget' => $this->additionalBudgetTotal($budgetHead->id),
                'approved' => $approved,
                'issued' => $issued,
                'usage' => $usage,
            ];

            $ld['issue_due'] = $approved - $issued;
            $ld['field_hand'] = $issued - $usage;

            $tableData[] = $ld;
        }

        return $tableData;
    }


    public function generate()
    {

        $tableData = $this->tableData();

        return $tableData;
    }
}
