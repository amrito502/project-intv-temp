<?php

namespace App\Helper;

use DB;
use App\Order;
use App\CashSale;
use App\CreditSale;
use App\CashPurchase;
use App\CashSaleItem;
use App\PurchaseOrder;
use App\CreditPurchase;
use App\CreditSaleItem;
use App\PurchaseReturn;
use App\CashPurchaseItem;
use App\PurchaseOrderItem;
use App\CreditPurchaseItem;
use App\Models\DealerPurchaseReturn;
use App\Models\DealerPurchaseReturnItem;
use App\PurchaseReturnItem;
use App\PurchaseOrderReceive;

class StockStatus
{
    public $product_id;

    public function __construct($product_id)
    {
        $this->product_id = $product_id;
    }

    public static function StockCheck($id = null)
    {
        $stockOutReports = DB::table('stock_valuation_report')
            ->select('products.id', 'products.stockUnit', 'stock_valuation_report.productId as productId', DB::raw('(((SUM(stock_valuation_report.cashPurchaseQty) + SUM(stock_valuation_report.creditPurchaseQty)) - SUM(stock_valuation_report.purchaseReturnQty)) - ((SUM(stock_valuation_report.cashSaleQty) + SUM(stock_valuation_report.creditSaleQty)) - SUM(stock_valuation_report.salesReturnQty))) as remainingQty'))
            ->join('products', 'products.id', '=', 'stock_valuation_report.productId')
            ->where('products.stockUnit', '1')
            ->where('stock_valuation_report.productId', $id)
            ->first();

        return $stockOutReports;
    }

    public function totalPurchase()
    {
        $cashPurchase = (float)CashPurchaseItem::where('product_id', $this->product_id)->sum('qty');

        $creditPurchase = (float)CreditPurchaseItem::where('product_id', $this->product_id)->sum('qty');

        $purchaseOrder = (float)PurchaseOrderItem::where('product_id', $this->product_id)->sum('qty');

        $total_purchase = $cashPurchase + $creditPurchase + $purchaseOrder;

        return $total_purchase;
    }

    public function totalPurchaseByDate($startDate, $endDate)
    {

        if ($startDate < '2010-01-01') {
            $startDate = "0000-00-00";
        }

        if ($endDate < '2010-01-01') {
            $endDate = date('Y-m-d', time());
        }

        $cashPurchasesInDate = CashPurchase::with(['items'])->whereBetween('voucher_date', [$startDate, $endDate])->get();

        $cashPurchaseCountInDate = 0;

        foreach ($cashPurchasesInDate as $cashPurchase) {
            foreach ($cashPurchase->items as $item) {
                if ($item->product_id == $this->product_id) {
                    $cashPurchaseCountInDate += $item->qty;
                }
            }
        }

        $creditPurchasesInDate = CreditPurchase::with(['items'])->whereBetween('submission_date', [$startDate, $endDate])->get();

        $creditPurchaseCountInDate = 0;

        foreach ($creditPurchasesInDate as $Purchase) {
            foreach ($Purchase->items as $item) {
                if ($item->product_id == $this->product_id) {
                    $creditPurchaseCountInDate += $item->qty;
                }
            }
        }

        $PurchasesOrderInDate = PurchaseOrderReceive::with(['items'])->whereBetween('receive_date', [$startDate, $endDate])->get();

        $PurchasesOrderCountInDate = 0;

        foreach ($PurchasesOrderInDate as $Purchase) {
            foreach ($Purchase->items as $item) {
                if ($item->product_id == $this->product_id) {
                    $PurchasesOrderCountInDate += $item->qty;
                }
            }
        }

        $totalPurchaseInDate = $cashPurchaseCountInDate + $creditPurchaseCountInDate + $PurchasesOrderCountInDate;

        return [
            'total_purchase_in_date_range' => $totalPurchaseInDate,
        ];
    }

    public function totalPurchaseReturn()
    {
        $purchaseReturn = (float)PurchaseReturnItem::where('product_id', $this->product_id)->sum('qty');

        return $purchaseReturn;
    }

    public function totalPurchaseReturnByDate($startDate, $endDate)
    {

        if ($startDate < '2010-01-01') {
            $startDate = "0000-00-00";
        }

        if ($endDate < '2010-01-01') {
            $endDate = date('Y-m-d', time());
        }

        $purchaseReturnInDate = PurchaseReturn::with(['items'])->whereBetween('purchase_return_date', [$startDate, $endDate])->get();

        $purchaseReturnCountInDate = 0;

        foreach ($purchaseReturnInDate as $purchaseReturn) {
            foreach ($purchaseReturn->items as $item) {
                if ($item->product_id == $this->product_id) {
                    $purchaseReturnCountInDate += $item->qty;
                }
            }
        }

        return [
            'total_purchase_return_in_date_range' => $purchaseReturnCountInDate,
        ];
    }

