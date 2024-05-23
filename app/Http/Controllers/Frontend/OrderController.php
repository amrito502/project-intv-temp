<?php

namespace App\Http\Controllers;

use App\Order;
use App\Category;
use App\SubCategory;
use App\Product;
use Illuminate\Http\Request;
use Cart;
use Shipu\Aamarpay\Facades\Aamarpay;

class OrderController extends Controller
{
    public function index($id, $subCategory)
    {
        $category = Category::find($id);
        $subCategory = SubCategory::find($subCategory);
        return view('frontend.products.category')->with(compact('category', 'subCategory'));
    }

    public function single($id)
    {
        $product = Product::find($id);
        $relatedProduct = Product::where('sub_category_id', $product->sub_category_id)
            ->where('status', 1)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)->get();
        return view('frontend.products.single')->with(compact('product', 'relatedProduct'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function paymentSuccessOrFailed(Request $request)
    {
        if($request->get('pay_status') == 'Failed') {
            return redirect()->back();
        }
        
        $amount = 3500;
        $valid  = Aamarpay::valid($request, $amount);
        
        if($valid) {
            // Successfully Paid.
        } else {
           // Something went wrong. 
        }
        
        return redirect()->back();
    }

}
