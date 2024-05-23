<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;
use App\User;
use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\DealerReports\DealerOutStanding;

class SalesCollectionOutstandingController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $year = $request->year;
        $month = $request->month;

        $customer = $request->customer;

        $customers = User::where('role', 4)->orderBy('name','asc')->get();

        // $data = $request->all();
        // dd($data)

        $report = [];

        if ($year == "" || $month == "")
        {
            $salesCollections = array();
        }
        else
        {

            $params = [
                'year' => $year,
                'month' => $month,
                'dealerIds' => $customer,
            ];

            $dealerOutStanding = new DealerOutStanding($params);
            $report = $dealerOutStanding->getReport();

        }

        return view('admin.salesCollectionOutstanding.index')->with(compact('title','year','month','customers','customer', 'report'));
    }

    public function print(Request $request)
    {
        $title = "Sales & Collection Statement";

        $year = $request->year;
        $month = $request->month;

        $customer = $request->customer;

        // $data = $request->all();
        // dd($data)

        if ($year == "" || $month == "")
        {
            $salesCollections = array();
        }
        else
        {
            $params = [
                'year' => $year,
                'month' => $month,
                'dealerIds' => $customer,
            ];

            $dealerOutStanding = new DealerOutStanding($params);
            $report = $dealerOutStanding->getReport();
        }

        $pdf = PDF::loadView('admin.salesCollectionOutstanding.print',['title'=>$title,'year'=>$year,'month'=>$month, 'report'=>$report])->setPaper('a4', 'landscape');

        return $pdf->stream('sales_and_collection_standings_'.$month.'_of_'.$year.'.pdf');
    }
}
