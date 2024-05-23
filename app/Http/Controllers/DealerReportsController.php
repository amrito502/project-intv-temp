<?php

namespace App\Http\Controllers;

use PDF;
use App\User;
use App\Product;
use App\CashSale;
use App\Category;
use App\Models\MemberSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Helper\DealerReports\PaymentLog;
use App\Helper\DealerReports\SaleDetails;
use App\Helper\DealerReports\StockReport;
use App\Helper\DealerReports\PurchaseDetails;
use App\Helper\DealerReports\StatementReport;
use App\Helper\DealerReports\DealerStateReport;

class DealerReportsController extends Controller
{


    public function dealerPurchaseDateWise(Request $request)
    {

        $title = "Dealer Purchase";

        $reports = [];

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

        // if search form is submitted
        if ($request->searched) {
            if ($request->searched == "summary") {
                $dealerPurchaseReport = new PurchaseDetails($dateRange);
                $reports = $dealerPurchaseReport->getAllDetails();
            } else {

                // get cashSale list datewise
                $reports = CashSale::with(['items', 'items.product'])
                    ->where('customer_id', auth()->user()->id)
                    ->where('invoice_date', '>=', $dateRange['start_date'])
                    ->where('invoice_date', '<=', $dateRange['end_date'])
                    ->get();
            }
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
            'dateRangeUi' => $dateRangeUi,
        ];

        return view('admin.dealerReports.purchaseDetailsReport', compact('title', 'data'));
    }

    public function dealerPurchaseDateWisePrint(Request $request)
    {
        $title = "Dealer Purchase";

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

        if ($request->searched) {
            if ($request->searched == "summary") {
                $dealerPurchaseReport = new PurchaseDetails($dateRange);
                $reports = $dealerPurchaseReport->getAllDetails();
            } else {

                // get cashSale list datewise
                $reports = CashSale::with(['items', 'items.product'])
                    ->where('customer_id', auth()->user()->id)
                    ->where('invoice_date', '>=', $dateRange['start_date'])
                    ->where('invoice_date', '<=', $dateRange['end_date'])
                    ->get();
            }
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
        ];

        $pdf = PDF::loadView('admin.dealerReports.dealer_purchase_details_print', compact('title', 'data'))->setPaper('a4', 'landscape');

        return $pdf->stream('dealer_purchase_details.pdf');
    }

    public function dealerSaleDateWise(Request $request)
    {
        $title = "Dealer Sale Details";

        $reports = [];

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        // if search form is submitted
        if ($request->searched) {

            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];

            if ($request->searched == "summary") {
                $dealerSaleReport = new SaleDetails($dateRange);
                $reports = $dealerSaleReport->getAllDetails();
            } else {

                // get member sale list in the daterange
                $reports = MemberSale::with('items', 'items.product', 'customer')
                    ->where('store_id', auth()->user()->id)
                    ->where('invoice_date', '>=', $dateRange['start_date'])
                    ->where('invoice_date', '<=', $dateRange['end_date'])
                    ->get();
            }
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
            'dateRangeUi' => $dateRangeUi,
        ];


        return view('admin.dealerReports.saleDetailsReport', compact('title', 'data'));
    }

    public function dealerSaleDateWisePrint(Request $request)
    {

        $title = "Dealer Sale Details";

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

        if ($request->searched == "summary") {
            $dealerSaleReport = new SaleDetails($dateRange);
            $reports = $dealerSaleReport->getAllDetails();
        } else {

            // get member sale list in the daterange
            $reports = MemberSale::with('items', 'items.product', 'customer')
                ->where('store_id', auth()->user()->id)
                ->where('invoice_date', '>=', $dateRange['start_date'])
                ->where('invoice_date', '<=', $dateRange['end_date'])
                ->get();
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
        ];

        $pdf = PDF::loadView('admin.dealerReports.dealer_sale_details_print', compact('title', 'data'))->setPaper('a4', 'landscape');

        return $pdf->stream('dealer_sale_details.pdf');
    }



    public function dealerInventory(Request $request)
    {
        $title = $this->title;

        $reports = [];

        if ($request->searched) {
            $dealerId = $request->dealer_id;
            $dealerStockReport = new StockReport($dealerId);
            $reports = $dealerStockReport->getAllDetails();
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
            'dealers' => User::whereIn('role', [4, 6])->get(),
            'selectedUser' => User::find($request->dealer_id),
        ];


        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.dealerReports.dealer_stock_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('my_statement.pdf');
        }

        return view('admin.dealerReports.DealerStockReport', compact('title', 'data'));

    }


    public function dealerPaymentLog(Request $request)
    {
        $title = "Dealer Payment Log";

        $reports = [];

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        // if search form is submitted
        if ($request->searched) {

            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];


            $dealerSaleReport = new PaymentLog($dateRange);
            $reports = $dealerSaleReport->getAllDetails();
        }

        $data = (object)[
            'reports' => $reports,
            'dateRangeUi' => $dateRangeUi,
        ];

        return view('admin.dealerReports.dealer_payment_log', compact('title', 'data'));
    }

    public function dealerStatement(Request $request)
    {
        $title = "Dealer Statement";

        $reports = [];
        $previousBalance = 0;

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        // if search form is submitted
        if ($request->searched) {

            // previous daterange start
            $previousDateRange = [
                'start_date' => "0000-00-00",
                'end_date' => date('Y-m-d', strtotime($request->start_date)),
            ];

            $dealerId = $request->dealer;

            $previousDealerStatementReport = new StatementReport($dealerId, $previousDateRange, 0);
            $PreviousReports = $previousDealerStatementReport->getAllDetails();

            $previousBalance = 0;

            if (count($PreviousReports)) {
                $lastRow = count($PreviousReports) - 1;
                $previousBalance = $PreviousReports[$lastRow]['balance'];
            }

            // previous daterange end


            // main daterange start
            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];

            $dealerStatementReport = new StatementReport($dealerId, $dateRange, $previousBalance);
            $reports = $dealerStatementReport->getAllDetails();
            // main daterange end

        }

        $data = (object)[
            'reports' => $reports,
            'previousBalance' => $previousBalance,
            'dateRangeUi' => $dateRangeUi,
            'dealers' => User::whereIn('role', [4, 6])->get(),
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.dealerReports.dealer_statement_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('dealer_statement.pdf');
        }

        return view('admin.dealerReports.dealer_statement', compact('title', 'data'));
    }

    public function dealerStateReport(Request $request)
    {
        $title = "Dealer State Report";

        $reports = [];

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        // if search form is submitted
        if ($request->searched) {

            $params = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
                'dealer' => $request->dealer,
                'categories' => $request->categories,
                'products' => $request->products,
            ];

            $dealerStateReport = new DealerStateReport($params);

            $reports = $dealerStateReport->getReport();
        }

        $data = (object)[
            'reports' => $reports,
            'dateRangeUi' => $dateRangeUi,
            'dealers' => User::where('role', 4)->get(),
            'categories' => Category::get(),
            'products' => Product::where('status', 1)->get(),
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.dealerReports.dealer_state_report_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('dealer_state_report.pdf');
        }

        return view('admin.dealerReports.dealer_state_report', compact('title', 'data'));
    }
}
