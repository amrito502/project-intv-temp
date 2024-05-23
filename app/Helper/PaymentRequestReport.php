<?php

namespace App\Helper;

use App\User;
use App\Wallet;

class PaymentRequestReport
{

    protected $params;
    protected $query;
    protected $reports;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function query()
    {

        // dd($this->params);

        $wallet = Wallet::with(['from', 'to'])
            ->where('remarks', 'Withdraw');

        if ($this->params['user_type']) {

            // get role user Ids
            $userIds = User::where('role', $this->params['user_type'])->pluck('id')->toArray();

            $wallet = $wallet->whereIn('from_id', $userIds);
        }

        if ($this->params['dealer']) {
            $wallet = $wallet->where('to_id', $this->params['dealer']);
        }

        if ($this->params['payment_status'] == "approved") {
            $wallet = $wallet->whereNotNull('approved_by')
                ->where('created_at', '>=', $this->params['dateRange']['start_date'])
                ->where('created_at', '<=', $this->params['dateRange']['end_date']);
        }

        if ($this->params['payment_status'] == "pending") {
            $wallet = $wallet->whereNull('approved_by')
                ->where('created_at', '>=', $this->params['dateRange']['start_date'])
                ->where('created_at', '<=', $this->params['dateRange']['end_date']);
        }

        if ($this->params['payment_status'] == "paid") {
            $wallet = $wallet->where('status', 1)
                ->where('updated_at', '>=', $this->params['dateRange']['start_date'])
                ->where('updated_at', '<=', $this->params['dateRange']['end_date']);
        }

        if ($this->params['payment_way']) {
            $wallet = $wallet->where('payment_gateway', $this->params['payment_way']);
        }

        $wallet = $wallet->get();

        $this->query = [
            'wallet' => $wallet
        ];
    }

    public function reports()
    {
        $data = [];

        foreach ($this->query['wallet'] as $wallet) {

            $date = $wallet->created_at->format('d-m-Y');

            if ($this->params['payment_status'] == "paid") {
                $date = $wallet->created_at->format('d-m-Y');
            }

            $data[] = [
                'withdraw_by' => $wallet->from,
                'withdraw_amount' => $wallet->amount + $wallet->charge,
                'withdraw_charge' => $wallet->charge,
                'final_amount' => $wallet->amount,
                'date' => $date,
                'type' => $wallet->from->role == "4" ? "Dealer" : "Customer",
                'payment_gateway' => $wallet->payment_gateway,
                'payment_gateway_no' => $wallet->account_no,
                'transaction_no' => "",
            ];
        }

        return $data;
    }

    public function getReport()
    {

        $this->query();

        return $this->reports();
    }
}
