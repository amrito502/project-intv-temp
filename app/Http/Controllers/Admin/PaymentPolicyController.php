<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\PaymentPolicies;

class PaymentPolicyController extends Controller
{
    public function paymentPolicy()
    {
        $title = "Update Payment Policy";
    	$paymentPolicy = PaymentPolicies::where('id',1)->first();
        
        return view('admin.payment-policy.paymentPolicy')->with(compact('title','paymentPolicy'));
    	
    }

    public function updatpaymentPolicy(Request $request){
    	$this->validate(request(), [
            'description' => 'required',           
        ]);

        $paymentpolicyID = $request->paymentpolicyID;

        $about = PaymentPolicies::find($paymentpolicyID);

        $about->update( [
            'title' => $request->title,          
            'description' => $request->description,   
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
           'status' => $request->status,          
        ]);

       

        return redirect(route('payment.policy'))->with('msg','Payment Policy Updated Successfully');     
    }

    

    
}
