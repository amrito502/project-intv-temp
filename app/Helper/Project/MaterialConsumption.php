<?php


namespace App\Helper\Project;

use App\Models\DailyUses;
use App\Models\ProjectUnit;
use App\Models\DailyUseItems;
use App\Models\DailyConsumption;
use App\Models\DailyConsumptionItem;
use Illuminate\Support\Facades\Auth;

class MaterialConsumption
{

    private int $projectId;
    private $towerId;
    private array $unitIds;
    private $start_date;
    private $end_date;

    public function __construct($projectId, $unitIds = [], $start_date = null, $end_date = null, $towerId = null)
    {
        $this->projectId = $projectId;
        $this->towerId = $towerId;

        if ($unitIds) {
            $this->unitIds = $unitIds;
        } else {
            $this->unitIds = ProjectUnit::where('project_id', $projectId)->select('unit_id')->get()->pluck('unit_id')->toArray();
        }

        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }


    public function consumptionIds()
    {
        $dailyConsumptionIds = DailyConsumption::where('project_id', $this->projectId)
            ->whereIn('unit_id', $this->unitIds)
            ->where('company_id', Auth::user()->company_id)
            ->select('id');

        if ($this->start_date) {
            $dailyConsumptionIds = $dailyConsumptionIds->where('date', ">=", $this->start_date)->where('date', "<=", $this->end_date);
        }

        if ($this->towerId) {
            $dailyConsumptionIds = $dailyConsumptionIds->whereIn('tower_id', $this->towerId);
        }

        $dailyConsumptionIds = $dailyConsumptionIds
            ->get()
            ->pluck('id')
            ->toArray();

        return $dailyConsumptionIds;
    }


    public function consumptions()
    {
        return DailyConsumption::whereIn('id', $this->consumptionIds())->get();
    }


    public function consumptionItemIds()
    {

        return DailyConsumptionItem::whereIn('daily_consumption_id', $this->consumptionIds())
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function consumptionItems()
    {
        return DailyConsumptionItem::whereIn('id', $this->consumptionItemIds())->with(['budgetHead'])->get();
    }

    public function totalIssuedMaterial($budgetHeads)
    {
        return DailyConsumptionItem::whereIn('id', $this->consumptionItemIds())->whereIn('budget_head_id', $budgetHeads)->sum('consumption_qty');
    }


    public function totalIssuedMaterialByProjectAndTower($budgetHeads, $projectId, $towerIds)
    {

        $dailyConsumptionIds = DailyConsumption::where('project_id', $projectId)
        ->where(function ($q) {
            $q->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        });

        if ($towerIds) {
            $dailyConsumptionIds = $dailyConsumptionIds->whereIn('tower_id', $towerIds);
        }

        $dailyConsumptionIds = $dailyConsumptionIds->select('id')
            // ->where('status', 1)
            ->get()
            ->pluck('id')
            ->toArray();

        return DailyConsumptionItem::whereIn('id', $this->consumptionItemIds())->whereIn('daily_consumption_id', $dailyConsumptionIds)->whereIn('budget_head_id', $budgetHeads)->sum('consumption_qty');
    }

    public function usesIds()
    {
        $dailyConsumptionIds = DailyUses::where('project_id', $this->projectId)
            ->whereIn('unit_id', $this->unitIds)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            })
            ->select('id');

        if ($this->start_date) {
            $dailyConsumptionIds = $dailyConsumptionIds->where('date', ">=", $this->start_date)->where('date', "<=", $this->end_date);
        }

        if ($this->towerId) {
            $dailyConsumptionIds = $dailyConsumptionIds->whereIn('tower_id', $this->towerId);
        }

        $dailyConsumptionIds = $dailyConsumptionIds
            ->get()
            ->pluck('id')
            ->toArray();

        return $dailyConsumptionIds;
    }

    public function useItemIds()
    {

        return DailyUseItems::whereIn('daily_use_id', $this->usesIds())
            ->select('id')
            ->get()
            ->pluck('id')
            ->toArray();
    }

    public function usedItems()
    {
        return DailyUseItems::whereIn('id', $this->useItemIds())->with(['budgetHead'])->get();
    }

    public function totalConsumedMaterial($budgetHeads)
    {
        return DailyUseItems::whereIn('id', $this->useItemIds())->whereIn('budget_head_id', $budgetHeads)->sum('use_qty');
    }

    public function totalConsumedMaterialByProjectAndTower($budgetHeads, $projectId, $towerIds)
    {

        $dailyUseIds = DailyUses::where('project_id', $projectId)
            ->where(function ($q) {
                $q->where('company_id', Auth::user()->company_id)
                    ->orWhere('company_id', 0);
            });

        if ($towerIds) {
            $dailyUseIds = $dailyUseIds->whereIn('tower_id', $towerIds);
        }

        $dailyUseIds = $dailyUseIds->select('id')
            ->get()
            ->pluck('id')
            ->toArray();

        return DailyUseItems::whereIn('id', $this->useItemIds())->whereIn('daily_use_id', $dailyUseIds)->whereIn('budget_head_id', $budgetHeads)->sum('use_qty');
    }
}