    public function totalSales()
    {
        $cashSale = (float)CashSaleItem::where('item_id', $this->product_id)->sum('item_quantity');
        $creditSale = (float)CreditSaleItem::where('item_id', $this->product_id)->sum('item_quantity');

        $onlineSale = (float)Order::where('product_id', $this->product_id)
            ->with(['checkout' => function ($query) {
                $query->where('status', "Complete");
            }])
            ->sum('qty');

        $totalSale = $cashSale + $creditSale + $onlineSale;

        return $totalSale;
    }

    public function totalSalesByDate($startDate, $endDate)
    {

        if ($startDate < '2010-01-01') {
            $startDate = "0000-00-00";
        }

        if ($endDate < '2010-01-01') {
            $endDate = date('Y-m-d', time());
        }

        $cashSaleInDate = CashSale::with(['items'])->whereBetween('invoice_date', [$startDate, $endDate])->get();

        $cashSaleCountInDate = 0;

        foreach ($cashSaleInDate as $Sale) {
            foreach ($Sale->items as $item) {
                if ($item->item_id == $this->product_id) {
                    $cashSaleCountInDate += $item->item_quantity;
                }
            }
        }

        $creditSaleInDate = CreditSale::with(['items'])->whereBetween('invoice_date', [$startDate, $endDate])->get();

        $creditSaleCountInDate = 0;

        foreach ($creditSaleInDate as $Sale) {
            foreach ($Sale->items as $item) {
                if ($item->item_id == $this->product_id) {
                    $creditSaleCountInDate += $item->item_quantity;
                }
            }
        }

        $OrdersInDate = Order::whereBetween('created_at', [$startDate, $endDate])->with(['checkout' => function ($query) {
            $query->where('status', "Complete");
        }])->get();


        $OrdersCountInDate = 0;

        foreach ($OrdersInDate as $Sale) {
            if ($Sale->product_id == $this->product_id) {
                $OrdersCountInDate += $Sale->qty;
            }
        }

        $totalSaleInDate = $cashSaleCountInDate + $creditSaleCountInDate + $OrdersCountInDate;

        return [
            'total_sale_in_date_range' => $totalSaleInDate,
        ];
    }

    public function totalSalesReturn()
    {
        $purchaseReturn = DealerPurchaseReturnItem::where('product_id', $this->product_id)->sum('qty');

        return $purchaseReturn;
    }

    public function totalSalesReturnByDate($startDate, $endDate)
    {

        if ($startDate < '2010-01-01') {
            $startDate = "0000-00-00";
        }

        if ($endDate < '2010-01-01') {
            $endDate = date('Y-m-d', time());
        }

        $dealerReturnInDate = DealerPurchaseReturn::with(['items'])->whereBetween('purchase_return_date', [$startDate, $endDate])->get();

        $dealerReturnCountInDate = 0;

        foreach ($dealerReturnInDate as $return) {
            foreach ($return->items as $item) {
                if ($item->product_id == $this->product_id) {
                    $dealerReturnCountInDate += $item->qty;
                }
            }
        }

        return [
            'total_return_in_date_range' => $dealerReturnCountInDate,
        ];
    }


    public function stock()
    {
        return ($this->totalPurchase() + $this->totalSalesReturn()) - ($this->totalPurchaseReturn() + $this->totalSales());
    }

    public function stockByDate($startDate, $endDate)
    {
        return $this->totalPurchase($startDate, $endDate) - $this->totalSales($startDate, $endDate);
    }

    public function avgPurchasePrice()
    {

        $divideBy = 0;

        $cashPurchase = (float)CashPurchaseItem::where('product_id', $this->product_id)->avg('rate_cash');

        // $creditPurchase = (float)CreditPurchaseItem::where('product_id', $this->product_id)->avg('rate');

        // $purchaseOrder = (float)PurchaseOrderItem::where('product_id', $this->product_id)->avg('rate');

        if($cashPurchase > 0){
            $divideBy++;
        }
        // if($creditPurchase > 0){
        //     $divideBy++;
        // }
        // if($purchaseOrder > 0){
        //     $divideBy++;
        // }

        if($divideBy == 0){
            $divideBy = 1;
        }

        // $total_purchase = ($cashPurchase + $creditPurchase + $purchaseOrder) / $divideBy;
        $total_purchase = ($cashPurchase) / $divideBy;

        return $total_purchase;
    }
}
