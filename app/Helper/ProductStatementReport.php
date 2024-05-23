<?php

namespace App\Helper;

use App\User;
use App\Wallet;
use App\CashSale;
use Carbon\Carbon;
use App\CashPurchase;
use App\CashSaleItem;
use App\PurchaseReturn;
use App\CreditCollection;
use App\CreditPurchase;
use App\CreditSale;
use App\Models\MemberSale;
use App\PurchaseOrderReceive;
use App\Models\DealerPurchaseReturn;
use Illuminate\Support\Facades\Auth;


class ProductStatementReport
{

    protected $params;
    protected $dateRange;
    protected $previousBalance;

    public function __construct($params, $previousBalance)
    {
        $this->params = $params;
        $this->previousBalance = $previousBalance;
        $this->dateRange = $params['dateRange'];
    }


    public function query()
    {

        // dealer purchase
        $dealerPurchase = CashSale::with(['items', 'dealer'])
            ->where('invoice_date', '>=', $this->dateRange['start_date'])
            ->where('invoice_date', '<=', $this->dateRange['end_date'])
            ->whereHas('items', function ($query) {
                $query->where('item_id', $this->params['productId']);
            })
            ->get();



        // dealer return
        $dealerReturn = DealerPurchaseReturn::with(['items', 'dealer'])
            ->where('purchase_return_date', '>=', $this->dateRange['start_date'])
            ->where('purchase_return_date', '<=', $this->dateRange['end_date'])
            ->whereHas('items', function ($query) {
                $query->where('product_id', $this->params['productId']);
            })
            ->get();


        // admin lifting
        $liftings = CashPurchase::with(['items'])
            ->where('voucher_date', '>=', $this->dateRange['start_date'])
            ->where('voucher_date', '<=', $this->dateRange['end_date'])
            ->whereHas('items', function ($query) {
                $query->where('product_id', $this->params['productId']);
            })
            ->get();

        // dealer credit purchase
        $creditLiftings = CreditPurchase::with(['items'])
            ->where('voucher_date', '>=', $this->dateRange['start_date'])
            ->where('voucher_date', '<=', $this->dateRange['end_date'])
            ->whereHas('items', function ($query) {
                $query->where('product_id', $this->params['productId']);
            })
            ->get();


        // admin return
        $returns = PurchaseReturn::with(['items'])
            ->where('purchase_return_date', '>=', $this->dateRange['start_date'])
            ->where('purchase_return_date', '<=', $this->dateRange['end_date'])
            ->whereHas('items', function ($query) {
                $query->where('product_id', $this->params['productId']);
            })
            ->get();


        // po lifting
        $poLiftings = PurchaseOrderReceive::with(['items', 'purchaseOrder'])
            ->whereBetween('receive_date', [$this->dateRange['start_date'], $this->dateRange['end_date']])
            ->get();


        return  [
            'dealerPurchase' => $dealerPurchase,
            'dealerReturn' => $dealerReturn,
            'liftings' => $liftings,
            'creditLiftings' => $creditLiftings,
            'poLiftings' => $poLiftings,
            'returns' => $returns,
        ];
    }


    public function formattedData()
    {
        $query = $this->query();

        $balance = $this->previousBalance;
        $data = [];

        // dealer purchase details
        if ($query['dealerPurchase']->count()) {

            foreach ($query['dealerPurchase'] as $purchase) {

                $data[] = [
                    'timestamp' => strtotime($purchase->invoice_date),
                    'date' => date('d-m-Y', strtotime($purchase->invoice_date)),
                    'remarks' => 'Dealer Sale - ' . $purchase->dealer->username . ' - ' . $purchase->invoice_no,
                    'in' => 0,
                    'out' => (int)$purchase->items->where('item_id', $this->params['productId'])->sum('item_quantity'),
                ];
            }
        }

        // dealer purchase return details
        if ($query['dealerReturn']->count()) {

            foreach ($query['dealerReturn'] as $dealerReturn) {

                $data[] = [
                    'timestamp' => strtotime($dealerReturn->purchase_return_date),
                    'date' => date('d-m-Y', strtotime($dealerReturn->purchase_return_date)),
                    'remarks' => 'Dealer Return - ' . $dealerReturn->dealer->username . ' - ' . $dealerReturn->purchase_return_serial,
                    'in' => (int)$dealerReturn->items->where('product_id', $this->params['productId'])->sum('qty'),
                    'out' => 0,
                ];
            }
        }


        // admin lifting details
        if ($query['liftings']->count()) {

            foreach ($query['liftings'] as $lifting) {

                $carbon = Carbon::parse($lifting->voucher_date);
                $timeStamp = $carbon->timestamp;
                $formatted = $carbon->format('d-m-Y');

                $data[] = [
                    'timestamp' => $timeStamp,
                    'date' => $formatted,
                    'remarks' => 'Company Lifting - ' . $lifting->voucher_no,
                    'in' => (int)$lifting->items->where('product_id', $this->params['productId'])->sum('qty'),
                    'out' => 0,
                ];
            }
        }

        // admin credit lifting details
        if ($query['creditLiftings']->count()) {

            foreach ($query['creditLiftings'] as $creditLifting) {

                $carbon = Carbon::parse($creditLifting->voucher_date);
                $timeStamp = $carbon->timestamp;
                $formatted = $carbon->format('d-m-Y');

                $data[] = [
                    'timestamp' => $timeStamp,
                    'date' => $formatted,
                    'remarks' => 'Company Credit Lifting - ' . $creditLifting->vouchar_no,
                    'in' => (int)$creditLifting->items->where('product_id', $this->params['productId'])->sum('qty'),
                    'out' => 0,
                ];
            }
        }


        // admin po lifting details
        if ($query['poLiftings']->count()) {

            foreach ($query['poLiftings'] as $poLifting) {

                $carbon = Carbon::parse($poLifting->receive_date);
                $timeStamp = $carbon->timestamp;
                $formatted = $carbon->format('d-m-Y');

                $data[] = [
                    'timestamp' => $timeStamp,
                    'date' => $formatted,
                    'remarks' => 'PO Receive - ' . $poLifting->purchaseOrder->order_no,
                    'in' => (int)$poLifting->items->where('product_id', $this->params['productId'])->sum('qty'),
                    'out' => 0,
                ];
            }
        }


        // admin lifting returns
        if ($query['returns']->count()) {

            foreach ($query['returns'] as $return) {

                $carbon = Carbon::parse($return->purchase_return_date);
                $timeStamp = $carbon->timestamp;
                $formatted = $carbon->format('d-m-Y');

                $data[] = [
                    'timestamp' => $timeStamp,
                    'date' => $formatted,
                    'remarks' => 'Company Return - ' . $return->purchase_return_serial,
                    'in' => 0,
                    'out' => (int)$return->items->where('product_id', $this->params['productId'])->sum('qty'),
                ];
            }
        }

        // sort array by timestamp
        usort($data, function ($a, $b) {
            return $a['timestamp'] - $b['timestamp'];
        });


        // add balance field to array
        foreach ($data as $key => $value) {
            $balance += $value['in'] - $value['out'];
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
