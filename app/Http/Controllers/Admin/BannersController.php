<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Banner;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    
    public function index()
    {
        $title = "Manage Banners";
        $banners = Banner::all();
        return view('admin.banners.index')->with(compact('title','banners'));
    }

    
    public function destroy(Banner $banner, Request $request)
    {
        if($request->ajax())
        {
            $banner->delete();
            print_r(1);       
            return;
        }

        $banner->delete();
        return redirect(route('banners.index')) -> with( 'message', 'Deleted Successfully');
    }

   

    public function changebannerStatus(Request $request)
    {
         if($request->ajax())
        {
            $data = Banner::find($request->banner_id);
            $data->bannerStatus = $data->bannerStatus ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('banners.index')) -> with( 'message', 'Wrong move!');
    }

    public function addbanner()
    {
        $title = "Add New Banner";
        return view('admin.banners.addbanners')->with(compact('title','banners'));
    }

     public function savebanner(Request $request){
        $this->validation($request);

        $this->validate(request(), [
            'bannerImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'           
                    
        ]);

        if (isset($request->bannerImage)) {
            $bannerImage = \App\helperClass::_bannerImage($request->bannerImage);
        }

        $banner = Banner::create( [     
            'title' => $request->title,
            'bannerImage' => @$bannerImage,              
            'bannerStatus' => $request->bannerStatus, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
        ]);

        // $product = Product::create($request->all());

        return redirect(route('banneradd.page'))->with('msg','banner Added Successfully');     
    }

  
    public function editbanner($id)
    {
        $title = "Edit Banner";
        $banners = Banner::where('id',$id)->first();
        return view('admin.banners.updatebanners')->with(compact('title','banners'));
    }


    public function updatebanner(Request $request){
        $this->validation($request);
        $bannerId = $request->bannerId;

        $banner = Banner::find($bannerId);

        if($request->bannerImage){
            @unlink($banner->bannerImage);
            $bannerImage = \App\helperClass::_bannerImage($request->bannerImage);
            $banner->update( [
                'bannerImage' => $bannerImage,          
            ]);
        }
        
       

        $banner->update( [
             'title' => $request->title,              
            'bannerStatus' => $request->bannerStatus,
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,          
        ]);

        // $product = Product::create($request->all());

        return redirect(route('banners.index'))->with('msg','Banner Updated Successfully');     
    }

    //View banner

     public function edit(banner $banner, Request $request)
    {
        

        $banner = Banner::find($request->banner_id);
        if($request->ajax())
            {
                return response()->json([
                    'banner'=>$banner
                ]);
            }
        return view('admin.categories.edit')->with(compact('banner'));
    }

    public function deleteBanner($id){
        Banner::where('id',$id)->delete();
        return redirect(route('banners.index'))->with('msg','Banner Deleted Successfully');
    }

    public function validation(Request $request)
    {
        $this->validate(request(), [
            
           
            
        ]);
    }
}
