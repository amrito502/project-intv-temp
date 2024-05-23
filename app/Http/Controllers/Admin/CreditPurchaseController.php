<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CashPurchase;
use App\CreditPurchase;
use App\CreditPurchaseItem;
use App\Vendors;
use App\Product;

use PDF;
use DB;

class CreditPurchaseController extends Controller
{
    public function index()
    {
        $creditPurchase = CreditPurchase::with(['items', 'items.product'])->select('credit_purchases.*', 'vendors.vendorName')
            ->join('vendors', 'vendors.id', '=', 'credit_purchases.supplier_id')
            ->orderBy('credit_purchases.purchase_by', 'asc')
            ->orderby('vendors.vendorName', 'asc')
            ->get();

        $title = $this->title;

        return view('admin.creditPurchase.index')->with(compact('creditPurchase', 'title'));
    }

    public function add()
    {
        $title = 'Credit Purchase';

        $vendors = Vendors::where('vendorStatus', 1)->get();
        $products = Product::where('status', 1)->get();
        $cashPurchase = CashPurchase::all();

        return view('admin.creditPurchase.add')->with(compact('title', 'vendors', 'products', 'cashPurchase'));
    }

    public function save(Request $request)
    {
        $submission_date = date('Y-m-d', strtotime($request->submission_date));
        $voucher_date = date('Y-m-d', strtotime($request->voucher_date));

        $this->validate(request(), [
            'credit_serial' => 'required',
            'vouchar_no' => 'required',
            'supplier_id' => 'required',
            'purchase_by' => 'required',
            'voucher_date' => 'required',
        ]);

        $creditPurchase = CreditPurchase::create([
            'credit_serial' => $request->credit_serial,
            'vouchar_no' => $request->vouchar_no,
            'supplier_id' => $request->supplier_id,
            'submission_date' => $submission_date,
            'purchase_by' => $request->purchase_by,
            'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
            // 'discount' => $request->discount,
            // 'vat' => $request->vat,
            // 'net_amount' => $request->net_amount,
        ]);

        $countProduct = count($request->product_id);
        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $postData[] = [
                    'credit_puchase_id' => $creditPurchase->id,
                    'product_id' => $request->product_id[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'amount' => $request->amount[$i],
                    'rate_cash' => $request->cash_rate[$i],
                    'amount_cash' => $request->cash_amount[$i],
                ];
            }
            CreditPurchaseItem::insert($postData);
        }

        return redirect(route('creditPurchase.index'))->with('msg', 'Credit Purchase Added Successfully');
    }

    public function edit($id)
    {
        $creditPurchase = CreditPurchase::where('id', $id)->first();
        $vendors = Vendors::where('vendorStatus', 1)->get();
        $products = Product::where('status', 1)->get();
        $creditPurchaseItem = CreditPurchaseItem::where('credit_puchase_id', $id)->get();
        $title = 'Edit Credit Purchase';
        return view('admin.creditPurchase.edit')->with(compact('creditPurchase', 'title', 'vendors', 'products', 'creditPurchaseItem'));
    }

    public function printVoucher($id)
    {
        $title = 'Credit Purchase';

        $creditPurchase = CreditPurchase::with(['supplier'])->where('id', $id)->first();
        $creditPurchaseItems = CreditPurchaseItem::with(['product'])->where('credit_puchase_id', $id)->get();


        $pdf = PDF::loadView('admin.creditPurchase.print', [
            'title' => $title,
            'creditPurchase' => $creditPurchase,
            'creditPurchaseItems' => $creditPurchaseItems
        ]);

        return $pdf->stream('credit_purchase_voucher.pdf');

        // return view('admin.cashPurchase.print', compact('title', 'cashPurchase', 'cashPurchaseItems'));
    }

    public function update(Request $request)
    {
        $submission_date = date('Y-m-d', strtotime($request->submission_date));
        $voucher_date = date('Y-m-d', strtotime($request->voucher_date));

        $this->validate(request(), [
            'credit_serial' => 'required',
            'vouchar_no' => 'required',
            'supplier_id' => 'required',
            'purchase_by' => 'required',
        ]);
        $creditPurchaseId = $request->creditPurchaseId;
        $creditPurchase = CreditPurchase::find($creditPurchaseId);

        $creditPurchase->update([
            'credit_serial' => $request->credit_serial,
            'vouchar_no' => $request->vouchar_no,
            'supplier_id' => $request->supplier_id,
            'submission_date' => $submission_date,
            'purchase_by' => $request->purchase_by,
            'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
            'discount' => $request->discount,
            'vat' => $request->vat,
            'net_amount' => $request->net_amount,
        ]);

        $countProduct = count($request->product_id);
        DB::table('credit_purchase_items')->where('credit_puchase_id', $creditPurchaseId)->delete();
        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $postData[] = [
                    'credit_puchase_id' => $creditPurchase->id,
                    'product_id' => $request->product_id[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'amount' => $request->amount[$i],
                    'rate_cash' => $request->cash_rate[$i],
                    'amount_cash' => $request->cash_amount[$i],
                ];
            }

            CreditPurchaseItem::insert($postData);
        }

        return redirect(route('creditPurchase.index'))->with('msg', 'Credit Purchase Updated Successfully');
    }


    public function destroy(Request $request)
    {
        CreditPurchase::where('id', $request->creditPurchaseId)->delete();
        CreditPurchaseItem::where('credit_puchase_id', $request->creditPurchaseId)->delete();
    }
}
