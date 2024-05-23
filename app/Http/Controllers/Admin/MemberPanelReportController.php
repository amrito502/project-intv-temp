<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Customer;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper\SaleStateReport;
use App\Helper\SalesContribution;
use App\Helper\TeamPaymentStatus;
use App\Http\Controllers\Controller;
use App\Helper\BusinessAnalysisReport;
use App\Helper\TeamDistributionStatus;
use App\Helper\MemberSaleHistoryReport;

use PDF;

class MemberPanelReportController extends Controller
{

    public function salesHistoryReport(Request $request)
    {
        $title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

        // if search form is submitted
        if ($request->searched) {

            $params = [
                'dateRange' => $dateRange,
                'dealers' => $request->dealers,
                'members' => $request->members,
                'products' => $request->products,
                'categories' => $request->categories,
            ];

            $MemberSaleHistoryReport = new MemberSaleHistoryReport($params);
            $reports = $MemberSaleHistoryReport->getReport();
        }

        $data = (object)[
            'reports' => $reports,
            'products' => Product::where('status', 1)->get(),
            'dealers' => User::where('role', 4)->get(),
            'categories' => Category::where('categoryStatus', 1)->get(),
            'members' => Customer::get(),
            'dateRangeUi' => $dateRangeUi,
        ];


        if($request->submitType == "print"){

            $pdf = PDF::loadView('admin.memberReports.sales_history_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('sales_history.pdf');

        }

        return view('admin.memberReports.sales_history_report', compact('title', 'data'));
    }


    public function TeamPaymentStatus(Request $request)
    {
        $title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

         // if search form is submitted
         if ($request->searched) {

            $params = [
                'dateRange' => $dateRange,
                'members' => $request->members,
            ];

            $teamPaymentStatus = new TeamPaymentStatus($params);
            $reports = $teamPaymentStatus->getReport();

        }

        $data = (object)[
            'dateRangeUi' => $dateRangeUi,
            'members' => User::where('role', 3)->get(),
            'reports' => $reports,
        ];


        if($request->submitType == "print"){

            $pdf = PDF::loadView('admin.memberReports.team_payment_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('member_wallet.pdf');

        }

        return view('admin.memberReports.team_payment_report', compact('title', 'data'));

    }


    public function TeamDistributionStatus(Request $request)
    {
        $title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

         // if search form is submitted
         if ($request->searched) {

            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];

            $params = [
                'dateRange' => $dateRange,
                'members' => $request->members,
                'type' => $request->type,
            ];

            $teamDistributionStatus = new TeamDistributionStatus($params);
            $reports = $teamDistributionStatus->getReport();

        }

        $data = (object)[
            'dateRangeUi' => $dateRangeUi,
            'members' => User::where('role', 3)->get(),
            'reports' => $reports,
        ];

        if($request->submitType == "print"){

            $pdf = PDF::loadView('admin.memberReports.team_distribution_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('team_distribution.pdf');

        }

        return view('admin.memberReports.team_distribution_report', compact('title', 'data'));

    }

    public function SaleStateReport(Request $request)
    {
        $title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

         // if search form is submitted
         if ($request->searched) {

            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];

            $params = [
                'dateRange' => $dateRange,
                'members' => $request->members,
                'type' => $request->type,
                'categories' => $request->categories,
            ];

            $saleStateReport = new SaleStateReport($params);
            $reports = $saleStateReport->getReport();

        }

        $data = (object)[
            'dateRangeUi' => $dateRangeUi,
            'categories' => Category::all(),
            'reports' => $reports,
        ];

        if($request->submitType == "print"){

            $pdf = PDF::loadView('admin.memberReports.sale_state_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('sale_state_report.pdf');
        }

        return view('admin.memberReports.sale_state_report', compact('title', 'data'));

    }


    public function salesCont(Request $request)
    {
        $title = $this->title;

        $reports = [];

        $dateRangeUi = (object)[
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

         // if search form is submitted
         if ($request->searched) {

            $dateRange = [
                'start_date' => date('Y-m-d', strtotime($request->start_date)),
                'end_date' => date('Y-m-d', strtotime($request->end_date)),
            ];

            $params = [
                'type' => $request->type,
                'dealerId' => $request->dealer,
                'productId' => $request->product,
                'categoryId' => $request->category,
                'dateRange' => $dateRange,
            ];

            $salesContribution = new SalesContribution($params);
            $reports = $salesContribution->getReport();

        }

        $data = (object)[
            'dateRangeUi' => $dateRangeUi,
            'categories' => Category::all(),
            'dealers' => User::where('role', 4)->get(),
            // 'products' => Product::all(),
            'reports' => $reports,
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.memberReports.sales_contribution_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('sales_contribution.pdf');
        }

        return view('admin.memberReports.sales_contribution_report', compact('title', 'data'));
    }

}
