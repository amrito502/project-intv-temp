<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use MPDF;
use App\Vendors;
use App\CashPurchase;
use App\CreditPurchase;
use App\PurchaseReturn;

use App\SupplierPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\SupplierStatementReport;

class SupplierStatementController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $supplier = $request->supplier;

        $previousBalances = array();
        $supplierStatements = array();

        $vendors = Vendors::orderBy('vendorName', 'asc')->get();

        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));

        $reports = [];
        $previousBalance = 0;

        if ($request->searched) {

            // get previous report start
            $previousSupplierStatementReport = new SupplierStatementReport("0000-01-01", $lastDate, $supplier, 0);
            $previousReports = $previousSupplierStatementReport->getReport();

            if ($previousReports) {
                $lastRow = count($previousReports) - 1;
                $previousBalance = $previousReports[$lastRow]['balance'];
            }
            // get previous report end


            // get current report start
            $supplierStatementReport = new SupplierStatementReport($fromDate, $toDate, $supplier, $previousBalance);
            $reports = $supplierStatementReport->getReport();
            // get current report end

        }


        return view('admin.supplierStatement.index')->with(compact('title', 'fromDate', 'toDate', 'vendors', 'supplier', 'reports', 'previousBalance'));
    }

    public function print(Request $request)
    {
        $title = "Print Supplier Statement";

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $supplier = $request->supplier;
        $previousBalance = 0;

        $lastDate = Date('Y-m-d', strtotime("-1 day", strtotime($fromDate)));

        // get previous report start
        $previousSupplierStatementReport = new SupplierStatementReport("0000-01-01", $lastDate, $supplier, 0);
        $previousReports = $previousSupplierStatementReport->getReport();

        if ($previousReports) {
            $lastRow = count($previousReports) - 1;
            $previousBalance = $previousReports[$lastRow]['balance'];
        }
        // get previous report end


        // get current report start
        $supplierStatementReport = new SupplierStatementReport($fromDate, $toDate, $supplier, $previousBalance);
        $reports = $supplierStatementReport->getReport();
        // get current report end

        $pdf = PDF::loadView('admin.supplierStatement.prints', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'previousBalance' => $previousBalance, 'reports' => $reports]);

        return $pdf->stream('supplier_statement_history_' . $fromDate . '_to_' . $toDate . '.pdf');
    }
}
