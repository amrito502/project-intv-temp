<?php

namespace App\Helper\DealerReports;

use App\User;
use App\Wallet;
use App\CashSale;
use App\CreditCollection;
use App\Models\DealerPurchaseReturn;
use App\Models\MemberSale;
use Illuminate\Support\Facades\Auth;


class StatementReport
{
    protected $dateRange;
    protected $previousBalance;
    protected $dealerUser;

    public function __construct($dealerId, $dateRange, $previousBalance)
    {
        $this->previousBalance = $previousBalance;
        $this->dateRange = $dateRange;
        $this->dealerUser = User::findOrFail($dealerId);
    }


    public function query()
    {
        // dealer purchase details
        $dealerPurchase = CashSale::where('customer_id', $this->dealerUser->id)
            ->where('invoice_date', '>=', $this->dateRange['start_date'])
            ->where('invoice_date', '<=', $this->dateRange['end_date'])
            ->get();


        // dealer payment details
        $dealerCreditCollection = CreditCollection::where('client_id', $this->dealerUser->id)
            ->where('payment_date', '>=', $this->dateRange['start_date'])
            ->where('payment_date', '<=', $this->dateRange['end_date'])
            ->get();


        // member payment details
        $memberPayment = Wallet::with(['from'])
            ->where('remarks', 'Withdraw')
            ->where('to_id', $this->dealerUser->id)
            // ->where('payment_gateway', 'cash')
            ->where('created_at', '>=', $this->dateRange['start_date'])
            ->where('created_at', '<=', $this->dateRange['end_date'])
            ->where('status', 1)
            ->get();


        // dealer return
        $dealerReturns = DealerPurchaseReturn::where('dealer_id', $this->dealerUser->id)
            ->where('purchase_return_date', '>=', $this->dateRange['start_date'])
            ->where('purchase_return_date', '<=', $this->dateRange['end_date'])
            ->get();


        // dealer withdraw
        $withdraw = Wallet::where('from_id', $this->dealerUser->id)
            ->where('remarks', 'Withdraw')
            ->where('created_at', '>=', $this->dateRange['start_date'])
            ->where('created_at', '<=', $this->dateRange['end_date'])
            ->where('status', 1)
            ->get();

        // dealer Commission
        $dealer_commission = Wallet::where('from_id', $this->dealerUser->id)
            ->where('remarks', 'DealerCommission')
            ->where('created_at', '>=', $this->dateRange['start_date'])
            ->where('created_at', '<=', $this->dateRange['end_date'])
            ->where('status', 1)
            ->get();

        // member sale details
        // $memberSales = MemberSale::where('store_id', $this->dealerUser->id)
        //     ->whereDate('invoice_date', '>=', $this->dateRange["start_date"])
        //     ->whereDate('invoice_date', '<=', $this->dateRange["end_date"])
        //     ->get();


        return  [
            'dealerPurchase' => $dealerPurchase,
            'dealerCreditCollection' => $dealerCreditCollection,
            'dealerReturns' => $dealerReturns,
            'memberPayment' => $memberPayment,
            'withdraw' => $withdraw,
            'dealer_commission' => $dealer_commission,
            // 'memberSales' => $memberSales,
        ];
    }


