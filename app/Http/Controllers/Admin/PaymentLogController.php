<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendors;
use App\Product;
use App\SupplierPayment;

use DB;
use PDF;
use MPDF;

class PaymentLogController extends Controller
{
    public function index(Request $request)
    {
    	$title = $this->title;

        $fromDate = Date('Y-m-d',strtotime($request->from_date));
        $toDate = Date('Y-m-d',strtotime($request->to_date));

        $supplier = $request->supplier;

        $vendors = Vendors::orderBy('vendorName','asc')->get();

        $paymentLogs = DB::table('supplier_payments')
        	->select('supplier_payments.payment_date as date',DB::raw('sum(supplier_payments.payment_now) as payment'),'vendors.vendorName as vendorName')
        	->join('vendors','vendors.id','=','supplier_payments.supplier_id')
        	->orWhere(function($query) use($fromDate,$toDate,$supplier){
        		if (!empty($fromDate))
        		{
        			$query->whereBetween('supplier_payments.payment_date',array($fromDate,$toDate));
        		}

        		if (@$supplier)
        		{
        			$query->whereIn('vendors.id',$supplier);
        		}
        	})
        	->groupBy('supplier_payments.payment_date','vendors.vendorName')
        	->get();

    	return view('admin.paymentLog.index')->with(compact('title','vendors','paymentLogs','supplier','fromDate','toDate'));
    }

    public function print(Request $request)
    {
    	$title = "Print Payment Log History";

        $fromDate = Date('Y-m-d',strtotime($request->from_date));
        $toDate = Date('Y-m-d',strtotime($request->to_date));

        $supplier = $request->supplier;

        $paymentLogs = DB::table('supplier_payments')
        	->select('supplier_payments.payment_date as date',DB::raw('sum(supplier_payments.payment_now) as payment'),'vendors.vendorName as vendorName')
        	->join('vendors','vendors.id','=','supplier_payments.supplier_id')
        	->orWhere(function($query) use($fromDate,$toDate,$supplier){
        		if (!empty($fromDate))
        		{
        			$query->whereBetween('supplier_payments.payment_date',array($fromDate,$toDate));
        		}

        		if (@$supplier)
        		{
        			$query->whereIn('vendors.id',$supplier);
        		}
        	})
        	->groupBy('supplier_payments.payment_date','vendors.vendorName')
        	->get();

        $pdf = PDF::loadView('admin.paymentLog.print',['title'=>$title,'fromDate'=>$fromDate,'toDate'=>$toDate,'paymentLogs'=>$paymentLogs]);

        return $pdf->stream('payment_log_history_'.$fromDate.'_to_'.$toDate.'.pdf');
    }
}
