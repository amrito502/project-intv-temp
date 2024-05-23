<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;
use App\CreditSale;
use App\CreditSaleItem;
use App\ClientEntry;
use App\Customer;
use App\Wallet;
use DB;

class CreditSaleController extends Controller
{
    public function index()
    {
        $title = "Credit Sale";
        $creditSales = CreditSale::select('credit_sales.*', 'customers.name as client_name')
            ->join('customers', 'customers.id', '=', 'credit_sales.customer_id')
            ->orderBy('customers.name', 'asc')->get();
        return view('admin.creditSale.index')->with(compact('title', 'creditSales'));
    }

    public function add()
    {
        $title = "Add Credit Sale";
        $products = Product::where('status', 1)->get();
        $customers = Customer::orderBy('name', 'asc')->get();

        $credit_sale_id = CreditSale::whereRaw('id = (select max(`id`) from credit_sales)')->first();

        if (!$credit_sale_id) {
            $random_no = 1;
        } else {
            $random_no = $credit_sale_id->id + 1;
        }

        $invoice_no = "CRDT-" . date('yd', strtotime("now")) . "-" . $random_no;

        return view('admin.creditSale.add')->with(compact('title', 'products', 'customers', 'invoice_no'));
    }

    public function save(Request $request)
    {
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $this->validate(request(), [
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'client' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $creditSale = CreditSale::create([
            'customer_id' => $request->client,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => $request->vat,
            'net_amount' => $request->net_amount,
            'payment_type' => $request->payment_type,
        ]);

        $countProduct = count($request->product_id);

        if ($request->product_id) {
            $postData = [];
            $totalPoint = 0;
            for ($i = 0; $i < $countProduct; $i++) {
                $productId = Product::find($request->product_id[$i]);
                $postData[] = [
                    'credit_sale_id' => $creditSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $request->qty[$i],
                    'item_rate' => $request->rate[$i],
                    'item_price' => $request->amount[$i],
                    'pp' => $productId->pp * $request->qty[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
                $totalPoint += $productId->pp * $request->qty[$i];
            }
            CreditSaleItem::insert($postData);
        }


        // $userId = Customer::find($request->client);
        // if ($userId->user_id) {
        //     Wallet::create([
        //         'from_id' => $userId->user_id,
        //         'pp' => $totalPoint,
        //         'remarks' => 'Purchase Point',
        //         'status' => 1,
        //     ]);
        // }

        return redirect(route('creditSale.index'))->with('msg', 'Credit Sale Added Successfully');
    }

    public function edit($id)
    {
        $title = "Edit Credit Sale";
        $products = Product::where('status', 1)->get();
        $creditSale = CreditSale::where('id', $id)->first();
        $customers = Customer::orderBy('name', 'asc')->get();
        $creditSaleItems = CreditSaleItem::select('credit_sale_items.*', 'products.name as product_name', 'products.id as product_id')
            ->join('products', 'products.id', '=', 'credit_sale_items.item_id')
            ->where('credit_sale_items.credit_sale_id', $id)->get();

        $creditSaleItemQty = CreditSaleItem::where('credit_sale_id', $id)->sum('item_quantity');

        return view('admin.creditSale.edit')->with(compact('title', 'products', 'creditSale', 'creditSaleItems', 'creditSaleItemQty', 'customers'));
    }

    public function update(Request $request)
    {
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $creditSaleId = $request->creditSaleId;

        $this->validate(request(), [
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'client' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $creditSale = CreditSale::find($creditSaleId);

        $creditSale->update([
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => $request->vat,
            'net_amount' => $request->net_amount,
            'payment_type' => $request->payment_type,
        ]);

        $countProduct = count($request->product_id);
        DB::table('credit_sale_items')->where('credit_sale_id', $creditSaleId)->delete();

        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $postData[] = [
                    'credit_sale_id' => $creditSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $request->qty[$i],
                    'item_rate' => $request->rate[$i],
                    'item_price' => $request->amount[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
            }
            CreditSaleItem::insert($postData);
        }

        return redirect(route('creditSale.index'))->with('msg', 'Credit Sale Update Successfully');
    }

    public function destroy(Request $request)
    {
        CreditSale::where('id', $request->creditSaleId)->delete();
        CreditSaleItem::where('credit_sale_id', $request->creditSaleId)->delete();
    }
}
