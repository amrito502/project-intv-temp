<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class HeaderImageController extends Controller
{
    public function index()
    {
        $title = "Update Header Image";
    	$image = DB::table('header_image')->where('id',1)->first();
        
        return view('admin.headerImage.index')->with(compact('title','image'));
    	
    }

    public function update(Request $request)
    {
    	$this->validate(request(), [
            'image' => 'required',           
        ]);

       $id = DB::table('header_image')->where('id',1)->first();
        
        if($request->image){
            @unlink($id->image);
            $image = \App\helperClass::_sliderImage($request->image);
            DB::table('header_image')
                ->where('id', 1)
                ->update(['image' => $image]);
        }
        
        return redirect(route('homeImage.index'))->with('msg','Image Updated Successfully');     
    }

}
