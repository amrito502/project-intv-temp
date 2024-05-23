<?php

namespace App\Helper\Reports;

use App\Helper\Project\MaterialHelper;
use App\Models\Project;
use App\Models\Material;
use Illuminate\Support\Carbon;
use App\Helper\Project\StockHelper;
use App\Models\ProjectWiseBudget;
use App\Models\ProjectWiseBudgetItems;

class DashBoardStockReport
{

    public $filters;
    public $start_date;
    public $end_date;
    public $project_id;
    public $material_ids;
    public $company_id;


    public function __construct($filters)
    {
        $this->filters = $filters;
        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project_id = $filters['project'];
        $this->material_ids = $filters['materials'];
        $this->company_id = $filters['company_id'];

        if (!$this->material_ids) {

            if($this->project_id == 999999){
                $this->material_ids = Material::select(['id'])->get()->pluck('id')->toArray();
            }else{
                $project = Project::findOrFail($this->project_id);
                $this->material_ids = $project->projectMaterialIds();
            }

        }

        $this->materials = Material::whereIn('id', $this->material_ids)->with('materialUnit')->get();
    }

    public function query()
    {

        $stockHelper = new StockHelper($this->filters);

        $liftingStock = $stockHelper->LiftingStock();
        $receiveStock = $stockHelper->ReceiveStock();
        $returnStock = $stockHelper->ReturnStock();
        $consumedStock = $stockHelper->ConsumedStock();
        $localIssueStock = $stockHelper->localIssueStock();

        return [
            'liftingStock' => $liftingStock,
            'receiveStock' => $receiveStock,
            'returnStock' => $returnStock,
            'consumedStock' => $consumedStock,
            'localIssueStock' => $localIssueStock,
        ];
    }

    public function liftingFormat($liftingStocks)
    {
        $data = [];

        // format lifting stock
        foreach ($liftingStocks->groupBy('material_id') as $materialGroup) {

            $ld = [
                'material_id' => $materialGroup->first()->material_id,
                'total_qty' => $materialGroup->sum('material_qty'),
            ];

            array_push($data, $ld);
        }

        return collect($data);
    }

    public function transferFormat($returnStock)
    {
        $data = [];

        // format return stock
        foreach ($returnStock->groupBy('material_id') as $materialGroup) {

            $ld = [
                'material_id' => $materialGroup->first()->material_id,
                'total_qty' => $materialGroup->sum('receive_qty'),
            ];

            array_push($data, $ld);
        }

        return collect($data);
    }

    public function consumedFormat($consumedStock)
    {
        $data = [];

        // format return stock
        foreach ($consumedStock->groupBy('budget_head_id') as $materialGroup) {

            $ld = [
                'material_id' => $materialGroup->first()->budgetHead->materialInfo()->id,
                'total_qty' => $materialGroup->sum('use_qty'),
            ];

            array_push($data, $ld);
        }

        return collect($data);
    }

    public function localIssueFormat($localIssueReceived)
    {
        $data = [];

        // format return stock
        foreach ($localIssueReceived->groupBy('budget_head_id') as $materialGroup) {

            if (!$materialGroup->first()->budgetHead->materialInfo()) {
                continue;
            }

            $ld = [
                'material_id' => $materialGroup->first()->budgetHead->materialInfo()->id,
                'total_qty' => $materialGroup->sum('consumption_qty'),
            ];

            array_push($data, $ld);
        }

        return collect($data);
    }

    public function formatData($queryData)
    {

        $liftingStock = $this->liftingFormat($queryData['liftingStock']);
        $receiveStock = $this->transferFormat($queryData['receiveStock']);
        $returnStock = $this->transferFormat($queryData['returnStock']);
        $consumedStock = $this->consumedFormat($queryData['consumedStock']);
        $localIssueStock = $this->localIssueFormat($queryData['localIssueStock']);

        return [
            'liftingStock' => $liftingStock,
            'receiveStock' => $receiveStock,
            'returnStock' => $returnStock,
            'consumedStock' => $consumedStock,
            'localIssueStock' => $localIssueStock,
        ];
    }


