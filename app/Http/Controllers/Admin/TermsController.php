<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Terms;

class TermsController extends Controller
{
     public function termsCondition()
     {
        $title = "Update Terms & Controller";
    	$termsCondition = Terms::where('id',1)->first();
        
        return view('admin.terms-condition.termsCondition')->with(compact('title','termsCondition'));
    	
    }

    public function updatetermsCondition(Request $request){
    	$this->validate(request(), [
            'description' => 'required',           
        ]);

        $termsconditionID = $request->termsconditionID;

        $about = Terms::find($termsconditionID);

        $about->update( [
            'title' => $request->title,          
            'description' => $request->description,   
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
           'status' => $request->status,          
        ]);

       

        return redirect(route('terms.condition'))->with('msg','Terms and Condition Updated Successfully');     
    }

}
