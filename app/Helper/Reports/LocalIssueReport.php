<?php

namespace App\Helper\Reports;

use App\Models\DailyUses;
use App\Models\DailyConsumption;
use App\Helper\Project\MaterialHelper;

class LocalIssueReport
{

    public $start_date;
    public $end_date;
    public $project_id;
    public $tower_ids;
    public $unit_ids;
    public $material_ids;
    public $budgetHead_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project_id = $filters['project'];
        $this->tower_ids = $filters['towers'];
        $this->material_ids = $filters['materials'];
        if($this->material_ids){
            $this->budgetHead_ids = MaterialHelper::materialIdToBudgetHeadId($filters['materials']);
        }
        $this->unit_ids = $filters['units'];
    }

    public function query()
    {

        $dailyConsumptions = DailyConsumption::where('project_id', $this->project_id)
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

        $queryData = $this->query();


        $data = [];

        foreach ($queryData as $dailyConsumption) {

            foreach ($dailyConsumption->items as $item) {

                if($this->material_ids){
                    if(!in_array($item->budget_head_id, $this->budgetHead_ids)){
                        continue;
                    }
                }

                $material = $item->budgetHead->name;

                if($item->budgetHead->materialInfo()){
                    $material .= ' (' . $item->budgetHead->materialInfo()->materialUnit->name . ')';
                }

                $ld = [
                    'date' => $dailyConsumption->date,
                    'unit' => $dailyConsumption->unit->name,
                    'tower' => $dailyConsumption->tower->name,
                    'material' => $material,
                    'qty' => $item->consumption_qty,
                ];

                array_push($data, $ld);
            }
        }

        return [
            'report_table' => $data,
        ];
    }
}
