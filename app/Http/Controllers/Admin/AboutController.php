<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\About;

class AboutController extends Controller
{
    public function aboutUs()
    {
        $title = "Update Abount Us Information";
    	$about = About::where('id',1)->first();

        return view('admin.about.aboutUs')->with(compact('title','about'));

    }

    public function updatAbout(Request $request)
    {
        $title = "";
    	$this->validate(request(), [
            'aboutDescription' => 'required',
        ]);

        $aboutId = $request->aboutId;

        $about = About::find($aboutId);

        $about->update( [
            'title' => $request->title,
            'aboutDescription' => $request->aboutDescription,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
           'status' => $request->status,
        ]);



        return redirect(route('about.us'))->with('msg','About Us Information Updated Successfully');
    }



    public function adminLogo(){
        $title = "";
        $logos = Settings::where('id',1)->first();
        return view('admin.settings.adminLogo')->with(compact('title','logos'));
    }

    public function updatadminLogo(Request $request){
        $title = "";
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
