<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CoaSetup;

use Auth;
use DB;
use PDF;

class BalanceSheetController extends Controller
{
	public function index(Request $request)
	{
		$title = "Balance Sheet";
		$searchFormLink = "balanceSheet.index";
		$printFormLink = "balanceSheet.print";
        $print = $request->print;

        $fromDate = date('Y-m-d',strtotime($request->fromDate));
        $toDate = date('Y-m-d',strtotime($request->toDate));

        $assetsLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','A')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

        $libilityLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','L')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

		return view('admin.balanceSheet.index')->with(compact('assetsLists','libilityLists','title','searchFormLink','printFormLink','print','fromDate','toDate'));
	}
}
