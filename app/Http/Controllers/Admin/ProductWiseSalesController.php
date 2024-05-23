<?php

namespace App\Http\Controllers\Admin;

use PDF;
use MPDF;

use App\Order;
use App\Product;
use App\Vendors;
use App\CashSale;
use App\Category;
use App\Checkout;
use App\CreditSale;
use App\ClientEntry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductWiseSalesController extends Controller
{
	public function index(Request $request)
	{
		$title = $this->title;

		$fromDate = Date('Y-m-d', strtotime($request->from_date));
		$toDate = Date('Y-m-d', strtotime($request->to_date));
		$product = $request->product;
		$cashSales = array();
		$creditSales = array();

		$products = Product::orderBy('name', 'asc')->where('status', 1)->get();
		// echo "<pre>";
		// print_r($products);
		// echo "</pre>";
		// exit();

		$cashSales = CashSale::select('cash_sales.*', 'cash_sale_items.item_id', 'cash_sale_items.item_quantity', 'cash_sale_items.item_rate', 'cash_sale_items.item_price', 'categories.categoryName', 'products.name')
			->join('cash_sale_items', 'cash_sale_items.cash_sale_id', '=', 'cash_sales.id')
			->join('products', 'products.id', '=', 'cash_sale_items.item_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->orWhere(function ($cashQuery) use ($fromDate, $toDate, $product) {
				if (!empty($fromDate)) {
					$cashQuery->whereBetween('cash_sales.invoice_date', array($fromDate, $toDate));
				}

				if ($product) {
					$cashQuery->where('products.id', $product);
				}
			})
			->orderBy('cash_sale_items.item_id')
			->get();

		$creditSales = CreditSale::select('credit_sales.*', 'credit_sale_items.item_id', 'credit_sale_items.item_quantity', 'credit_sale_items.item_rate', 'credit_sale_items.item_price', 'categories.categoryName', 'products.name')
			->join('credit_sale_items', 'credit_sale_items.credit_sale_id', '=', 'credit_sales.id')
			->join('products', 'products.id', '=', 'credit_sale_items.item_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->orWhere(function ($creditQuery) use ($fromDate, $toDate, $product) {
				if (!empty($fromDate)) {
					$creditQuery->whereBetween('credit_sales.invoice_date', array($fromDate, $toDate));
				}

				if ($product) {
					$creditQuery->where('products.id', $product);
				}
			})
			->orderBy('credit_sale_items.item_id')
			->get();


		$onlineSales = Order::whereBetween('created_at', [$fromDate, $toDate])
			->with(['product']);


		if ($product) {
			$onlineSales->where('product_id', $product);
		}

		$onlineSales = $onlineSales->get();
		$onlineSales = $onlineSales->groupBy('product_id');

		// dd();

		return view('admin.productWiseSales.index')->with(compact('title', 'fromDate', 'toDate', 'product', 'products', 'cashSales', 'creditSales', 'onlineSales'));
	}

	public function print(Request $request)
	{
		$title = "Print Sales History";
		$fromDate = Date('Y-m-d', strtotime($request->from_date));
		$toDate = Date('Y-m-d', strtotime($request->to_date));
		$product = $request->product;
		$cashSales = array();
		$creditSales = array();

		// $data = $request->all();
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// exit();


		$cashSales = CashSale::select('cash_sales.*', 'cash_sale_items.item_id', 'cash_sale_items.item_quantity', 'cash_sale_items.item_rate', 'cash_sale_items.item_price', 'products.name')
			->join('cash_sale_items', 'cash_sale_items.cash_sale_id', '=', 'cash_sales.id')
			->join('products', 'products.id', '=', 'cash_sale_items.item_id')
			->orWhere(function ($cashQuery) use ($fromDate, $toDate, $product) {
				if (!empty($fromDate)) {
					$cashQuery->whereBetween('cash_sales.invoice_date', array($fromDate, $toDate));
				}

				if ($product) {
					$cashQuery->where('products.id', $product);
				}
			})
			->orderBy('cash_sale_items.item_id')
			->get();

		$creditSales = CreditSale::select('credit_sales.*', 'credit_sale_items.item_id', 'credit_sale_items.item_quantity', 'credit_sale_items.item_rate', 'credit_sale_items.item_price', 'products.name', 'client_entries.name as clientName')
			->join('credit_sale_items', 'credit_sale_items.credit_sale_id', '=', 'credit_sales.id')
			->join('products', 'products.id', '=', 'credit_sale_items.item_id')
			->join('client_entries', 'client_entries.id', '=', 'credit_sales.customer_id')
			->orWhere(function ($creditQuery) use ($fromDate, $toDate, $product) {
				if (!empty($fromDate)) {
					$creditQuery->whereBetween('credit_sales.invoice_date', array($fromDate, $toDate));
				}

				if ($product) {
					$creditQuery->where('products.id', $product);
				}
			})
			->orderBy('credit_sale_items.item_id')
			->get();

		$pdf = PDF::loadView('admin.productWiseSales.print', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'cashSales' => $cashSales, 'creditSales' => $creditSales]);

		return $pdf->stream('product_wise_sales_history_' . $fromDate . '_to_' . $toDate . '.pdf');
	}
}
