<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Offer;

class OfferController extends Controller
{

    public function index()
    {
        $title = "Manage Offers";
        $offers = Offer::all();
        return view('admin.offers.index')->with(compact('title','offers'));
    }

    public function add()
    {
        $title = "Add New Offer";
        return view('admin.offers.add')->with(compact('title'));
    }


    public function save(Request $request){
        $this->validate(request(), [
            'promo_code' => 'required|unique:offers',
            'start' => 'required',
            'expire' => 'required',
            'type' => 'required',
            'minimum_amount' => 'required',
            'discount' => 'required',
        ]);

        Offer::create( [
            'promo_code' => $request->promo_code,
            'start' => date('Y-m-d', strtotime($request->start)),
            'expire' => date('Y-m-d', strtotime($request->expire)),
            'type' => $request->type,
            'minimum_amount' => $request->minimum_amount,
            'discount' => $request->discount,
            'status' => 1,
        ]);

        return redirect(route('offer.index'))->with('msg','Offer Added Successfully');
    }


    public function edit($id)
    {
        $title = "Edit Offer";
        $offer = Offer::find($id);

        return view('admin.offers.edit')->with(compact('title','offer'));
    }

    public function update(Request $request){
        $offer = Offer::find($request->id);

        $this->validate(request(), [
            'promo_code' => 'required|unique:offers,promo_code,' . $offer->id,
            'start' => 'required',
            'expire' => 'required',
            'type' => 'required',
            'minimum_amount' => 'required',
            'discount' => 'required',
        ]);



        $offer->update( [
            'promo_code' => $request->promo_code,
            'start' => date('Y-m-d', strtotime($request->start)),
            'expire' => date('Y-m-d', strtotime($request->expire)),
            'type' => $request->type,
            'minimum_amount' => $request->minimum_amount,
            'discount' => $request->discount,
        ]);

        return redirect(route('offer.index'))->with('msg','Offer Updated Successfully');
    }


    public function status(Request $request)
    {
        if($request->ajax())
        {
            $data = Offer::find($request->id);
            $data->status = $data->status ^ 1;
            $data->update();
            return;
        }
    }


    public function delete(Request $request)
    {
        Offer::find($request->id)->delete();
    }


    public function chekVoucher(Request $request){
        $code = $request->code;
        $offer = Offer::where('promo_code', $code)
                ->where('start', '<=', date('Y-m-d'))
                ->where('expire', '>=', date('Y-m-d'))
                ->where('status', 1)
                ->first();

        if(!empty($offer)){
            $status = true;
        }else{
            $status = false;
        }

        return $info = [
            'offer' => $offer,
            'status' => $status
            ];
    }
}
