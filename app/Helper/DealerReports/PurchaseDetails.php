<?php

namespace App\Helper\DealerReports;

use App\User;
use App\Product;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\Auth;


class PurchaseDetails
{
    protected $dateRange;
    protected $dealerUser;

    public function __construct($dateRange)
    {
        $this->dateRange = $dateRange;
        $this->dealerUser = User::findOrFail(Auth::user()->id);

    }


    public function getAllDetails()
    {

        // get all products
        $products = Product::where('status', 1)->get();

        $data = [];

        $DealerInventory = new DealerInventory($this->dealerUser);

        // loop through products and get details
        foreach ($products as $product) {

            $amount = $DealerInventory->getDealerStockInAmountTotalByDate($product, $this->dateRange);

            if(!$amount){
                continue;
            }

            $data[] = [
                'product' => $product,
                'stockIn' => $DealerInventory->getDealerStockInTotalByDate($product, $this->dateRange),
                'amount' => $amount,
                'pp' => $DealerInventory->getDealerStockInPurchasePointTotalByDate($product, $this->dateRange),
            ];
        }

        return $data;
    }


}
