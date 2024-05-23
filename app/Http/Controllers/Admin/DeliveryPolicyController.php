<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\DeliveryPolicies;

class DeliveryPolicyController extends Controller
{
    public function deliveryPolicy()
    {
        $title = "Update Delivery Policy";
    	$deliveryPolicy = DeliveryPolicies::where('id',1)->first();
        
        return view('admin.delivery.deliveryPolicy')->with(compact('title','deliveryPolicy'));
    	
    }

    public function updatdeliveryPolicy(Request $request){
    	$this->validate(request(), [
            'description' => 'required',           
        ]);

        $deliverypolicyID = $request->deliverypolicyID;

        $about = DeliveryPolicies::find($deliverypolicyID);

        $about->update( [
            'title' => $request->title,          
            'description' => $request->description,   
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
           'status' => $request->status,          
        ]);

       

        return redirect(route('delivery.policy'))->with('msg','Delivery Policy Updated Successfully');     
    }

    

    public function adminLogo()
    {
        $title = "";
        $logos = Settings::where('id',1)->first();
        return view('admin.settings.adminLogo')->with(compact('title','logos'));
    }

    public function updatadminLogo(Request $request){
        $adminLogoId = $request->adminLogoId;

        $setting = Settings::find($adminLogoId);

        $this->validate(request(), [
            'adminLogo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'           
                    
        ]);

       if($request->adminLogo){
            @unlink($setting->adminLogo);
            $logo = \App\helperClass::_uploadImage($request->adminLogo);
            $setting->update( [
                'adminLogo' => $logo,          
            ]);
        }
        

        return redirect(route('admin.logo'))->with('msg','Logo Updated Successfully');     
    }
}
