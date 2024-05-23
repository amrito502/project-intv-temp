<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\CoaSetup;

use Auth;
use DB;
use PDF;

class TrialBalanceController extends Controller
{
	public function index(Request $request)
	{
		$title = "Trial Balance";
		$searchFormLink = "trialBalance.index";
		$printFormLink = "trialBalance.print";
        $print = $request->print;

        $date = date('Y-m-d',strtotime($request->date));

        $coaLists = CoaSetup::where('general_ledger',1)->get();

		return view('admin.trialBalance.index')->with(compact('title','searchFormLink','printFormLink','print','date','coaLists'));
	}

	public function print(Request $request)
	{
		$title = "Print Trial Balance";
        $print = $request->print;

        $date = date('Y-m-d',strtotime($request->date));

        $coaLists = CoaSetup::where('general_ledger',1)->get();

        $pdf = PDF::loadView('admin.trialBalance.print',['title'=>$title,'date'=>$date,'print'=>$print,'coaLists'=>$coaLists],[]);
        return $pdf->stream('trial_balance_'.$date.'.pdf');
	}
}
