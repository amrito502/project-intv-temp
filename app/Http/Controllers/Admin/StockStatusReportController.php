<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;
use App\Product;
use App\Vendors;

use App\Category;
use App\Helper\StockStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockStatusReportController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $beforeFromDate = Date('Y-m-d', strtotime($request->from_date . '-1 day'));


        $supplier = $request->supplier;
        $category = $request->category;
        $product = $request->product;

        $products = Product::where('status', 1);

        if ($category) {
            $products = $products->whereIn('root_category', $category);
        }

        if ($product) {
            $products = $products->whereIn('id', $product);
        }

        $products = $products->get();

        $vendors = Vendors::orderBy('vendorName', 'asc')->get();
        $categories = Category::orderBy('categoryName', 'asc')->get();

        $stockInfos = [];

        foreach ($products as $p) {

            $productCategory = Category::findOrFail($p->root_category);

            // before date data
            $previousStock = new StockStatus($p->id);
            $previousPurchaseByDate = $previousStock->totalPurchaseByDate("0000-00-00", $beforeFromDate);
            $previousPurchaseReturnByDate = $previousStock->totalPurchaseReturnByDate("0000-00-00", $beforeFromDate);
            $previousSaleByDate = $previousStock->totalSalesByDate("0000-00-00", $beforeFromDate);
            $previousDealerReturnByDate = $previousStock->totalSalesReturnByDate("0000-00-00", $beforeFromDate);

            $opening = ($previousPurchaseByDate['total_purchase_in_date_range'] - $previousPurchaseReturnByDate['total_purchase_return_in_date_range']) - ($previousSaleByDate['total_sale_in_date_range'] - $previousDealerReturnByDate['total_return_in_date_range']);

            // date range data
            $stock = new StockStatus($p->id);
            $purchaseByDate = $stock->totalPurchaseByDate($fromDate, $toDate);
            $purchaseReturnByDate = $stock->totalPurchaseReturnByDate($fromDate, $toDate);
            $saleByDate = $stock->totalSalesByDate($fromDate, $toDate);
            $dealerReturnByDate = $stock->totalSalesReturnByDate($fromDate, $toDate);

            $lineInfo = [
                'product' => $p,
                'productCategory' => $productCategory,
                'total_purchase' => $purchaseByDate['total_purchase_in_date_range'],
                'total_purchase_return' => $purchaseReturnByDate['total_purchase_return_in_date_range'],
                'total_sales' => $saleByDate['total_sale_in_date_range'],
                'total_sales_return' => $dealerReturnByDate['total_return_in_date_range'],
                'opening' => $opening,
                'purchase_point' => $p->pp,
            ];

            if ($lineInfo['total_purchase'] > 0 || $lineInfo['total_sales'] > 0 || $lineInfo['opening'] > 0) {
                array_push($stockInfos, $lineInfo);
            }
        }

        return view('admin.stockStatusReport.index')->with(compact('title', 'fromDate', 'toDate', 'vendors', 'supplier', 'categories', 'category', 'products', 'product', 'stockInfos'));
    }

    public function print(Request $request)
    {
        $title = "Print Stock Status Report";

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $beforeFromDate = Date('Y-m-d', strtotime($request->from_date . '-1 day'));


        $supplier = $request->supplier;
        $category = $request->category;
        $product = $request->product;

        $products = Product::where('status', 1);

        if ($category) {
            $products = $products->whereIn('root_category', $category);
        }

        if ($product) {
            $products = $products->whereIn('id', $product);
        }

        $products = $products->get();

        $stockInfos = [];

        foreach ($products as $p) {

            $productCategory = Category::findOrFail($p->root_category);

           // before date data
           $previousStock = new StockStatus($p->id);
           $previousPurchaseByDate = $previousStock->totalPurchaseByDate("0000-00-00", $beforeFromDate);
           $previousPurchaseReturnByDate = $previousStock->totalPurchaseReturnByDate("0000-00-00", $beforeFromDate);
           $previousSaleByDate = $previousStock->totalSalesByDate("0000-00-00", $beforeFromDate);
           $previousDealerReturnByDate = $previousStock->totalSalesReturnByDate("0000-00-00", $beforeFromDate);

           $opening = ($previousPurchaseByDate['total_purchase_in_date_range'] - $previousPurchaseReturnByDate['total_purchase_return_in_date_range']) - ($previousSaleByDate['total_sale_in_date_range'] - $previousDealerReturnByDate['total_return_in_date_range']);

           // date range data
           $stock = new StockStatus($p->id);
           $purchaseByDate = $stock->totalPurchaseByDate($fromDate, $toDate);
           $purchaseReturnByDate = $stock->totalPurchaseReturnByDate($fromDate, $toDate);
           $saleByDate = $stock->totalSalesByDate($fromDate, $toDate);
           $dealerReturnByDate = $stock->totalSalesReturnByDate($fromDate, $toDate);

           $lineInfo = [
               'product' => $p,
               'productCategory' => $productCategory,
               'total_purchase' => $purchaseByDate['total_purchase_in_date_range'],
               'total_purchase_return' => $purchaseReturnByDate['total_purchase_return_in_date_range'],
               'total_sales' => $saleByDate['total_sale_in_date_range'],
               'total_sales_return' => $dealerReturnByDate['total_return_in_date_range'],
               'opening' => $opening,
               'purchase_point' => $p->pp,
           ];

           if ($lineInfo['total_purchase'] > 0 || $lineInfo['total_sales'] > 0 || $lineInfo['opening'] > 0) {
               array_push($stockInfos, $lineInfo);
           }
        }

        $pdf = PDF::loadView('admin.stockStatusReport.print', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'stockInfos' => $stockInfos])->setPaper('a4', 'landscape');;

        return $pdf->stream('supplier_statement_history_' . $fromDate . '_to_' . $toDate . '.pdf');
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
