<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\HelpCenters;

class HelpCenterController extends Controller
{
     public function helpCenter()
     {
        $title = "Update Help Center Information";
    	$helpCenter = HelpCenters::where('id',1)->first();
        
        return view('admin.help-center.help_center')->with(compact('title','helpCenter'));
    	
    }

    public function updatelpCenter(Request $request){
    	$this->validate(request(), [
            'description' => 'required',           
        ]);

        $helpcenterID = $request->helpcenterID;

        $about = HelpCenters::find($helpcenterID);

        $about->update( [
            'title' => $request->title,          
            'description' => $request->description,   
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
           'status' => $request->status,          
        ]);

       

        return redirect(route('help.center'))->with('msg','Help Center Information Updated Successfully');     
    }

}
