<?php

namespace App\Helper\Project;

use App\Models\Material;
use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\MaterialIssue;
use App\Models\MaterialLifting;
use App\Models\DailyConsumption;
use App\Models\MaterialIssueItem;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use App\Models\DailyConsumptionItem;
use App\Models\DailyUseItems;
use App\Models\ProjectWiseBudgetItems;
use App\Models\MaterialLiftingMaterial;


class BasicMaterialStock
{
    public $project_id;
    public $material_id;
    public $unit_id = null;
    public $tower_id = null;

    public function __construct($filters)
    {

        $this->project_id = $filters['project'];
        $this->material_id = $filters['material'];

        if (array_key_exists('unit_id',  $filters)) {
            $this->unit_id = $filters['unit_id'];
        }

        if (array_key_exists('tower_id', $filters)) {
            $this->tower_id = $filters['tower_id'];
        }

        $this->material = Material::find($this->material_id);
        $this->budgethead = $this->material->budgetheadInfo();
    }


    public function stockBalance()
    {
        $stockQty = $this->stockQty();

        return $stockQty;
    }

    public function budgetBalance()
    {
        $budgetQty = (double)$this->budgetQty();
        $usedQty = (double)$this->usedQty();

        return $budgetQty - $usedQty;
    }

    public function stockQty()
    {

        $liftingQty = (double)$this->liftingQty();
        $receiveQty = (double)$this->receiveQty();
        $localIssueQty = (double)$this->localIssueQty();
        // $ConsumptionUsedQty = (double)$this->usedQty();
        $returnQty = (double)$this->returnQty();

        $stockQty = ($liftingQty + $receiveQty) - ($returnQty + $localIssueQty);

        return $stockQty;
    }

    public function localIssueStockQty()
    {

        $localIssueQty = $this->localIssueQty();
        $ConsumptionUsedQty = $this->usedQty();

        $stockQty = $localIssueQty - $ConsumptionUsedQty;

        return $stockQty;
    }


    public function budgetQty()
    {

        $unitconfigsIds = UnitConfiguration::where('unit_id', $this->unit_id)->select('id')->get()->pluck('id')->toArray();

        $projectBudgetIds = ProjectWiseBudget::where('project_id', $this->project_id);
        // ->where('is_additional', 0);

        if ($this->unit_id) {
            $projectBudgetIds = $projectBudgetIds->whereIn('unit_config_id', $unitconfigsIds);
        }

        if ($this->tower_id) {
            $projectBudgetIds = $projectBudgetIds->where('tower_id', $this->tower_id);
        }

        $projectBudgetIds = $projectBudgetIds->select('id')->get()->pluck('id')->toArray();


        $budgetQty = ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $projectBudgetIds)
            ->where('budget_head', $this->budgethead->id)
            ->sum('qty');

        return $budgetQty;
    }

    public function liftingQty()
    {
        $liftingIds = MaterialLifting::where('project_id', $this->project_id);

        if ($this->unit_id) {
            $liftingIds = $liftingIds->where('unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $liftingIds = $liftingIds->where('tower_id', $this->tower_id);
        }

        $liftingIds = $liftingIds
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        $usedQty = MaterialLiftingMaterial::whereIn('material_lifting_id', $liftingIds)
            ->where('material_id', $this->material->id)
            ->sum('material_qty');

        return $usedQty;
    }

    public function receiveQty()
    {
        $issueIds = MaterialIssue::where('project_id', $this->project_id);

        if ($this->unit_id) {
            $issueIds = $issueIds->where('unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $issueIds = $issueIds->where('tower_id', $this->tower_id);
        }

        $issueIds = $issueIds->select(['id'])->get()->pluck('id')->toArray();

        $usedQty = MaterialIssueItem::whereIn('material_issue_id', $issueIds)
            ->where('material_id', $this->material->id)
            ->sum('receive_qty');

        return $usedQty;
    }

    public function returnQty()
    {

        $issueIds = MaterialIssue::where('source_project_id', $this->project_id);

        if ($this->unit_id) {
            $issueIds = $issueIds->where('source_unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $issueIds = $issueIds->where('source_tower_id', $this->tower_id);
        }

        $issueIds = $issueIds->select(['id'])->get()->pluck('id')->toArray();

        $usedQty = MaterialIssueItem::whereIn('material_issue_id', $issueIds)
            ->where('material_id', $this->material->id)
            ->sum('receive_qty');

        return $usedQty;
    }

    public function localIssueQty()
    {
        $consumptionIds = DailyConsumption::where('project_id', $this->project_id);

        if ($this->unit_id) {
            $consumptionIds = $consumptionIds->where('unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $consumptionIds = $consumptionIds->where('tower_id', $this->tower_id);
        }

        $consumptionIds = $consumptionIds->select('id')->get()->pluck('id')->toArray();

        $usedQty = DailyConsumptionItem::whereIn('daily_consumption_id', $consumptionIds)->where('budget_head_id', $this->budgethead->id)->sum('consumption_qty');

        return $usedQty;
    }

    public function usedQty()
    {

        $consumptionIds = DailyUses::where('project_id', $this->project_id);

        if ($this->unit_id) {
            $consumptionIds = $consumptionIds->where('unit_id', $this->unit_id);
        }

        if ($this->tower_id) {
            $consumptionIds = $consumptionIds->where('tower_id', $this->tower_id);
        }

        $consumptionIds = $consumptionIds->select('id')->get()->pluck('id')->toArray();

        $usedQty = DailyUseItems::whereIn('daily_use_id', $consumptionIds)->where('budget_head_id', $this->budgethead->id)->sum('use_qty');

        return $usedQty;
    }
}
