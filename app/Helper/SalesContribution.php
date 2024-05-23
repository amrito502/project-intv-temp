<?php

namespace App\Helper;

use App\User;
use App\Product;
use App\CashSale;
use App\Category;
use App\CashSaleItem;

class SalesContribution
{

    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function getCategoryWiseReport()
    {
        $categories = Category::all();

        $reports = [];

        $totalQty = 0;
        $totalAmount = 0;
        $totalPurchasePoint = 0;

        foreach ($categories as $category) {

            // check if category have products
            $productIds = Product::where('root_category', $category->id)
                ->where('status', 1)
                ->pluck('id')
                ->toArray();

            if ($productIds) {

                // get cash sale items id of this productIds
                $cashSaleIds = CashSaleItem::whereIn('item_id', $productIds)->pluck('cash_sale_id')->toArray();

                // get cash sale of this cash sale ids (filter by date and dealer)
                $cashSaleIds = CashSale::whereIn('id', $cashSaleIds)
                    ->where('created_at', '>=', $this->params['dateRange']['start_date'])
                    ->where('created_at', '<=', $this->params['dateRange']['end_date']);

                if ($this->params['dealerId']) {
                    $cashSaleIds = $cashSaleIds->where('customer_id', $this->params['dealerId']);
                }

                $cashSaleIds = $cashSaleIds->pluck('id')
                    ->toArray();

                // cash sale product in qty
                $totalQuantity = CashSaleItem::whereIn('item_id', $productIds)
                    ->whereIn('cash_sale_id', $cashSaleIds)
                    ->sum('item_quantity');

                if (!$totalQuantity) {
                    continue;
                }

                // dealer sale product in amount
                $totalItemAmount = CashSaleItem::whereIn('item_id', $productIds)
                    ->whereIn('cash_sale_id', $cashSaleIds)
                    ->sum('item_price');

                // dealer sale product in pp
                $totalPP = 0;

                $items = CashSaleItem::whereIn('item_id', $productIds)
                    ->whereIn('cash_sale_id', $cashSaleIds)
                    ->get();

                foreach ($items as $item) {
                    $totalPP += $item->item_quantity * $item->pp;
                }


                $totalQty += $totalQuantity;
                $totalAmount += $totalItemAmount;
                $totalPurchasePoint += $totalPP;

                $reports['perCat'][] = [
                    'category' => $category,
                    'qty' => $totalQuantity,
                    'amount' => $totalItemAmount,
                    'pp' => $totalPP,
                ];
            }
        }

        $reports['total'] = [
            'qty' => $totalQty,
            'amount' => $totalAmount,
            'pp' => $totalPurchasePoint,
        ];

        return $reports;
    }

    public function getProductWiseReport()
    {

        $products = Product::with(['category'])
        ->where('status', 1)
        ->where('root_category', $this->params['categoryId'])
        ->get();

        $reports = [];

        $totalQty = 0;
        $totalAmount = 0;
        $totalPurchasePoint = 0;

        foreach ($products as $product) {

            // get cash sale items id of this productIds
            $cashSaleIds = CashSaleItem::where('item_id', $product->id)->pluck('cash_sale_id')->toArray();

            // get cash sale of this cash sale ids (filter by date and dealer)
            $cashSaleIds = CashSale::whereIn('id', $cashSaleIds)
                ->where('created_at', '>=', $this->params['dateRange']['start_date'])
                ->where('created_at', '<=', $this->params['dateRange']['end_date'])
                ->pluck('id')
                ->toArray();

            // cash sale product in qty
            $totalQuantity = CashSaleItem::where('item_id', $product->id)
                ->whereIn('cash_sale_id', $cashSaleIds)
                ->sum('item_quantity');

            if (!$totalQuantity) {
                continue;
            }

            // dealer sale product in amount
            $totalItemAmount = CashSaleItem::where('item_id', $product->id)
                ->whereIn('cash_sale_id', $cashSaleIds)
                ->sum('item_price');

            // dealer sale product in pp
            $totalPP = 0;

            $items = CashSaleItem::where('item_id', $product->id)
                ->whereIn('cash_sale_id', $cashSaleIds)
                ->get();

            foreach ($items as $item) {
                $totalPP += $item->item_quantity * $item->pp;
            }


            $totalQty += $totalQuantity;
            $totalAmount += $totalItemAmount;
            $totalPurchasePoint += $totalPP;

            $reports['perProduct'][] = [
                'product' => $product,
                'qty' => $totalQuantity,
                'amount' => $totalItemAmount,
                'pp' => $totalPP,
            ];
        }

        $reports['total'] = [
            'qty' => $totalQty,
            'amount' => $totalAmount,
            'pp' => $totalPurchasePoint,
        ];

        return $reports;
    }

    public function getDealerWiseReport()
    {

        $dealers = User::where('role', 4)->get();

        $reports = [];

        $totalQty = 0;
        $totalAmount = 0;
        $totalPurchasePoint = 0;

        foreach ($dealers as $dealer) {

            // dealer sale ids
            $dealerSaleIds = CashSale::where('customer_id', $dealer->id)
                ->whereDate('invoice_date', '>=', $this->params['dateRange']["start_date"])
                ->whereDate('invoice_date', '<=', $this->params['dateRange']["end_date"])
                ->pluck('id')
                ->toArray();

            // dealer sale product in qty
            $totalQuantity = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
                ->sum('item_quantity');

            if (!$totalQuantity) {
                continue;
            }

            // dealer sale product in amount
            $totalItemAmount = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
                ->sum('item_price');

            // dealer sale product in pp
            $totalPP = 0;

            $items = CashSaleItem::whereIn('cash_sale_id', $dealerSaleIds)
                ->get();

            foreach ($items as $item) {
                $totalPP += $item->item_quantity * $item->pp;
            }


            $totalQty += $totalQuantity;
            $totalAmount += $totalItemAmount;
            $totalPurchasePoint += $totalPP;


            $reports['perDealer'][] = [
                'dealer' => $dealer,
                'qty' => $totalQuantity,
                'amount' => $totalItemAmount,
                'pp' => $totalPP,
            ];
        }

        $reports['total'] = [
            'qty' => $totalQty,
            'amount' => $totalAmount,
            'pp' => $totalPurchasePoint,
        ];

        return $reports;
    }

    public function getReport()
    {

        if ($this->params['type'] == 'categoryWise') {
            return $this->getCategoryWiseReport();
        }


        if ($this->params['type'] == 'productWise') {
            return $this->getProductWiseReport();
        }


        if ($this->params['type'] == 'dealerWise') {
            return $this->getDealerWiseReport();
        }
    }
}
