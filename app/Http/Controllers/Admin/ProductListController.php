<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\Product;

use DB;
use PDF;
use MPDF;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $product_category = $request->product_category;
        $product = $request->product;

        $categories = Category::orderBy('categoryName', 'asc')->get();
        $products = Product::orderBy('name', 'asc')->get();

        // $data = $request->all();
        // dd($data);

        if ($product_category == "" && $product == "") {
            $productLists = Product::select('categories.categoryName as categoryName', 'products.name as productName', 'products.price as unitPrice', 'products.discount as dp', 'products.pp as pp', 'products.deal_code as productCode')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->orderBy('categoryName')
                ->get();
        } else {
            $productLists = Product::select('categories.categoryName as categoryName', 'products.name as productName', 'products.price as unitPrice', 'products.discount as dp', 'products.pp as pp', 'products.deal_code as productCode')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->orWhere(function ($query) use ($product_category, $product) {
                    if ($product_category) {

                        foreach ($product_category as $categoryParam) {
                            $query->whereRaw("find_in_set('".$categoryParam."', products.category_id)");
                        }
                        // $query->whereIn('categories.id', $product_category);
                    }

                    if ($product) {
                        $query->whereIn('products.id', $product);
                    }
                })
                ->orderBy('categoryName')
                // ->orderBy('productName')
                ->get();
        }

        return view('admin.productList.index')->with(compact('title', 'categories', 'products', 'productLists', 'product_category', 'product'));
    }

    public function print(Request $request)
    {
        $title = "Product List";

        $product_category = $request->product_category;
        $product = $request->product;

        // $data = $request->all();
        // dd($data);

        if ($product_category == "" && $product == "") {
            $productLists = Product::select('categories.categoryName as categoryName', 'products.name as productName', 'products.price as unitPrice', 'products.discount as dp', 'products.pp as pp', 'products.deal_code as productCode')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->orderBy('products.category_id')
                ->get();
        } else {
            $productLists = Product::select('categories.categoryName as categoryName', 'products.name as productName', 'products.price as unitPrice', 'products.discount as dp', 'products.pp as pp', 'products.deal_code as productCode')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->orWhere(function ($query) use ($product_category, $product) {
                    if ($product_category) {
                        $query->whereIn('categories.id', $product_category);
                    }

                    if ($product) {
                        $query->whereIn('products.id', $product);
                    }
                })
                ->orderBy('products.category_id')
                // ->orderBy('productName')
                ->get();
        }


        $pdf = PDF::loadView('admin.productList.print', ['title' => $title, 'productLists' => $productLists]);

        return $pdf->stream('product_lists.pdf');
    }


    public function memberIndex()
    {

        $title = "Product List";

        $products = Product::select('products.*', 'categories.id as catId', 'categories.categoryName as catName', 'product_images.productId', 'product_images.images')
            ->leftjoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_images', 'product_images.productId', '=', 'products.id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'desc')
            ->get();

        return view('admin.product.product_list_member')->with(compact('title', 'products'));

    }
}
