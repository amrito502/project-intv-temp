<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Product;

use App\Vendors;
use App\Category;
use App\CashPurchase;

use App\PurchaseOrder;
use App\CreditPurchase;

use Illuminate\Http\Request;
use App\PurchaseOrderReceive;
use App\Http\Controllers\Controller;
// use MPDF;

class PurchaseHistoryController extends Controller
{
	public function index(Request $request)
	{
		$title = $this->title;

		$fromDate = Date('Y-m-d', strtotime($request->from_date));
		$toDate = Date('Y-m-d', strtotime($request->to_date));

		$supplier = $request->supplier;
		$purchaseType = $request->purchase_type;
		$productCategory = $request->product_category;
		$product = $request->product;
		$cashPurchases = array();
		$creditPurchases = array();

		$vendors = Vendors::orderBy('vendorName', 'asc')->get();
		$categories = Category::orderBy('categoryName', 'asc')->get();
		$products = Product::orderBy('name', 'asc')->where('status', 1)->get();

		// $data = $request->all();
		// dd($productCategory);

		$cashPurchases = CashPurchase::select('cash_purchase.*', 'cash_purchase_item.product_id', 'cash_purchase_item.qty', 'cash_purchase_item.rate', 'cash_purchase_item.amount', 'categories.categoryName', 'products.name', 'products.deal_code', 'vendors.vendorName as vendorName')
			->join('cash_purchase_item', 'cash_purchase_item.cash_puchase_id', '=', 'cash_purchase.id')
			->join('products', 'products.id', '=', 'cash_purchase_item.product_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->join('vendors', 'vendors.id', '=', 'cash_purchase.supplier_id')
			->orWhere(function ($cashQuery) use ($fromDate, $toDate, $supplier, $purchaseType, $productCategory, $product) {
				if (!empty($fromDate)) {
					$cashQuery->whereBetween('cash_purchase.voucher_date', array($fromDate, $toDate));
				}

				if (@$supplier) {
					$cashQuery->whereIn('vendors.id', $supplier);
				}

				if ($purchaseType) {
					$cashQuery->whereIn('cash_purchase.type', $purchaseType);
				}

				if ($productCategory) {
					$cashQuery->whereIn('categories.id', $productCategory);
				}

				if ($product) {
					$cashQuery->whereIn('products.id', $product);
				}
			})->get();

		$creditPurchases = CreditPurchase::select('credit_purchases.*', 'credit_purchase_items.product_id', 'credit_purchase_items.qty', 'credit_purchase_items.rate', 'credit_purchase_items.amount', 'categories.categoryName', 'products.name', 'vendors.vendorName as vendorName')
			->join('credit_purchase_items', 'credit_purchase_items.credit_puchase_id', '=', 'credit_purchases.id')
			->join('products', 'products.id', '=', 'credit_purchase_items.product_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->join('vendors', 'vendors.id', '=', 'credit_purchases.supplier_id')
			->orWhere(function ($creditQuery) use ($fromDate, $toDate, $supplier, $purchaseType, $productCategory, $product) {
				if (!empty($fromDate)) {
					$creditQuery->whereBetween('credit_purchases.voucher_date', array($fromDate, $toDate));
				}

				if ($supplier) {
					$creditQuery->whereIn('vendors.id', $supplier);
				}

				if ($purchaseType) {
					$creditQuery->whereIn('credit_purchases.type', $purchaseType);
				}

				if ($productCategory) {
					$creditQuery->whereIn('categories.id', $productCategory);
				}

				if ($product) {
					$creditQuery->whereIn('products.id', $product);
				}
			})->get();


		$purchaseRecieve = PurchaseOrder::with(['poRecieve.items.product.category', 'supplier'])
			->orWhere(function ($POR) use ($fromDate, $toDate, $supplier, $productCategory, $product) {

				if (!empty($fromDate)) {
					$POR->whereBetween('order_date', array($fromDate, $toDate));
				}

				if ($supplier) {
					$POR->whereIn('supplier_id', $supplier);
				}

				if ($productCategory) {
					$POR->whereHas('poRecieve.items.product', function ($q) use ($productCategory) {
						$q->whereRaw('FIND_IN_SET(?,category_id)', [$productCategory]);
					});
				}

				if ($product) {
					$POR->whereHas('poRecieve.items.product', function ($q) use ($product) {
						$q->where('id', $product);
					});
				}
			})->get();

		if ($purchaseType) {
			if ($purchaseType[0] != "POR") {
				$purchaseRecieve = null;
			}
		}


		return view('admin.purchaseHistory.index')->with(compact('purchaseRecieve', 'title', 'vendors', 'categories', 'products', 'cashPurchases', 'creditPurchases', 'fromDate', 'toDate', 'supplier', 'purchaseType', 'productCategory', 'product'));
	}

	public function print(Request $request)
	{
		$title = "Print Purchase History";

		$fromDate = Date('Y-m-d', strtotime($request->from_date));
		$toDate = Date('Y-m-d', strtotime($request->to_date));

		$supplier = $request->supplier;
		$purchaseType = $request->purchase_type;
		$productCategory = $request->product_category;
		$product = $request->product;

		$cashPurchases = array();
		$creditPurchases = array();

		$cashPurchases = CashPurchase::select('cash_purchase.*', 'cash_purchase_item.product_id', 'cash_purchase_item.qty', 'cash_purchase_item.rate', 'cash_purchase_item.amount', 'categories.categoryName', 'products.name', 'products.deal_code', 'vendors.vendorName as vendorName', 'vendors.vendor_serial as vendorCode')
			->join('cash_purchase_item', 'cash_purchase_item.cash_puchase_id', '=', 'cash_purchase.id')
			->join('products', 'products.id', '=', 'cash_purchase_item.product_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->join('vendors', 'vendors.id', '=', 'cash_purchase.supplier_id')
			->orWhere(function ($cashQuery) use ($fromDate, $toDate, $supplier, $purchaseType, $productCategory, $product) {
				if (!empty($fromDate)) {
					$cashQuery->whereBetween('cash_purchase.voucher_date', array($fromDate, $toDate));
				}

				if (@$supplier) {
					$cashQuery->whereIn('vendors.id', $supplier);
				}

				if ($purchaseType) {
					$cashQuery->whereIn('cash_purchase.type', $purchaseType);
				}

				if ($productCategory) {
					$cashQuery->whereIn('categories.id', $productCategory);
				}

				if ($product) {
					$cashQuery->whereIn('products.id', $product);
				}
			})->get();


		$creditPurchases = CreditPurchase::select('credit_purchases.*', 'credit_purchase_items.product_id', 'credit_purchase_items.qty', 'credit_purchase_items.rate', 'credit_purchase_items.amount', 'categories.categoryName', 'products.name', 'vendors.vendorName as vendorName')
			->join('credit_purchase_items', 'credit_purchase_items.credit_puchase_id', '=', 'credit_purchases.id')
			->join('products', 'products.id', '=', 'credit_purchase_items.product_id')
			->join('categories', 'categories.id', '=', 'products.category_id')
			->join('vendors', 'vendors.id', '=', 'credit_purchases.supplier_id')
			->orWhere(function ($creditQuery) use ($fromDate, $toDate, $supplier, $purchaseType, $productCategory, $product) {
				if (!empty($fromDate)) {
					$creditQuery->whereBetween('credit_purchases.voucher_date', array($fromDate, $toDate));
				}

				if ($supplier) {
					$creditQuery->whereIn('vendors.id', $supplier);
				}

				if ($purchaseType) {
					$creditQuery->whereIn('credit_purchases.type', $purchaseType);
				}

				if ($productCategory) {
					$creditQuery->whereIn('categories.id', $productCategory);
				}

				if ($product) {
					$creditQuery->whereIn('products.id', $product);
				}
			})->get();



		$purchaseRecieve = PurchaseOrder::with(['poRecieve.items.product.category', 'supplier'])
			->orWhere(function ($POR) use ($fromDate, $toDate, $supplier, $productCategory, $product) {

				if (!empty($fromDate)) {
					$POR->whereBetween('order_date', array($fromDate, $toDate));
				}

				if ($supplier) {
					$POR->whereIn('supplier_id', $supplier);
				}

				if ($productCategory) {
					$POR->whereHas('poRecieve.items.product', function ($q) use ($productCategory) {
						$q->whereRaw('FIND_IN_SET(?,category_id)', [$productCategory]);
					});
				}

				if ($product) {
					$POR->whereHas('poRecieve.items.product', function ($q) use ($product) {
						$q->where('id', $product);
					});
				}
			})->get();

		if ($purchaseType) {
			if ($purchaseType[0] != "POR") {
				$purchaseRecieve = null;
			}
		}


		$pdf = PDF::loadView('admin.purchaseHistory.print', ['purchaseRecieve' => $purchaseRecieve,'title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'cashPurchases' => $cashPurchases, 'creditPurchases' => $creditPurchases]);

		return $pdf->stream('purchase_history.pdf');
		// return $pdf->download('invoice.pdf');

	}
}
