<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Product;
use App\Vendors;
use App\PurchaseReturn;
use App\Helper\StockStatus;
use App\PurchaseReturnItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helper\Ui\FlashMessageGenerator;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $purchaseReturn = PurchaseReturn::select('purchase_returns.*','vendors.vendorName')
            ->join('vendors','vendors.id','=','purchase_returns.supplier_id')
            ->orderBy('vendors.vendorName','asc')
            ->get();

        // $purchaseReturn = PurchaseReturn::orderBy('id','DESC')->get();
        $title = $this->title;
        return view('admin.purchaseReturn.index')->with(compact('purchaseReturn','title'));
    }

    public function add(){
    	$vendors = Vendors::where('vendorStatus',1)->get();
        $products = Product::where('status',1)->get();
        $title = 'Create Purchase Return';
        return view('admin.purchaseReturn.add')->with(compact('title','products','vendors'));
    }

     public function save(Request $request){

        $purchase_return_date = date('Y-m-d', strtotime($request->purchase_return_date));

        $this->validate(request(), [
             'supplier_id' => 'required',
        ]);

        $countProduct = count($request->product_id);

        // validate stock start
        if ($request->product_id) {
            for ($i = 0; $i < $countProduct; $i++) {
                $product = Product::find($request->product_id[$i]);

                $stock = new StockStatus($request->product_id[$i]);
                $stockQty = $stock->stock();

                if($stockQty < $request->qty[$i]){
                    FlashMessageGenerator::generate("danger", 'Stock is not enough for product ' . $product->name);
                    return back();
                }
            }
        }
        // validate stock end


        $purchaseReturn = PurchaseReturn::create( [
            'purchase_return_serial' => $request->purchase_return_serial,
            'purchase_return_date' => $purchase_return_date,
            'supplier_id' => $request->supplier_id,
            'remarks' => $request->remarks,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,

        ]);

            if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'purchase_return_id'=> $purchaseReturn->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                    ];
                }

                PurchaseReturnItem::insert($postData);
            }

       return redirect(route('purchaseReturn.index'))->with('msg','Purchase Return Created Successfully');
    }

    public function edit($id){
    	$vendors = Vendors::where('vendorStatus',1)->get();
        $products = Product::where('status',1)->get();
        $purchaseReturn = PurchaseReturn::where('id',$id)->first();
        $purchaseReturnItem = PurchaseReturnItem::where('purchase_return_id',$id)->get();
        $title = 'Edit Purchase Return';
        return view('admin.purchaseReturn.edit')->with(compact('vendors','title','products','purchaseReturnItem','purchaseReturn'));
    }


     public function update(Request $request){
        $purchase_return_date = date('Y-m-d', strtotime($request->purchase_return_date));

        $this->validate(request(), [
             'supplier_id' => 'required',
        ]);
        $purchaseReturnId = $request->purchaseReturnId;
        $purchaseReturn = PurchaseReturn::find($purchaseReturnId);

        $purchaseReturn->update( [
            'purchase_return_date' => $purchase_return_date,
            'supplier_id' => $request->supplier_id,
            'remarks' => $request->remarks,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
        ]);

        $countProduct = count($request->product_id);
         DB::table('purchase_return_items')->where('purchase_return_id', $purchaseReturnId)->delete();
         if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'purchase_return_id'=> $purchaseReturn->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                    ];
                }

                PurchaseReturnItem::insert($postData);
            }

        return redirect(route('purchaseReturn.index'))->with('msg','Purchase Return  Updated Successfully');
    }


    public function destroy(Request $request){

        PurchaseReturn::where('id',$request->dealerPurchaseReturnId)->delete();
        PurchaseReturnItem::where('purchase_return_id',$request->dealerPurchaseReturnId)->delete();

    }

 /* public function getPurchaseOrderItem(Request $request){
  	$purchaseOrderItems = PurchaseOrderItem::select('purchase_order_items.*', 'products.name','products.id as productId')
                    ->join('products', 'products.id', '=', 'purchase_order_items.product_id')
                    ->where('purchase_order_items.purchase_order_id', $request->purchaseOrderId)
                    ->get();
    $purchaseOrder = PurchaseOrder::where('id',$request->purchaseOrderId)->first();
    $data = ['purchaseOrderItems' => $purchaseOrderItems, 'purchaseOrder' => $purchaseOrder];

    return $data;
  }*/


  public function supplierProducts(Request $request)
  {
      return $request;
  }
}
