<?php

namespace App\Helper\Project;

use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\ProjectUnit;
use App\Models\MaterialIssue;
use App\Models\MaterialLifting;
use App\Models\MaterialIssueItem;
use App\Models\ProjectWiseBudget;
use App\Models\UnitConfiguration;
use Illuminate\Support\Facades\Auth;
use App\Helper\Project\MaterialHelper;
use App\Models\ProjectWiseBudgetItems;
use App\Models\MaterialLiftingMaterial;


class ProjectHelper
{

    private int $projectId;
    private array $unitIds;
    private $start_date;
    private $end_date;

    public function __construct($projectId, $unitIds = [], $start_date = null, $end_date = null)
    {

        $this->projectId = $projectId;

        if ($unitIds) {
            $this->unitIds = $unitIds;
        } else {
            $this->unitIds = ProjectUnit::where('project_id', $projectId)->select('unit_id')->get()->pluck('unit_id')->toArray();
        }

        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function unitConfigIds()
    {
        return UnitConfiguration::where('project_id', $this->projectId)->whereIn('unit_id', $this->unitIds)->select(['id'])->get()->pluck('id')->toArray();
    }

    public function unitConfig()
    {
        return UnitConfiguration::whereIn('id', $this->unitConfigIds())->get();
    }

    public function budgetIds()
    {
        return ProjectWiseBudget::where('project_id', $this->projectId)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            })
            ->whereIn('unit_config_id', $this->unitConfigIds())
            ->where('is_additional', 0)
            ->select(['id'])
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function budgets()
    {
        return ProjectWiseBudget::whereIn('id', $this->budgetIds())->get();
    }

