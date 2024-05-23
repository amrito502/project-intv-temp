<?php

namespace App\Helper\DealerReports;

use App\User;
use App\Product;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\Auth;


class StockReport
{
    protected $dealerUser;

    public function __construct($userId)
    {
        $this->dealerUser = User::findOrFail($userId);

    }


    public function getAllDetails()
    {

        // get all products
        $products = Product::with(['category'])->where('status', 1)->get();

        $data = [];

        $DealerInventory = new DealerInventory($this->dealerUser);

        // loop through products and get details
        foreach ($products as $product) {

            $data[] = [
                'product' => $product,
                'stockIn' => $DealerInventory->getDealerStockQty($product),
                'amount' => $DealerInventory->getDealerStockAmount($product),
            ];

        }

        return $data;
    }


}
