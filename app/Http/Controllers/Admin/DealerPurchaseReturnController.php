<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Product;
use App\Vendors;
use Illuminate\Http\Request;
use App\Helper\DealerInventory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DealerPurchaseReturn;
use App\Helper\Ui\FlashMessageGenerator;
use App\Models\DealerPurchaseReturnItem;

class DealerPurchaseReturnController extends Controller
{

    public function index()
    {
        $dealerPurchaseReturn = DealerPurchaseReturn::with(['dealer'])->get();

        $title = $this->title;
        return view('admin.dealerPurchaseReturn.index')->with(compact('dealerPurchaseReturn','title'));
    }


    public function add(){
        $title = 'Create Dealer Return';

        $products = Product::where('status',1)->get();
        $dealers = User::where('role', 4)->get();

        return view('admin.dealerPurchaseReturn.add')->with(compact('title','products', 'dealers'));
    }


    public function save(Request $request){

        $purchase_return_date = date('Y-m-d', strtotime($request->purchase_return_date));

        $this->validate(request(), [
             'dealer' => 'required',
        ]);

        $dealer = User::find($request->dealer);

        $countProduct = count($request->product_id);

        // validate stock start
        // if ($request->product_id) {
            // $stock = new DealerInventory($dealer);
        //     for ($i = 0; $i < $countProduct; $i++) {
        //         $product = Product::find($request->product_id[$i]);

        //         $stockQty = $stock->getDealerStockQty($product);

        //         if($stockQty < $request->qty[$i]){
        //             FlashMessageGenerator::generate("danger", 'Stock is not enough for product ' . $product->name);
        //             return back();
        //         }
        //     }
        // }
        // validate stock end


        $dealerPurchaseReturn = DealerPurchaseReturn::create( [
            'purchase_return_serial' => $request->purchase_return_serial,
            'purchase_return_date' => $purchase_return_date,
            'dealer_id' => $dealer->id,
            'remarks' => $request->remarks,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,

        ]);

            if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'dealer_purchase_return_id'=> $dealerPurchaseReturn->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                    ];
                }

                DealerPurchaseReturnItem::insert($postData);
            }

       return redirect(route('dealerPurchaseReturn.index'))->with('msg','Purchase Return Created Successfully');
    }

    public function edit($id){

        $title = 'Edit Purchase Return';

        $dealers = User::where('role', 4)->get();
        $products = Product::where('status',1)->get();

        $dealerPurchaseReturn = DealerPurchaseReturn::where('id',$id)->first();

        // dd($dealerPurchaseReturn);
        $dealerPurchaseReturnItem = DealerPurchaseReturnItem::where('dealer_purchase_return_id',$id)->get();

        return view('admin.dealerPurchaseReturn.edit')->with(compact('dealers','title','products','dealerPurchaseReturnItem','dealerPurchaseReturn'));
    }


    public function update(Request $request){
        $purchase_return_date = date('Y-m-d', strtotime($request->purchase_return_date));

        $this->validate(request(), [
            'dealer' => 'required',
        ]);
        $dealerPurchaseReturnId = $request->dealerPurchaseReturnId;
        $dealerPurchaseReturn = DealerPurchaseReturn::find($dealerPurchaseReturnId);

        $dealerPurchaseReturn->update( [
            'purchase_return_date' => $purchase_return_date,
            'dealer_id' => $request->dealer,
            'remarks' => $request->remarks,
            'total_qty' => $request->total_qty,
            'total_amount' => $request->total_amount,
        ]);

        $countProduct = count($request->product_id);
         DB::table('dealer_purchase_return_items')->where('dealer_purchase_return_id', $dealerPurchaseReturnId)->delete();
         if($request->product_id){
                $postData = [];
                for ($i=0; $i <$countProduct ; $i++) {
                    $postData[] = [
                        'dealer_purchase_return_id'=> $dealerPurchaseReturn->id,
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qty[$i],
                        'rate' => $request->rate[$i],
                        'amount' => $request->amount[$i],
                    ];
                }

                DealerPurchaseReturnItem::insert($postData);
            }

        return redirect(route('dealerPurchaseReturn.index'))->with('msg','Purchase Return  Updated Successfully');
    }


    public function destroy(Request $request){

        DealerPurchaseReturn::where('id',$request->dealerPurchaseReturnId)->delete();
        DealerPurchaseReturnItem::where('dealer_purchase_return_id',$request->dealerPurchaseReturnId)->delete();

    }

}
