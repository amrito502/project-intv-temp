<?php

namespace App\Helper\Reports;

use App\Models\Unit;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\CashRequisition;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use App\Models\ProjectWiseBudgetItems;
use App\Helper\Project\MaterialConsumption;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueItem;
use App\Models\MaterialLifting;
use App\Models\MaterialLiftingMaterial;

class PlanSheetFollowUpReport
{

    public int $project_id;
    public $unit_ids;
    public $tower_ids;
    public array $project_unit_ids;
    public array $project_unit_config_ids;
    public array $project_unit_config_by_unit_id;

    public function __construct($filters)
    {
        $this->project_id = $filters['project_id'];
        $this->unit_ids = $filters['unit_ids'];
        $this->tower_ids = $filters['tower_ids'];

        if ($this->unit_ids) {
            $this->project_unit_ids = $this->unit_ids;
        } else {
            $this->project_unit_ids = $this->getProjectUnitIds();
        }

        $this->project_unit_config_ids = $this->getProjectUnitConfigIds();
        $this->project_unit_config_by_unit_id = $this->getProjectUnitConfigByUnitId();

    }


    public function getProjectUnitIds()
    {
        return UnitConfiguration::where('project_id', $this->project_id)->select('unit_id')->get()->pluck('unit_id')->toArray();
    }

    public function getProjectUnitConfigIds()
    {
        return UnitConfiguration::where('project_id', $this->project_id)->select('id')->get()->pluck('id')->toArray();
    }

    public function getProjectUnitConfigByUnitId()
    {
        $unit_configs = UnitConfiguration::whereIn('id', $this->project_unit_config_ids)->get();

        $unit_configs_group_by_unit = $unit_configs->groupBy('unit_id');
        $unit_ids = array_keys($unit_configs_group_by_unit->toArray());

        $unitWiseConfigs = [];

        foreach ($unit_ids as $unit_id) {
            $unitConfigIds = $unit_configs->where('unit_id', $unit_id)->pluck('id')->toArray();
            $unitWiseConfigs[$unit_id] = $unitConfigIds;
        }

        return $unitWiseConfigs;
    }


    public function projectWiseBudgetItems($unit_id)
    {



        $projectWiseBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id)
            ->where('is_additional', 0)
            ->whereIn('unit_config_id', $this->project_unit_config_by_unit_id[$unit_id]);

        if ($this->tower_ids) {
            $projectWiseBudgetIds = $projectWiseBudgetIds->whereIn('tower_id', $this->tower_ids);
        }

        $projectWiseBudgetIds = $projectWiseBudgetIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();


        $projectitems = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectWiseBudgetIds)
            ->with(['budgetHead', 'unit_of_measurement', 'unit_of_measurement'])->get()->groupBy('budget_head');

        return $projectitems;
    }


    public function tableData($unit_id)
    {

        $unit = Unit::findOrFail($unit_id);

        $tableData = [
            'table_title' => [
                'unit_name' => $unit->name,
            ],
            'table_data' => [
                'material_data' => [
                    'column_type_data' => [
                        'title' => 'Material Cost',
                    ],
                    'items' => [],
                ],
                'self_define_cost' => [
                    'column_type_data' => [
                        'title' => 'Self Define Cost',
                    ],
                    'items' => [],
                ],
            ]
        ];

        $projectitems = $this->projectWiseBudgetItems($unit_id);

        foreach ($projectitems as $projectitem) {

            $totalUsageAmount = 0;
            $lifting_qty = 0;
            $issue_qty = 0;

            $item_type = $projectitem->first()->budgetHead->type;
            $budgetHeadId = $projectitem->first()->budgetHead->id;
            $itemMaterialId = $projectitem->first()?->budgetHead?->materialInfo()?->id;
            $materialUnitName = $projectitem->first()?->budgetHead?->materialInfo()?->materialUnit?->name;


            if ($item_type == 'Material') {

                $MaterialConsumption = new MaterialConsumption(projectId: $this->project_id, unitIds: [$unit_id], towerId: $this->tower_ids);
                $totalConsumedMaterial = $MaterialConsumption->totalConsumedMaterialByProjectAndTower([$budgetHeadId], $this->project_id, $this->tower_ids);


                $lifting_ids = MaterialLifting::where('project_id', $this->project_id)->where('unit_id', $unit_id)->select('id')->get()->pluck('id')->toArray();
                $lifting_qty = MaterialLiftingMaterial::whereIn('material_lifting_id', $lifting_ids)->where('material_id', $itemMaterialId)->sum('material_qty');

                $issue_ids = MaterialIssue::where('project_id', $this->project_id)->where('unit_id', $unit_id)->select('id')->get()->pluck('id')->toArray();
                $issue_qty = MaterialIssueItem::whereIn('material_issue_id', $issue_ids)->where('material_id', $itemMaterialId)->sum('receive_qty');
            } else {
                $usage_amount = CashRequisition::where('project_id', $this->project_id)->where(
                    'unit_config_id',
                    $unit_id
                )->with(['items', 'items.budgethead', 'items.vendor'])
                    ->whereHas('items', function ($q) use ($itemMaterialId) {
                        if ($itemMaterialId) {
                            $q->whereIn('budget_head_id', $itemMaterialId);
                        }
                    });

                if ($this->tower_ids) {
                    $usage_amount = $usage_amount->where('tower_id', $this->tower_ids);
                }

                $usage_amount = $usage_amount->get();

                $totalUsageAmount = 0;

                foreach ($usage_amount as $usage) {
                    $totalUsageAmount += $usage->RequisitionTotalAmount();
                }
            }

            $item_name = $projectitem->first()->budgetHead->name . ' (' . $materialUnitName . ')';
            $item_qty = $projectitem->sum('qty');
            $item_amount = $projectitem->sum('amount');

            $itemData = [
                'material_name' => $item_name,
                'budget_qty' => $item_qty,
                'project_issue' => $lifting_qty + $issue_qty,
                'used_qty' => $totalConsumedMaterial,
                'in_stock' => ($lifting_qty + $issue_qty) - $totalConsumedMaterial,
                'budget_pending' => $item_qty - $totalConsumedMaterial,
                'budget_value' => $item_amount,
                'used_value' => $totalUsageAmount,
                'pending_value' => $item_amount - $totalUsageAmount,
            ];

            if ($item_type == 'Material') {
                array_push($tableData['table_data']['material_data']['items'], $itemData);
            } else {
                array_push($tableData['table_data']['self_define_cost']['items'], $itemData);
            }
        }


        return $tableData;
    }


    public function generate()
    {

        $data = [];

        foreach (array_unique($this->project_unit_ids) as $unit_id) {

            if (array_key_exists($unit_id, $this->project_unit_config_by_unit_id)) {
                $tableData = $this->tableData($unit_id);
                array_push($data, $tableData);
            }
        }

        return $data;
    }
}
