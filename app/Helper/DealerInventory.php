<?php

namespace App\Helper;

use App\User;
use App\Product;
use App\CashSale;
use App\CashSaleItem;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;
use App\Models\DealerPurchaseReturn;
use App\Models\DealerPurchaseReturnItem;


class DealerInventory
{
    protected $dealerUser;

    public function __construct(User $dealerUser)
    {
        $this->dealerUser = $dealerUser;
    }


    // get dealer stock in
    public function getDealerStockIn(Product $product)
    {

        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)->pluck('id')->toArray();

        // dealer sale product in count
        $total = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)->where('item_rate', '!=', 0)->where('item_id', $product->id)->sum('item_quantity');

        return $total;
    }

    // get dealer stock in total by date
    public function getDealerStockInTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"])
            ->whereDate('invoice_date', '<=', $dateRange["end_date"])
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $total = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_quantity');


        return $total;
    }

    // get dealer stock in amount by date
    public function getDealerStockInAmountTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"])
            ->whereDate('invoice_date', '<=', $dateRange["end_date"])
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $total = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_price');


        return $total;
    }


    // get dealer stock in amount
    public function getDealerStockInAmountTotal(Product $product)
    {
        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $total = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_dealer_price');

        return $total;
    }

    // get dealer stock in purchase point by date
    public function getDealerStockInPurchasePointTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"])
            ->whereDate('invoice_date', '<=', $dateRange["end_date"])
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $items = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
            ->where('item_id', $product->id)->get();

        foreach ($items as $item) {
            $total += $item->item_quantity * $item->pp;
        }


        return $total;
    }

    // get dealer stock in purchase point
    public function getDealerStockInPurchasePointTotal(Product $product)
    {
        $total = 0;

        // dealer sale ids
        $dealerSaleIds = CashSale::where('customer_id', $this->dealerUser->id)
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $items = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
            ->where('item_id', $product->id)->get();

        foreach ($items as $item) {
            $total += $item->item_quantity * $item->pp;
        }


        return $total;
    }


    // get dealer stock out
    public function getDealerStockOut(Product $product)
    {

        $total = 0;

        // member sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)->pluck('id')->toArray();

        // member sale product out count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)->where('item_id', $product->id)->sum('item_quantity');

        // dealer purchase return ids
        $dealerReturnIds = DealerPurchaseReturn::where('dealer_id', $this->dealerUser->id)->pluck('id')->toArray();

        // dealer purchase return product out count
        $total += DealerPurchaseReturnItem::whereIn('dealer_purchase_return_id', $dealerReturnIds)->where('product_id', $product->id)->sum('qty');

        return $total;
    }

    // get dealer stock out total by date
    public function getDealerStockOutTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // dealer sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"])
            ->whereDate('invoice_date', '<=', $dateRange["end_date"])
            ->pluck('id')
            ->toArray();


        // dealer sale product in count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_quantity');

        return $total;
    }

    // get dealer stock in amount by date
    public function getDealerStockOutAmountTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // member sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"] . " 00:00:00")
            ->whereDate('invoice_date', '<=', $dateRange["end_date"] . " 00:00:00")
            ->pluck('id')
            ->toArray();


        // member sale product in count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_price');

        return $total;
    }


    // get dealer stock in amount
    public function getDealerStockOutAmountTotal(Product $product)
    {
        $total = 0;

        // member sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)
            ->pluck('id')
            ->toArray();


        // member sale product in count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)
            ->where('item_id', $product->id)
            ->sum('item_price');


        return $total;
    }

    // get dealer stock in purchase point by date
    public function getDealerStockOutPurchasePointTotalByDate(Product $product, $dateRange)
    {
        $total = 0;

        // member sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)
            ->whereDate('invoice_date', '>=', $dateRange["start_date"])
            ->whereDate('invoice_date', '<=', $dateRange["end_date"])
            ->pluck('id')
            ->toArray();


        // member sale product in count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)
            ->where('item_id', $product->id)
            ->sum('pp');


        return $total;
    }

    // get dealer stock out purchase point
    public function getDealerStockOutPurchasePointTotal(Product $product)
    {
        $total = 0;

        // member sale ids
        $memberSaleIds = MemberSale::where('store_id', $this->dealerUser->id)
            ->pluck('id')
            ->toArray();


        // member sale product in count
        $total = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)
            ->where('item_id', $product->id)
            ->sum('pp');


        return $total;
    }


    // get dealer stock qty
    public function getDealerStockQty(Product $product)
    {
        $totalStockIn = $this->getDealerStockIn($product);
        $totalStockOut = $this->getDealerStockOut($product);
        $totalStockQty = $totalStockIn - $totalStockOut;
        return $totalStockQty;
    }

    // get dealer stock qty by date range
    public function getDealerStockQtyTotalByDate(Product $product, $dateRange)
    {
        $totalStockIn = $this->getDealerStockInTotalByDate($product, $dateRange);
        $totalStockOut = $this->getDealerStockOutTotalByDate($product, $dateRange);
        $totalStockQty = $totalStockIn - $totalStockOut;
        return $totalStockQty;
    }


    // get dealer stock Amount
    public function getDealerStockAmount(Product $product)
    {

        $productStockQty = $this->getDealerStockQty($product);

        $totalStockQty = $productStockQty * $product->discount;

        return $totalStockQty;
    }

    // get dealer stock purchase point
    public function getDealerStockPurchasePoint(Product $product)
    {
        $totalStockIn = $this->getDealerStockInPurchasePointTotal($product);
        $totalStockOut = $this->getDealerStockOutPurchasePointTotal($product);
        $totalStockQty = $totalStockIn - $totalStockOut;
        return $totalStockQty;
    }
}
