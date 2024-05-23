<?php
namespace App\Helper\DailyUse;


use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\DailyUseItems;
use App\Models\DailyConsumption;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use App\Models\DailyConsumptionItem;
use App\Helper\Project\ProjectHelper;
use App\Models\ProjectWiseBudgetItems;
use App\Helper\Ui\FlashMessageGenerator;
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

    public function productWiseStockQty($budgetHead)
    {

        $filters = [
            'project' => $this->request->project,
            'unit_id' => $this->request->unit_id,
            'tower_id' => $this->request->tower,
            'material' => $budgetHead->materialInfo()->id,
        ];

        $stockHelper = new BasicMaterialStock($filters);

        return $stockHelper->localIssueStockQty();

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


    public function budgetValidation()
    {

        $error = false;
        $errorMsg = '';
        $i = 0;

        foreach ($this->budgetHeads as $budgetHead) {

            if ($error == true) {
                break;
            }

            if($budgetHead->type != "Cash"){

                //stock Qty
                $stockQty = $this->productWiseStockQty($budgetHead);
            }else{
                $stockQty = 999999;
            }

            // get productWise total consumption on the project and tower
            $newQty = (float)$this->request->consumption_qty[$i];

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
