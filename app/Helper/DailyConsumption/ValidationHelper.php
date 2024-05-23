<?php

namespace App\Helper\DailyConsumption;

use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\DailyUseItems;
use App\Helper\Project\ProjectHelper;
use App\Helper\Project\BasicMaterialStock;

class ValidationHelper
{

    protected $request;
    protected $budgetHeads;

    public function __construct($request)
    {
        $this->request = $request;
        $this->budgetHeads = BudgetHead::whereIn('id', $request->budgetHeadIds)->get();
    }

    public function productWiseBudgetQty($budgetHead)
    {

        $filters = [
            'project' => $this->request->project,
            'material' => $budgetHead->materialInfo()->id,
        ];

        $stockHelper = new BasicMaterialStock($filters);

        $BudgetQty = $stockHelper->budgetBalance();

        return $BudgetQty;
    }

    public function productWiseStockQty($budgetHead)
    {

        $filters = [
            'project' => $this->request->project,
            'unit_id' => $this->request->unit_id,
            'tower_id' => $this->request->tower,
            'material' => $budgetHead->materialInfo()->id,
        ];

        $stockHelper = new BasicMaterialStock($filters);

        return $stockHelper->stockQty();

    }

    public function productWiseConsumptionQty($budgetHead)
    {

        $ProjectWiseConsumptionIds = DailyUses::where('project_id', $this->request->project);

        if($this->request->unit_ids){
            $ProjectWiseConsumptionIds = $ProjectWiseConsumptionIds->whereIn('unit_id', $this->request->unit_ids);
        }

        if($this->request->tower){
            $ProjectWiseConsumptionIds = $ProjectWiseConsumptionIds->where('tower_id', $this->request->tower);
        }

        $ProjectWiseConsumptionIds = $ProjectWiseConsumptionIds->select('id')->get()->pluck('id')->toArray();

        $ConsumptionQty = DailyUseItems::where('daily_use_id', $ProjectWiseConsumptionIds)->where('budget_head_id', $budgetHead->id)->sum('use_qty');

        return $ConsumptionQty;
    }


    public function Validation()
    {

        $error = false;
        $errorMsg = '';
        $i = 0;

        // init project helper
        $projectHelper = new ProjectHelper($this->request->project, $this->request->unit_ids);

        $budgetItemsIds = $projectHelper->budgetItemsBudgetHeadIds();


        foreach ($this->budgetHeads as $budgetHead) {

            if ($error == true) {
                break;
            }

            $budgetQty = 9999999;

            // check if the budgethead is used in budget prepare
            if (in_array($budgetHead->id, $budgetItemsIds)) {

                // get productWise total budgetQty on the project and tower
                $budgetQty = (double)$this->productWiseBudgetQty($budgetHead);

            }


            if($budgetHead->type != "Cash"){

                //stock Qty
                $stockQty = $this->productWiseStockQty($budgetHead);
            }else{
                $stockQty = 999999;
            }


            // get productWise total consumption on the project and tower
            // $consumptionQty = $this->productWiseConsumptionQty($budgetHead);

            // new qty + old consumption
            $newQty = (float)$this->request->consumption_qty[$i];


            // compare
            if ($newQty > $budgetQty) {
                $error = true;
                $errorMsg = $budgetHead->name . ' Exceeded budget Qty';
            }

            if ($newQty > $stockQty) {
                $error = true;
                $errorMsg = $budgetHead->name . ' Exceeded stock Qty';
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

        $budgetValidation = $this->Validation();
        if ($budgetValidation['error']) {
            return $budgetValidation;
        }

        return [
            'error' => false,
            'errorMsg' => "",
        ];
    }
}
