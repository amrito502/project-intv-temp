<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Project;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\CashRequisition;
use App\Models\CashRequisitionItem;
use App\Models\CashVendorPayment;
use Illuminate\Support\Facades\Auth;

use PDF;

class CashRequisitionController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Cash Requisition')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return CashRequisition::datatable();
        }

        return view('dashboard.cashrequisition.cashrequisition_index');
    }

    public function approveRequisitionIndexView(Request $request)
    {

        if (!Auth::user()->can('Requisition Approve')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return CashRequisition::approvingDatatable();
        }

        return view('dashboard.cashrequisition.cashrequisition_approve');
    }

    public function supplierPaymentIndex(Request $request)
    {
        if (!Auth::user()->can('Supplier Payment')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return CashRequisition::supplierPaymentDatatable();
        }

        return view('dashboard.supplierpayment.supplierpayment_index');
    }

    public function create()
    {
        if (!Auth::user()->can('create cashrequisition')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')->get();

        $vendors = Vendor::GetRoleWiseAll()->where('vendor_type', 'Working Associate')->get();

        if (Auth::user()->hasRole('Vendor')) {
            $vendors = Vendor::where('user_id', Auth::user()->id)->get();
        }

        $data = (object)[
            'title' => 'Create Cash Requisition',
            'serial' => CashRequisition::nextSerial(),
            'projects' => $projects,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'budgetHeads' => $budgetheads,
            'vendors' => $vendors,
        ];

        return view('dashboard.cashrequisition.create_cashrequisition', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create cashrequisition')) {
            return redirect(route('home'));
        }

        $request->validate([
            'date' => 'required',
            'budget_head.*' => 'required',
            // 'vendor.*' => 'required',
        ]);

        // insert master table start
        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $data['project_id'] = $request->project_id;
        $data['unit_config_id'] = $request->unit_config_id;
        $data['tower_id'] = $request->tower;
        $data['date'] = date('Y-m-d', strtotime($request->date));
        $data['remarks'] = $request->remarks;
        $data['status'] = "Pending";
        $data['created_by'] = Auth::user()->id;

        $cashrequisition = CashRequisition::create($data);
        // insert master table end


        // insert items table start

        if ($request->vendor) {

            $i = 0;
            foreach ($request->vendor as $vendorId) {

                CashRequisitionItem::create([
                    'cash_requisition_id' => $cashrequisition->id,
                    'vendor_id' => $vendorId,
                    'budget_head_id' => $request->budget_head[$i],
                    'requisition_amount' => $request->amount[$i],
                    'remarks' => $request->item_remarks[$i],
                    'approved_amount_log' => $request->approved_amount[$i],
                    'issued_amount_log' => $request->issued[$i],
                    'approved_due_log' => $request->approved_due[$i],
                ]);

                $i++;
            }
        }

        // insert items table end


        return redirect(route('cashrequisition.index'));
    }

    public function edit($id)
    {
        if (!Auth::user()->can('edit cashrequisition')) {
            return redirect(route('home'));
        }

        $cashrequisition = CashRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead', 'items.vendor'])->first();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')->get();

        $data = (object)[
            'title' => 'Edit Cash Requisition',
            'budgetHeads' => $budgetheads,
            'cashrequisition' => $cashrequisition,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Working Associate')->get(),
        ];

        return view('dashboard.cashrequisition.edit_cashrequisition', compact('data'));
    }

    public function update(Request $request, CashRequisition $cashrequisition)
    {
        if (!Auth::user()->can('edit cashrequisition')) {
            return redirect(route('home'));
        }

        $request->validate([
            'budget_head.*' => 'required',
            // 'vendor.*' => 'required',
        ]);


        // insert items table start

        if ($request->vendor) {

            CashRequisitionItem::where('cash_requisition_id', $cashrequisition->id)->delete();

            $i = 0;
            foreach ($request->vendor as $vendorId) {

                CashRequisitionItem::create([
                    'cash_requisition_id' => $cashrequisition->id,
                    'vendor_id' => $vendorId,
                    'budget_head_id' => $request->budget_head[$i],
                    'requisition_amount' => $request->amount[$i],
                    'remarks' => $request->item_remarks[$i],
                ]);

                $i++;
            }
        }


        // insert items table end

        return redirect(route('cashrequisition.index'));
    }

    public function destroy(CashRequisition $cashrequisition)
    {
        CashRequisitionItem::where('cash_requisition_id', $cashrequisition->id)->delete();
        $cashrequisition->delete();
        return true;
    }

    public function approveRequisitionView($id)
    {

        if (!Auth::user()->can('Can Approve Cash Requisition')) {
            return back();
        }

        $cashrequisition = CashRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead', 'items.vendor'])->first();

        $budgetheads = BudgetHead::where(function ($query) {
            $query->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        })->where('type', 'Cash')
            ->get();

        $data = (object)[
            'title' => 'Cash Requisition Approve',
            'budgetHeads' => $budgetheads,
            'cashrequisition' => $cashrequisition,
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
            'vendors' => Vendor::where('company_id', Auth::user()->company_id)->where('vendor_type', 'Working Associate')->get(),
        ];

        return view('dashboard.cashrequisition.approve_cashrequisition', compact('data'));
    }


    public function CashRequisitionPrint($cashRequisitionId)
    {

        $cashrequisition = CashRequisition::where('id', $cashRequisitionId)->with(['project', 'tower', 'items', 'items.budgethead', 'items.vendor'])->first();

        $data = (object)[
            'cashrequisition' => $cashrequisition,
        ];

        $pdf = PDF::loadView('dashboard.cashrequisition.cash_requisition_print', compact('data'))->setPaper('a4', 'landscape');

        return $pdf->stream('cash_requisition.pdf');

    }

    public function serial()
    {
        $i = CashRequisition::count();
        $serial = date('Ymd') + $i;
        return $serial;
    }


    public function approveRequisition(Request $request)
    {

        $request->validate([
            'cashRequisitionId' => 'required',
            'approved_amount' => 'required',
        ]);

        foreach ($request->approved_amount as $id => $approveAmount) {

            CashRequisitionItem::where('id', $id)->first()->update([
                'approved_amount' => $approveAmount,
            ]);
        }

        CashRequisition::where('id', $request->cashRequisitionId)->first()->update([
            'status' => 'Approved',
        ]);

        return redirect(route('cashrequisition.index.view'));
    }


    public function PayDetailsView($id)
    {
        $cashrequisition = CashRequisition::where('id', $id)->with(['project', 'tower', 'unitConfig', 'items', 'items.budgethead', 'items.vendor'])->first();
        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')->get();

        $data = (object)[
            'budgetHeads' => $budgetheads,
            'cashrequisition' => $cashrequisition,
            'materials' => Material::GetRoleWiseAll()->get(),
            'units' => MaterialUnit::all(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Working Associate')->get(),
        ];

        return view('dashboard.cashrequisition.details_cashrequisition', compact('data'));
    }


    public function Pay(Request $request)
    {
        $request->validate([
            'pay' => 'required',
        ]);

        foreach ($request->pay as $id => $value) {

            if(!$value){
                continue;
            }

            CashVendorPayment::create([
                'requisition_item_id' => $id,
                'amount' => $value,
                'created_by' => Auth::user()->id,
            ]);

        }

        // get cash requisition
        $cashRequisition = CashRequisition::where('id', $request->cash_requisition_id)->first();

        $thisRequisitionTotalApproved = $cashRequisition->RequisitionTotalApprovedAmount();
        $thisRequisitionTotalPaid = $cashRequisition->RequisitionTotalPaidAmount();

        if($thisRequisitionTotalPaid >= $thisRequisitionTotalApproved){
            $cashRequisition->update([
                'status' => 'Paid',
            ]);
        }

        return redirect(route('supplier.payment'));
    }
}
