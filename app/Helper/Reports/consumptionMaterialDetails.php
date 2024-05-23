<?php

namespace App\Helper\Reports;

use App\Models\Unit;
use App\Models\Project;
use App\Models\BudgetHead;
use App\Models\DailyConsumption;

class consumptionMaterialDetails
{
    public $projectId;
    public $project;
    public $unitId;
    public $unit;
    public $budgetHeadId;
    public $budgetHead;
    public $materialId;
    public $material;

    public function __construct($filters)
    {
        $this->projectId = $filters['projectId'];
        $this->project = Project::where('id', $this->projectId)->select(['project_name'])->first();

        $this->unitId = $filters['unitId'];
        $this->unit = Unit::where('id', $this->unitId)->select(['name'])->first();

        $this->budgetHeadId = $filters['budgetHeadId'];
        $this->budgetHead = BudgetHead::findOrFail($this->budgetHeadId);

        $this->materialId = $this->budgetHead->materialInfo()->id;
        $this->material = $this->budgetHead->materialInfo();

    }

    public function query()
    {

        $consumptions = DailyConsumption::with(['items', 'tower'])
            ->where('project_id', $this->projectId)
            ->where('unit_id', $this->unitId)
            ->whereHas('items', function ($q) {
                $q->where('budget_head_id', $this->budgetHeadId);
            })
            ->get();

        return [
            'consumptions' => $consumptions,
        ];
    }

    public function generate()
    {

        $queryData = $this->query();

        $data = [];

        $totalQty = 0;
        $totalAmount = 0;

        // consumptions data formatting start
        foreach ($queryData['consumptions'] as $consumption) {


            $lineQty = 0;
            $lineAmount = 0;

            foreach ($consumption->items->where('budget_head_id', $this->budgetHeadId) as $item) {
                $lineQty += $item->consumption_qty;
                $lineAmount += $item->consumption_used_qty;
            }

            $totalQty += $lineQty;
            $totalAmount += $lineAmount;

            $ld = [
                'type' => "Consumption",
                'tower' => $consumption?->tower?->name,
                'project_name' => $consumption->project->project_name,
                'unit_name' => $consumption->unit->name,
                'budgethead' => $this->budgetHead->name,
                'qty' => $lineQty,
                'amount' => $lineAmount,
            ];

            array_push($data, $ld);
        }
        // consumptions data formatting end

        return [
            'report_table' => $data,
            'report_total' => [
                'TotalQty' => $totalQty,
                'TotalAmount' => $totalAmount,
            ],
            "project" => $this->project,
            "unit" => $this->unit,
            "material_uom" => $this->material->materialUnit->name,
        ];
    }
}
