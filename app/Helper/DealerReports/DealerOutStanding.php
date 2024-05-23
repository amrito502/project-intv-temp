<?php

namespace App\Helper\DealerReports;

use App\User;
use App\CashSale;
use App\CreditCollection;
use Illuminate\Support\Carbon;

class DealerOutStanding
{
    protected $data;
    protected $dealers;

    protected $lastYear = [];
    protected $thisYear = [];
    protected $thisMonth = [];

    public function __construct($data)
    {
        $this->data = $data;

        // init dealer Ids start
        if ($this->data['dealerIds'] == null) {
            $this->data['dealerIds'] = User::where('role', 4)->orderBy('name', 'asc')->pluck('id')->toArray();
        }

        $this->dealers = User::whereIn('id', $this->data['dealerIds'])->orderBy('name', 'asc')->get();
        // init dealer Ids end

        // init dates start

        $this->lastYear = [
            'start_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->subYear()->startOfYear(),
            'end_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->subYear()->endOfYear(),
        ];

        $this->thisYear = [
            'start_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->startOfYear(),
            'end_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->endOfYear(),
        ];

        $this->thisMonth = [
            'start_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->startOfMonth(),
            'end_date' => Carbon::createFromDate($data['year'], $data['month'], 1)->endOfMonth(),
        ];

        // init dates end
    }


    public function getPreviousYearBalance($dealer)
    {

        // get dealer credit sale Amount
        $cashSale = CashSale::where('customer_id', $dealer->id)
            ->where('payment_type', 'Credit')
            ->whereBetween('invoice_date', [$this->lastYear['start_date']->format("Y-m-d"), $this->lastYear['end_date']->format("Y-m-d")])
            ->sum('invoice_amount');

        // get dealer credit collection Amount
        $creditCollection = CreditCollection::where('client_id', $dealer->id)
            ->whereBetween('payment_date', [$this->lastYear['start_date']->format("Y-m-d"), $this->lastYear['end_date']->format("Y-m-d")])
            ->sum('payment_amount');

        // get dealer balance
        $due = $cashSale - $creditCollection;

        return $due;
    }

    public function getThisYearInfo($dealer)
    {

        // get dealer credit sale Amount
        $cashSale = CashSale::where('customer_id', $dealer->id)
            ->where('payment_type', 'Credit')
            ->whereBetween('invoice_date', [$this->thisYear['start_date']->format("Y-m-d"), $this->thisYear['end_date']->format("Y-m-d")])
            ->sum('invoice_amount');

        // get dealer credit collection Amount
        $creditCollection = CreditCollection::where('client_id', $dealer->id)
            ->whereBetween('payment_date', [$this->thisYear['start_date']->format("Y-m-d"), $this->thisYear['end_date']->format("Y-m-d")])
            ->sum('payment_amount');

        // get dealer balance
        $due = $cashSale - $creditCollection;

        return [
            'sales' => $cashSale,
            'collection' => $creditCollection,
            'balance' => $due,
        ];
    }

    public function getThisMonthInfo($dealer)
    {

        // get dealer credit sale Amount
        $cashSale = CashSale::where('customer_id', $dealer->id)
            ->where('payment_type', 'Credit')
            ->whereBetween('invoice_date', [$this->thisMonth['start_date']->format("Y-m-d"), $this->thisMonth['end_date']->format("Y-m-d")])
            ->sum('invoice_amount');

        // get dealer credit collection Amount
        $creditCollection = CreditCollection::where('client_id', $dealer->id)
            ->whereBetween('payment_date', [$this->thisMonth['start_date']->format("Y-m-d"), $this->thisMonth['end_date']->format("Y-m-d")])
            ->sum('payment_amount');

        // get dealer balance
        $due = $cashSale - $creditCollection;

        return [
            'sales' => $cashSale,
            'collection' => $creditCollection,
            'balance' => $due,
        ];
    }


    public function getReport()
    {
        $report = [];

        foreach ($this->dealers as $dealer) {

            $previousYearBalance = $this->getPreviousYearBalance($dealer);
            $thisYearInfo = $this->getThisYearInfo($dealer);
            $thisMonthInfo = $this->getThisMonthInfo($dealer);

            $current_balance = $previousYearBalance + $thisYearInfo['balance'];

            $report[] = [
                'name' => $dealer->name . " - " . $dealer->username,
                'previous_year_balance' => $this->getPreviousYearBalance($dealer),
                'this_year_sales' => $thisYearInfo['sales'],
                'this_year_collection' => $thisYearInfo['collection'],
                'this_year_balance' => $thisYearInfo['balance'],
                'this_month_sales' => $thisMonthInfo['sales'],
                'this_month_collection' => $thisMonthInfo['collection'],
                'this_month_balance' => $thisMonthInfo['balance'],
                'current_balance' => $current_balance,
            ];
        }


        return $report;
    }
}
