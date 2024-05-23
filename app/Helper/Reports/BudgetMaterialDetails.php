<?php

namespace App\Helper\Reports;

use App\Models\Unit;
use App\Models\Project;
use App\Models\BudgetHead;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;

class BudgetMaterialDetails
{

    public $projectId;
    public $project;
    public $unitId;
    public $unit;
    public $budgetHeadId;
    public $budgetHead;
    public $material;
    public $projectUnitConfigs;

    public function __construct($filters)
    {
        $this->projectId = $filters['projectId'];
        $this->project = Project::where('id', $this->projectId)->select(['project_name'])->first();

        $this->unitId = $filters['unitId'];
        $this->unit = Unit::where('id', $this->unitId)->select(['name'])->first();

        $this->budgetHeadId = $filters['budgetHeadId'];
        $this->budgetHead = BudgetHead::findOrFail($this->budgetHeadId);

        $this->material = $this->budgetHead->materialInfo();

        $this->projectUnitConfigIds = UnitConfiguration::where('project_id', $this->projectId)
            ->where('unit_id', $this->unitId)
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function query()
    {

        $budgets = ProjectWiseBudget::with(['unitConfig', 'tower', 'items.budgetHead'])
            ->where('is_additional', 0)
            ->where('project_id', $this->projectId)
            ->whereIn('unit_config_id', $this->projectUnitConfigIds)
            ->whereHas('items', function ($q) {
                $q->where('budget_head', $this->budgetHeadId);
            })
            ->get();

        return $budgets;
    }

    public function generate()
    {

        $queryData = $this->query();
        $budgetHead = BudgetHead::findOrFail($this->budgetHeadId);

        $data = [];

        $totalQty = 0;
        $totalAmount = 0;

        foreach ($queryData as $budget) {

            $lineQty = 0;
            $lineAmount = 0;

            foreach ($budget->items->where('budget_head', $this->budgetHeadId) as $item) {
                $lineQty += $item->qty;
                $lineAmount += $item->amount;
            }

            $totalQty += $lineQty;
            $totalAmount += $lineAmount;

            $ld = [
                'unit_config_name' => $budget->unitConfig->unit_name,
                'tower' => $budget?->tower?->name,
                'budgethead' => $budgetHead->name,
                'qty' => $lineQty,
                'amount' => $lineAmount,
            ];

            array_push($data, $ld);
        }

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
