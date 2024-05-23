<?php

namespace App\Helper;

use App\User;
use App\Product;

class ProductDealerStock
{

    public static function report($productId)
    {

        $product = Product::find($productId);
        $dealers = User::where('role', 4)->get();

        $report = [];

        foreach ($dealers as $dealer) {

            $dealerInventory = new DealerInventory($dealer);
            $stockQty = $dealerInventory->getDealerStockQty($product);

            if($stockQty == 0){
                continue;
            }

            $report[] = [
                'dealer' => $dealer,
                'dealerStock' => $stockQty,
            ];

        }

        return $report;
    }
}
