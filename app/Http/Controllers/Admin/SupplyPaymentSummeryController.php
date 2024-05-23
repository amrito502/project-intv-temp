<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendors;
use App\CashPurchase;
use App\CreditPurchase;
use App\PurchaseReturn;
use App\SupplierPayment;
use Carbon\Carbon;
use DB;
use PDF;
use MPDF;

class SupplyPaymentSummeryController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $year = $request->year;
        $month = $request->month;

        $supplier = $request->supplier;

        $vendors = Vendors::orderBy('vendorName','asc')->get();

        if ($year == "" || $month == "")
        {
            $supplierStatements = array();
        }
        else
        {
            $previousSupplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('0 as yearlyPurchase'), DB::raw('0 as monthlyPurchase'), DB::raw('0 as yearlyPayment'), DB::raw('0 as monthlyPayment'), DB::raw('SUM(supply_payment_summery.purchase) as previousPurchase'), DB::raw('SUM(supply_payment_summery.payment) as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date','<',$year);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName');

            $monthlySupplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('0 as yearlyPurchase'), DB::raw('SUM(supply_payment_summery.purchase) as monthlyPurchase'), DB::raw('0 as yearlyPayment'), DB::raw('SUM(supply_payment_summery.payment) as monthlyPayment'), DB::raw('0 as previousPurchase'), DB::raw('0 as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$month,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date', $year);
                    }

                    if (@$month)
                    {
                        $query->whereMonth('supply_payment_summery.date', $month);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName');

            $supplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('SUM(supply_payment_summery.purchase) as yearlyPurchase'), DB::raw('0 as monthlyPurchase'), DB::raw('SUM(supply_payment_summery.payment) as yearlyPayment'), DB::raw('0 as monthlyPayment'), DB::raw('0 as previousPurchase'), DB::raw('0 as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date', $year);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName')
                ->unionAll($monthlySupplierStatements)
                ->unionAll($previousSupplierStatements)
                ->orderBy('vendorId')
                ->get();
        }

        return view('admin.supplyPaymentSummery.index')->with(compact('title','supplierStatements','year','month','vendors','supplier'));
    }

    public function print(Request $request)
    {

        $year = $request->year;
        $month = $request->month;

        $searchedDate = Carbon::parse($year, $month);

        $title = "Supplier & Payment Summary ". $searchedDate->format('F') ." - " . $year;

        $supplier = $request->supplier;

        // $data = $request->all();
        // dd($data)

        if ($year == "" || $month == "")
        {
            $supplierStatements = array();
        }
        else
        {
            $previousSupplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('0 as yearlyPurchase'), DB::raw('0 as monthlyPurchase'), DB::raw('0 as yearlyPayment'), DB::raw('0 as monthlyPayment'), DB::raw('SUM(supply_payment_summery.purchase) as previousPurchase'), DB::raw('SUM(supply_payment_summery.payment) as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date','<',$year);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName');

            $monthlySupplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('0 as yearlyPurchase'), DB::raw('SUM(supply_payment_summery.purchase) as monthlyPurchase'), DB::raw('0 as yearlyPayment'), DB::raw('SUM(supply_payment_summery.payment) as monthlyPayment'), DB::raw('0 as previousPurchase'), DB::raw('0 as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$month,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date', $year);
                    }

                    if (@$month)
                    {
                        $query->whereMonth('supply_payment_summery.date', $month);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName');

            $supplierStatements = DB::table('supply_payment_summery')
                ->select(DB::raw('SUM(supply_payment_summery.purchase) as yearlyPurchase'), DB::raw('0 as monthlyPurchase'), DB::raw('SUM(supply_payment_summery.payment) as yearlyPayment'), DB::raw('0 as monthlyPayment'), DB::raw('0 as previousPurchase'), DB::raw('0 as previousPayment'), 'vendors.id as vendorId', 'vendors.vendorName as vendorName')
                ->join('vendors','vendors.id','=','supply_payment_summery.supplierId')
                ->orWhere(function($query) use($year,$supplier){
                    if (@$year)
                    {
                        $query->whereYear('supply_payment_summery.date', $year);
                    }

                    if (@$supplier)
                    {
                        $query->whereIn('vendors.id',$supplier);
                    }
                })
                ->groupBy('vendors.id','vendors.vendorName')
                ->unionAll($monthlySupplierStatements)
                ->unionAll($previousSupplierStatements)
                ->orderBy('vendorId')
                ->get();
        }

        $pdf = PDF::loadView('admin.supplyPaymentSummery.print',['title'=>$title,'year'=>$year,'month'=>$month,'supplierStatements'=>$supplierStatements]);

        return $pdf->stream('supply_and_payment_summery_'.$month.'_of_'.$year.'.pdf');
    }
}