    public function opening()
    {

        $openingData = [];

        $openingFilter = $this->filters;

        $endDate = Carbon::createFromFormat('Y-m-d', $openingFilter['start_date']);

        $openingFilter['end_date'] = $endDate->subDay()->format('Y-m-d');
        $openingFilter['start_date'] = '0000-00-00';
        $openingStock = new StockReport($openingFilter);

        $queryData = $openingStock->query();

        $formattedData = $openingStock->formatData($queryData);

        foreach ($openingStock->materials as $material) {

            $liftingQty = $formattedData['liftingStock']->where('material_id', $material->id)->first() ? $formattedData['liftingStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $receiveQty = $formattedData['receiveStock']->where('material_id', $material->id)->first() ? $formattedData['receiveStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $returnQty = $formattedData['returnStock']->where('material_id', $material->id)->first() ? $formattedData['returnStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $consumptionQty = $formattedData['consumedStock']->where('material_id', $material->id)->first() ? $formattedData['consumedStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $localIssueQty = $formattedData['localIssueStock']->where('material_id', $material->id)->first() ? $formattedData['localIssueStock']->where('material_id', $material->id)->first()['total_qty'] : 0;

            $ld = [
                'material_id' => $material->id,
                'opening' => 0,
                'lifting' => $liftingQty,
                'receive' => $receiveQty + $localIssueQty,
                'return' => $returnQty,
                'localIssueQty' => $localIssueQty,
                'consumption' => $consumptionQty,
            ];

            $ld['balance'] = ($ld['opening'] + $ld['lifting'] + $ld['receive']) - ($ld['return'] + $ld['localIssueQty'] + $ld['consumption']);

            array_push($openingData, $ld);
        }


        return  collect($openingData);
    }

    public function generate()
    {

        $queryData = $this->query();
        $formattedData = $this->formatData($queryData);
        $openingData = $this->opening();

        $data = [];

        // projectwise budget ids
        $projectWiseBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id)
            ->where('is_additional', 0)
            ->pluck('id')
            ->toArray();

        // projectwise additional budget ids
        $projectWiseAdditionalBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id)
            ->where('is_additional', 1)
            ->pluck('id')
            ->toArray();


        foreach ($this->materials as $material) {

            $budgetHead = $material->budgetheadInfo();

            if(!$budgetHead){
                continue;
            }


            // get this material budget qty sun
            $designQty = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectWiseBudgetIds)->where('budget_head', $budgetHead->id)->sum('qty');
            $additionalQty = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectWiseAdditionalBudgetIds)->where('budget_head', $budgetHead->id)->sum('qty');

            if($this->project_id != 999999){
                if($designQty == 0 && $additionalQty == 0){
                    continue;
                }
            }

            $openingQty = $openingData->where('material_id', $material->id)->first() ? $openingData->where('material_id', $material->id)->first()['balance'] : 0;
            $liftingQty = $formattedData['liftingStock']->where('material_id', $material->id)->first() ? $formattedData['liftingStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $receiveQty = $formattedData['receiveStock']->where('material_id', $material->id)->first() ? $formattedData['receiveStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $returnQty = $formattedData['returnStock']->where('material_id', $material->id)->first() ? $formattedData['returnStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $consumptionQty = $formattedData['consumedStock']->where('material_id', $material->id)->first() ? $formattedData['consumedStock']->where('material_id', $material->id)->first()['total_qty'] : 0;
            $localIssueStockQty = $formattedData['localIssueStock']->where('material_id', $material->id)->first() ? $formattedData['localIssueStock']->where('material_id', $material->id)->first()['total_qty'] : 0;


            if($this->project_id == 999999){
                if($openingQty == 0 && $liftingQty == 0 && $receiveQty == 0 && $returnQty == 0 && $consumptionQty == 0){
                    continue;
                }
            }

            $ld = [
                'material' => $material->name . ' (' . $material->materialUnit->name . ')',
                'opening' => round($openingQty, 2),
                'design_qty' => (int)$designQty,
                'additional_qty' => (int)$additionalQty,
                'lifting' => round($liftingQty, 2),
                'receive' => round($receiveQty, 2),
                'localIssueStockQty' => round($localIssueStockQty, 2),
                'return' => round($returnQty, 2),
                'consumption' => round($consumptionQty, 2),
            ];

            $ld['balance'] = round(($ld['opening'] + $ld['lifting'] + $ld['receive']) - ($ld['return'] + $ld['localIssueStockQty']), 2);
            $ld['field_stock'] = round(($ld['localIssueStockQty'] - $ld['consumption']), 2);

            array_push($data, $ld);
        }

        return [
            'report_table' => $data,
        ];
    }
}
