<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    public function index()
    {
        $nullCategories = Category::select('categories.*','parent as parentName')
            ->whereNull('parent');

        $categories = DB::table('categories as tab1')
            ->select('tab1.*','tab2.categoryName as parentName')
            ->join('categories as tab2','tab2.id','=','tab1.parent')
            ->union($nullCategories)
            ->orderBy('parentName','asc')
            ->orderBy('categoryName','asc')
            ->get();


        $title = $this->title;
        return view('admin.categories.index')->with(compact('title','categories'));
    }

    public function changecategoryStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = Category::find($request->category_id);
            $data->categoryStatus = $data->categoryStatus ^ 1;
            $data->update();
            print_r(1);
            return;
        }
        return redirect(route('categories.index')) -> with( 'message', 'Wrong move!');
    }


    /*public function subCategories(Category $category, Request $request)
    {
        if($request->ajax())
            {
                $category = Category::find($request->category_id);
                return response()->json([
                    'subCategories'=>$category->subCategories
                ]);
            }
        return view('admin.categories.edit')->with(compact('category'));
    }*/


    public function addcategory()
    {
        $title = "Category";
        $categories = Category::orderBy('categoryName','asc')->get();
        return view('admin.categories.addcategory')->with(compact('title','categories'));
    }

     public function savecategory(Request $request){
        $this->validation($request);

        $this->validate(request(), [
            'categoryImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'categoryCoverImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'leftMenuImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if (isset($request->categoryImage)) {
            $categoryImage = \App\helperClass::_categoryImage($request->categoryImage);
        }

        if (isset($request->categoryCoverImage)) {
            $categoryCoverImage = \App\helperClass::_categoryCoverImage($request->categoryCoverImage);
        }

        if (isset($request->leftMenuImage)) {
            $leftMenuImage = \App\helperClass::_categoryCoverImage($request->leftMenuImage);
        }

        $category = Category::create( [
            'categoryName' => $request->categoryName,
            'categoryImage' => @$categoryImage,
            'categoryCoverImage' => @$categoryCoverImage,
            'leftMenuImage' => @$leftMenuImage,
            'categoryStatus' => $request->categoryStatus,
            'parent' => $request->parent,
            'showInHomepage' => $request->showInHomepage,
            'showInMegaMenu' => $request->showInMegaMenu,
            'showInFooter' => $request->showInFooter,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
            'color' => $request->color,
            'orderBy' => $request->orderBy,
        ]);

        // $product = Product::create($request->all());

        return redirect(route('categoryadd.page'))->with('msg','Category Added Successfully');
    }


    public function editCategory($id){
        $title = "Category";
        $parentCategory = Category::orderBy('categoryName','asc')->get();
        $categories = Category::where('id',$id)->first();
        return view('admin.categories.updatecategory')->with(compact('title','categories','parentCategory'));
    }


    public function updateCategory(Request $request){
        $this->validation($request);
        $categoryId = $request->categoryId;

        $category = Category::find($categoryId);

        if($request->categoryImage){
@unlink($category->categoryImage);
            $categoryImage = \App\helperClass::_categoryImage($request->categoryImage);
            $category->update( [
                'categoryImage' => $categoryImage,
            ]);
        }

        if($request->categoryCoverImage){
@unlink($category->categoryCoverImage);
            $categoryCoverImage = \App\helperClass::_categoryCoverImage($request->categoryCoverImage);
            $category->update( [
                 'categoryCoverImage' => @$categoryCoverImage,
            ]);
        }

        if($request->leftMenuImage){
@unlink($category->leftMenuImage);
            $leftMenuImage = \App\helperClass::_categoryCoverImage($request->leftMenuImage);
            $category->update( [
                 'leftMenuImage' => @$leftMenuImage,
            ]);
        }

        $category->update( [
            'categoryName' => $request->categoryName,
            'categoryStatus' => $request->categoryStatus,
            'parent' => $request->parent,
            'showInHomepage' => $request->showInHomepage,
            'showInMegaMenu' => $request->showInMegaMenu,
            'showInFooter' => $request->showInFooter,
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
            'color' => $request->color,
            'orderBy' => $request->orderBy,
        ]);

        // $product = Product::create($request->all());

        return redirect(route('categories.index'))->with('msg','Category Updated Successfully');
    }

    //Delete Category from update page

    public function deleteCategory($id){

        Category::where('id',$id)->delete();

        return redirect(route('categories.index')) -> with( 'msg', 'Deleted Successfully');
    }

    //View Category

     public function edit(Category $category, Request $request)
    {
        $category = Category::find($request->category_id);
        if($request->ajax())
            {
                return response()->json([
                    'category'=>$category
                ]);
            }
        return view('admin.categories.edit')->with(compact('category'));
    }

    public function destroy(Category $category, Request $request)
    {
        if($request->ajax())
        {
            $category->delete();
            print_r(1);
            return;
        }


    }

    public function validation(Request $request)
    {
        $this->validate(request(), [
            'categoryName' => 'required|string'

        ]);
    }
}
