<?php

namespace App\Helper;

use App\CashPurchase;
use App\CreditPurchase;
use App\SupplierPayment;

class SupplierStatementReport
{
    protected $fromDate;

    protected $toDate;

    protected $supplierId;

    protected $previousBalance;

    protected $queryData;

    protected $formattedData;

    public function __construct($fromDate, $toDate, $supplierId, $previousBalance)
    {
        // please do not rearrange this order
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->supplierId = $supplierId;
        $this->previousBalance = $previousBalance;

        $this->queryData = $this->getData();

        $this->formatData();

        $this->sortDataByDateTimeStamp();

        $this->calculateBalanceOfData();

    }

    public function getCashPurchase()
    {

        $cashPurchase = CashPurchase::where('supplier_id', $this->supplierId)
            ->whereBetween('voucher_date', [$this->fromDate, $this->toDate])
            ->get();

        return $cashPurchase;
    }

    public function getCreditPurchase()
    {

        $creditPurchase = CreditPurchase::where('supplier_id', $this->supplierId)
            ->whereBetween('voucher_date', [$this->fromDate, $this->toDate])
            ->get();

        return $creditPurchase;
    }

    public function getSupplierPayment()
    {

        $supplierPayment = SupplierPayment::where('supplier_id', $this->supplierId)
            ->whereBetween('payment_date', [$this->fromDate, $this->toDate])
            ->get();

        return $supplierPayment;
    }

    public function getData()
    {
        return [
            'cashPurchase' => $this->getCashPurchase(),
            'creditPurchase' => $this->getCreditPurchase(),
            'supplierPayment' => $this->getSupplierPayment(),
        ];
    }

    public function formatData()
    {
        $tmpData = [];

        // cash purchase start
        foreach ($this->queryData["cashPurchase"] as $cashPurchase) {

            $tmpData[] = [
                'voucher_date_timestamp' => strtotime($cashPurchase->voucher_date),
                'date' => date('d-m-Y', strtotime($cashPurchase->voucher_date)),
                'description' => 'Cash Purchase - ' . $cashPurchase->voucher_no,
                'lifting' => $cashPurchase->total_amount,
                'payment' => $cashPurchase->total_amount,
            ];
        }
        // cash purchase end

        // credit purchase start
        foreach ($this->queryData["creditPurchase"] as $creditPurchase) {

            $tmpData[] = [
                'voucher_date_timestamp' => strtotime($creditPurchase->voucher_date),
                'date' => date('d-m-Y', strtotime($creditPurchase->voucher_date)),
                'description' => 'Credit Purchase -' . $creditPurchase->voucher_no,
                'lifting' => $creditPurchase->total_amount,
                'payment' => 0,
            ];
        }
        // credit purchase end

        // supplier payment start
        foreach ($this->queryData["supplierPayment"] as $supplierPayment) {

            $tmpData[] = [
                'voucher_date_timestamp' => strtotime($supplierPayment->payment_date),
                'date' => date('d-m-Y', strtotime($supplierPayment->payment_date)),
                'description' => 'Supplier Payment -' . $supplierPayment->payment_no,
                'lifting' => 0,
                'payment' => $supplierPayment->payment_now,
            ];
        }

        $this->formattedData = $tmpData;
    }

    public function sortDataByDateTimeStamp()
    {
        usort($this->formattedData, function ($a, $b) {
            return $a['voucher_date_timestamp'] - $b['voucher_date_timestamp'];
        });
    }

    public function calculateBalanceOfData()
    {
        $balance = $this->previousBalance;

        foreach ($this->formattedData as $key => $data) {
            $balance += $data['lifting'] - $data['payment'];
            $this->formattedData[$key]['balance'] = $balance;
        }

    }

    public function getReport()
    {
        return $this->formattedData;
    }
}
