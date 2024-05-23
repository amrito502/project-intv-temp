<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\Vendors;
use App\Product;
use DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrder = PurchaseOrder::select('purchase_orders.*','vendors.vendorName')
            ->join('vendors','vendors.id','=','purchase_orders.supplier_id')
            ->orderBy('vendors.vendorName','asc')
            ->get();

        $title = $this->title;
        return view('admin.purchaseOrder.index')->with(compact('purchaseOrder','title'));
    }

    public function add(){
        $vendors = Vendors::where('vendorStatus',1)->get();
        $products = Product::where('status',1)->where('status', 1)->get();
        $title = 'Purchase Order';
        return view('admin.purchaseOrder.add')->with(compact('title','vendors','products'));
    }

     public function save(Request $request){
        $delivery_date = date('Y-m-d', strtotime($request->delivery_date));
        $order_date = date('Y-m-d', strtotime($request->order_date));
        // $voucher_date = date('Y-m-d', strtotime($request->voucher_date));

        $this->validate(request(), [
             'supplier_id' => 'required',
        ]);
        $purchaseOrder = purchaseOrder::create( [
            'supplier_id' => $request->supplier_id,
            'order_no' => $request->order_no,
            'delivery_date' => $delivery_date,
            'order_date' => $order_date,
            // 'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,

        ]);

        $countProduct = count($request->product_id);
            if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'purchase_order_id'=> $purchaseOrder->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                        'rate_cash' => $request->cash_rate[$i],
                        'amount_cash' => $request->cash_amount[$i],
                    ];
                }

                PurchaseOrderItem::insert($postData);
            }

       return redirect(route('purchaseOrder.index'))->with('msg','Purchase Order Created Successfully');
    }

    public function edit($id){
    	$purchaseOrder = PurchaseOrder::where('id',$id)->first();
        $vendors = Vendors::where('vendorStatus',1)->get();
        $products = Product::where('status',1)->where('status', 1)->get();
        $purchaseOrderItem = PurchaseOrderItem::where('purchase_order_id',$id)->get();
        $title = 'Edit Purchase Order';
        return view('admin.purchaseOrder.edit')->with(compact('purchaseOrder','title','vendors','products','purchaseOrderItem'));
    }

    public function view($id){
    	$purchaseOrder = PurchaseOrder::where('id',$id)->first();
        $vendors = Vendors::where('vendorStatus',1)->get();
        $products = Product::where('status',1)->where('status', 1)->get();
        $purchaseOrderItem = PurchaseOrderItem::where('purchase_order_id',$id)->get();
        $title = 'View Purchase Order';
        return view('admin.purchaseOrder.view')->with(compact('purchaseOrder','title','vendors','products','purchaseOrderItem'));
    }

     public function update(Request $request){
        $delivery_date = date('Y-m-d', strtotime($request->delivery_date));
        $order_date = date('Y-m-d', strtotime($request->order_date));
        // $voucher_date = date('Y-m-d', strtotime($request->voucher_date));

        $this->validate(request(), [
             'supplier_id' => 'required',
        ]);
        $purchaseOrderId = $request->purchaseOrderId;
        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);

        $purchaseOrder->update( [
            'supplier_id' => $request->supplier_id,
            'order_no' => $request->order_no,
            'delivery_date' => $delivery_date,
            'order_date' => $order_date,
            // 'voucher_date' => $voucher_date,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
        ]);

        $countProduct = count($request->product_id);
         DB::table('purchase_order_items')->where('purchase_order_id', $purchaseOrderId)->delete();
        if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'purchase_order_id'=> $purchaseOrder->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                    ];
                }

                PurchaseOrderItem::insert($postData);
            }

        return redirect(route('purchaseOrder.index'))->with('msg','Purchase Order Updated Successfully');
    }


public function destroy(Request $request){
    PurchaseOrder::where('id',$request->purchaseOrderId)->delete();
    PurchaseOrderItem::where('purchase_order_id',$request->purchaseOrderId)->delete();
    }
}

