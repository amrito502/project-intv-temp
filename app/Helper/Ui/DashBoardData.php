<?php

namespace App\Helper\Ui;

use App\Models\Project;
use App\Models\ProjectTower;
use App\Models\ProjectWiseBudget;
use Illuminate\Support\Facades\Auth;


class DashBoardData
{

    private static function companyRunningProjects()
    {

        $nowTimeStamp = strtotime('now');

        $runningProjects = 0;

        $thisCompanyProjectIds = Project::where('company_id', Auth::user()->company_id)->select('id')->get()->pluck('id')->toArray();

        foreach ($thisCompanyProjectIds as $companyProjectId) {

            $projectWiseBudgets = ProjectWiseBudget::where('project_id', $companyProjectId)->where('is_additional', 0)->get();

            foreach ($projectWiseBudgets as $projectWiseBudget) {

                $budgetEndTime = strtotime($projectWiseBudget->end_date);

                if ($nowTimeStamp < $budgetEndTime) {
                    $runningProjects++;
                    break;
                }
            }
        }

        return $runningProjects;
    }


    private static function companyRunningTowers()
    {

        $nowTimeStamp = strtotime('now');

        $runningTowers = 0;

        $thisCompanyProjectIds = Project::where('company_id', Auth::user()->company_id)->select('id')->get()->pluck('id')->toArray();
        $thisCompanyTowerIds = ProjectTower::whereIn('project_id', $thisCompanyProjectIds)->select('id')->get()->pluck('id')->toArray();


        foreach ($thisCompanyTowerIds as $thisCompanyTowerId) {

            $projectWiseBudgets = ProjectWiseBudget::where('tower_id', $thisCompanyTowerId)->where('is_additional', 0)->get();

            foreach($projectWiseBudgets as $projectWiseBudget){

                $budgetEndTime = strtotime($projectWiseBudget->end_date);

                if($nowTimeStamp < $budgetEndTime){
                    $runningTowers++;
                    break;
                }

            }

        }

        return $runningTowers;
    }

    public static function ofCompany()
    {

        $thisCompanyProjectIds = Project::where('company_id', Auth::user()->company_id)->select('id')->get()->pluck('id')->toArray();
        $thisCompanyProjectTowerCount = ProjectTower::where('project_id', $thisCompanyProjectIds)->count();

        return [
            'running_project' => self::companyRunningProjects(),
            'total_project' => Project::where('company_id', Auth::user()->company_id)->count(),
            'working_tower' => self::companyRunningTowers(),
            'total_tower' => $thisCompanyProjectTowerCount,
        ];

    }

}
