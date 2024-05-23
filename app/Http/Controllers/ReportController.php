<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\Material;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helper\Reports\StockReport;
use Illuminate\Support\Facades\Auth;
use App\Helper\Reports\LiftingReport;
use App\Helper\Reports\IssueLogReport;
use App\Helper\Reports\CostLedgerReport;
use App\Helper\Reports\ExpenseLogReport;
use App\Helper\Reports\LocalIssueReport;
use App\Helper\Reports\PaymentLogReport;
use App\Helper\Reports\CashDueStatusReport;
use App\Helper\Reports\IssueMaterialDetails;
use App\Helper\Reports\BudgetMaterialDetails;
use App\Helper\Reports\VendorStatementReport;
use App\Helper\Reports\DailyConsumptionReport;
use App\Helper\Reports\MaterialStatementReport;
use App\Helper\Reports\PlanSheetFollowUpReport;
use App\Helper\Reports\ProjectBudgetStatusReport;
use App\Helper\Reports\consumptionMaterialDetails;

class ReportController extends Controller
{


    public function vendorStatement(Request $request)
    {
        if (!Auth::user()->can('Vendor Statement')) {
            return redirect(route('home'));
        }

        $vendorStatementReport = [];

        $filters = [
            'start_date' => date('d-m-Y', time()),
            'end_date' => date('d-m-Y', time()),
        ];

        if ($request->has('search')) {

            $request->validate([
                'project' => 'required',
                'vendor' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $filters = [
                'project' => $request->project,
                'vendor' => $request->vendor,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];

            $vendorStatementReportGenerator = new VendorStatementReport($filters);
            $vendorStatementReport = $vendorStatementReportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Material Vendor Statement',
            'vendors' => Vendor::GetRoleWiseAll()->whereIn('vendor_type', ['Material Supplier', 'Logistics Associate'])->get(),
            'projects' => Project::GetRoleWiseAll()->get(),
            'filters' => $filters,
            'report' => $vendorStatementReport,
        ];

        return view('dashboard.reports.vendor_statement', compact('data'));
    }

    public function vendorStatementPrint(Request $request)
    {
        $request->validate([
            'vendor' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $filters = [
            'project' => $request->project,
            'vendor' => $request->vendor,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];


        $vendorStatementReportGenerator = new VendorStatementReport($filters);
        $vendorStatementReport = $vendorStatementReportGenerator->generate();

        $data = (object)[
            'title' => 'Project Plan Sheet',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $vendorStatementReport,
        ];

        $pdf = PDF::loadView('dashboard.reports.vendor_state_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }


    public function planSheetFollowUp(Request $request)
    {

        if (!Auth::user()->can('Project Plan Sheet')) {
            return redirect(route('home'));
        }

        $planFollowUpReport = (object)[];


        if ($request->has('search')) {

            $request->validate([
                'project' => 'required',
            ]);

            $filters = [
                'project_id' => $request->project,
                'tower_ids' => $request->towers,
                'unit_ids' => $request->unit_ids,
                'materials' => $request->materials,
                'summary' => $request->has('summary'),
            ];

            $planFollowUpReportGenerator = new PlanSheetFollowUpReport($filters);
            $planFollowUpReport = $planFollowUpReportGenerator->generate();
        }


        $budgetHeads = BudgetHead::GetRoleWiseAll()->where('type', "Material")
            ->get();


        $data = (object)[
            'title' => 'Project Plan Sheet',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $planFollowUpReport,
            'budgetHeads' => $budgetHeads,
        ];


        return view('dashboard.reports.plan_sheet_follow_up', compact('data'));
    }

    public function planSheetFollowUpPrint(Request $request)
    {
        $request->validate([
            'project' => 'required',
        ]);

        $filters = [
            'project_id' => $request->project,
            'unit_ids' => $request->unit_ids,
            'tower_ids' => $request->towers,
            'materials' => $request->materials,
            'summary' => $request->has('summary'),
        ];

        $planFollowUpReportGenerator = new PlanSheetFollowUpReport($filters);
        $planFollowUpReport = $planFollowUpReportGenerator->generate();

        $data = (object)[
            'title' => 'Project Plan Sheet',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $planFollowUpReport,
        ];

        $pdf = PDF::loadView('dashboard.reports.plan_sheet_follow_up_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream();
    }


    public function projectBudgetStatus(Request $request)
    {
        if (!Auth::user()->can('Project Budget Status')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'project' => 'required',
            ]);

            $filters = [
                'project_id' => $request->project,
                'tower_ids' => $request->tower,
            ];

            $ProjectBudgetStatusReportGenerator = new ProjectBudgetStatusReport($filters);
            $report = $ProjectBudgetStatusReportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Project Budget Status',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        return view('dashboard.reports.project_budget_status', compact('data'));
    }

    public function projectBudgetStatusPrint(Request $request)
    {
        $request->validate([
            'project' => 'required',
        ]);

        $filters = [
            'project_id' => $request->project,
            'tower_ids' => $request->tower,
        ];

        $ProjectBudgetStatusReportGenerator = new ProjectBudgetStatusReport($filters);
        $report = $ProjectBudgetStatusReportGenerator->generate();

        $data = (object)[
            'title' => 'Project Budget Status',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.project_budget_status_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('project_budget_status.pdf');
    }


    public function cashDueStatus(Request $request)
    {
        if (!Auth::user()->can('Cash Payment Status')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'project' => 'required',
            ]);

            $filters = [
                'project_id' => $request->project,
                'tower_ids' => $request->tower,
            ];

            $CashDueStatusReportGenerator = new CashDueStatusReport($filters);
            $report = $CashDueStatusReportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Cash Payment Status',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        return view('dashboard.reports.cash_due_status', compact('data'));
    }


    public function cashDueStatusPrint(Request $request)
    {
        $request->validate([
            'project' => 'required',
        ]);

        $filters = [
            'project_id' => $request->project,
            'tower_ids' => $request->tower,
        ];

        $CashDueStatusReportGenerator = new CashDueStatusReport($filters);
        $report = $CashDueStatusReportGenerator->generate();

        $data = (object)[
            'title' => 'Project Budget Status',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.cash_due_status_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('project_budget_status.pdf');
    }


    public function materialStatement(Request $request)
    {
        if (!Auth::user()->can('Material Statement')) {
            return redirect(route('home'));
        }

        $report = (object)[];
        $prevBalance = 0;

        if ($request->has('search')) {

            $request->validate([
                'project' => 'required',
                'material' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
            ]);



            // previous balance
            $prevFilters = [
                'project' => $request->project,
                'material' => $request->material,
                'start_date' => "2021-12-00",
                'end_date' => date('Y-m-d', strtotime($request->start_date . ' -1 day')),
            ];

            $prevReportGenerator = new MaterialStatementReport($prevFilters);
            $prevReport = $prevReportGenerator->generate();

            if(count($prevReport['report_table'])){
                // dd($prevReport['report_table']);
                $prevBalance = $prevReport['report_table'][count($prevReport['report_table']) - 1]['balance'];
            }


            // main report
            $filters = [
                'project' => $request->project,
                'material' => $request->material,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ];

            $reportGenerator = new MaterialStatementReport($filters);
            $report = $reportGenerator->generate($prevBalance);
        }

        $data = (object)[
            'title' => 'Material Statement',
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'materials' => Material::GetRoleWiseAll()->get(),
            'report' => $report,
            'prev_balance' => $prevBalance,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.material_statement_report', compact('data'));
    }

    public function materialStatementPrint(Request $request)
    {
        $request->validate([
            'project' => 'required',
        ]);

        $request->validate([
            'material' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $filters = [
            'project' => $request->project,
            'material' => $request->material,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        $reportGenerator = new MaterialStatementReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Material Statement',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.material_statement_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('material_statement_print.pdf');
    }


    public function dailyConsumptionReport(Request $request)
    {
        if (!Auth::user()->can('Consumption Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                'project' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'towers' => $request->towers,
                'materials' => $request->materials,
                'units' => $request->units,
            ];

            $reportGenerator = new DailyConsumptionReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Daily Consumption Report',
            'projects' => Project::GetRoleWiseAll()->get(),
            'project' => Project::find(request()->project),
            'materials' => Material::GetRoleWiseAll()->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.daily_consumption_report', compact('data'));
    }


    public function dailyConsumptionReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'project' => 'required',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project' => $request->project,
            'towers' => $request->towers,
            'materials' => $request->materials,
            'units' => $request->units,
        ];

        $reportGenerator = new DailyConsumptionReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Daily Consumption Report',
            'project' => Project::find(request()->project),
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.daily_consumption_log_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('daily_consumption_log_print.pdf');
    }


    public function localIssueReport(Request $request)
    {
        if (!Auth::user()->can('Local Issue Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                'project' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'towers' => $request->towers,
                'materials' => $request->materials,
                'units' => $request->units,
            ];

            $reportGenerator = new LocalIssueReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Local Issue Report',
            'projects' => Project::GetRoleWiseAll()->get(),
            'project' => Project::find(request()->project),
            'materials' => Material::GetRoleWiseAll()->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.local_issue_report', compact('data'));
    }

    public function localIssueReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'project' => 'required',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project' => $request->project,
            'towers' => $request->towers,
            'materials' => $request->materials,
            'units' => $request->units,
        ];

        $reportGenerator = new LocalIssueReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Local Issue Report',
            'project' => Project::find(request()->project),
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.local_issue_log_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('local_issue_log_print.pdf');
    }

    public function stockReport(Request $request)
    {
        if (!Auth::user()->can('Stock Status')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                'project' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'materials' => $request->materials,
                'company_id' => $request->company ? $request->company : Auth::user()->company_id,
            ];

            $reportGenerator = new StockReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Stock Report',
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'materials' => Material::GetRoleWiseAll()->where('id', '!=', 1)->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.stock_report', compact('data'));
    }

    public function stockReportPrint(Request $request)
    {
        $request->validate([
            'project' => 'required',
        ]);

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'project' => 'required',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project' => $request->project,
            'materials' => $request->materials,
            'company_id' => $request->company ? $request->company : Auth::user()->company_id,
        ];


        $reportGenerator = new StockReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Stock Report',
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.stock_report_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('stock_repot.pdf');
    }

    public function liftingReport(Request $request)
    {
        if (!Auth::user()->can('Lifting Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
                // 'project' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'unit' => $request->unit_id,
                'tower' => $request->tower,
                'vendors' => $request->vendors,
                'logistics_associates' => $request->logistics_associates,
                'lifting_type' => $request->lifting_type,
                'materials' => $request->materials,
            ];


            $reportGenerator = new LiftingReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Lifting Log',
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'materials' => Material::GetRoleWiseAll()->where('id', '!=', 1)->get(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.lifting_report', compact('data'));
    }

    public function liftingReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            // 'project' => 'required',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project' => $request->project,
            'unit' => $request->unit_id,
            'tower' => $request->tower,
            'vendors' => $request->vendors,
            'logistics_associates' => $request->logistics_associates,
            'lifting_type' => $request->lifting_type,
            'materials' => $request->materials,
        ];


        $reportGenerator = new LiftingReport($filters);
        $report = $reportGenerator->generate();


        $data = (object)[
            'title' => 'Lifting Log',
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.lifting_report_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('lifting_report.pdf');
    }

    public function IssueLogReport(Request $request)
    {
        if (!Auth::user()->can('Transfer Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);


            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'source_project' => $request->source_project,
                'source_tower' => $request->source_tower,
                'destination_project' => $request->destination_project,
                'destination_tower' => $request->destination_tower,
                'materials' => $request->materials,
            ];


            $reportGenerator = new IssueLogReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Issue Log',
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'materials' => Material::GetRoleWiseAll()->where('id', '!=', 1)->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.issue_log_report', compact('data'));
    }

    public function IssueLogReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'source_project' => $request->source_project,
            'source_tower' => $request->source_tower,
            'destination_project' => $request->destination_project,
            'destination_tower' => $request->destination_tower,
            'materials' => $request->materials,
        ];


        $reportGenerator = new IssueLogReport($filters);
        $report = $reportGenerator->generate();


        $data = (object)[
            'title' => 'Issue Log',
            'source_project' => Project::find($request->source_project),
            'destination_project' => Project::find($request->destination_project),
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.issue_log_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('issue_log.pdf');
    }

    public function PaymentLogReport(Request $request)
    {
        if (!Auth::user()->can('Payment Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'tower' => $request->tower,
                'units' => $request->units,
                'vendor' => $request->vendor,
                'materials' => $request->materials,
            ];

            $reportGenerator = new PaymentLogReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Payment Log',
            'projects' => Project::GetRoleWiseAll()->get(),
            'budgetHeads' => BudgetHead::GetRoleWiseAll()->get(),
            'vendors' => Vendor::GetRoleWiseAll()->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.payment_log_report', compact('data'));
    }

    public function PaymentLogReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project' => $request->project,
            'tower' => $request->tower,
            'units' => $request->units,
            'vendor' => $request->vendor,
            'materials' => $request->materials,
        ];

        $reportGenerator = new PaymentLogReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Payment Log',
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.payment_log_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('payment_log.pdf');
    }

    public function ExpenseLogReport(Request $request)
    {
        if (!Auth::user()->can('Expense Log')) {
            return redirect(route('home'));
        }

        $report = (object)[];

        if ($request->has('search')) {

            $request->validate([
                'start_date' => 'required',
                'end_date' => 'required',
            ]);

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'project' => $request->project,
                'tower' => $request->tower,
                'units' => $request->units,
                'vendor' => $request->vendor,
                'materials' => $request->materials,
            ];

            $reportGenerator = new ExpenseLogReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Expense Log',
            'projects' => Project::GetRoleWiseAll()->get(),
            'budgetHeads' => BudgetHead::GetRoleWiseAll()->get(),
            'vendors' => Vendor::GetRoleWiseAll()->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.expense_log_report', compact('data'));
    }

    public function CostLedgerReport(Request $request)
    {
        if (!Auth::user()->can('Cost Ledger')) {
            return redirect(route('home'));
        }

        $date = Carbon::now()->endOfMonth()->format('d-m-Y');

        $report = (object)[];

        if ($request->has('search')) {

            $filters = [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'vendor' => $request->vendor,
                'project' => $request->project,
                'budgetheads' => $request->budgetHeads,
                'company_id' => $request->company ? $request->company : Auth::user()->company_id,
            ];

            $reportGenerator = new CostLedgerReport($filters);
            $report = $reportGenerator->generate();
        }

        $data = (object)[
            'title' => 'Cost Ledger',
            'budgetHeads' => BudgetHead::GetRoleWiseAll()->get(),
            'vendors' => Vendor::GetRoleWiseAll()->get(),
            'projects' => Project::GetRoleWiseAll()->get(),
            'report' => $report,
            'defaultDates' => [
                'start_date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'end_date' => Carbon::now()->endOfMonth()->format('Y-m-d'),
            ],
        ];

        return view('dashboard.reports.cost_ledger_report', compact('data'));
    }

    public function CostLedgerReportPrint(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        $filters = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'vendor' => $request->vendor,
            'project' => $request->project,
            'budgetheads' => $request->budgetHeads,
            'company_id' => $request->company ? $request->company : Auth::user()->company_id,
        ];

        $reportGenerator = new CostLedgerReport($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Cost Ledger',
            'report' => $report,
        ];

        $pdf = PDF::loadView('dashboard.reports.cost_ledger_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('cost_ledger.pdf');
    }


    public function budgetMaterialDetails($projectId, $unitId, $budgetHeadId)
    {

        $report = (object)[];

        $filters = [
            'projectId' => $projectId,
            'unitId' => $unitId,
            'budgetHeadId' => $budgetHeadId,
        ];

        $reportGenerator = new BudgetMaterialDetails($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Budget Material Details',
            'report' => $report,
        ];

        if (request()->print) {
            $pdf = PDF::loadView('dashboard.reports.budget_material_details_print', compact('data'))->setPaper('a4', 'landscape');

            return $pdf->stream();
        }

        return view('dashboard.reports.budget_material_details', compact('data'));
    }

    public function issueMaterialDetails($projectId, $unitId, $budgetHeadId)
    {

        $report = (object)[];

        $filters = [
            'projectId' => $projectId,
            'unitId' => $unitId,
            'budgetHeadId' => $budgetHeadId,
        ];

        $reportGenerator = new IssueMaterialDetails($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Issue Material Details',
            'report' => $report,
        ];

        if (request()->print) {
            $pdf = PDF::loadView('dashboard.reports.issue_material_details_print', compact('data'))->setPaper('a4', 'landscape');

            return $pdf->stream();
        }

        return view('dashboard.reports.issue_material_details', compact('data'));
    }

    public function consumptionMaterialDetails($projectId, $unitId, $budgetHeadId)
    {

        $report = (object)[];

        $filters = [
            'projectId' => $projectId,
            'unitId' => $unitId,
            'budgetHeadId' => $budgetHeadId,
        ];

        $reportGenerator = new consumptionMaterialDetails($filters);
        $report = $reportGenerator->generate();

        $data = (object)[
            'title' => 'Used Material Details',
            'report' => $report,
        ];

        if (request()->print) {
            $pdf = PDF::loadView('dashboard.reports.consumption_material_details_print', compact('data'))->setPaper('a4', 'landscape');

            return $pdf->stream();
        }

        return view('dashboard.reports.consumption_material_details', compact('data'));
    }

}
