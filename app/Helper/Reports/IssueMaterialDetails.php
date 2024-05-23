<?php

namespace App\Helper\Reports;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Project;
use App\Models\BudgetHead;
use App\Models\MaterialIssue;
use App\Models\MaterialLifting;

class IssueMaterialDetails
{
    public $projectId;
    public $project;
    public $unitId;
    public $unit;
    public $budgetHeadId;
    public $budgetHead;
    public $materialId;

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

        $liftings = MaterialLifting::with(['item', 'tower'])
            ->where('project_id', $this->projectId)
            ->where('unit_id', $this->unitId)
            ->whereHas('item', function ($q) {
                $q->where('material_id', $this->materialId);
            })
            ->get();


        $issues = MaterialIssue::with(['issuedMaterials.material', 'tower'])
            ->where('project_id', $this->projectId)
            ->where('unit_id', $this->unitId)
            ->whereHas('issuedMaterials', function ($q) {
                $q->where('material_id', $this->materialId);
            })
            ->get();

        return [
            'liftings' => $liftings,
            'issues' => $issues,
        ];
    }

    public function generate()
    {

        $queryData = $this->query();

        $data = [];

        $totalQty = 0;
        $totalAmount = 0;

        // lifting data formatting start
        foreach ($queryData['liftings'] as $lifting) {


            $lineQty = 0;
            $lineAmount = 0;

            foreach ($lifting->item->where('material_id', $this->materialId) as $item) {
                $lineQty += $item->material_qty;
                $lineAmount += $item->material_rate * $item->material_qty;
            }

            $totalQty += $lineQty;
            $totalAmount += $lineAmount;

            $ld = [
                'type' => "Local Lifting",
                'tower' => $lifting?->tower?->name,
                'date' => Carbon::parse($lifting->vouchar_date)->format('d-m-Y'),
                'serial' => $lifting->system_serial,
                'budgethead' => $this->budgetHead->name,
                'qty' => $lineQty,
                'amount' => $lineAmount,
            ];

            array_push($data, $ld);
        }
        // lifting data formatting end


        // issue data formatting start
        foreach ($queryData['issues'] as $issue) {

            $lineQty = 0;
            $lineAmount = 0;

            foreach ($issue->issuedMaterials->where('material_id', $this->materialId) as $item) {
                $lineQty += $item->receive_qty;
                $lineAmount += $item->material_rate * $item->receive_qty;
            }

            $totalQty += $lineQty;
            $totalAmount += $lineAmount;

            $ld = [
                'type' => "Central Receive",
                'tower' => $issue?->tower?->name,
                'date' => Carbon::parse($lifting->issue_date)->format('d-m-Y'),
                'serial' => $issue->system_serial,
                'budgethead' => $this->budgetHead->name,
                'qty' => $lineQty,
                'amount' => $lineAmount,
            ];

            array_push($data, $ld);
        }
        // issue data formatting end

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
