<?php

namespace App\Helper\DealerReports;

use App\User;
use App\Wallet;
use App\Product;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\Auth;


class PaymentLog
{
    protected $dateRange;
    protected $dealerUser;

    public function __construct($dateRange)
    {
        $this->dateRange = $dateRange;
        $this->dealerUser = User::findOrFail(Auth::user()->id);
    }


    public function getAllDetails()
    {

        // get withdraws in date range

        $withdraws = Wallet::with(['from'])
            ->where('remarks', 'Withdraw')
            ->where('to_id', auth::user()->id)
            ->where('payment_gateway', 'cash')
            ->where('created_at', '>=', $this->dateRange['start_date'])
            ->where('created_at', '<=', $this->dateRange['end_date'])
            ->where('status', 1)
            ->get();


        // $data = [];


        // foreach ($withdraws as $withdraw) {

        //     $data[] = [
        //         'date' => $withdraw->created_at->format('Y-m-d'),
        //         'type' => 'Withdraw',
        //         'amount' => $withdraw->amount,
        //         'from' => $withdraw->from->name,
        //     ];
        // }



        return $withdraws;
    }
}
