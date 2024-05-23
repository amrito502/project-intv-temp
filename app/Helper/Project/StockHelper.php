<?php

namespace App\Helper\Project;

class StockHelper
{

    public $start_date;
    public $end_date;
    public $project_id;
    public $material_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project_id = $filters['project'];
        $this->material_ids = $filters['materials'];

        $this->projectHelper = new ProjectHelper($this->project_id, [], $this->start_date, $this->end_date);
        $this->MaterialConsumption = new MaterialConsumption($this->project_id, [], $this->start_date, $this->end_date);


    }

    public function LiftingStock()
    {
        $liftingItems = $this->projectHelper->liftingMaterials();

        return $liftingItems;
    }

    public function ReceiveStock()
    {
        $receiveItems = $this->projectHelper->materialReceiveItems();

        return $receiveItems;
    }

    public function ReturnStock()
    {
        $issueItems = $this->projectHelper->materialIssueItems();

        return $issueItems;
    }

    public function ConsumedStock()
    {

        $consumedItems = $this->MaterialConsumption->usedItems();

        return $consumedItems;

    }

    public function localIssueStock()
    {

        $consumedItems = $this->MaterialConsumption->consumptionItems();

        return $consumedItems;

    }

    public function balance()
    {
        return ($this->LiftingStock() + $this->ReceiveStock() + $this->localIssueStock() ) - ($this->ReturnStock() + $this->ConsumedStock());
    }


}
