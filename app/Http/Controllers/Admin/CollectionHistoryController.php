<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;

use App\User;
use App\Checkout;
use App\Customer;
use App\CreditCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));
        $reports = [];

        if($request->searched){
            $reports = CreditCollection::with('dealer')->where('client_id', $request->dealer)->whereBetween('payment_date', [$fromDate, $toDate])->get();
        }

        $data = (object)[
            'title' => $this->title,
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'dealers' => User::whereIn('role', [4, 6])->get(),
            'reports' => $reports,
        ];

        return view('admin.collectionHistory.index')->with(compact('data'));
    }

    public function print(Request $request)
    {
        $title = "Print Collection History";

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $reports = CreditCollection::with('dealer')->where('client_id', $request->dealer)->whereBetween('payment_date', [$fromDate, $toDate])->get();


        $pdf = PDF::loadView('admin.collectionHistory.print', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'reports' => $reports]);

        return $pdf->stream('collection_history_' . $fromDate . '_to_' . $toDate . '.pdf');
    }
}
