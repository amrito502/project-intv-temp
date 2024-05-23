<?php

namespace App\Helper\Reports;

use App\Models\DailyUses;
use App\Models\DailyConsumption;
use App\Helper\Project\MaterialHelper;
use App\Models\ProjectWiseBudget;

class DailyConsumptionReport
{

    public $start_date;
    public $end_date;
    public $project_id;
    public $tower_ids;
    public $unit_ids;
    public $material_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project_id = $filters['project'];
        $this->tower_ids = $filters['towers'];
        $this->material_ids = $filters['materials'];

        if ($this->material_ids) {
            $this->budgetHead_ids = MaterialHelper::materialIdToBudgetHeadId($filters['materials']);
        }

        $this->unit_ids = $filters['units'];
    }

    public function query()
    {

        $dailyConsumptions = DailyUses::where('project_id', $this->project_id)
            ->where('date', '>=', $this->start_date)
            ->where('date', '<=', $this->end_date)
            ->with(['project', 'unit', 'tower', 'items', 'items.budgetHead']);

        if ($this->unit_ids) {
            $dailyConsumptions = $dailyConsumptions->whereIn('unit_id', $this->unit_ids);
        }

        if ($this->tower_ids) {
            $dailyConsumptions = $dailyConsumptions->whereIn('tower_id', $this->tower_ids);
        }

        $dailyConsumptions = $dailyConsumptions->get();

        return $dailyConsumptions;
    }

    public function generate()
    {

        // get tower and unit budget
        $budgetPrepare = ProjectWiseBudget::where('project_id', $this->project_id)
            ->where('is_additional', 0)
            ->with(['items', 'items.budgetHead']);

        if ($this->tower_ids) {
            $budgetPrepare = $budgetPrepare->whereIn('tower_id', $this->tower_ids);
        }

        if ($this->unit_ids) {
            $budgetPrepare = $budgetPrepare->whereIn('unit_id', $this->unit_ids);
        }

        $budgetPrepare = $budgetPrepare->first();

        $numberOfPile = $budgetPrepare->number_of_pile;

        $queryData = $this->query();


        $data = [];

        foreach ($queryData as $dailyConsumption) {

            foreach ($dailyConsumption->items as $item) {

                if ($this->material_ids) {
                    if (!in_array($item->budget_head_id, $this->budgetHead_ids)) {
                        continue;
                    }
                }

                $rowHtmlClass = "";
                $totalQty = $budgetPrepare->items->where('budget_head', $item->budgetHead->id)->first()->qty;

                $perPileQty = $totalQty / $numberOfPile;

                $qtyString = $perPileQty - $item->use_qty;

                if ($perPileQty < $item->use_qty) {
                    $rowHtmlClass = "text-danger";
                }

                $ld = [
                    'rowHtmlClass' => $rowHtmlClass,
                    'date' => date('d-m-Y', strtotime($dailyConsumption->date)),
                    'unit' => $dailyConsumption?->unit?->name,
                    'tower' => $dailyConsumption?->tower?->name,
                    'pile_no' => $dailyConsumption->pile_no,
                    'material' => $item->budgetHead->name . ' (' . $item->budgetHead->materialInfo()->materialUnit->name . ')',
                    'budget_qty' => $perPileQty,
                    'used_qty' => $item->use_qty,
                    'qtyString' => $qtyString,
                    'remarks' => $item->remarks,
                ];

                array_push($data, $ld);
            }
        }

        return [
            'report_table' => $data,
        ];
    }
}
