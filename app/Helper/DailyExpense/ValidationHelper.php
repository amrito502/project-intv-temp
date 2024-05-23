<?php
namespace App\Helper\DailyExpense;


use App\Models\BudgetHead;
use App\Models\DailyExpense;
use App\Models\CashRequisition;
use App\Models\DailyExpenseItem;
use App\Models\CashVendorPayment;
use App\Models\ProjectWiseBudget;
use App\Models\CashRequisitionItem;
use App\Models\ProjectWiseBudgetItems;

class ValidationHelper
{

    protected $request;
    protected $budgetHeads;
    protected $searchedCashRequisitionIds;
    protected $searchedDailyExpenseIds;

    public function __construct($request)
    {
        // dd($request);
        $this->request = $request;
        $this->budgetHeads = BudgetHead::whereIn('id', $request->budget_head)->get();

        $this->searchedCashRequisitionIds = $this->searchedCashRequisitionIds();
        $this->searchedDailyExpenseIds = $this->searchedDailyExpenseIds();
    }

    public function searchedCashRequisitionIds()
    {
        $cashRequisitionIds = CashRequisition::where('project_id', $this->request->project_id);

        if ($this->request->tower) {
            $cashRequisitionIds = $cashRequisitionIds->where('tower_id', $this->request->tower);
        }

        if ($this->request->unit_config_id) {
            $cashRequisitionIds = $cashRequisitionIds->where('unit_config_id', $this->request->unit_config_id);
        }

        $cashRequisitionIds = $cashRequisitionIds
            ->where('status', "Paid")
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

    public function supplierPaymentTotal($budgetHeadId)
    {

        $cashRequisitionItemByBudgetHeadids = $this->cashRequisitionItemByBudgetHeadIds($budgetHeadId);

        $cashVendorPaymentTotal = CashVendorPayment::whereIn('requisition_item_id', $cashRequisitionItemByBudgetHeadids)
            ->sum('amount');

        return (float)$cashVendorPaymentTotal;
    }

    public function searchedDailyExpenseIds()
    {
        $dailyExpenseIds = DailyExpense::where('project_id', $this->request->project_id);

        if ($this->request->tower) {
            $dailyExpenseIds = $dailyExpenseIds->where('tower_id', $this->request->tower);
        }

        if ($this->request->unit_config_id) {
            $dailyExpenseIds = $dailyExpenseIds->where('unit_config_id', $this->request->unit_config_id);
        }

        $dailyExpenseIds = $dailyExpenseIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return $dailyExpenseIds;
    }

    public function budgetHeadCashBalance($budgetHeadId)
    {

        $totalIn =  $this->supplierPaymentTotal($budgetHeadId);

        $totalOut = (float)DailyExpenseItem::whereIn('daily_expense_id', $this->searchedDailyExpenseIds)
        ->where('budget_head_id', $budgetHeadId)
        ->sum('amount');

        $balance = $totalIn - $totalOut;

        return $balance;
    }

    public function budgetValidation()
    {

        $error = false;
        $errorMsg = '';
        $i = 0;

        foreach ($this->budgetHeads as $budgetHead) {

            if ($error == true) {
                break;
            }

            $thisHeadBalance = $this->budgetHeadCashBalance($budgetHead->id);

            // get productWise total consumption on the project and tower
            $newQty = (float)$this->request->amount[$i];

            if ($newQty > $thisHeadBalance) {
                $error = true;
                $errorMsg = $budgetHead->name . ' has insufficient balance';
            }


            $i++;
        }

        return [
            'error' => $error,
            'errorMsg' => $errorMsg,
        ];
    }

    public function validate()
    {

        $budgetValidation = $this->budgetValidation();
        if ($budgetValidation['error']) {
            return $budgetValidation;
        }

        return [
            'error' => false,
            'errorMsg' => "",
        ];
    }
}
