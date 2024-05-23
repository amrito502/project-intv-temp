<?php

namespace App\Helper\Reports;

use App\Models\CashRequisition;
use App\Models\DailyExpense;
use App\Models\MaterialLifting;
use App\Models\MaterialVendorPayment;
use App\Models\MaterialVendorPaymentInvoice;
use App\Models\ProjectTower;

class ExpenseLogReport
{

    public $start_date;
    public $end_date;
    public $project;
    public $tower;
    public $vendor;
    public $unit_ids;
    public $material_ids;

    public function __construct($filters)
    {

        $this->start_date = $filters['start_date'];
        $this->end_date = $filters['end_date'];
        $this->project = $filters['project'];
        $this->tower = $filters['tower'];
        $this->vendor = $filters['vendor'];
        $this->unit_ids = $filters['units'];
        $this->material_ids = $filters['materials'];
    }

    public function query()
    {

        $materialIds = $this->material_ids;
        $vendorId = $this->vendor;

        // cash requisition table start
        $dailyExpense = DailyExpense::where('company_id', auth()->user()->company_id)
            ->where('date', '>=', $this->start_date)
            ->where('date', '<=', $this->end_date);

        if ($this->project) {
            $dailyExpense = $dailyExpense->where('project_id', $this->project);
        }

        if ($this->tower) {
            $dailyExpense = $dailyExpense->where('tower_id', $this->tower);
        }

        if ($this->unit_ids) {
            $dailyExpense = $dailyExpense->whereIn('unit_config_id', $this->unit_ids);
        }

        $dailyExpense = $dailyExpense->with(['items', 'items.budgethead', 'items.vendor', 'project'])
            ->whereHas('items', function ($q) use ($materialIds) {
                if ($materialIds) {
                    $q->whereIn('budget_head_id', $materialIds);
                }
            })
            ->whereHas('items', function ($q) use ($vendorId) {
                if ($vendorId) {
                    $q->where('vendor_id', $vendorId);
                }
            })
            ->get();

        // cash requisition table end

        return [
            'dailyExpense' => $dailyExpense,
        ];
    }

    public function generate()
    {

        $queryData = $this->query();


        $data = [];

        // cash requisition table start
        foreach ($queryData['dailyExpense'] as $dailyExpense) {

            foreach ($dailyExpense->items as $item) {

                $ld = [
                    'date' => date('d-m-Y', strtotime($dailyExpense->date)),
                    'project' => $dailyExpense->project->project_name,
                    'vendor' => $item?->vendor?->name,
                    'head' => $item->budgethead->name,
                    'amount' => $item->amount,
                ];

                array_push($data, $ld);
            }
        }
        // cash requisition table end


        return [
            'report_table' => $data,
        ];
    }
}
