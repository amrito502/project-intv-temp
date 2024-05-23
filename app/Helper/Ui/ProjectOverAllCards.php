<?php

namespace App\Helper\Ui;

use App\Models\Project;
use App\Models\DailyUses;
use Illuminate\Support\Carbon;
use App\Models\CashRequisition;
use App\Models\DailyConsumption;
use App\Models\ProjectWiseBudget;
use Illuminate\Support\Facades\Auth;

class ProjectOverAllCards
{

    public static function getAllCards()
    {

        $towerProjects = Project::where('project_type', 'tower')
            ->where('company_id', Auth::user()->company_id)
            ->with(['projectTowers'])
            ->get();

        $nonTowerProjects = Project::where('project_type', '!=', 'tower')
            ->where('company_id', Auth::user()->company_id)
            ->get();

        $cards = [];

        $projectCards = self::projectTowerWiseOverAll($towerProjects);
        $nonProjectCards = self::projectGlobalOverAll($nonTowerProjects);

        foreach ($projectCards as $projectCard) {
            array_push($cards, $projectCard);
        }

        foreach ($nonProjectCards as $nonProjectCard) {
            array_push($cards, $nonProjectCard);
        }

        return $cards;
    }


    public static function projectGlobalOverAll($projects)
    {
        $items = [];

        foreach ($projects as $project) {

            $byDateCompletion = self::ProjectCompletionByDate($project);
            $byCashCompletion = self::ProjectCompletionByCash($project);
            $byQtyCompletion = self::ProjectCompletionByQty($project);

            if ($byDateCompletion == false) {
                break;
            }

            if ($byDateCompletion == false) {
                $byCashCompletion = 0;
            }

            $item = [
                'project_name' => $project->project_name,
                'tower_name' => "",
                'by_date' => $byDateCompletion,
                'by_cash' => $byCashCompletion,
                'by_qty' => $byQtyCompletion,
            ];

            array_push($items, $item);

        }

        return $items;
    }

    public static function projectTowerWiseOverAll($projects)
    {

        $items = [];

        foreach ($projects as $project) {
            $projectTowers = $project->projectTowers;


            if (!$projectTowers->count()) {
                break;
            }

            foreach ($projectTowers as $projectTower) {

                $byDateCompletion = self::towerProjectCompletionByDate($projectTower);
                $byCashCompletion = self::towerProjectCompletionByCash($projectTower);
                $byQtyCompletion = self::towerProjectCompletionByQty($projectTower);

                if ($byDateCompletion == false) {
                    break;
                }

                if ($byDateCompletion == false) {
                    $byCashCompletion = 0;
                }

                $item = [
                    'project_name' => $project->project_name,
                    'tower_name' => $projectTower->name,
                    'by_date' => $byDateCompletion,
                    'by_cash' => $byCashCompletion,
                    'by_qty' => $byQtyCompletion,
                ];

                array_push($items, $item);
            }
        }

        return $items;
    }


