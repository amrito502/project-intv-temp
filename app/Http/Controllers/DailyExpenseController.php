<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\DailyExpense;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\DailyExpenseItem;

use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;
use App\Helper\DailyExpense\ValidationHelper;

class DailyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Daily Expense')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return DailyExpense::datatable();
        }

        return view('dashboard.dailyexpense.dailyexpense_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create dailyexpense')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')->get();

        $vendors = Vendor::GetRoleWiseAll()->where('vendor_type', 'Working Associate')->get();

        if (Auth::user()->hasRole('Vendor')) {
            $vendors = Vendor::where('user_id', Auth::user()->id)->get();
        }

        $data = (object)[
            'title' => 'Create Daily Expense',
            'serial' => DailyExpense::nextSerial(),
            'projects' => $projects,
            'materials' => Material::GetRoleWiseAll()->get(),
            'budgetHeads' => $budgetheads,
            'vendors' => $vendors,
        ];

        return view('dashboard.dailyexpense.create_dailyexpense', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create dailyexpense')) {
            return redirect(route('home'));
        }

        $request->validate([
            'date' => 'required',
            'budget_head' => 'required',
        ]);

        // validate expense Condition
        $consumptionValidator = new ValidationHelper($request);
        $validationResult = $consumptionValidator->validate();

        if ($validationResult['error']) {
            FlashMessageGenerator::generate('danger', $validationResult['errorMsg']);
            return back();
        }

        // insert master table start
        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $data['project_id'] = $request->project_id;
        $data['unit_config_id'] = $request->unit_config_id;
        $data['tower_id'] = $request->tower;
        $data['date'] = date('Y-m-d', strtotime($request->date));
        $data['remarks'] = $request->remarks;
        $data['created_by'] = Auth::user()->id;

        $dailyexpense = DailyExpense::create($data);
        // insert master table end


        // insert items table start

        if ($request->vendor) {

            $i = 0;
            foreach ($request->vendor as $vendorId) {

                DailyExpenseItem::create([
                    'daily_expense_id' => $dailyexpense->id,
                    'vendor_id' => $vendorId,
                    'budget_head_id' => $request->budget_head[$i],
                    'amount' => $request->amount[$i],
                    'remarks' => $request->item_remarks[$i],
                    'approved_amount_log' => $request->approved_amount[$i],
                    'issued_amount_log' => $request->issued[$i],
                    'approved_due_log' => $request->approved_due[$i],
                ]);

                $i++;
            }
        }

        // insert items table end


        return redirect(route('dailyexpense.index'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit dailyexpense')) {
            return redirect(route('home'));
        }

        $dailyexpense = DailyExpense::where('id', $id)->with(['project', 'tower', 'unit', 'items', 'items.budgethead', 'items.vendor'])->first();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')->get();

        $data = (object)[
            'title' => 'Edit Daily Expense',
            'budgetHeads' => $budgetheads,
            'dailyexpense' => $dailyexpense,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Working Associate')->get(),
        ];

        return view('dashboard.dailyexpense.edit_dailyexpense', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DailyExpense  $dailyExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DailyExpense $dailyexpense)
    {
        if (!Auth::user()->can('edit dailyexpense')) {
            return redirect(route('home'));
        }

        // insert items table start
        if ($request->vendor) {

            DailyExpenseItem::where('daily_expense_id', $dailyexpense->id)->delete();

            $i = 0;
            foreach ($request->vendor as $vendorId) {

                DailyExpenseItem::create([
                    'daily_expense_id' => $dailyexpense->id,
                    'vendor_id' => $vendorId,
                    'budget_head_id' => $request->budget_head[$i],
                    'amount' => $request->amount[$i],
                    'remarks' => $request->item_remarks[$i],
                ]);

                $i++;
            }
        }


        // insert items table end

        return redirect(route('dailyexpense.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DailyExpense  $dailyExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyExpense $dailyexpense)
    {

        if (!Auth::user()->can('delete dailyexpense')) {
            return redirect(route('home'));
        }

        DailyExpenseItem::where('daily_expense_id', $dailyexpense->id)->delete();
        $dailyexpense->delete();
        return true;
    }

    public function DailyExpensePrint($id)
    {

        $dailyexpense = DailyExpense::where('id', $id)->with(['project', 'tower', 'unit', 'items', 'items.budgethead', 'items.vendor'])->first();

        $data = (object)[
            'dailyexpense' => $dailyexpense,
        ];

        $pdf = PDF::loadView('dashboard.dailyexpense.dailyexpense_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('daily_expense.pdf');

    }

}
