<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Vendor;
use App\Models\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\MaterialVendorPayment;
use App\Models\MaterialVendorPaymentInvoice;

class MaterialVendorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return MaterialVendorPayment::datatable();
        }
    }


    public function serial_no()
    {
        $i = MaterialVendorPayment::count();

        return 10000 + $i + 1;
    }

    public function create()
    {
        if (!Auth::user()->can('material')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'serial_no' => $this->serial_no(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
            'projects' => Project::GetRoleWiseAll()->get(),
        ];

        return view('dashboard.material_vendor_payment.create_material_vendor_payment', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'vendor' => 'required',
            'project' => 'required',
            'tower' => 'required',
            'payment_date' => 'required',
            'payment_now' => 'required',
            'payment_type' => 'required',
            'money_receipt' => 'required',
            'remarks' => 'required',
            'lifting_invoice_ids' => 'required',
        ]);


        $materialVendorPayment = MaterialVendorPayment::create([
            'company_id' => $request->company ? $request->company : Auth::user()->company_id,
            'vendor_id' => $request->vendor,
            'project_id' => $request->project,
            'tower_id' => $request->tower,
            'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
            'payment_no' => $this->serial_no(),
            'payment_amount' => $request->payment_now,
            'payment_type' => $request->payment_type,
            'money_receipt' => $request->money_receipt,
            'remarks' => $request->remarks,
            'created_by' => Auth::user()->id,
        ]);


        foreach ($request->lifting_invoice_ids as $lifting_invoice_id) {
            MaterialVendorPaymentInvoice::create([
                'material_vendor_payment_id' => $materialVendorPayment->id,
                'lifting_id' => $lifting_invoice_id,
            ]);
        }

        return redirect()->route('supplier.payment');
    }

    public function destroy($id)
    {
        MaterialVendorPayment::findOrFail($id)->delete();
    }



}
