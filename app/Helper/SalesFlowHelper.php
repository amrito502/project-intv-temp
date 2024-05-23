<?php

namespace App\Helper;

use App\Wallet;
use App\CashSale;
use App\CreditSale;
use App\CashSaleItem;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;
use Illuminate\Support\Carbon;

class SalesFlowHelper
{

    public static function SalesFlow()
    {
        $data = [];

        $memberSale = MemberSale::all();

        $startDate = Carbon::parse("2022-08-01")->subDay();
        $endDate = Carbon::parse("now");
        $diff = $startDate->diffInDays($endDate);


        $saleTotal = 0;


        for ($i = 0; $i <= $diff; $i++) {

            $amountByDate = $memberSale->where('invoice_date', $startDate->addDay()->format('Y-m-d') . " 00:00:00")->sum('invoice_amount');

            $saleTotal += $amountByDate;

            $data[] = [
                'dayCount' => $i,
                'SaleTotal' => $saleTotal,
            ];
        }

        // dd($data);

        return $data;
    }

    public static function DealerTransactionFlow($userId)
    {
        $data = [];

        // get last 6 month startdate and enddate on a array via carbon
        $month = Carbon::now()->subMonth(5)->format('Y-m');
        $monthArray = [];
        for ($i = 0; $i < 6; $i++) {
            $monthArray[] = [
                'startDate' => Carbon::parse($month)->startOfMonth(),
                'endDate' => Carbon::parse($month)->endOfMonth(),
            ];
            $month = Carbon::parse($month)->addMonth()->format('Y-m');
        }

        foreach ($monthArray as $month) {
            // sold by dealer
            $memberSaleAmount = MemberSale::where('store_id', $userId)
                ->where('invoice_date', '>=', $month['startDate']->format('Y-m-d'))
                ->where('invoice_date', '<=', $month['endDate']->format('Y-m-d'))
                ->sum('invoice_amount');

            // purchase by dealer
            $dealerSaleIds = CashSale::where('customer_id', $userId)
                ->where('invoice_date', '>=', $month['startDate']->format('Y-m-d'))
                ->where('invoice_date', '<=', $month['endDate']->format('Y-m-d'))
                ->pluck('id')
                ->toArray();

            $cashSaleAmount = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
                ->sum('item_price');


            $creditSaleAmount = CreditSale::where('customer_id', $userId)
                ->where('invoice_date', '>=', $month['startDate']->format('Y-m-d'))
                ->where('invoice_date', '<=', $month['endDate']->format('Y-m-d'))
                ->sum('invoice_amount');


            $data[] = [
                'month' => $month['startDate']->format('M'),
                'SaleTotal' => $memberSaleAmount,
                'purchaseTotal' => $cashSaleAmount + $creditSaleAmount,
            ];
        }

        return $data;
    }


    public static function monthWisePackageSale()
    {
        // get last 6 month startdate and enddate on a array via carbon
        $month = Carbon::now()->subMonth(5)->format('Y-m');
        $monthArray = [];
        for ($i = 0; $i < 6; $i++) {
            $monthArray[] = [
                'startDate' => Carbon::parse($month)->startOfMonth(),
                'endDate' => Carbon::parse($month)->endOfMonth(),
            ];
            $month = Carbon::parse($month)->addMonth()->format('Y-m');
        }

        // get package count of each month
        $packageCounts = [];
        foreach ($monthArray as $month) {

            $totalPackageCount = Wallet::whereBetween('created_at', [$month['startDate'], $month['endDate']])
                ->where('remarks', 'TeamBonus')
                ->where('pp', 100)
                ->count();

            $monthSaleIds = MemberSale::where('invoice_date', '>=', $month['startDate']->format('Y-m-d'))
                ->where('invoice_date', '<=', $month['endDate']->format('Y-m-d'))
                ->pluck('id')
                ->toArray();

            $totalQty = MemberSaleItem::whereIn('member_sale_id', $monthSaleIds)->sum('item_quantity');

            $packageCounts[] = [
                'month' => $month['startDate']->format('M'),
                'totalPackageCount' => $totalPackageCount,
                'totalQty' => $totalQty,
            ];
        }

        return $packageCounts;
    }

    public static function monthWiseProductSale()
    {

        // get last 6 month startdate and enddate on a array via carbon
        $month = Carbon::now()->subMonth(5)->format('Y-m');
        $monthArray = [];
        for ($i = 0; $i < 6; $i++) {
            $monthArray[] = [
                'startDate' => Carbon::parse($month)->startOfMonth(),
                'endDate' => Carbon::parse($month)->endOfMonth(),
            ];
            $month = Carbon::parse($month)->addMonth()->format('Y-m');
        }


        // get product count of each month
        $productCounts = [];
        foreach ($monthArray as $month) {

            $monthSaleIds = MemberSale::where('invoice_date', '>=', $month['startDate']->format('Y-m-d'))
                ->where('invoice_date', '<=', $month['endDate']->format('Y-m-d'))
                ->pluck('id')
                ->toArray();

            $totalSaleAmount = MemberSaleItem::whereIn('member_sale_id', $monthSaleIds)->sum('item_price');
            $totalPurchasePoint = MemberSaleItem::whereIn('member_sale_id', $monthSaleIds)->sum('pp');

            $productCounts[] = [
                'month' => $month['startDate']->format('M'),
                'totalSaleAmount' => $totalSaleAmount,
                'totalPurchasePoint' => $totalPurchasePoint,
            ];
        }

        return $productCounts;
    }
}
