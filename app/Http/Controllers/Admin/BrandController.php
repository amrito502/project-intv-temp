<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{

    public function index()
    {
        $title = "Brand";
        $brands = Brand::orderBy('id', 'ASC')->get();
        return view('admin.brands.index')->with(compact('title', 'brands'));
    }

    public function add()
    {
        $title = "Brand";
        return view('admin.brands.add')->with(compact('title'));
    }

    public function save(Request $request)
    {

        $this->validate(request(), [
            'brand_name' => 'required',
            'brand_img' => 'required|image',
        ]);

        $img = \App\helperClass::UploadImage($request->brand_img, 'brands', 'public/uploads/brand_image/', @$width, @$height);

        Brand::create([
            'name' => $request->brand_name,
            'image' => $img,
            'description' => $request->description,
            'status' => 1,
        ]);

        return redirect(route('brand.index'))->with('msg', 'Brand Added Successfully');
    }

    public function edit($id)
    {
        $title = "Brand";
        $brand = Brand::where('id', $id)->first();
        return view('admin.brands.edit')->with(compact('title', 'brand'));
    }

    public function update(Request $request)
    {

        $this->validate(request(), [
            'brand_id' => 'required',
            'brand_name' => 'required',
            'brand_img' => 'image',
        ]);

        $brand = Brand::findOrFail($request->brand_id);

        $img = $brand->image;
        if ($request->has('brand_img')) {
            $img = \App\helperClass::UploadImage($request->brand_img, 'brands', 'public/uploads/brand_image/', @$width, @$height);
        }

        $brand->update([
            'name' => $request->brand_name,
            'image' => $img,
            'description' => $request->description,
            'status' => 1,
        ]);

        return redirect(route('brand.index'))->with('msg', 'Brand Added Successfully');
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::find($request->brand_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);
            return;
        }

    }

    public function destroy(Request $request)
    {
        Brand::where('id', $request->brandId)->delete();
    }

}
