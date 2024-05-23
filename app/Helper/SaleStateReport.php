<?php
namespace App\Helper;

use App\User;
use App\Product;
use App\Models\MemberSaleItem;

class SaleStateReport{

    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function getReport()
    {

        $reports = [];

        $products = Product::with(['category'])->where('status', 1)->get();


        foreach ($products as $product) {

            $memberSaleItem = MemberSaleItem::with(['product']);


            if($this->params['categories']){
                $memberSaleItem = $memberSaleItem->whereHas('product', function($query) use ($product){
                    $query->whereIn('root_category', $this->params['categories']);
                });
            }


            $totalSalePoint = $memberSaleItem->where('item_id', $product->id)->sum('pp');

            $totalSaleAmount = $memberSaleItem->where('item_id', $product->id)->sum('item_price');

            $totalSaleQty = $memberSaleItem->where('item_id', $product->id)->sum('item_quantity');


            if($totalSalePoint == 0){
                continue;
            }


            $reports[] = [
                'product' => $product,
                'salesPoint' => $totalSalePoint,
                'salesAmount' => $totalSaleAmount,
                'salesQty' => $totalSaleQty,
            ];

        }

        return $reports;
    }


}
