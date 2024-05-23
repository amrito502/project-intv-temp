<?php

namespace App\Http\Controllers\Admin;

use DB;

use PDF;
use App\Product;
use App\Vendors;
use App\CashPurchase;
use App\SupplierPayment;
use App\CashPurchaseItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashPurchaseController extends Controller
{
    public function index()
    {
        $cashPurchase = CashPurchase::with(['items', 'items.product'])->select('cash_purchase.*', 'vendors.vendorName')
            ->join('vendors', 'vendors.id', '=', 'cash_purchase.supplier_id')
            ->orderBy('cash_purchase.id', 'desc')
            ->get();

        $title = $this->title;

        return view('admin.cashPurchase.index')->with(compact('cashPurchase', 'title'));
    }


    public function serialNo()
    {
        $cash_purchase = CashPurchase::whereRaw('id = (select max(`id`) from cash_purchase)')->first();
        if (!$cash_purchase) {
            $cashSerial = 1000000 + 1;
        } else {
            $cashSerial = $cash_purchase->cash_serial + 1;
        }

        return $cashSerial;
    }

    public function add()
    {

        $vendors = Vendors::where('vendorStatus', 1)->get();
        $products = Product::where('status', 1)->get();

        $title = 'Cash Purchase';
        $serialNo = $this->serialNo();

        return view('admin.cashPurchase.add')->with(compact('title', 'vendors', 'products', 'serialNo'));
    }

    public function save(Request $request)
    {
        $voucher_date = date('Y-m-d', strtotime($request->voucher_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $this->validate(request(), [
            'cash_serial' => 'required',
            'supplier_id' => 'required',
            'voucher_date' => 'required',
        ]);

        $cashPurchase = CashPurchase::create([
            'cash_serial' => $request->cash_serial,
            'voucher_no' => $request->vouchar_no,
            'supplier_id' => $request->supplier_id,
            'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
            'created_at' => $created_at,
            'updated_at' => $updated_at,

        ]);

        $countProduct = count($request->product_id);
        $invoiceTotal = 0;
        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $postData[] = [
                    'cash_puchase_id' => $cashPurchase->id,
                    'product_id' => $request->product_id[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'amount' => $request->amount[$i],
                    // 'qty_cash' => $request->cash_qty[$i],
                    'rate_cash' => $request->cash_rate[$i],
                    'amount_cash' => $request->cash_amount[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];


                $invoiceTotal += $request->cash_amount[$i];
            }

            CashPurchaseItem::insert($postData);
        }

        // add supplierpayment data
        SupplierPayment::create([
            'supplier_id' => $request->supplier_id,
            'payment_no' => $request->cash_serial,
            'payment_date' => $voucher_date,
            'current_due' => 0,
            'payment_now' => $invoiceTotal,
            'balance' => 0,
            'money_receipt' => $request->cash_serial,
            'payment_type' => "Cash",
            'remarks' => null,
            'cash_purchase_id' => $cashPurchase->id,
        ]);

        return redirect(route('cashPurchase.index'))->with('msg', 'Cash Purchase Added Successfully');
    }

    public function edit($id)
    {
        $cashPurchase = CashPurchase::where('id', $id)->first();
        $vendors = Vendors::where('vendorStatus', 1)->get();
        $products = Product::where('status', 1)->get();
        $cashPurchaseItem = CashPurchaseItem::where('cash_puchase_id', $id)->get();
        $title = 'Edit Cash Purchase';
        return view('admin.cashPurchase.edit')->with(compact('cashPurchase', 'title', 'vendors', 'products', 'cashPurchaseItem'));
    }

    public function printVoucher($id)
    {
        $title = 'Cash Purchase';

        $cashPurchase = CashPurchase::with(['supplier'])->where('id', $id)->first();
        $cashPurchaseItems = CashPurchaseItem::with(['product'])->where('cash_puchase_id', $id)->get();


        $pdf = PDF::loadView('admin.cashPurchase.print', [
            'title' => $title,
            'cashPurchase' => $cashPurchase,
            'cashPurchaseItems' => $cashPurchaseItems
        ]);

        return $pdf->stream('cash_purchase_voucher.pdf');

        // return view('admin.cashPurchase.print', compact('title', 'cashPurchase', 'cashPurchaseItems'));
    }

    public function update(Request $request)
    {
        $voucher_date = date('Y-m-d', strtotime($request->voucher_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $this->validate(request(), [
            'cash_serial' => 'required',
            'supplier_id' => 'required',
            'voucher_date' => 'required',
        ]);
        $cashPurchaseId = $request->cashPurchaseId;
        $cashPurchase = CashPurchase::find($cashPurchaseId);

        $cashPurchase->update([
            'voucher_no' => $request->voucher_no,
            'supplier_id' => $request->supplier_id,
            'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ]);

        $countProduct = count($request->product_id);
        $invoiceTotal = 0;

        DB::table('cash_purchase_item')->where('cash_puchase_id', $cashPurchaseId)->delete();
        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $postData[] = [
                    'cash_puchase_id' => $cashPurchase->id,
                    'product_id' => $request->product_id[$i],
                    'qty' => $request->qty[$i],
                    'rate' => $request->rate[$i],
                    'amount' => $request->amount[$i],
                    // 'qty_cash' => $request->cash_qty[$i],
                    'rate_cash' => $request->cash_rate[$i],
                    'amount_cash' => $request->cash_amount[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];

                $invoiceTotal += $request->cash_amount[$i];
            }

            CashPurchaseItem::insert($postData);
        }


        // add supplierpayment data

        SupplierPayment::where('cash_purchase_id', $cashPurchaseId)->delete();

        SupplierPayment::create([
            'supplier_id' => $cashPurchase->supplier_id,
            'payment_no' => $cashPurchase->cash_serial,
            'payment_date' => $voucher_date,
            'current_due' => 0,
            'payment_now' => $invoiceTotal,
            'balance' => 0,
            'money_receipt' => $request->cash_serial,
            'payment_type' => "Cash",
            'remarks' => null,
            'cash_purchase_id' => $cashPurchaseId,
        ]);

        return redirect(route('cashPurchase.index'))->with('msg', 'Cash Purchase Updated Successfully');
    }


    public function destroy(Request $request)
    {
        CashPurchase::where('id', $request->cashPurchaseId)->delete();
        CashPurchaseItem::where('cash_puchase_id', $request->cashPurchaseId)->delete();
        SupplierPayment::where('cash_purchase_id', $request->cashPurchaseId)->delete();

    }
}
