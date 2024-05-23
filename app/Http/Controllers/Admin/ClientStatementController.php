<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Customer;

use DB;
use PDF;
use MPDF;

class ClientStatementController extends Controller
{
	public function index(Request $request)
	{
        $title = $this->title;

        $fromDate = Date('Y-m-d',strtotime($request->from_date));
        $toDate = Date('Y-m-d',strtotime($request->to_date));

        $customer = $request->customer;

        $customers = Customer::orderBy('name','asc')->get();

        $lastDate = Date('Y-m-d',strtotime("-1 day", strtotime($fromDate)));

        // $data = $request->all();
        // dd($data)

        if (empty($fromDate) || empty($toDate))
        {
        	$previousBalances = array();
        	$clientStatements = array();
        }
        else
        {
	        $previousBalances = DB::table('client_statement_report')
	            ->select(DB::raw('SUM(client_statement_report.sales) as sales'), DB::raw('SUM(client_statement_report.collection) as collection'), DB::raw('SUM(client_statement_report.others) as others'))
	            ->orWhere(function($cashQuery) use($lastDate,$customer){
	                if (!empty($lastDate))
	                {
	                    $cashQuery->where('client_statement_report.date','<=', $lastDate);
	                }

	                if (@$customer)
	                {
	                    $cashQuery->whereIn('client_statement_report.customerId',$customer);
	                }
	            })
	            ->first();

	        $clientStatements = DB::table('client_statement_report')
	            ->select('client_statement_report.date as date', DB::raw('SUM(client_statement_report.sales) as sales'), DB::raw('SUM(client_statement_report.collection) as collection'), DB::raw('SUM(client_statement_report.others) as others'),'customers.name as customerName')
	            ->join('customers','customers.id','=','client_statement_report.customerId')
	            ->orWhere(function($cashQuery) use($fromDate,$toDate,$customer){
	                if (!empty($fromDate))
	                {
	                    $cashQuery->whereBetween('client_statement_report.date', array($fromDate,$toDate));
	                }

	                if (@$customer)
	                {
	                    $cashQuery->whereIn('customers.id',$customer);
	                }
	            })
	            ->groupBy('client_statement_report.date','customers.name')
	            ->get();
        }

        return view('admin.clientStatement.index')->with(compact('title','previousBalances','clientStatements','fromDate','toDate','customers','customer'));
	}

	public function print(Request $request)
	{
        $title = "Client Statement";

        $fromDate = Date('Y-m-d',strtotime($request->from_date));
        $toDate = Date('Y-m-d',strtotime($request->to_date));

        $customer = $request->customer;

        $lastDate = Date('Y-m-d',strtotime("-1 day", strtotime($fromDate)));

        // $data = $request->all();
        // dd($data)

        if (empty($fromDate) || empty($toDate))
        {
        	$previousBalances = array();
        	$clientStatements = array();
        }
        else
        {
	        $previousBalances = DB::table('client_statement_report')
	            ->select(DB::raw('SUM(client_statement_report.sales) as sales'), DB::raw('SUM(client_statement_report.collection) as collection'), DB::raw('SUM(client_statement_report.others) as others'))
	            ->orWhere(function($cashQuery) use($lastDate,$customer){
	                if (!empty($lastDate))
	                {
	                    $cashQuery->where('client_statement_report.date','<=', $lastDate);
	                }

	                if (@$customer)
	                {
	                    $cashQuery->whereIn('client_statement_report.customerId',$customer);
	                }
	            })
	            ->first();

	        $clientStatements = DB::table('client_statement_report')
	            ->select('client_statement_report.date as date', DB::raw('SUM(client_statement_report.sales) as sales'), DB::raw('SUM(client_statement_report.collection) as collection'), DB::raw('SUM(client_statement_report.others) as others'),'customers.name as customerName')
	            ->join('customers','customers.id','=','client_statement_report.customerId')
	            ->orWhere(function($cashQuery) use($fromDate,$toDate,$customer){
	                if (!empty($fromDate))
	                {
	                    $cashQuery->whereBetween('client_statement_report.date', array($fromDate,$toDate));
	                }

	                if (@$customer)
	                {
	                    $cashQuery->whereIn('customers.id',$customer);
	                }
	            })
	            ->groupBy('client_statement_report.date','customers.name')
	            ->get();
        }

        $pdf = PDF::loadView('admin.clientStatement.print',['title'=>$title,'fromDate'=>$fromDate,'toDate'=>$toDate,'previousBalances'=>$previousBalances,'clientStatements'=>$clientStatements]);

        return $pdf->stream('client_statement_history_'.$fromDate.'_to_'.$toDate.'.pdf');
	}
}