    public function formattedData()
    {
        $query = $this->query();

        $balance = $this->previousBalance;
        $data = [];

        // dealer purchase details
        if ($query['dealerPurchase']->count()) {

            // dd($query['dealerPurchase']);

            foreach ($query['dealerPurchase'] as $purchase) {

                $remarks = 'Cash Purchase - ';

                if ($purchase->payment_type != 'Cash') {
                    $remarks = 'Credit Purchase - ';
                }

                $data[] = [
                    'timestamp' => strtotime($purchase->invoice_date),
                    'date' => date('d-m-Y', strtotime($purchase->invoice_date)),
                    'remarks' => $remarks . $purchase->invoice_no,
                    'purchase' => (int)$purchase->invoice_amount,
                    'payment' => 0,
                ];


                if ($purchase->payment_type == "Cash") {

                    $data[] = [
                        'timestamp' => strtotime($purchase->invoice_date),
                        'date' => date('d-m-Y', strtotime($purchase->invoice_date)),
                        'remarks' => 'Payment - ' . $purchase->invoice_no,
                        'purchase' => 0,
                        'payment' => (int)$purchase->invoice_amount,
                    ];
                }

                // if ($purchase->payment_type != "Cash") {
                //     $data[] = [
                //         'timestamp' => strtotime($purchase->invoice_date),
                //         'date' => date('d-m-Y', strtotime($purchase->invoice_date)),
                //         'remarks' => 'Commission - ' . $purchase->invoice_no,
                //         'purchase' => 0,
                //         'payment' => (int)$purchase->invoice_amount - (int)$purchase->net_amount,
                //     ];
                // }


            }
        }

        // dealer credit payment details
        if ($query['dealerCreditCollection']->count()) {

            foreach ($query['dealerCreditCollection'] as $dealerCreditCollection) {

                $invoiceDate = explode(' ', $dealerCreditCollection->payment_date)[0];

                $data[] = [
                    'timestamp' => strtotime($invoiceDate),
                    'date' => date('d-m-Y', strtotime($invoiceDate)),
                    'remarks' => 'Credit Payment - ' . $dealerCreditCollection->payment_no,
                    'purchase' => 0,
                    'payment' => (int)$dealerCreditCollection->payment_amount,
                ];
            }
        }

        // dealer return details
        if ($query['dealerReturns']->count()) {

            foreach ($query['dealerReturns'] as $dealerReturn) {

                $invoiceDate = explode(' ', $dealerReturn->purchase_return_date)[0];

                $data[] = [
                    'timestamp' => strtotime($invoiceDate),
                    'date' => date('d-m-Y', strtotime($invoiceDate)),
                    'remarks' => 'Product Return - ' . $dealerReturn->purchase_return_serial,
                    'purchase' => 0,
                    'payment' => (int)$dealerReturn->total_amount,
                ];
            }
        }

        // dealer member payment details
        if ($query['memberPayment']->count()) {

            foreach ($query['memberPayment'] as $memberPayment) {


                $data[] = [
                    'timestamp' => strtotime($memberPayment->created_at),
                    'date' => date('d-m-Y', strtotime($memberPayment->created_at)),
                    'remarks' => 'Member Withdraw - ' . $memberPayment->from->username,
                    'purchase' => 0,
                    'payment' => $memberPayment->amount,
                ];
            }
        }

        // dealer Withdraw details
        if ($query['withdraw']->count()) {

            foreach ($query['withdraw'] as $withdraw) {


                $data[] = [
                    'timestamp' => strtotime($withdraw->created_at),
                    'date' => date('d-m-Y', strtotime($withdraw->created_at)),
                    'remarks' => 'Dealer Withdraw - ' . $withdraw->from->username,
                    'purchase' => $withdraw->amount + $withdraw->charge,
                    'payment' => 0,
                ];
            }
        }

        // dealer commission details
        if ($query['dealer_commission']->count()) {

            foreach ($query['dealer_commission'] as $dealer_commission) {


                $data[] = [
                    'timestamp' => strtotime($dealer_commission->created_at),
                    'date' => date('d-m-Y', strtotime($dealer_commission->created_at)),
                    'remarks' => 'Dealer Commission - ' . $dealer_commission->from->username,
                    'purchase' => 0,
                    'payment' => $dealer_commission->amount,
                ];
            }
        }

        // member sale income details
        // if ($query['memberSales']->count()) {

        //     foreach ($query['memberSales'] as $memberSale) {


        //         $data[] = [
        //             'timestamp' => strtotime($memberSale->invoice_date),
        //             'date' => date('d-m-Y', strtotime($memberSale->invoice_date)),
        //             'remarks' => 'Member Sale - ' . $memberSale->invoice_no,
        //             'purchase' => $memberSale->net_amount,
        //             'payment' => 0,
        //         ];
        //     }
        // }


        // sort array by timestamp
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });


        // add balance field to array
        foreach ($data as $key => $value) {
            $balance += $value['purchase'] - $value['payment'];
            $data[$key]['balance'] = $balance;
        }

        return $data;
    }


    public function getAllDetails()
    {

        $reports = $this->formattedData();

        return $reports;
    }
}
