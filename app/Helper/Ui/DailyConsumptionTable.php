<?php

namespace App\Helper\Ui;

use App\Helper\Project\ProjectHelper;



class DailyConsumptionTable
{

    protected $projectId;
    protected $unitIds;

    public function __construct($projectId, $unitIds)
    {
        $this->projectId = $projectId;
        $this->unitIds = $unitIds;
    }

    public function generateBudgetHeadSelect()
    {

        $projectHelper = new ProjectHelper($this->projectId);
        $budgetItems = $projectHelper->ProjectUsedBudgetHeads();

        return view('dashboard.dailyconsumption.table.material_select', compact('budgetItems'))->render();
    }

    public function generateMaterialSelect()
    {

        $projectHelper = new ProjectHelper($this->projectId);
        $budgetItems = $projectHelper->ProjectUsedMaterialBudgetHeads();

        return view('dashboard.dailyconsumption.table.material_select', compact('budgetItems'))->render();
    }


}