    public function budgetItemsIds()
    {
        return ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $this->budgetIds())->select(['id'])->get()->pluck('id')->toArray();
    }

    public function budgetItemsBudgetHeadIds()
    {
        return ProjectWiseBudgetItems::whereIn('projectwise_budget_id', $this->budgetIds())->select(['budget_head'])->get()->pluck('budget_head')->toArray();
    }

    public function budgetHeadIdsToMaterialIds(array $budgetHeads)
    {
        $materials = [];


        foreach ($budgetHeads as $budgetHead) {
            $BH = BudgetHead::findOrFail($budgetHead);
            $material = $BH->materialInfo();

            if ($material) {
                $materials[] = $material->id;
            }
        }


        return $materials;
    }

    public function budgetItems()
    {
        return ProjectWiseBudgetItems::whereIn('id', $this->budgetItemsIds())->with(['budgetHead', 'unit_of_measurement'])->get();
    }

    public function budgetItemsTypeCash()
    {
        $projectBudgetItemIds = ProjectWiseBudgetItems::whereIn('id', $this->budgetItemsIds())
            ->with(['budgetHead'])
            ->whereHas('budgetHead', function ($q) {
                $q->where('type', 'Cash');
            })
            ->get()
            ->pluck('budget_head')
            ->toArray();

        $uniqueProjectBudgetItemIds = array_unique($projectBudgetItemIds);

        $budgetHeads = BudgetHead::whereIn('id', $uniqueProjectBudgetItemIds)->get();

        return $budgetHeads;
    }

    public function budgetItemsTypeMaterial()
    {
        $projectBudgetItemIds = ProjectWiseBudgetItems::whereIn('id', $this->budgetItemsIds())
            ->with(['budgetHead'])
            ->whereHas('budgetHead', function ($q) {
                $q->where('type', 'Material');
            })
            ->get()
            ->pluck('budget_head')
            ->toArray();

        $uniqueProjectBudgetItemIds = array_unique($projectBudgetItemIds);

        $budgetHeads = BudgetHead::whereIn('id', $uniqueProjectBudgetItemIds)->get();

        return $budgetHeads;
    }

    public function liftingIds()
    {

        $materialLifting = MaterialLifting::where('project_id', $this->projectId)->where(function ($q) {
            $q->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        });

        if ($this->projectId != 999999) {
            $materialLifting = $materialLifting->whereIn('lifting_type', ['Local Lifting To Project', 'Client Provide To Project']);
        }

        $materialLifting = $materialLifting->select(['id']);

        if ($this->start_date) {
            $materialLifting = $materialLifting

                ->where('vouchar_date', ">=", $this->start_date)
                ->where('vouchar_date', "<=", $this->end_date);
        }

        $materialLifting = $materialLifting->get()->pluck('id')->toArray();

        return $materialLifting;
    }

    public function liftings()
    {
        return MaterialLifting::whereIn('id', $this->liftingIds())->get();
    }


    public function liftingMaterialRowIds()
    {
        return MaterialLiftingMaterial::whereIn('material_lifting_id', $this->liftingIds())->select(['id'])->get()->pluck('id')->toArray();
    }

    public function liftingMaterialIds()
    {
        return MaterialLiftingMaterial::whereIn('material_lifting_id', $this->liftingIds())->select(['material_id'])->get()->pluck('material_id')->toArray();
    }

    public function liftingMaterials()
    {
        return MaterialLiftingMaterial::whereIn('id', $this->liftingMaterialRowIds())->get();
    }


    public function materialIssueIds()
    {

        $materialIssue = MaterialIssue::where('source_project_id', $this->projectId)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            })
            ->select(['id']);

        if ($this->start_date) {
            $materialIssue = $materialIssue->where('issue_date', ">=", $this->start_date)->where('issue_date', "<=", $this->end_date);
        }

        $materialIssue = $materialIssue->get()->pluck('id')->toArray();

        return $materialIssue;
    }

    public function materialIssues()
    {
        return MaterialIssue::whereIn('id', $this->materialIssueIds())->get();
    }

    public function materialIssueItemRowIds()
    {
        return MaterialIssueItem::whereIn('material_issue_id', $this->materialIssueIds())
            ->select(['id'])
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function materialIssueItemIds()
    {
        return MaterialIssueItem::whereIn('material_issue_id', $this->materialIssueIds())->select(['material_id'])->get()->pluck('material_id')->toArray();
    }

    public function materialIssueItems()
    {
        return MaterialIssueItem::whereIn('id', $this->materialIssueItemRowIds())->get();
    }

    public function materialReceiveIds()
    {
        $materialReceive = MaterialIssue::where('project_id', $this->projectId)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            })
            ->select(['id']);

        if ($this->start_date) {
            $materialReceive = $materialReceive->where('issue_date', ">=", $this->start_date)->where('issue_date', "<=", $this->end_date);
        }

        $materialReceive = $materialReceive->get()->pluck('id')->toArray();

        return $materialReceive;
    }

    public function materialReceives()
    {
        return MaterialIssue::whereIn('id', $this->materialReceiveIds())->get();
    }

    public function materialReceiveItemRowIds()
    {
        return MaterialIssueItem::whereIn('material_issue_id', $this->materialReceiveIds())->select(['id'])->get()->pluck('id')->toArray();
    }

    public function materialReceiveItemIds()
    {
        return MaterialIssueItem::whereIn('material_issue_id', $this->materialReceiveIds())->select(['material_id'])->get()->pluck('material_id')->toArray();
    }

    public function materialReceiveItems()
    {
        return MaterialIssueItem::whereIn('id', $this->materialReceiveItemRowIds())->get();
    }


    public function ProjectUsedBudgetHeadIds()
    {

        $budgetPrepareBudgetHeadIds = $this->budgetItemsBudgetHeadIds();

        $liftingMaterialBudgetHeadIds = MaterialHelper::materialIdToBudgetHeadId($this->liftingMaterialIds());

        // merge array here
        $allIds = array_merge($budgetPrepareBudgetHeadIds, $liftingMaterialBudgetHeadIds);

        //unique array
        $allIds = array_unique($allIds);
        //return array

        return $allIds;
    }


    public function ProjectUsedBudgetHeads()
    {

        $budgetHeads = BudgetHead::whereIn('id', $this->ProjectUsedBudgetHeadIds())->get();

        return $budgetHeads;
    }

    public function ProjectUsedMaterialBudgetHeads()
    {

        $budgetHeads = BudgetHead::whereIn('id', $this->ProjectUsedBudgetHeadIds())->where('type', 'Material')->get();

        return $budgetHeads;
    }
}
