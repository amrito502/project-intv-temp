<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;

use App\User;
use App\Wallet;
use App\Product;
use App\CashSale;
use App\Customer;
use App\CashSaleItem;
use App\Helper\StockStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;

class CashSaleController extends Controller
{
    public function index()
    {
        $title = $this->title;

        $cashSales = CashSale::with(['dealer', 'items', 'items.product'])->orderBy('id', 'DESC')->get();

        return view('admin.cashSale.index')->with(compact('title', 'cashSales'));
    }

    public function getNewSerialNo($type)
    {
        $cash_sale_id = CashSale::whereRaw('id = (select max(`id`) from cash_sales)')->first();

        if (!$cash_sale_id) {
            $random_no = 1;
        } else {
            $random_no = $cash_sale_id->id + 1;
        }

        $typeString = strtoupper($type);

        $invoice_no = $typeString . "/" . date('ym', strtotime("now")) . "/" . $random_no;

        return $invoice_no;
    }

    public function add()
    {
        $title = "Dealer Sale";
        $products = Product::where('status', 1)->get();

        $users = User::where('role', 4)->get();

        $cash_sale_id = CashSale::whereRaw('id = (select max(`id`) from cash_sales)')->first();

        if (!$cash_sale_id) {
            $random_no = 1;
        } else {
            $random_no = $cash_sale_id->id + 1;
        }

        $invoice_no = $this->getNewSerialNo('cash');

        return view('admin.cashSale.add')->with(compact('title', 'products', 'invoice_no', 'users'));
    }

    public function save(Request $request)
    {
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $this->validate(request(), [
            // 'invoice_no' => 'required',
            'invoice_date' => 'required',
        ]);

        // get product count
        $countProduct = count($request->product_id);

        // validate stock start
        if ($request->product_id) {
            for ($i = 0; $i < $countProduct; $i++) {
                $product = Product::find($request->product_id[$i]);

                $stock = new StockStatus($request->product_id[$i]);
                $stockQty = $stock->stock();

                if ($stockQty < $request->qty[$i]) {
                    FlashMessageGenerator::generate("danger", 'Stock is not enough for product ' . $product->name);
                    return back();
                }
            }
        }
        // validate stock end

        $invoice_no = $this->getNewSerialNo($request->payment_type);

        $cashSale = CashSale::create([
            'customer_id' => $request->customer,
            'invoice_no' => $invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => $request->vat,
            'net_amount' => $request->net_amount,
            'customer_paid' => $request->customer_paid,
            'change_amount' => $request->change_amount,
            'payment_type' => $request->payment_type,
            'created_by' => Auth::user()->id,
        ]);



        if ($request->product_id) {
            $postData = [];
            $totalPoint = 0;
            for ($i = 0; $i < $countProduct; $i++) {

                $productId = Product::find($request->product_id[$i]);

                $rate = $request->rate[$i];

                $price = $request->amount[$i];
                $itemDealerPrice = $request->dealer_price[$i];
                $pp = $productId->pp;

                if ($rate == 0) {
                    $price = 0;
                    $itemDealerPrice = 0;
                    $pp = 0;
                }

                $postData[] = [
                    'cash_sale_id' => $cashSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $request->qty[$i],
                    'item_rate' => $rate,
                    'item_price' => $price,
                    'item_dealer_price' => $itemDealerPrice,
                    'pp' => $pp,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
            }

            CashSaleItem::insert($postData);
        }

        $commissionAmount = $request->total_amount - $request->net_amount;

        Wallet::create([
            'from_id' => $request->customer,
            'dealer_sale_invoice_id' => $cashSale->id,
            'amount' => $commissionAmount,
            'remarks' => 'DealerCommission',
            'status' => 1,
        ]);


        return redirect(route('cashSale.index'))->with('msg', 'Dealer Sale Added Successfully');
    }

    public function edit($id)
    {
        $title = "Dealer Sale";
        $products = Product::where('status', 1)->get();
        $users = User::where('role', 4)->get();
        $cashSaleId = $id;

        $cashSale = CashSale::where('id', $id)->first();

        $cashSaleItems = CashSaleItem::select('cash_sale_items.*', 'products.name as product_name', 'products.id as product_id')
            ->join('products', 'products.id', '=', 'cash_sale_items.item_id')
            ->where('cash_sale_items.cash_sale_id', $id)->get();

        return view('admin.cashSale.edit')->with(compact('title', 'products', 'cashSale', 'cashSaleItems', 'cashSaleId', 'users'));
    }

    public function update(Request $request)
    {
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $case_sale_id = $request->cash_sale_id;

        $this->validate(request(), [
            'invoice_no' => 'required',
            'invoice_date' => 'required',/*
        	'customer_paid' => 'required',*/
        ]);

        $cashSale = CashSale::find($case_sale_id);

        $cashSale->update([
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => $request->vat,
            'net_amount' => $request->net_amount,
            'customer_paid' => $request->customer_paid,
            'change_amount' => $request->change_amount,
            'payment_type' => $request->payment_type,
        ]);

        $countProduct = count($request->product_id);
        DB::table('cash_sale_items')->where('cash_sale_id', $case_sale_id)->delete();

        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $productId = Product::find($request->product_id[$i]);

                $rate = $request->rate[$i];

                $price = $request->amount[$i];
                $itemDealerPrice = $request->dealer_price[$i];
                $pp = $productId->pp;

                if ($rate == 0) {
                    $price = 0;
                    $itemDealerPrice = 0;
                    $pp = 0;
                }

                $postData[] = [
                    'cash_sale_id' => $cashSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $request->qty[$i],
                    'item_rate' => $rate,
                    'item_price' => $price,
                    'item_dealer_price' => $itemDealerPrice,
                    'pp' => $pp,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
            }
            CashSaleItem::insert($postData);
        }



        $commissionAmount = $request->total_amount - $request->net_amount;

        Wallet::where('dealer_sale_invoice_id', $cashSale->id)->delete();

        Wallet::create([
            'from_id' => $cashSale->customer_id,
            'dealer_sale_invoice_id' => $cashSale->id,
            'amount' => $commissionAmount,
            'remarks' => 'DealerCommission',
            'status' => 1,
        ]);

        return redirect(route('cashSale.index'))->with('msg', 'Dealer Sale Update Successfully');
    }

    public function destroy(Request $request)
    {
        CashSale::where('id', $request->cashSaleId)->delete();
        CashSaleItem::where('cash_sale_id', $request->cashSaleId)->delete();
        Wallet::where('dealer_sale_invoice_id', $request->cashSaleId)->delete();
    }

    public function invoicePrint($id)
    {

        $title = "Dealer Sale";

        $cashSale = CashSale::with(['dealer', 'dealer.district', 'dealer.thana'])->where('id', $id)->first();

        $cashSaleItems = CashSaleItem::select('cash_sale_items.*', 'products.name as product_name',  'products.deal_code as code', 'products.id as product_id')
            ->join('products', 'products.id', '=', 'cash_sale_items.item_id')
            ->where('cash_sale_items.cash_sale_id', $id)->get();


        $pdf = PDF::loadView('admin.cashSale.invoice', compact('cashSale', 'cashSaleItems', 'title'));

        return $pdf->stream('invoice.pdf');
    }
}
