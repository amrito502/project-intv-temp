<?php

namespace App\Helper;

use App\User;
use App\Product;
use App\CashSaleItem;
use App\CashPurchaseItem;
use App\CreditPurchaseItem;
use App\Models\MemberSaleItem;

class ProductStatusReport
{

    public static function report()
    {
        // db queries
        $products = Product::all();
        $dealers = User::where('role', 4)->get();

        // report Array
        $report = [];

        foreach ($products as $product) {

            $dealerBalance = (int)self::dealerBalance($dealers, $product);
            $stockBalance = (int)self::stockBalance($product->id);
            $totalBalance = $dealerBalance + $stockBalance;

            if($totalBalance == 0){
                continue;
            }

            $report[] = [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->deal_code,
                'totalPurchase' => (int)self::totalPurchase($product->id),
                'totalPrimarySale' => (int)self::totalPrimarySale($product->id),
                'totalSecondarySale' => (int)self::totalSecondarySale($product->id),
                'dealerBalance' => $dealerBalance,
                'stockBalance' => $stockBalance,
                'totalBalance' => $totalBalance,
            ];

        }

        return $report;
    }

    public static function totalPurchase($productId)
    {

        // total cash purchase qty of this product
        $totalCashPurchase = CashPurchaseItem::where('product_id', $productId)->sum('qty');

        // total credit purchase qty of this product
        $totalCreditPurchase = CreditPurchaseItem::where('product_id', $productId)->sum('qty');

        // total purchase qty of this product
        $totalPurchase = $totalCashPurchase + $totalCreditPurchase;

        return $totalPurchase;
    }

    public static function totalPrimarySale($productId)
    {
        // total primary sale qty of this product
        $totalPrimarySale = CashSaleItem::where('item_id', $productId)->sum('item_quantity');

        return $totalPrimarySale;
    }

    public static function totalSecondarySale($productId)
    {
        // total secondary sale qty of this product
        $totalSecondarySale = MemberSaleItem::where('item_id', $productId)->sum('item_quantity');

        return $totalSecondarySale;
    }

    public static function dealerBalance($dealers, $product)
    {

        $totalDealerBalance = 0;

        foreach ($dealers as $dealer) {
            $dealerInventory = new DealerInventory($dealer);
            $totalDealerBalance += $dealerInventory->getDealerStockQty($product);
        }

        return $totalDealerBalance;
    }

    public static function stockBalance($productId)
    {

        $productStock = new StockStatus($productId);

        $stockBalance = $productStock->stock();

        return $stockBalance;

    }

}
