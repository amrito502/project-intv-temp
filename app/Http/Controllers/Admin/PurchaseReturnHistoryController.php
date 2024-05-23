<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendors;
use App\Category;
use App\Product;
use App\PurchaseReturn;

use PDF;
use MPDF;

class PurchaseReturnHistoryController extends Controller
{
    public function index(Request $request)
    {
    	$title = $this->title;

    	$fromDate = Date('Y-m-d',strtotime($request->from_date));
    	$toDate = Date('Y-m-d',strtotime($request->to_date));

    	$supplier = $request->supplier;
    	$productCategory = $request->product_category;
    	$product = $request->product;

    	$purchaseReturns = array();

    	$vendors = Vendors::orderBy('vendorName','asc')->get();
    	$categories = Category::orderBy('categoryName','asc')->get();
    	$products = Product::orderBy('name','asc')->where('status', 1)->get();

    	// $data = $request->all();
    	// dd($data);

		$purchaseReturns = PurchaseReturn::select('purchase_returns.*','purchase_return_items.product_id','purchase_return_items.qty','purchase_return_items.rate','purchase_return_items.amount','categories.categoryName','products.name','vendors.vendorName as vendorName')
			->join('purchase_return_items','purchase_return_items.purchase_return_id','=','purchase_returns.id')
			->join('products','products.id','=','purchase_return_items.product_id')
			->join('categories','categories.id','=','products.category_id')
			->join('vendors','vendors.id','=','purchase_returns.supplier_id')
			->orWhere(function($cashQuery) use($fromDate,$toDate,$supplier,$productCategory,$product){
	    		if (!empty($fromDate))
	    		{
	    			$cashQuery->whereBetween('purchase_returns.purchase_return_date', array($fromDate,$toDate));
	    		}

	    		if (@$supplier)
	    		{
	    			$cashQuery->whereIn('vendors.id',$supplier);
	    		}

	    		if ($productCategory)
	    		{
	    			$cashQuery->whereIn('categories.id',$productCategory);
	    		}

	    		if ($product)
	    		{
	    			$cashQuery->whereIn('products.id',$product);
	    		}
			})->get();

    	return view('admin.purchaseReturnHistory.index')->with(compact('title','purchaseReturns','fromDate','toDate','vendors','categories','products','supplier','productCategory','product'));
    }

    public function print(Request $request)
    {
    	$title = "Print Purchase History";

    	$fromDate = Date('Y-m-d',strtotime($request->from_date));
    	$toDate = Date('Y-m-d',strtotime($request->to_date));

    	$supplier = $request->supplier;
    	$purchaseType = $request->purchase_type;
    	$productCategory = $request->product_category;
    	$product = $request->product;

    	$purchaseReturns = array();

    	// $data = $request->all();
    	// dd($productCategory);

		$purchaseReturns = PurchaseReturn::select('purchase_returns.*','purchase_return_items.product_id','purchase_return_items.qty','purchase_return_items.rate','purchase_return_items.amount','categories.categoryName','products.name','vendors.vendorName as vendorName')
			->join('purchase_return_items','purchase_return_items.purchase_return_id','=','purchase_returns.id')
			->join('products','products.id','=','purchase_return_items.product_id')
			->join('categories','categories.id','=','products.category_id')
			->join('vendors','vendors.id','=','purchase_returns.supplier_id')
			->orWhere(function($cashQuery) use($fromDate,$toDate,$supplier,$productCategory,$product){
	    		if (!empty($fromDate))
	    		{
	    			$cashQuery->whereBetween('purchase_returns.purchase_return_date', array($fromDate,$toDate));
	    		}

	    		if (@$supplier)
	    		{
	    			$cashQuery->whereIn('vendors.id',$supplier);
	    		}

	    		if ($productCategory)
	    		{
	    			$cashQuery->whereIn('categories.id',$productCategory);
	    		}

	    		if ($product)
	    		{
	    			$cashQuery->whereIn('products.id',$product);
	    		}
			})->get();

		$pdf = PDF::loadView('admin.purchaseReturnHistory.print',['title'=>$title,'fromDate'=>$fromDate,'toDate'=>$toDate,'purchaseReturns'=>$purchaseReturns]);

        return $pdf->stream('purchase_return_history_'.$fromDate.'_to_'.$toDate.'.pdf');
    }
}
