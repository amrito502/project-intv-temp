<?php
namespace App\Helper\DealerReports;

use App\Product;
use App\Models\Category;
use App\Models\MemberSale;
use App\Models\MemberSaleItem;

class DealerContribution{

    protected $params;

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function getProductReport()
    {

        // query start

        $memberSaleIds = MemberSale::with(['items', 'items.product']);

        if($this->params['dealerId']){
            $memberSaleIds = $memberSaleIds->where('store_id', $this->params['dealerId']);
        }

        $memberSaleIds = $memberSaleIds->select('id')->get()->pluck('id')->toArray();


        $memberSaleItems = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)->get();

        $productBySale = $memberSaleItems->groupBy('item_id');
        // query end

        // format array start
        $reports = [];

        $totalQty = $memberSaleItems->sum('item_quantity');
        $totalAmount = $memberSaleItems->sum('item_price');

        foreach ($productBySale as $productGroup) {

            $qty = $productGroup->sum('item_quantity');
            $amount = $productGroup->sum('item_price');

            $percentage_qty = ($qty / $totalQty) * 100;
            $percentage_amount = ($amount / $totalAmount) * 100;

            $reports[] = [
                'name' => $productGroup->first()->product->name . ' (' . $productGroup->first()->product->deal_code . ')',
                'qty' => round($qty, 2),
                'amount' => round($amount, 2),
                'percentage_qty' => round($percentage_qty, 2),
                'percentage_amount' => round($percentage_amount, 2),
            ];

        }

        // format array end

        return $reports;

    }

    public function getCategoryReport()
    {

        $reports = [];
        // query start

        $categories = Category::all();

        foreach ($categories as $category) {

            // get category products
            $productIds = Product::where('root_category', $category->id)->where('status', 1)->pluck('id');

            if(!$productIds){
                continue;
            }

            // get dealer sale Ids
            if($this->params['dealerId']){
                $memberSaleIds = MemberSale::where('store_id', $this->params['dealerId'])->select('id')->get()->pluck('id')->toArray();
            }else{
                $memberSaleIds = MemberSale::select('id')->get()->pluck('id')->toArray();
            }

            // get products member sale
            $memberSaleItems = MemberSaleItem::whereIn('member_sale_id', $memberSaleIds)->whereIn('item_id', $productIds)->get();

            if(!$memberSaleItems){
                continue;
            }

            $qty = $memberSaleItems->sum('item_quantity');

            if(!$qty){
                continue;
            }

            $amount = $memberSaleItems->sum('item_price');

            $percentage_qty = ($qty / MemberSaleItem::sum('item_quantity')) * 100;
            $percentage_amount = ($amount / MemberSaleItem::sum('item_price')) * 100;

            $reports[] = [
                'name' => $category->categoryName,
                'qty' => round($qty, 2),
                'amount' => round($amount, 2),
                'percentage_qty' => round($percentage_qty, 2),
                'percentage_amount' => round($percentage_amount, 2),
            ];

        }

        // query end

        return $reports;
    }


    public function getReport()
    {
        $reports = [];

        if($this->params['option'] == "Products"){
            $reports = $this->getProductReport();
        }else{
            $reports = $this->getCategoryReport();
        }

        return $reports;
    }

}
