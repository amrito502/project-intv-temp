<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CoaSetup;

use Auth;
use DB;
use PDF;

class IncomeStatementController extends Controller
{
	public function index(Request $request)
	{
		$title = "Income Statement";
		$searchFormLink = "incomeStatement.index";
		$printFormLink = "incomeStatement.print";
        $print = $request->print;

        $fromDate = date('Y-m-d',strtotime($request->fromDate));
        $toDate = date('Y-m-d',strtotime($request->toDate));

        $incomeLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','I')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

        $expenseLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','E')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

		return view('admin.incomeStatement.index')->with(compact('title','searchFormLink','printFormLink','print','fromDate','toDate','incomeLists','expenseLists'));
	}

	public function print(Request $request)
	{
		$title = "Print Income Statement";
        $print = $request->print;

        $fromDate = date('Y-m-d',strtotime($request->fromDate));
        $toDate = date('Y-m-d',strtotime($request->toDate));

        $incomeLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','I')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

        $expenseLists = DB::table('tbl_account_transactions')
        	->select('tbl_account_transactions.coa_head_code as headCode','tbl_coa.head_name as headName',DB::raw('(SUM(tbl_account_transactions.debit_amount) - SUM(tbl_account_transactions.credit_amount)) as amount'))
        	->leftJoin('tbl_coa','tbl_coa.head_code','=','tbl_account_transactions.coa_head_code')
            // ->where('showroom_id',$this->showroomId)
        	->where('tbl_account_transactions.approve',1)
        	->whereBetween('tbl_account_transactions.voucher_date',array($fromDate,$toDate))
        	->where('tbl_coa.head_type','E')
        	->groupBy('tbl_account_transactions.coa_head_code','tbl_coa.head_code')
        	->get();

        $pdf = PDF::loadView('admin.incomeStatement.print',['title'=>$title,'fromDate'=>$fromDate,'toDate'=>$toDate,'print'=>$print,'incomeLists'=>$incomeLists,'expenseLists'=>$expenseLists],[]);
        return $pdf->stream('income_statement_'.$fromDate.'_'.$toDate.'.pdf');
	}
}
