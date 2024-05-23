<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('category')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            return Category::dataTableAjax();
        }


        return view('dashboard.category.category_index');
    }


    public function create()
    {
        if (!Auth::user()->can('create category')) {
            return redirect(route('home'));
        }

        return view('dashboard.category.create_category');
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('create category')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name',
        ]);

        Category::create([
            'name' => $request->name,
            'status' => 1
        ]);

        FlashMessageGenerator::generate('primary', 'Category Successfully Added');

        return redirect(route('category.index'));
    }


    public function edit(Category $category)
    {
        if (!Auth::user()->can('edit category')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'category' => $category
        ];

        return view('dashboard.category.edit_category', compact('data'));
    }


    public function update(Request $request, Category $category)
    {
        if (!Auth::user()->can('edit category')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        FlashMessageGenerator::generate('primary', 'Category Updated Successfully');

        return redirect(route('category.index'));
    }


    public function destroy(Category $category)
    {
        if (!Auth::user()->can('delete category')) {
            return redirect(route('home'));
        }

        $category->delete();

        return True;
    }

    public function toggleStatus(Category $category)
    {
        $category->toggleStatus();

        return True;
    }
}
