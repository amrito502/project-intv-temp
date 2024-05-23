<?php

namespace App\Helper\Reports;

use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\MaterialVendorPayment;
use App\Models\MaterialVendorPaymentInvoice;
use App\Models\ProjectTower;

class PaymentLogReport
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
        $CashRequisition = CashRequisition::where('company_id', auth()->user()->company_id)
            ->where('date', '>=', $this->start_date)
            ->where('date', '<=', $this->end_date);

        if ($this->project) {
            $CashRequisition = $CashRequisition->where('project_id', $this->project);
        }

        if ($this->tower) {
            $CashRequisition = $CashRequisition->where('tower_id', $this->tower);
        }

        if ($this->unit_ids) {
            $CashRequisition = $CashRequisition->whereIn('unit_config_id', $this->unit_ids);
        }

        $CashRequisition = $CashRequisition->with(['items', 'items.budgethead', 'items.vendor', 'project'])
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


        // MaterialVendorPayment table start
        $MaterialVendorPayment = MaterialVendorPayment::where('company_id', auth()->user()->company_id)
            ->where('payment_date', '>=', $this->start_date)
            ->where('payment_date', '<=', $this->end_date);


        // get this project lifting Ids

        if ($this->project) {
            $thisProjectLiftingIds = MaterialLifting::where('project_id', $this->project)->pluck('id');
            $material_vendor_payment_ids = MaterialVendorPaymentInvoice::whereIn('lifting_id', $thisProjectLiftingIds)->pluck('id');
            $MaterialVendorPayment = $MaterialVendorPayment->whereIn('id', $material_vendor_payment_ids);
        }

        if ($this->tower) {
            $thisProjectLiftingIds = MaterialLifting::where('tower_id', $this->tower)->pluck('id');
            $material_vendor_payment_ids = MaterialVendorPaymentInvoice::whereIn('lifting_id', $thisProjectLiftingIds)->pluck('id');

            $MaterialVendorPayment = $MaterialVendorPayment->whereIn('id', $material_vendor_payment_ids);
        }

        if ($this->vendor) {
            $MaterialVendorPayment = $MaterialVendorPayment->where('vendor_id', $this->vendor);
        }

        $MaterialVendorPayment = $MaterialVendorPayment->with(['vendor', 'invoices', 'invoices.materialLifting', 'invoices.materialLifting.project'])->get();
        // MaterialVendorPayment table end


        return [
            'CashRequisition' => $CashRequisition,
            'MaterialVendorPayment' => $MaterialVendorPayment,
        ];
    }

    public function generate()
    {

        $queryData = $this->query();


        $data = [];

        // cash requisition table start
        foreach ($queryData['CashRequisition'] as $CashRequisition) {

            foreach ($CashRequisition->items as $item) {

                $ld = [
                    'date' => date('d-m-Y', strtotime($CashRequisition->date)),
                    'project' => $CashRequisition->project->project_name,
                    'vendor' => $item?->vendor?->name,
                    'head' => $item->budgethead->name,
                    'amount' => $item->requisition_amount,
                ];

                array_push($data, $ld);
            }
        }
        // cash requisition table end

        // MaterialVendorPayment table start
        foreach ($queryData['MaterialVendorPayment'] as $MaterialVendorPayment) {

            foreach ($MaterialVendorPayment->invoices as $invoice) {

                $ld = [
                    'date' => date('d-m-Y', strtotime($MaterialVendorPayment->payment_date)),
                    'project' => $invoice->materialLifting->project->project_name,
                    'vendor' => $MaterialVendorPayment->vendor->name,
                    'head' => 'Material Purchase',
                    // 'amount' => $MaterialVendorPayment->payment_amount,
                    'amount' => $invoice->materialLifting->totalAmount(),
                ];

                array_push($data, $ld);
            }
        }
        // MaterialVendorPayment table end

        return [
            'report_table' => $data,
        ];
    }
}
