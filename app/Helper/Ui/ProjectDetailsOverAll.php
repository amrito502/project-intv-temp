<?php

namespace App\Helper\Ui;

use App\Models\TBP;
use App\Models\Project;
use App\Models\DailyUses;
use App\Models\BudgetHead;
use App\Models\MaterialIssue;
use Illuminate\Support\Carbon;
use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\DailyConsumption;
use App\Models\ProjectWiseBudget;
use Illuminate\Support\Facades\Auth;

class ProjectDetailsOverAll
{

    public static function ProjectCompletionByDate($project)
    {
        $currentTimeStamp = strtotime('now');

        $startTimeStamp = 0;
        $endTimeStamp = 0;

        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses) {
            return 0;
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


    public static function projectTotalBudget($project)
    {

        $grandTotalBudget = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 0)->get();

        if (!$towerWiseBudgetStatuses) {
            return 0;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->CashBudgetGrandTotalAmount();
        }
        // get budget end


        return $grandTotalBudget;
    }

    public static function projectAdditionalBudget($project)
    {

        $grandTotalBudget = 0;

        // get budget start
        $towerWiseBudgetStatuses = ProjectWiseBudget::where('project_id', $project->id)->where('is_additional', 1)->get();

        if (!$towerWiseBudgetStatuses) {
            return 0;
        }

        foreach ($towerWiseBudgetStatuses as $towerWiseBudgetStatus) {
            $grandTotalBudget += $towerWiseBudgetStatus->CashBudgetGrandTotalAmount();
        }
        // get budget end


        return $grandTotalBudget;
    }

    public static function projectTotalConsumptionUsed($project)
    {

        $grandTotal = 0;

        // get budget start
        $consumptions = DailyUses::where('project_id', $project->id)->get();

        if (!$consumptions) {
            return 0;
        }

        foreach ($consumptions as $consumption) {
            $grandTotal += $consumption->grandTotalUseAmount();
        }
        // get budget end


        return $grandTotal;
    }

    public static function projectTotalLogisticsExpense($project)
    {

        $grandTotal = 0;

        // get budget start
        $tbps = TBP::where('project_id', $project->id)->get();

        if (!$tbps) {
            return 0;
        }

        foreach ($tbps as $tbp) {
            $grandTotal += $tbp->grandTotalPaidAmount();
        }
        // get budget end


        return $grandTotal;
    }

    public static function projectRoaTotalCost($project)
    {

        $grandTotal = 0;

        // get budget start
        $budgets = $project->project_wise_budgets;

        if (!$budgets) {
            return 0;
        }

        foreach ($budgets as $budget) {

            if (!$budget->budget_wise_roas) {
                continue;
            }

            foreach ($budget->budget_wise_roas as $roa) {
                $grandTotal += $roa->advance_paid;
            }
        }

        // get budget end


        return $grandTotal;
    }


    public static function getProjectSelfDefineCost($project)
    {
        $totalUsageAmount = 0;

        $cashRequisitions = CashRequisition::where('project_id', $project->id)->get();

        foreach ($cashRequisitions as $cashRequisition) {
            $totalUsageAmount += $cashRequisition->RequisitionTotalPaidAmount();
        }

        return $totalUsageAmount;
    }

    public static function getProjectTotalLiftingAmount($project)
    {
        $grandTotal = 0;

        $liftings = MaterialLifting::where('project_id', $project->id)->get();

        foreach ($liftings as $lifting) {
            $grandTotal += $lifting->totalAmount();
        }

        return $grandTotal;
    }

    public static function getProjectTotalIssueAmount($project)
    {
        $grandTotal = 0;

        $issues = MaterialIssue::where('project_id', $project->id)->get();

        foreach ($issues as $issue) {
            $grandTotal += $issue->totalAmount();
        }


        $returns = MaterialIssue::where('source_project_id', $project->id)->get();

        foreach ($returns as $return) {
            $grandTotal -= $return->totalAmount();
        }

        return $grandTotal;
    }


    public static function generate()
    {
        $data = [];

        $projects = Project::GetRoleWiseAll()->where('show_dashboard', 1)->with(['projectTowers', 'projectUnit.unit', 'project_wise_budgets.budget_wise_roas'])->get();

        foreach ($projects as $project) {

            $units = [];

            if ($project->projectUnit) {

                foreach ($project->projectUnit as $unitb) {
                    $units[] = $unitb->unit->name;
                }
            }

            $units = implode(', ', $units);

            $ld = [
                'project_name' => $project->project_name,
                'project_type' => $project->project_type,
                'project_units' => $units,
                'project_time' => self::ProjectCompletionByDate($project),
                'total_budget' => self::projectTotalBudget($project),
                'additional_budget' => self::projectAdditionalBudget($project),
                'material_expense' => self::projectTotalConsumptionUsed($project),
                'self_define_cost' => self::getProjectSelfDefineCost($project),
                'logistics_expense' => self::projectTotalLogisticsExpense($project),
                'roa_expense' => self::projectRoaTotalCost($project),
                'lifting_amount' => self::getProjectTotalLiftingAmount($project),
                'issue_amount' => self::getProjectTotalIssueAmount($project),
            ];

            if ($project->projectTowers) {
                $ld['tower_count'] = $project->projectTowers->count();
            }

            $ld['total_expense'] = $ld['material_expense'] + $ld['self_define_cost'] + $ld['logistics_expense'] + $ld['roa_expense'];
            // $ld['budget_balance'] = $ld['total_budget'] - $ld['total_expense'];

            $ld['consumption_value'] = $ld['material_expense'];
            $ld['stock_value'] = ($ld['lifting_amount'] + $ld['issue_amount']) - ($ld['consumption_value']);

            $data[] = $ld;
        }

        return $data;
    }
}
