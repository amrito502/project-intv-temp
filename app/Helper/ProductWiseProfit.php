<?php
namespace App\Helper;

use App\Product;


class ProductWiseProfit{
    protected $params;
    protected $products;

    public function __construct($params)
    {
        $this->params = $params;

        $this->products = Product::with(['category']);

        if($this->params['products']){
            $this->products->whereIn('id', $this->params['products']);
        }

        if($this->params['categories']){
            $this->products->whereIn('category_id', $this->params['categories']);
        }

        $this->products = $this->products->get();

    }

    public function report()
    {
        $reports = [];

        foreach($this->products as $product){
            $reports[] = [
                'category' => $product->category->categoryName,
                'product' => $product->name,
            ];
        }

        dd($reports);

        return $reports;
    }


}
