<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\ShippingCharges;
use App\Http\Controllers\Controller;

class ShippingChargeController extends Controller
{

    public function index()
    {
        $title = $this->title;
        $shippingCharges = ShippingCharges::all();

        return view('admin.shippingCharges.index')->with(compact('title','shippingCharges'));
    }

    public function shippingChargeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = ShippingCharges::find($request->charge_id);
            $data->shippingStatus = $data->shippingStatus ^ 1;
            $data->update();
            print_r(1);
            return;
        }
        return redirect(route('shippingCharges.index')) -> with( 'message', 'Wrong move!');
    }


     public function addcharge(){
        $title = "Shipping Charge Configuration";
        return view('admin.shippingCharges.addchargeadd')->with(compact('title'));
    }

     public function savecharge(Request $request){

        $this->validate(request(), [
            'shippingAmount' => 'required|unique:shipping_charges',
            'shippingLocation' => 'required',
        ]);

        $shipping_charge = ShippingCharges::create( [
            'shippingAmount' => $request->shippingAmount,
            'shippingCharge' => $request->shippingCharge,
            'shippingLocation' => $request->shippingLocation,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
            'orderBy' => $request->orderBy,
            'shippingStatus' => $request->shippingStatus,
        ]);


        return redirect(route('chargeadd.page'))->with('msg','Shipping Charge Added Successfully');
    }


    public function editCharge($id){
        $title = "Shipping Charge Configuration";
        $shipping_charges = ShippingCharges::where('id',$id)->first();
        return view('admin.shippingCharges.updatecharge')->with(compact('title','shipping_charges'));
    }


    public function updateCharge(Request $request){
       $this->validate(request(), [
            'shippingAmount' => 'required',
            'shippingLocation' => 'required',
        ]);
        $chargeId = $request->chargeId;

        $shipping_charge = ShippingCharges::find($chargeId);

        $shipping_charge->update( [
            'shippingAmount' => $request->shippingAmount,
            'shippingCharge' => $request->shippingCharge,
            'shippingLocation' => $request->shippingLocation,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
            'orderBy' => $request->orderBy,
            'shippingStatus' => $request->shippingStatus,
        ]);

        // $product = Product::create($request->all());

        return redirect(route('shippingCharges.index'))->with('msg','Shipping Charge Updated Successfully');
    }

    //Delete Category from update page

    public function deleteCharge($id){

        ShippingCharges::where('id',$id)->delete();

        return redirect(route('shippingCharges.index')) -> with( 'msg', 'Deleted Successfully');
    }


    public function destroy(Request $request)
    {
        ShippingCharges::where('id',$request->charge_id)->delete();

    }

}
