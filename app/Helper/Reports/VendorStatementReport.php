<?php

namespace App\Helper\Reports;

use App\Models\TBP;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\CashRequisition;
use App\Models\MaterialLifting;
use App\Models\TBPItem;

class VendorStatementReport
{

    // public User $vendorUser;
    public $project;
    public Vendor $vendor;
    public string $start_date;
    public string $end_date;

    public function __construct($filters)
    {
        if ($filters['project']) {
            $this->project = Project::find($filters['project']);
        }

        $this->vendor = Vendor::where('id', $filters['vendor'])->select('id', 'user_id')->first();
        $this->start_date = date('Y-m-d', strtotime($filters['start_date']));
        $this->end_date = date('Y-m-d', strtotime($filters['end_date']));

    }

    public function generate()
    {

        $report = [];

        $data = $this->getMaterialData();

        $report = $this->materialReportProcess($data);

        return $report;
    }


    public function getMaterialData()
    {

        $listings = MaterialLifting::with(['project'])
            ->whereIn('lifting_type', ['Local Lifting To Project', 'Client Provide To Project'])
            ->where('vendor_id', $this->vendor->id);

        if ($this->project) {
            $listings = $listings->where('project_id', $this->project->id);
        }

        $listings = $listings->whereDate('vouchar_date', '>=', $this->start_date)
            ->whereDate('vouchar_date', '<=', $this->end_date)
            ->orderBy('vouchar_date')
            ->get();


        $payments = CashRequisition::whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->with(['items', 'project']);

        if ($this->project) {
            $payments = $payments->where('project_id', $this->project->id);
        }

        $payments = $payments->whereHas('items', function ($q) {
            $q->where('vendor_id', $this->vendor->id);
        })
            ->orderBy('date')
            ->get();

        $tbps = TBP::where('vendor_id', $this->vendor->id)
            ->where('project_id', $this->project->id)
            ->whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->with(['items'])
            ->get();

        $tbpIds = $tbps->pluck('id')->toArray();

        $tbpItems = TBPItem::whereIn('tbp_id', $tbpIds)
            ->whereDate('payment_time', '>=', $this->start_date)
            ->whereDate('payment_time', '<=', $this->end_date)
            ->where('payment_status', 1)
            ->get();

        $data = [
            'liftings' => $listings,
            'payments' => $payments,
            'tbps' => $tbps,
            'tbpItems' => $tbpItems,
        ];

        return $data;
    }


    public function materialReportProcess($data)
    {

        $report = [];

        // make result array start
        if ($data['liftings']->count()) {

            foreach ($data['liftings'] as $lifting) {
                $report[] = [
                    'sl' => 0,
                    'date_timestamp' => strtotime($lifting->vouchar_date),
                    'date' => date('d-m-Y', strtotime($lifting->vouchar_date)),
                    'project' => $lifting->project->project_name,
                    'remarks' => 'Purchase',
                    'purchase' => $lifting->totalAmount(),
                    'payment' => 0,
                    'balance' => 0,
                ];
            }
        }

        if ($data['payments']->count()) {

            foreach ($data['payments'] as $payment) {
                $report[] = [
                    'sl' => 0,
                    'date_timestamp' => strtotime($payment->date),
                    'date' => date('d-m-Y', strtotime($payment->date)),
                    'project' => $lifting->project->project_name,
                    'remarks' => 'Paid',
                    'purchase' => 0,
                    'payment' => $payment->RequisitionTotalPaidAmount(),
                    'balance' => 0,
                ];
            }
        }

        if ($data['tbps']->count()) {

            foreach ($data['tbps'] as $tbp) {
                foreach ($tbp->items as $item) {

                    $report[] = [
                        'sl' => 0,
                        'date_timestamp' => strtotime($tbp->date),
                        'date' => date('d-m-Y', strtotime($tbp->date)),
                        'project' => $this->project->project_name,
                        'remarks' => 'TBP Approved',
                        'purchase' => $item->payment_amount,
                        'payment' => 0,
                        'balance' => 0,
                    ];
                }
            }
        }

        if ($data['tbpItems']->count()) {

            foreach ($data['tbpItems'] as $tbpItem) {

                $report[] = [
                    'sl' => 0,
                    'date_timestamp' => strtotime($tbpItem->payment_time),
                    'date' => date('d-m-Y', strtotime($tbpItem->payment_time)),
                    'project' => $this->project->project_name,
                    'remarks' => 'TBP Paid',
                    'purchase' => 0,
                    'payment' => $tbpItem->payment_amount,
                    'balance' => 0,
                ];
            }
        }
        // make result array start


        // sort array start
        $timestamps = array_column($report, 'date_timestamp');
        array_multisort($timestamps, SORT_ASC, $report);
        // sort array end


        // calculate balance start

        $reportWithBalance = [];

        $balance = 0;
        $i = 1;
        foreach ($report as $ld) {

            $ld['sl'] = $i++;

            if ($ld['remarks'] == 'Purchase') {
                $balance += $ld['purchase'];
            }

            if ($ld['remarks'] == 'Paid') {
                $balance -= $ld['payment'];
            }

            $ld['balance'] = $balance;

            $reportWithBalance[] = $ld;
        }

        // calculate balance end


        return $reportWithBalance;
    }
}
