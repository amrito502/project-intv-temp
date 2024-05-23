<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\RefundPolicies;

class RefundsController extends Controller
{
     public function refundPolicy()
     {
        $title = "Update Refund Policy";
    	$refundPolicy = RefundPolicies::where('id',1)->first();
        
        return view('admin.refund-policy.refundPolicy')->with(compact('title','refundPolicy'));
    	
    }

    public function updatrefundPolicy(Request $request){
    	$this->validate(request(), [
            'description' => 'required',           
        ]);

        $refundpolicyID = $request->refundpolicyID;

        $about = RefundPolicies::find($refundpolicyID);

        $about->update( [
            'title' => $request->title,          
            'description' => $request->description,   
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
           'status' => $request->status,          
        ]);

       

        return redirect(route('refund.policy'))->with('msg','Refund Policy Updated Successfully');     
    }

}
