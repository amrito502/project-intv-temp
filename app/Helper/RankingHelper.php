<?php

namespace App\Helper;

use App\User;
use App\Wallet;
use App\Product;
use App\Customer;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;

class RankingHelper
{


    public static function totalMemberSaleItemWiseQty()
    {

        $products = Product::all();

        $memberSaleItems = MemberSaleItem::all();

        $data = [];

        foreach ($products as $product) {

            $qty = $memberSaleItems->where('item_id', $product->id)->sum('item_quantity');

            if ($qty == 0) {
                continue;
            }

            $data[] = [
                'product' => $product,
                'qty' => $qty,
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('qty')->take(10)->toArray();

        return $data;
    }


    public static function totalMemberSaleTopCustomers($limit)
    {

        $customers = Customer::all();

        $data = [];

        foreach ($customers as $customer) {

            if (!@$customer->UserAccount) {
                continue;
            }

            $directIncome = Wallet::where('from_id', $customer->UserAccount->id)
                ->whereIn('remarks', ['ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus'])
                ->where('status', 1)
                ->sum('amount');

            $totalIncome = $directIncome;


            $data[] = [
                'customer' => $customer,
                'income' => $totalIncome,
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('income')->take($limit)->toArray();

        return $data;
    }

    public static function TeamMemberSaleTopCustomers($limit, $userId)
    {

        $userDownLevelMemberIds = User::findOrFail($userId)->DownLevelMemberIds();

        $customers = Customer::whereIn('user_id', $userDownLevelMemberIds)->get();

        $data = [];

        foreach ($customers as $customer) {

            if (!@$customer->UserAccount) {
                continue;
            }

            $directIncome = Wallet::where('from_id', $customer->UserAccount->id)
                ->whereIn('remarks', ['ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus'])
                ->where('status', 1)
                ->sum('amount');

            $totalIncome = $directIncome;

            if($totalIncome == 0){
                continue;
            }

            $data[] = [
                'customer' => $customer,
                'income' => $totalIncome,
            ];
        }

        // sort by qty
        $data = collect($data)->sortByDesc('income')->take($limit)->toArray();

        return $data;
    }

    public static function salesSummary()
    {

        $memberSales = MemberSale::all();

        // total sales data
        $totalSalesAmount = $memberSales->sum('invoice_amount');

        $totalSalesPP = 0;

        foreach ($memberSales as $memberSale) {
            $totalSalesPP += $memberSale->invoiceTotalPP();
        }

        // last month sales data
        $lastMonthStartDate = date('Y-m-d', strtotime('first day of last month')) . " 00:00:00";
        $lastMonthEndDate = date('Y-m-d', strtotime('last day of last month')) . " 00:00:00";

        $lastMonthSales = $memberSales
            ->where('invoice_date', '>=', $lastMonthStartDate)
            ->where('invoice_date', '<=', $lastMonthEndDate);

        $lastMonthSalesAmount = $lastMonthSales->sum('invoice_amount');

        $lastMonthSalesPP = 0;
        foreach ($lastMonthSales as $memberSale) {
            $lastMonthSalesPP += $memberSale->invoiceTotalPP();
        }


        // this month sales data
        $thisMonthStartDate = date('Y-m-d', strtotime('first day of this month')) . " 00:00:00";
        $thisMonthEndDate = date('Y-m-d', strtotime('last day of this month')) . " 00:00:00";

        $thisMonthSales = $memberSales
            ->where('invoice_date', '>=', $thisMonthStartDate)
            ->where('invoice_date', '<=', $thisMonthEndDate);

        $thisMonthSalesAmount = $thisMonthSales->sum('invoice_amount');

        $thisMonthSalesPP = 0;
        foreach ($thisMonthSales as $memberSale) {
            $thisMonthSalesPP += $memberSale->invoiceTotalPP();
        }


        // last day sales data
        $lastDay = date('Y-m-d', strtotime('yesterday')) . " 00:00:00";

        $lastDaySales = $memberSales->where('invoice_date', $lastDay);

        $lastDaySalesAmount = $lastDaySales->sum('invoice_amount');

        $lastDaySalesPP = 0;
        foreach ($lastDaySales as $memberSale) {
            $lastDaySalesPP += $memberSale->invoiceTotalPP();
        }


        // today sales data
        $today = date('Y-m-d') . " 00:00:00";

        $todaySales = $memberSales->where('invoice_date', $today);

        $todaySalesAmount = $todaySales->sum('invoice_amount');

        $todaySalesPP = 0;
        foreach ($todaySales as $memberSale) {
            $todaySalesPP += $memberSale->invoiceTotalPP();
        }


        return [
            [
                'title' => 'Total Sales Amount',
                'value' => number_format($totalSalesAmount, 2, ".", ","),
            ],
            [
                'title' => 'Total Sales Point',
                'value' => number_format($totalSalesPP, 2, ".", ","),
            ],
            [
                'title' => 'Last Month Sales',
                'value' => number_format($lastMonthSalesAmount, 2, ".", ","),
            ],
            [
                'title' => 'Last Month Point',
                'value' => number_format($lastMonthSalesPP, 2, ".", ","),
            ],
            [
                'title' => 'This Month Sales',
                'value' => number_format($thisMonthSalesAmount, 2, ".", ","),
            ],
            [
                'title' => 'This Month Point',
                'value' => number_format($thisMonthSalesPP, 2, ".", ","),
            ],
            [
                'title' => 'Last Day Sales',
                'value' => number_format($lastDaySalesAmount, 2, ".", ","),
            ],
            [
                'title' => 'Last Day Point',
                'value' => number_format($lastDaySalesPP, 2, ".", ","),
            ],
            [
                'title' => 'Today Sales Amount',
                'value' => number_format($todaySalesAmount, 2, ".", ","),
            ],
            [
                'title' => 'Today Sales Point',
                'value' => number_format($todaySalesPP, 2, ".", ","),
            ],
        ];
    }
}
