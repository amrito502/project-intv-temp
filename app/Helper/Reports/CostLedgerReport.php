<?php

namespace App\Helper\Reports;

use App\Models\CashRequisition;
use App\Models\CashRequisitionItem;

class CostLedgerReport
{

    public $start_date;
    public $end_date;
    public $vendor;
    public $budgetheads;
    public $company_id;

    public function __construct($filters)
    {
        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->vendor = $filters['vendor'];
        $this->project = $filters['project'];
        $this->budgetheads = $filters['budgetheads'];
        $this->company_id = $filters['company_id'];
    }

    public function query()
    {

        // get cash requisition from cash requisition id filtering by vendor and budgethead start
        $cashrequisitionItemIds = CashRequisitionItem::query();

        if ($this->vendor) {
            $cashrequisitionItemIds->where('vendor_id', $this->vendor);
        }

        if ($this->budgetheads) {
            $cashrequisitionItemIds->where('budget_head_id', $this->budgetheads);
        }

        $cashrequisitionItemIds = $cashrequisitionItemIds->pluck('id');
        // get cash requisition from cash requisition id filtering by vendor and budgethead end

        $cashrequisitionIds = CashRequisitionItem::whereIn('id', $cashrequisitionItemIds)->pluck('cash_requisition_id');

        // get cash requisition ids filtering by date range and item requisition ids start
        $cashRequisitionIds = CashRequisition::where('company_id', $this->company_id)->whereIn('id', $cashrequisitionIds);

        if ($this->start_date && $this->end_date) {
            $cashRequisitionIds = $cashRequisitionIds->where('date', '>=', $this->start_date)
                ->where('date', '<=', $this->end_date);
        }

        if ($this->project) {
            $cashRequisitionIds = $cashRequisitionIds->where('project_id', $this->project);
        }

        $cashRequisitionIds = $cashRequisitionIds->pluck('id');
        // get cash requisition ids filtering by date range and item requisition ids end


        $cashRequisitionItems = CashRequisitionItem::whereIn('id', $cashrequisitionItemIds)
            ->whereIn('cash_requisition_id', $cashRequisitionIds)
            ->with(['cash_requisition', 'budgethead', 'vendor'])
            ->get();


        return [
            'cashRequisitionItems' => $cashRequisitionItems,
        ];
    }

    public function generate()
    {

        $queryData = $this->query();

        $data = [];

        foreach ($queryData['cashRequisitionItems'] as $cashRequisitionItem) {

            $ld = [
                'date' => $cashRequisitionItem->cash_requisition->date,
                'project' => $cashRequisitionItem->cash_requisition->project->project_name,
                'budgethead' => $cashRequisitionItem->budgethead->name,
                'vendor' => $cashRequisitionItem?->vendor?->name,
                'amount' => $cashRequisitionItem->approved_amount,
            ];

            array_push($data, $ld);
        }

        return [
            'report_table' => $data,
        ];
    }
}
