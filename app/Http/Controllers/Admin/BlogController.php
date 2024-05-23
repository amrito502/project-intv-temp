<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Blog;
use DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    
    public function index()
    {
        $title = "Manage Blogs";
        $blogs = Blog::all();

        return view('admin.blogs.index')->with(compact('title','blogs'));
    }

    public function changeblogStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = Blog::find($request->blog_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('blogs.index')) -> with( 'message', 'Wrong move!');
    }

    
    /*public function subCategories(blog $blog, Request $request)
    {        
        if($request->ajax())
            {
                $blog = blog::find($request->blog_id);
                return response()->json([
                    'subCategories'=>$blog->subCategories
                ]);
            }
        return view('admin.categories.edit')->with(compact('blog'));
    }*/

    
     public function addblog()
     {
        $title = "Add New Blogs";
        $categories = blog::all();
        return view('admin.blogs.addblog')->with(compact('title','categories'));
    }

     public function saveblog(Request $request){
       

        $this->validate(request(), [
            'title' => 'required',        
            'description' => 'required' ,       
            'orderBy' => 'required' ,       
        ]);

        if (isset($request->blogImage)) {
            $blogImage = \App\helperClass::_blogImage($request->blogImage);
        }

        $blog = Blog::create( [     
            'title' => $request->title,
            'blogImage' => @$blogImage,              
            'description' => @$request->description,              
            'status' => $request->status, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
        ]);

        // $product = Product::create($request->all());

        return redirect(route('blogadd.page'))->with('msg','Blog Added Successfully');     
    }

  
    public function editBlog($id)
    {
        $title = "Edit Blogs";
        $blogs = Blog::where('id',$id)->first();
        return view('admin.blogs.updateblog')->with(compact('title','blogs'));
    }


    public function updateBlog(Request $request){
        $this->validate(request(), [
            'title' => 'required',        
            'description' => 'required' ,       
            'orderBy' => 'required' ,       
        ]);

        $blogId = $request->blogId;

        $blog = Blog::find($blogId);

        if($request->blogImage){
            @unlink($blog->blogImage);
            $blogImage = \App\helperClass::_blogImage($request->blogImage);
            $blog->update( [
                'blogImage' => $blogImage,          
            ]);
        }
        
    
        $blog->update( [
            'title' => $request->title,
            'blogImage' => @$blogImage,              
            'description' => @$request->description,              
            'status' => $request->status, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,          
        ]);

        // $product = Product::create($request->all());

        return redirect(route('blogs.index'))->with('msg','Blog Updated Successfully');     
    }

    //Delete blog from update page

    public function deleteBlog($id){

        Blog::where('id',$id)->delete();

        return redirect(route('blogs.index')) -> with( 'msg', 'Deleted Successfully');
    }

    //View blog

     public function edit(blog $blog, Request $request)
    {
        $title = "Edit Blog";
        

        $blog = blog::find($request->blog_id);
        if($request->ajax())
            {
                return response()->json([
                    'blog'=>$blog
                ]);
            }
        return view('admin.blogs.edit')->with(compact('title','blog'));
    }

    public function destroy(blog $blog, Request $request)
    {
        if($request->ajax())
        {
            $blog->delete();
            print_r(1);       
            return;
        }

        $blog->delete();
        return redirect(route('blogs.index')) -> with( 'message', 'Deleted Successfully');
    }

   
}
