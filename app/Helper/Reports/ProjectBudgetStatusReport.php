<?php

namespace App\Helper\Reports;

use App\Models\TBP;
use App\Models\Unit;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\DailyExpense;
use App\Models\MaterialIssue;
use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\DailyExpenseItem;
use App\Models\MaterialIssueItem;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use App\Models\ProjectBudgetWiseRoa;
use Illuminate\Support\Facades\Auth;
use App\Models\ProjectWiseBudgetItems;
use App\Models\MaterialLiftingMaterial;
use App\Helper\Project\MaterialConsumption;

class ProjectBudgetStatusReport
{

    public int $project_id;
    public $tower_ids;
    public array $project_unit_ids;
    public array $project_unit_config_ids;
    public array $project_unit_config_by_unit_id;

    public function __construct($filters)
    {
        $this->project_id = $filters['project_id'];
        $this->tower_ids = $filters['tower_ids'];
        $this->project_unit_ids = $this->getProjectUnitIds();
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


    public function getRoa($unit_id)
    {
        $projectUnitConfigIds = UnitConfiguration::where('project_id', $this->project_id)
            ->where('unit_id', $unit_id)
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        $projectWiseBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id)
            ->where('is_additional', 0)
            ->whereIn('unit_config_id', $projectUnitConfigIds)
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        $roas = ProjectBudgetWiseRoa::whereIn('projectwise_budget_id', $projectWiseBudgetIds)->get();

        $items = [];

        foreach ($roas as $roa) {

            $itemData = [
                'material_name' => $roa->owner_name,
                'budget_qty' => 0,
                'project_issue' => 0,
                'used_qty' => 0,
                'in_stock' => 0,
                'budget_pending' => $roa->owner_demand,
                'budget_value' => $roa->total,
                'used_value' => $roa->advance_paid,
                'pending_value' => $roa->total - $roa->advance_paid,
            ];

            array_push($items, $itemData);
        }

        return $items;
    }


    public function tbpPaidTotal($budgetHeadId)
    {

        $tbpApprovedTotal = 0;

        $tbps = TBP::where('project_id', $this->project_id)
            ->where('budget_head_id', $budgetHeadId)
            ->get();

        foreach ($tbps as $tbp) {
            $tbpApprovedTotal += $tbp->grandTotalPaidAmount();
        }

        return (float)$tbpApprovedTotal;
    }

    public function tableData($unit_id)
    {

        $unit = Unit::findOrFail($unit_id);

        $tableData = [
            'table_title' => [
                'unit_name' => $unit->name,
                'unit_id' => $unit->id,
                'project_id' => $this->project_id,
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
                'roa_cost' => [
                    'column_type_data' => [
                        'title' => 'ROA Cost',
                    ],
                    'items' => [],
                ],
            ]
        ];

        // get roa data start
        $roaData = $this->getRoa($unit_id);
        $tableData['table_data']['roa_cost']['items'] = $roaData;
        // get roa data end

        // get material and self define items start
        $projectitems = $this->projectWiseBudgetItems($unit_id);


        foreach ($projectitems as $projectitem) {

            $lifting_qty = 0;
            $issue_qty = 0;

            $item_type = $projectitem->first()->budgetHead->type;
            $budgetHeadId = $projectitem->first()->budgetHead->id;
            $itemMaterialId = $projectitem->first()?->budgetHead?->materialInfo()?->id;
            $materialUnitName = $projectitem->first()?->budgetHead?->materialInfo()?->materialUnit?->name;


            if ($item_type == 'Material') {

                $MaterialConsumption = new MaterialConsumption(projectId: $this->project_id, unitIds: [$unit_id], towerId: $this->tower_ids);
                $totalConsumedMaterial = $MaterialConsumption->totalConsumedMaterialByProjectAndTower([$budgetHeadId], $this->project_id, $this->tower_ids);
                $totalLocalIssuedMaterial = $MaterialConsumption->totalIssuedMaterialByProjectAndTower([$budgetHeadId], $this->project_id, $this->tower_ids);

                $lifting_ids = MaterialLifting::where('project_id', $this->project_id)
                    ->where('company_id', Auth::user()->company_id)
                    ->where('unit_id', $unit_id)
                    ->whereIn('lifting_type', ['Local Lifting To Project', 'Client Provide To Project'])
                    ->select('id')
                    ->get()
                    ->pluck('id')
                    ->toArray();

                $lifting_qty = MaterialLiftingMaterial::whereIn('material_lifting_id', $lifting_ids)->where('material_id', $itemMaterialId)->sum('material_qty');
                $lifting_avg_price = MaterialLiftingMaterial::whereIn('material_lifting_id', $lifting_ids)->where('material_id', $itemMaterialId)->avg('material_rate');

                $issue_ids = MaterialIssue::where('project_id', $this->project_id)->where('company_id', Auth::user()->company_id);

                if ($unit_id) {
                    $issue_ids = $issue_ids->where('unit_id', $unit_id);
                }

                $issue_ids = $issue_ids->select('id')
                    ->get()
                    ->pluck('id')
                    ->toArray();

                $issue_qty = MaterialIssueItem::whereIn('material_issue_id', $issue_ids)->where('material_id', $itemMaterialId)->sum('receive_qty');

                $usedQty = $totalConsumedMaterial;
            } else {

                //    get daily Expense Ids
                $dailyExpenseIds = DailyExpense::where('project_id', $this->project_id);

                if ($this->tower_ids) {
                    $dailyExpenseIds = $dailyExpenseIds->whereIn('tower_id', $this->tower_ids);
                }

                $dailyExpenseIds = $dailyExpenseIds->select('id')
                    ->get()
                    ->pluck('id')
                    ->toArray();

                $dailyExpenseTotal = DailyExpenseItem::whereIn('daily_expense_id', $dailyExpenseIds)->where('budget_head_id', $budgetHeadId)->sum('amount');

                $tbpExpenseTotal = $this->tbpPaidTotal($budgetHeadId);

                $totalUsageAmount = $dailyExpenseTotal + $tbpExpenseTotal;

                $nonMaterialRate = round($projectitem->first()->amount / $projectitem->first()->qty, 2);

                $usedQty = $nonMaterialRate;
            }

            $item_name = $projectitem->first()->budgetHead->name;

            if ($materialUnitName) {
                $item_name .= ' (' . $materialUnitName . ')';
            }

            $item_qty = $projectitem->sum('qty');
            $item_amount = $projectitem->sum('amount');

            $itemData = [
                'material_id' => $projectitem->first()->budgetHead->id,
                'material_name' => $item_name,
                'budget_qty' => $item_qty,
                'project_issue' => $lifting_qty + $issue_qty,
                'local_issue' => $totalLocalIssuedMaterial,
                'used_qty' => $usedQty,
                'in_stock' => ($lifting_qty + $issue_qty) - $totalConsumedMaterial,
                'budget_pending' => $item_qty - $totalConsumedMaterial,
                'budget_value' => $item_amount,
            ];

            if ($item_type == 'Material') {
                $itemData['used_value'] = $usedQty * $lifting_avg_price;
                $itemData['pending_value'] = $item_amount - ($totalConsumedMaterial * $lifting_avg_price);
                array_push($tableData['table_data']['material_data']['items'], $itemData);
            } else {
                $itemData['used_value'] = $totalUsageAmount;
                $itemData['pending_value'] = $item_amount - $totalUsageAmount;
                array_push($tableData['table_data']['self_define_cost']['items'], $itemData);
            }
        }
        // get material and self define items end

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
