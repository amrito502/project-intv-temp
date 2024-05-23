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

class OutOfStockReportController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $category = [];
        $product = $request->product;

        $categories = Category::orderBy('categoryName', 'asc')->get();

        $products = Product::with(['category'])->where('status', 1);

        if ($request->category) {
            $category = $request->category;
            foreach ($category as $c) {
                $products = $products->orWhereRaw("find_in_set($c, category_id)");
            }
        }

        if ($product) {
            $products = $products->whereIn('id', $product);
        }

        $products = $products->get();


        $stockOutReports = [];

        foreach ($products as $product) {
            $stock = new StockStatus($product->id);
            $stockAmount = $stock->stock();

            if ($stockAmount <= 0) {
                array_push($stockOutReports, $product);
            }
        }

        if($request->submitType == "print"){

            $pdf = PDF::loadView('admin.outOfStockReport.out_of_stock_print', compact('title', 'stockOutReports'))->setPaper('a4', 'landscape');

            return $pdf->stream('out_of_stock_report.pdf');

        }

        return view('admin.outOfStockReport.index')->with(compact('title', 'categories', 'category', 'products', 'product', 'stockOutReports'));
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

}
