<?php

namespace App\Http\Controllers\Admin;

use App\SubCategory;
use App\Category;
use Illuminate\Http\Request;
namespace App\Http\Controllers\Admin;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::all();
        $categories = Category::all();
        return view('admin.subCategories.index')->with(compact('subCategories', 'categories'));
    }

    public function edit(SubCategory $subCategory, Request $request)
    {
        $subCategory = SubCategory::find($request->sub_category_id);
        if($request->ajax())
            {
                return response()->json([
                    'subCategory'=>$subCategory,
                    'category'=>$subCategory->category
                ]);
            }
        return view('admin.subCategories.edit')->with(compact('subCategory'));
    }

    
    public function destroy(SubCategory $subCategory, Request $request)
    {
        if($request->ajax())
        {
            $subCategory->delete();
            print_r(1);       
            return;
        }

        $subCategory->delete();
        return redirect(route('subCategories.index')) -> with( 'message', 'Deleted Successfully');
    }

    
    public function changeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = SubCategory::find($request->sub_category_id);
            $data->subcategoryStatus = $data->subcategoryStatus ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('subCategories.index')) -> with( 'message', 'Wrong move!');
    }


    public function addsubcategory(){
        $categories = Category::all();
        return view('admin.subCategories.addsubcategory')->with(compact('categories'));
    }

     public function savesubcategory(Request $request){
        $this->validation($request);


        $subcategory = subCategory::create( [     
            'category_id' => $request->category_id,              
            'subcategoryName' => $request->subcategoryName,              
            'subcategoryStatus' => $request->subcategoryStatus,
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,             
        ]);

        // $product = Product::create($request->all());

        return redirect(route('subcategoryadd.page'))->with('msg','Sub Category Added Successfully');     
    }

  
    public function editsubCategory($id){
        $subcategories = SubCategory::where('id',$id)->first();
        $categories = Category::all();
        return view('admin.subCategories.updatesubcategory')->with(compact('subcategories','categories'));
    }


    public function updatesubCategory(Request $request){
        $this->validation($request);
        $subcategoryId = $request->subcategoryId;

        $subcategory = SubCategory::find($subcategoryId);
       

        $subcategory->update( [
            'category_id' => $request->category_id,              
            'subcategoryName' => $request->subcategoryName,              
            'subcategoryStatus' => $request->subcategoryStatus, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
        ]);

        // $product = Product::create($request->all());

        return redirect(route('subcategory.edit',$subcategoryId))->with('msg','Sub Category Updated Successfully');     
    }

    


    public function validation(Request $request)
    {
        $this->validate(request(), [
            'subcategoryName' => 'required|string',
            'category_id' => 'required|numeric',
        ]);
    }
}
