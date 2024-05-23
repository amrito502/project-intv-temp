<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;
use App\Models\Category;
use App\Product;

use DB;
use PDF;

class ProductWiseProfitController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        // $customer = $request->customer;
        $selectedProduct = $request->product;
        $selectedCategory = $request->category;

        $customers = Customer::orderBy('name', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->where('status', 1)->get();
        $categories = Category::orderBy('categoryName', 'asc')->get();

        $productWiseProfits = array();

        $productWiseProfits = DB::table('product_wise_profit')
            ->select('categories.categoryName as categoryName', 'product_wise_profit.productId as productId', 'products.name as productName', 'products.deal_code as productCode', 'products.discount as dpPrice', DB::raw('SUM(product_wise_profit.cashProductQty) + SUM(product_wise_profit.creditProductQty) AS qty'), DB::raw('SUM(product_wise_profit.cashPriceAmount) + SUM(product_wise_profit.creditPriceAmount) as price'), DB::raw('SUM(product_wise_profit.cashVatAmount) + SUM(product_wise_profit.creditVatAmount) as vat'), DB::raw('SUM(product_wise_profit.cashDiscountAmount) + SUM(product_wise_profit.creditDiscountAmount) as discount'))
            ->join('categories', 'categories.id', '=', 'product_wise_profit.categoryId')
            ->join('products', 'products.id', '=', 'product_wise_profit.productId')
            ->orWhere(function ($query) use ($fromDate, $toDate, $selectedProduct, $selectedCategory) {
                if (!empty($fromDate)) {
                    $query->whereBetween('product_wise_profit.date', array($fromDate, $toDate));
                }

                if (@$selectedProduct) {
                    $query->whereIn('product_wise_profit.productId', $selectedProduct);
                }

                if (@$selectedCategory) {
                    $query->whereIn('product_wise_profit.categoryId', $selectedCategory);
                }
            })
            ->groupBy('product_wise_profit.productId')
            ->orderBy('productName')
            ->get();

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.productWiseProfit.print', compact('title', 'productWiseProfits'))->setPaper('a4', 'landscape');

            return $pdf->stream('product_wise_profit.pdf');
        }

        return view('admin.productWiseProfit.index')->with(compact('title', 'categories', 'products', 'fromDate', 'toDate', 'selectedProduct', 'selectedCategory', 'productWiseProfits'));
    }

}