    public static function towerProjectCompletionByDate($projectTower)
    {
        $currentTimeStamp = strtotime('now');

        $startTimeStamp = 0;
        $endTimeStamp = 0;

        $towerWiseBudgetStatuses = ProjectWiseBudget::where('tower_id', $projectTower->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        $i = 1;
        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {

            $budgetStartTimeStamp = Carbon::parse($towerWiseBudgetStatus->start_date)->timestamp;
            $budgetEndTimeStamp = Carbon::parse($towerWiseBudgetStatus->end_date)->timestamp;

            if ($budgetStartTimeStamp > $currentTimeStamp) {
                continue;
            }

            if ($i == 1) {
                $startTimeStamp = $budgetStartTimeStamp;
            } else {
                $startTimeStamp = $budgetStartTimeStamp < $startTimeStamp ? $budgetStartTimeStamp : $startTimeStamp;
            }

            $endTimeStamp = $budgetEndTimeStamp > $endTimeStamp ? $budgetEndTimeStamp : $endTimeStamp;

            $i++;
        }

        if ($endTimeStamp == 0 && $startTimeStamp == 0) {
            return 0;
        }

        $currentCarbon = Carbon::createFromTimestamp($currentTimeStamp);
        $startCarbon = Carbon::createFromTimestamp($startTimeStamp);
        $endCarbon = Carbon::createFromTimestamp($endTimeStamp);

        $completedDays = $startCarbon->diffInDays($currentCarbon);
        $totalDays = $startCarbon->diffInDays($endCarbon);

        return [
            'completed' => $completedDays,
            'total' => $totalDays,
        ];
    }


    public static function towerProjectCompletionByCash($projectTower)
    {

        $grandTotalBudget = 0;
        $grandTotalUsed = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('tower_id', $projectTower->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->CashBudgetGrandTotalAmount();
        }
        // get budget end

        // get used start
        $towerWiseCashRequisitions = CashRequisition::where('tower_id', $projectTower->id)->get();
        foreach ($towerWiseCashRequisitions as $towerWiseCashRequisition) {
            $grandTotalUsed += $towerWiseCashRequisition->CashBudgetHeadRequisitionTotalApprovedAmount();
        }
        // get used end

        $byCashCompletion = (100 / $grandTotalBudget) * $grandTotalUsed;

        return number_format($byCashCompletion, 2);
    }

    public static function towerProjectCompletionByQty($projectTower)
    {

        $grandTotalBudget = 0;
        $grandTotalUsed = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('tower_id', $projectTower->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->BudgetGrandTotalQty();
        }
        // get budget end

        // get used start
        $dailyConsumptions = DailyUses::where('tower_id', $projectTower->id)->get();
        foreach ($dailyConsumptions as $dailyConsumption) {
            $grandTotalUsed += $dailyConsumption->grandTotalUseQty();
        }
        // get used end

        $byQtyCompletion = (100 / $grandTotalBudget) * $grandTotalUsed;

        return number_format($byQtyCompletion, 2);
    }

    public static function ProjectCompletionByDate($project)
    {
        $currentTimeStamp = strtotime('now');

        $startTimeStamp = 0;
        $endTimeStamp = 0;

        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        $i = 1;
        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {

            $budgetStartTimeStamp = strtotime($towerWiseBudgetStatus->start_date);
            $budgetEndTimeStamp = strtotime($towerWiseBudgetStatus->end_date);

            if ($budgetStartTimeStamp > $currentTimeStamp) {
                continue;
            }

            if ($i == 1) {
                $startTimeStamp = $budgetStartTimeStamp;
            } else {
                $startTimeStamp = $budgetStartTimeStamp < $startTimeStamp ? $budgetStartTimeStamp : $startTimeStamp;
            }

            $endTimeStamp = $budgetEndTimeStamp > $endTimeStamp ? $budgetEndTimeStamp : $endTimeStamp;

            $i++;
        }

        if ($endTimeStamp == 0 && $startTimeStamp == 0) {
            return 0;
        }


        $currentCarbon = Carbon::createFromTimestamp($currentTimeStamp);
        $startCarbon = Carbon::createFromTimestamp($startTimeStamp);
        $endCarbon = Carbon::createFromTimestamp($endTimeStamp);

        $completedDays = $startCarbon->diffInDays($currentCarbon);
        $totalDays = $startCarbon->diffInDays($endCarbon);

        return [
            'completed' => $completedDays,
            'total' => $totalDays,
        ];
    }

    public static function ProjectCompletionByCash($project)
    {

        $grandTotalBudget = 0;
        $grandTotalUsed = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->CashBudgetGrandTotalAmount();
        }
        // get budget end

        // get used start
        $towerWiseCashRequisitions = CashRequisition::where('project_id', $project->id)->get();
        foreach ($towerWiseCashRequisitions as $towerWiseCashRequisition) {
            $grandTotalUsed += $towerWiseCashRequisition->CashBudgetHeadRequisitionTotalApprovedAmount();
        }
        // get used end

        $byCashCompletion = (100 / $grandTotalBudget) * $grandTotalUsed;

        return number_format($byCashCompletion, 2);
    }

    public static function ProjectCompletionByQty($project)
    {

        $grandTotalBudget = 0;
        $grandTotalUsed = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses->count()) {
            return false;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->BudgetGrandTotalQty();
        }
        // get budget end

        // get used start
        $dailyConsumptions = DailyUses::where('tower_id', $project->id)->get();
        foreach ($dailyConsumptions as $dailyConsumption) {
            $grandTotalUsed += $dailyConsumption->grandTotalUseQty();
        }
        // get used end

        $byQtyCompletion = (100 / $grandTotalBudget) * $grandTotalUsed;

        return number_format($byQtyCompletion, 2);
    }
}
