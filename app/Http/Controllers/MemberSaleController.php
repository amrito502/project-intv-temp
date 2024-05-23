<?php

namespace App\Http\Controllers;

use App\User;
use App\Wallet;
use App\Product;
use App\Customer;
use App\Models\MemberSale;
use Illuminate\Http\Request;
use App\Models\MemberSaleItem;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\DB;
use App\Helper\MemberClassification;
use App\Http\Controllers\Controller;
use App\Helper\Ui\FlashMessageGenerator;

use PDF;

class MemberSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Requisitionindex()
    {
        $title = "My Requisition";

        $memberSales = MemberSale::with('customer');

        // if user is customer then show only his/her sales
        if (auth()->user()->role == 3) {
            $memberSales->where('customer_id', auth()->user()->CustomerAccount->id);
        }

        $memberSales = $memberSales->orderBy('id', 'DESC')
            ->get();

        return view('admin.memberSale.RequisitionIndex')->with(compact('title', 'memberSales'));
    }

    public function MemberSaleindex()
    {
        if (auth()->user()->role == 3) {
            $title = "My Requisition";
        } else {
            $title = "Member Sale";
        }

        $memberSales = MemberSale::with(['customer', 'items', 'items.product']);

        // if user is customer then show only his/her sales
        if (auth()->user()->role == 3) {
            $memberSales->where('customer_id', auth()->user()->CustomerAccount->id);
        }

        $memberSales = $memberSales->orderBy('id', 'DESC')
            ->get();

        return view('admin.memberSale.index')->with(compact('title', 'memberSales'));
    }


    public function add()
    {
        if (auth()->user()->role == 3) {
            $title = "My Requisition";
        } else {
            $title = "Member Sale";
        }

        $products = Product::where('status', 1)->get();
        $customers = Customer::get();
        $stores = User::where('role', 4)->get();

        $member_sale_id = MemberSale::count();

        if (!$member_sale_id) {
            $random_no = 1;
        } else {
            $random_no = $member_sale_id + 1;
        }

        $invoice_no = "CASH-" . date('yd', strtotime("now")) . "-" . $random_no;

        return view('admin.memberSale.add')->with(compact('title', 'products', 'invoice_no', 'customers', 'stores'));
    }



    public function save(Request $request)
    {

        $this->validate(request(), [
            'invoice_no' => 'required',
            'invoice_date' => 'required',
        ]);

        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));

        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");

        $status = auth()->user()->role == 3 ? 0 : 1;

        // validate dealer Inventory
        $countProduct = count($request->product_id);

        $dealer = User::findOrFail($request->store);
        $customer = Customer::findOrFail($request->customer);
        $user = User::find($customer->user_id);


        $dealerInventory = new DealerInventory($dealer);

        for ($i = 0; $i < $countProduct; $i++) {

            $product = Product::find($request->product_id[$i]);

            // product this sale qty
            $thisSaleQty = $request->qty[$i];

            // this product qty in dealer inventory
            $productStock = $dealerInventory->getDealerStockQty($product);

            if ($thisSaleQty > $productStock) {

                FlashMessageGenerator::generate('error', $product->name . " not enough in stock. Please check dealer inventory.");

                return redirect()->back();
            }
        }

        $memberSale = MemberSale::create([
            'customer_id' => $request->customer,
            'store_id' => $request->store,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => 0,
            'net_amount' => $request->total_amount,
            'customer_paid' => 0,
            'change_amount' => 0,
            'payment_type' => 'Cash',
            'created_by' => auth()->user()->id,
            'status' => $status,
        ]);

        $countProduct = count($request->product_id);

        if ($request->product_id) {

            $postData = [];

            $totalPoint = 0;
            $totalAmount = 0;

            for ($i = 0; $i < $countProduct; $i++) {

                $product = Product::find($request->product_id[$i]);

                $linePP = $product->pp * $request->qty[$i];

                $qty = $request->qty[$i];
                // $rate = $user->currentRank() == 'Customer' ? $product->price : $product->discount;
                $rate = $product->discount;

                if ($totalPoint >= 100) {
                    $rate = $product->discount;
                }


                $postData[] = [
                    'member_sale_id' => $memberSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $qty,
                    'item_rate' => $rate,
                    'item_price' => $qty * $rate,
                    'pp' => $linePP,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];

                $totalPoint += $linePP;
                $totalAmount += $qty * $rate;
            }

            MemberSaleItem::insert($postData);

            $memberSale->update([
                'invoice_amount' => $totalAmount,
                'net_amount' => $totalAmount,
            ]);
        }


        // $customer = Customer::find($request->customer);
        // $user = User::find($customer->user_id);

        if ($customer->user_id) {

            if ($status) {

                $tp = $user->totalPointIncome();

                // if ($tp <= 100) {

                //     $totalMRP = 0;
                //     $totalDP = 0;
                //     $totalPoint = 0;


                //     if ($request->product_id) {
                //         for ($i = 0; $i < $countProduct; $i++) {

                //             $product = Product::find($request->product_id[$i]);

                //             $qty = $request->qty[$i];
                //             // $rate = $user->currentRank() == 'Customer' ? $product->price : $product->discount;
                //             $rate = $product->discount;

                //             if ($totalPoint < 100) {
                //                 $totalMRP += $product->price * $request->qty[$i];
                //                 $totalDP += $product->discount * $request->qty[$i];
                //             }

                //             $linePP = $product->pp * $request->qty[$i];
                //             $totalPoint += $linePP;
                //         }
                //     }

                //     $totalPriceDiff = $totalMRP - $totalDP;

                //     // incentive
                //     Wallet::create([
                //         'from_id' => $user->referrence,
                //         'to_id' => $user->id,
                //         'amount' => $totalPriceDiff,
                //         'remarks' => 'Entertainment',
                //         'status' => 1,
                //     ]);
                // }

                if ($tp >= 500) {

                    // repurchase
                    Wallet::create([
                        'from_id' => $user->id,
                        'amount' => $totalPoint * .56,
                        'remarks' => 'RePurchaseBonus',
                        'status' => 1,
                    ]);
                }


                // add customer purchaseBonus pp
                Wallet::create([
                    'from_id' => $user->id,
                    'pp' => $totalPoint,
                    'remarks' => 'Purchase Point',
                    'status' => 1,
                ]);


                // add reference salesbonus cash
                Wallet::create([
                    'from_id' => $user->referrence,
                    'to_id' => $user->id,
                    'amount' => $totalPoint * 1.2,
                    'remarks' => 'SalesBonus',
                    'status' => 1,
                ]);


                // update user classification
                MemberClassification::updateMemberClassification($user);
            }
        }



        if (auth()->user()->role == 3) {
            FlashMessageGenerator::generate('success', 'Requisition Added Successfully');

            return redirect(route('memberSale.index'));
        } else {
            FlashMessageGenerator::generate('success', 'Member Sale Added Successfully');

            return redirect(route('dealerMemberSale.index'));
        }
    }

    public function edit($id)
    {

        if (auth()->user()->role == 3) {
            $title = "My Requisition";
        } else {
            $title = "Member Sale";
        }

        $products = Product::where('status', 1)->get();
        $memberSale = MemberSale::where('id', $id)->first();
        $stores = User::where('is_founder', 1)->orWhere('is_agent', 1)->get();
        $customers = Customer::get();
        $memberSaleId = $id;

        $memberSaleItems = MemberSaleItem::select('member_sale_items.*', 'products.name as product_name', 'products.id as product_id')
            ->join('products', 'products.id', '=', 'member_sale_items.item_id')
            ->where('member_sale_items.member_sale_id', $id)->get();

        return view('admin.memberSale.edit')->with(compact('title', 'products', 'memberSale', 'memberSaleItems', 'memberSaleId', 'customers', 'stores'));
    }


    public function update(Request $request, MemberSale $memberSale)
    {
        $invoice_date = date('Y-m-d', strtotime($request->invoice_date));
        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $member_sale_id = $request->member_sale_id;

        $this->validate(request(), [
            'invoice_no' => 'required',
            'invoice_date' => 'required',/*
        	'customer_paid' => 'required',*/
        ]);

        $memberSale = MemberSale::find($member_sale_id);

        $memberSale->update([
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $invoice_date,
            'invoice_amount' => $request->total_amount,
            'discount_as' => $request->discount_percentage,
            'discount_amount' => $request->discount,
            'vat_amount' => 0,
            'net_amount' => $request->total_amount,
            'customer_paid' => 0,
            'change_amount' => 0,
            'payment_type' => 'Cash',
        ]);

        $countProduct = count($request->product_id);
        DB::table('member_sale_items')->where('member_sale_id', $member_sale_id)->delete();

        if ($request->product_id) {
            $postData = [];
            for ($i = 0; $i < $countProduct; $i++) {
                $productId = Product::find($request->product_id[$i]);

                $postData[] = [
                    'member_sale_id' => $memberSale->id,
                    'invoice_no' => $request->invoice_no,
                    'item_id' => $request->product_id[$i],
                    'item_quantity' => $request->qty[$i],
                    'item_rate' => $request->rate[$i],
                    'item_price' => $request->amount[$i],
                    'pp' => $productId->pp * $request->qty[$i],
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ];
            }
            MemberSaleItem::insert($postData);
        }

        return redirect(route('memberSale.index'))->with('msg', 'Cash Sale Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemberSale  $memberSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        MemberSale::where('id', $request->memberSaleId)->delete();
        MemberSaleItem::where('member_sale_id', $request->memberSaleId)->delete();
    }


    public function approve($saleId)
    {
        $memberSale = MemberSale::findOrFail($saleId);

        $memberSale->update([
            'status' => 1,
        ]);

        $totalPoint = $memberSale->invoiceTotalPP();
        // add customer purchaseBonus pp
        Wallet::create([
            'from_id' => $memberSale->customer->user_id,
            'pp' => $totalPoint,
            'remarks' => 'Purchase Point',
            'status' => 1,
        ]);


        // add reference salesbonus cash
        Wallet::create([
            'from_id' => $memberSale->customer->UserAccount->referrence,
            'amount' => $totalPoint * 1.2,
            'remarks' => 'SalesBonus',
            'status' => 1,
        ]);

        // update user classification
        $user = User::find($memberSale->customer->user_id);
        MemberClassification::updateMemberClassification($user);

        return redirect()->back()->with('msg', 'Requisition Approved Successfully !!');
    }

    public function reject($saleId)
    {
        $memberSale = MemberSale::findOrFail($saleId);

        $memberSale->update([
            'status' => 2,
        ]);

        return redirect()->back()->with('msg', 'Requisition Rejected Successfully !!');
    }


    public function invoicePrint($id)
    {

        $title = "Dealer Sale";

        $memberSale = MemberSale::where('id', $id)->first();

        $memberSaleItems = MemberSaleItem::select('member_sale_items.*', 'products.name as product_name', 'products.id as product_id')
            ->join('products', 'products.id', '=', 'member_sale_items.item_id')
            ->where('member_sale_items.member_sale_id', $id)->get();


        $pdf = PDF::loadView('admin.memberSale.invoice', compact('memberSale', 'memberSaleItems', 'title'));

        return $pdf->stream('invoice.pdf');
    }

}
