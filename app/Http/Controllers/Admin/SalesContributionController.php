<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\DealerReports\DealerContribution;

class SalesContributionController extends Controller
{

    public function index(Request $request)
    {
    	$title = $this->title;

    	$reports = [];
        $dealers = User::whereIn('role', [4, 6])->get();


        if($request->searched){

            $params = [
                'option' => $request->option,
                'dealerId' => $request->dealer,
            ];

            $dealerContribution = new DealerContribution($params);
            $reports = $dealerContribution->getReport();

        }

        $data = (object) [
            'title' => $title,
            'dealers' => $dealers,
            'reports' => $reports,
        ];

        return view('admin.salesContribution.index')->with(compact('title', 'data'));
    }

    public function print(Request $request)
    {
    	$title = "Print Sales Contribution";

    	$params = [
            'option' => $request->option,
            'dealerId' => $request->dealer,
        ];

        $dealerContribution = new DealerContribution($params);
        $reports = $dealerContribution->getReport();

        $pdf = PDF::loadView('admin.salesContribution.print',['title'=>$title, 'reports'=>$reports, 'params'=>$params]);

        return $pdf->stream('sales_contributes_by_'.$params['option'].'.pdf');
    }
}
