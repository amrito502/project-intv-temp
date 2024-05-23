<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Project;
use App\Models\BudgetHead;
use Illuminate\Http\Request;
use App\Models\SupplierPayment;
use App\Models\SupplierPaymentItem;
use Illuminate\Support\Facades\Auth;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return SupplierPayment::datatable();
        }
    }


    public function paymentNo()
    {
        $startNo = 1000000;

        $rowCount = SupplierPayment::count();

        $paymentno = $startNo + $rowCount + 1;

        return $paymentno;
    }

    public function create()
    {
        if (!Auth::user()->can('create supplierpayment')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();

        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')
            ->get();

        $data = (object)[
            'paymentNo' => $this->paymentNo(),
            'projects' => $projects,
            'budgetHeads' => $budgetheads,
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
        ];

        return view('dashboard.supplier_payment.create_supplier_payment', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->can('create supplierpayment')) {
            return redirect(route('home'));
        }

        $supplierPaymentId = SupplierPayment::create([
            'company_id' => $request->company ? $request->company : Auth::user()->company_id,
            'project_id' => $request->project,
            'unit_id' => $request->unit_config_id,
            'tower_id' => $request->tower,
            'payment_no' => $this->paymentNo(),
            'payment_date' => $request->date,
            'money_receipt' => $request->money_receipt,
            'payment_type' => $request->payment_type,
            'remarks' => $request->remarks,
            'created_by' => Auth::user()->id,
        ]);

        // insert items table start

        $i = 0;
        foreach ($request->vendor as $vendorId) {

            SupplierPaymentItem::create([
                'supplier_payment_id' => $supplierPaymentId->id,
                'vendor_id' => $vendorId,
                'budget_head_id' => $request->budget_head[$i],
                'amount' => $request->amount[$i],
            ]);

            $i++;
        }

        // insert items table end


        return redirect(route('supplier.payment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierPayment $supplierPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function edit($supplierpayment)
    {

        if (!Auth::user()->can('edit supplierpayment')) {
            return redirect(route('home'));
        }

        $budgetheads = BudgetHead::GetRoleWiseAll()->where('type', 'Cash')
            ->get();

        $data = (object)[
            'supplierpayment' => SupplierPayment::where('id', $supplierpayment)->with(['project', 'unit', 'tower'])->first(),
            'items' => SupplierPaymentItem::where('supplier_payment_id', $supplierpayment)->get(),
            'budgetHeads' => $budgetheads,
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
        ];

        return view('dashboard.supplier_payment.edit_supplier_payment', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierPayment $supplierpayment)
    {
        if (!Auth::user()->can('edit supplierpayment')) {
            return redirect(route('home'));
        }

        if ($request->vendor) {

            $i = 0;
            SupplierPaymentItem::where('supplier_payment_id', $supplierpayment->id)->delete();
            foreach ($request->vendor as $vendorId) {
                SupplierPaymentItem::create([
                    'supplier_payment_id' => $supplierpayment->id,
                    'vendor_id' => $vendorId,
                    'budget_head_id' => $request->budget_head[$i],
                    'amount' => $request->amount[$i],
                ]);

                $i++;
            }
        }


        return redirect(route('supplier.payment'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupplierPayment  $supplierPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierPayment $supplierPayment)
    {
        //
    }
}
