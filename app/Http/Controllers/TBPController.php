<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\TBP;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Project;
use App\Models\TBPItem;
use App\Models\Material;
use Illuminate\Http\Request;

use App\Models\LogisticsCharge;
use Illuminate\Support\Facades\Auth;

class TBPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Transportation Bill')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return TBP::datatable();
        }

        return view('dashboard.tbp.tbp_index');
    }

    public function payIndex(Request $request)
    {
        if (!Auth::user()->can('Supplier Payment')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return TBP::datatablePayment();
        }

    }


    public function system_serial($company_id = null)
    {

        $companyId = $company_id ? $company_id : Auth::user()->company_id;

        $company = Company::findOrFail($companyId);

        $tbpQty = TBP::where('company_id', $companyId)->count();

        if ($tbpQty > 0) {
            $tbpQty++;
        }else{
            $tbpQty = 1;
        }

        return $company->prefix . 'tb00000' . $tbpQty;
    }

    public function create()
    {
        if (!Auth::user()->can('create tbp')) {
            return redirect(route('home'));
        }

        if(Auth::user()->hasRole('Software Admin')){
            $system_serial = "";
        }else{
            $system_serial = $this->system_serial();
        }

        $data = (object)[
            'title' => 'Transportation Bill Prepare',
            'projects' => Project::GetRoleWiseAll()->get(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
            'system_serial' => $system_serial,
        ];

        return view('dashboard.tbp.create_tbp', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create tbp')) {
            return redirect(route('home'));
        }

        $request->validate([
            'date' => 'date',
            'project' => 'required',
            'vendor' => 'required',
            'cost_head' => 'required',
            'payment_mode' => 'required',
            'remarks' => 'required',
            'items.*' => 'required',
        ]);

        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $tbp = TBP::create([
            'system_serial' => $this->system_serial($company_id),
            'company_id' => $company_id,
            'project_id' => $request->project,
            'vendor_id' => $request->vendor,
            'budget_head_id' => $request->cost_head,
            'date' => date('Y-m-d', strtotime($request->date)),
            'payment_type' => $request->payment_mode,
            'remarks' => $request->remarks,
            'created_by' => Auth::user()->id,
        ]);

        if ($request->items) {

            foreach ($request->items as $item => $itemId) {
                TBPItem::create([
                    'tbp_id' => $tbp->id,
                    'consumption_item_id' => $itemId,
                    'material_id' => $request->materials[$itemId],
                    'material_qty' => $request->qtys[$itemId],
                    'material_rate' => $request->rates[$itemId],
                    'payment_amount' => $request->payment_amount[$itemId],
                ]);
            }
        }

        return redirect(route('tbp.index'));
    }


    public function destroy(TBP $tbp)
    {
        TBPItem::where('tbp_id', $tbp->id)->delete();
        $tbp->delete();
    }

    public function print($id)
    {

        $tbp = TBP::with(['project', 'vendor'])->where('id', $id)->first();
        $company = Company::findOrFail($tbp->company_id);
        $tbpItems = TBPItem::with(['material.materialUnit', 'consumptionItem.consumption.tower'])->where('tbp_id', $tbp->id)->get();

        $data = (object)[
            'tbp' => $tbp,
            'tbp_items' => $tbpItems,
            'company' => $company,
        ];

        $pdf = PDF::loadView('dashboard.tbp.tbp_print', compact('data'));
        return $pdf->stream('tbp_print_invoice.pdf');
    }



    public function PayDetailsView($id)
    {
        $tbp = TBP::with(['project', 'vendor'])->where('id', $id)->first();
        $company = Company::findOrFail($tbp->company_id);
        $tbpItems = TBPItem::with(['material.materialUnit', 'consumptionItem.consumption.tower'])->where('payment_status', 0)->where('tbp_id', $tbp->id)->get();
        $towers = [];

        foreach ($tbpItems as $tbpItem) {

          if($tbpItem->consumptionItem->consumption->tower){
              $tower = $tbpItem->consumptionItem->consumption->tower->name;

              if(!in_array($tower, $towers)){
                  array_push($towers, $tower);
              }

        	}
        }

        $data = (object)[
            'tbp' => $tbp,
            'tbp_items' => $tbpItems,
            'company' => $company,
            'towers' => $towers,
        ];


        return view('dashboard.tbp.pay_details_tbp', compact('data'));
    }

    public function Pay(Request $request)
    {

        $request->validate([
            'items' => 'required',
        ]);


        foreach ($request->items as $id => $value) {
            TBPItem::find($id)->update([
                'payment_status' => 1,
                'paid_by' => Auth::user()->id,
                'payment_time' => date('Y-m-d h:i:s'),
            ]);
        }


        return redirect(route('supplier.payment'));
    }
}
