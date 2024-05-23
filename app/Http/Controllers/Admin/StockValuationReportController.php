<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendors;
use App\Category;
use App\Helper\StockStatus;
use App\Product;

use DB;
use PDF;
use MPDF;

class StockValuationReportController extends Controller
{
    public function index(Request $request)
    {

        $title = $this->title;

        $category = $request->category;
        $product = $request->product;

        $categories = Category::orderBy('categoryName', 'asc')->get();

        $products = DB::table('products')
            ->Where(function ($query) use ($category, $product) {
                if (@$category) {
                    foreach ($category as $categoryInfo) {
                        $query->orWhereRaw('find_in_set(?,category_id)', [$categoryInfo]);
                    }
                }

                if (@$product) {
                    foreach ($product as $productInfo) {
                        $query->orWhereIn('id', [$productInfo]);
                    }
                }
            })
            ->orderBy('name', 'asc')
            ->get();


        $stockValuationReports = array();

        foreach ($products as $productInfos) {

            $productCategory = Category::find($productInfos->root_category);



            $stock_status = new StockStatus($productInfos->id);
            $stock_qty = $stock_status->stock();

            if ($stock_qty == 0) {
                continue;
            }
            $avg_purchase = $stock_status->avgPurchasePrice();

            $data = [
                'product_category' => $productCategory->categoryName,
                'product_code' => $productInfos->deal_code,
                'product_name' => $productInfos->name,
                'sale_price_mrp' => $productInfos->price,
                'sale_price_dp' => $productInfos->discount,
                'purchase_avg' => $avg_purchase,
                'stock_qty' => $stock_qty,
                'mrp_value' => $productInfos->price * $stock_qty,
                'dp_value' => $productInfos->discount * $stock_qty,
                'purchase_value' => $avg_purchase * $stock_qty,
            ];

            array_push($stockValuationReports, $data);
        }

        return view('admin.stockValuationReport.index')->with(compact('title', 'categories', 'category', 'product', 'category', 'products', 'product', 'stockValuationReports'));
    }

    public function getAllProductByCategory(Request $request)
    {
        $output = '';
        $results = '';
        $ids = $request->id;

        $products = DB::table('products')
            ->Where(function ($query) use ($ids) {
                if (@$ids) {
                    foreach ($ids as $id) {
                        $query->orWhereRaw('find_in_set(?,category_id)', [$id]);
                    }
                }
            })
            ->orderBy('name', 'asc')
            ->get();

        if ($products) {
            $output .= '<select class="form-control chosen-select" id="product" name="product[]" multiple>';
            $output .= '<option value="">Select Product</option>';
            foreach ($products as $product) {
                $output .= '<option value="' . $product->id . '">' . $product->name . '</option>';
            }
            $output .= '</select>';
        } else {
            $output .= '<select class="form-control chosen-select" id="product" name="product[]" multiple>';
            $output .= '</select>';
        }

        echo $output;
    }

    public function print(Request $request)
    {
        $title = "Print Stock Valuation Report";

        $category = $request->category;
        $product = $request->product;

        $stockValuationReports = array();

        $products = DB::table('products')
            ->Where(function ($query) use ($category, $product) {
                if (@$category) {
                    foreach ($category as $categoryInfo) {
                        $query->orWhereRaw('find_in_set(?,category_id)', [$categoryInfo]);
                    }
                }

                if (@$product) {
                    foreach ($product as $productInfo) {
                        $query->orWhereIn('id', [$productInfo]);
                    }
                }
            })
            ->orderBy('name', 'asc')
            ->get();


        $stockValuationReports = array();

        foreach ($products as $productInfos) {

            $productCategory = Category::find($productInfos->root_category);



            $stock_status = new StockStatus($productInfos->id);
            $stock_qty = $stock_status->stock();

            if ($stock_qty == 0) {
                continue;
            }
            $avg_purchase = $stock_status->avgPurchasePrice();

            $data = [
                'product_category' => $productCategory->categoryName,
                'product_code' => $productInfos->deal_code,
                'product_name' => $productInfos->name,
                'sale_price_mrp' => $productInfos->price,
                'sale_price_dp' => $productInfos->discount,
                'purchase_avg' => $avg_purchase,
                'stock_qty' => $stock_qty,
                'mrp_value' => $productInfos->price * $stock_qty,
                'dp_value' => $productInfos->discount * $stock_qty,
                'purchase_value' => $avg_purchase * $stock_qty,
            ];

            array_push($stockValuationReports, $data);
        }

        $pdf = PDF::loadView('admin.stockValuationReport.print', ['title' => $title, 'stockValuationReports' => $stockValuationReports])->setPaper('a4', 'landscape');

        return $pdf->stream('stock_valuation_history.pdf');
    }
}
