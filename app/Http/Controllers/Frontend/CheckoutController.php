<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Checkout;
use App\Customer;
use App\Order;
use App\Shipping;
use App\Transaction;
use App\Product;
use App\Settings;
use App\ProductSections;
use Illuminate\Http\Request;
use Cart;
use Session;
use DB;
use PDF;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.index')->with(compact('checkouts'));
    }


    public function neworderList()
    {
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.neworderList')->with(compact('checkouts'));
    }


     public function processingOrder()
    {
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.processingOrder')->with(compact('checkouts'));
    }


     public function shippingOrder()
    {
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.shippingOrder')->with(compact('checkouts'));
    }


    public function completeorderList()
    {
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.completeorderList')->with(compact('checkouts'));
    }

     public function listProduct($id){
         $orders = Order::where('checkout_id',$id)->get();
         $invoiceId = $id;
        return view('admin.checkouts.listProduct')->with(compact('orders','invoiceId'));
    }

     public function updateQuantity(Request $request, $rowId, $qty)
    {
        if($request->ajax())
        {
            $orders = Order::find($rowId);
            $orders->update( [
            'qty' => $qty,
            ]);
            print_r(1);
            return ;
        }

        return redirect(route('orders.updateQuantity'));
    }

     public function updatePrice(Request $request, $rowId, $price)
    {
        if($request->ajax())
        {
            $orders = Order::find($rowId);
            $orders->update( [
            'price' => $price,
            ]);
            print_r(1);
            return ;
        }

        return redirect(route('orders.updateQuantity'));
    }

    public function monthlySales($month,Request $request){
            $year = date("Y");
            $monthFrom = $year."-".$month."-01";
            $monthTo = $year."-".$month."-31";

            $monthName = date("F", mktime(0, 0, 0, $month, 10));

            $monthlyIncome =  Transaction::whereBetween('created_at', [$monthFrom, $monthTo])->sum('total');

             $salesbymonth = DB::table('orders')
                ->select('orders.product_id',DB::raw('sum(orders.price*orders.qty) as sum'))
                ->whereBetween('orders.created_at', [$monthFrom, $monthTo])
                ->groupBy('orders.product_id')
                ->orderBy('sum','DESC')
                ->get();

              $monthlySales = [];
            foreach ($salesbymonth as $monthlySale) {
                 $products = Product::where('id',$monthlySale->product_id)->first();
                  $sales = '
                            <tr>
                                <td class="txt-oflo" width="71%">'.$products->name.'</td>
                                <td><span class="text-success">'.$monthlySale->sum.' BDT</span></td>

                            </tr>
                   ';
               array_push($monthlySales, $sales);
            }

        if($request->ajax())
            {
                return response()->json([
                    'monthlySales'=>$monthlySales,
                    'monthlyIncome'=>$monthlyIncome,
                    'monthName'=>$monthName,
                ]);
            }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('frontend.products.checkout');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function billing(Shipping $shipping, Request $request)
    {
        if ($request->session()->exists('shipping') && $request->session()->get('shipping')->id==$shipping->id) {
            return view('frontend.products.checkout')->with(compact('shipping'));
        } else {
            return view('frontend.products.failure');
        }
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /* public function store(Request $request)
    {
        $this->validation($request);
        $carts=Cart::content();
        if(count($carts)==0){
            return back()->with('message', 'You Should Add One or More Product To The Cart');
        }
        $shipping = Shipping::create([
            'name'=>$request->first_name.' '.$request->last_name,
            'mobile'=>$request->mobile,
            'address'=>$request->address,
        ]);
        $request->session()->put('shipping', $shipping);
        return redirect(route('orders.billing', $shipping));
    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout, Request $request)
    {
        $checkout = Checkout::find($request->checkout_id);
        if($request->ajax())
            {
                if($request->option == 'customer')
                    return response()->json([
                        'customer'=>$checkout->customer
                    ]);
                if($request->option == 'order'){
                    $products = Order::select('orders.*', 'products.name', 'products.deal_code')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                        ->where('orders.checkout_id', $request->checkout_id)->get();
                        return response()->json([
                        'products'=>$products
                    ]);
                }

                if($request->option == 'transaction')
                    return response()->json([
                        'payment'=>$checkout->transaction
                    ]);
                if($request->option == 'shipping')
                    return response()->json([
                        'shipping'=>$checkout->shipping
                    ]);
                if($request->option == 'status')
                    return response()->json([
                        'checkout'=>$checkout,
                        'transaction'=>$checkout->transaction->status,
                        'shipping'=>$checkout->shipping->status
                    ]);
            }
        // return "view is not completed yet!! its from controller .";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
   /* public function update(Request $request, Checkout $checkout)
    {
        //
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Request $request)
    {   $shippingInfo = Checkout::where('id',$request->checkout_id)->first();
        if($request->ajax())
        {
            Checkout::where('id',$request->checkout_id)->delete();
            Transaction::where('checkout_id',$request->checkout_id)->delete();
            Order::where('checkout_id',$request->checkout_id)->delete();
            Shipping::where('id',$shippingInfo->shipping_id)->delete();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    /*public function shipping(Checkout $checkout, Request $request)
    {
        $checkout = Checkout::find($request->checkout_id);
        if($request->ajax())
            {
                if($request->option == 'customer')
                    return response()->json([
                        'customer'=>$checkout->customer
                    ]);
                if($request->option == 'order')
                    return response()->json([
                        'products'=>$checkout->orders
                    ]);
                if($request->option == 'transaction')
                    return response()->json([
                        'payment'=>$checkout->transaction
                    ]);
                if($request->option == 'shipping')
                    return response()->json([
                        'shipping'=>$checkout->shipping
                    ]);
                if($request->option == 'status')
                    return response()->json([
                        'checkout'=>$checkout->status,
                        'transaction'=>$checkout->transaction->status,
                        'shipping'=>$checkout->shipping->status
                    ]);
            }
        // return "view is not completed yet!! its from controller .";
    }*/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request)
    {
        $checkout = Checkout::find($request->checkout_id);
        if($request->ajax())
            {

                if($request->option == 'checkout'){
                    if($request->status == 'Waiting') {
                        $checkout->shipping->update(['status'=>'Waiting']);
                        $checkout->update(['status'=>'Waiting']);
                    } else if($request->status == 'Processing') {
                        $checkout->shipping->update(['status'=>'Processing']);
                        $checkout->update(['status'=>'Processing']);
                    } else if($request->status == 'Shipping') {
                        $checkout->shipping->update(['status'=>'Shipping']);
                        $checkout->update(['status'=>'Shipping']);
                    } else if($request->status == 'Complete') {
                        $checkout->transaction->update(['status'=>'Complete']);
                        $checkout->shipping->update(['status'=>'Complete']);
                        $checkout->update(['status'=>'Complete']);
                    }
                }

                $checkout->update();
                return response()->json([
                        'checkout'=>$checkout,
                        'transaction'=>$checkout->transaction,
                        'shipping'=>$checkout->shipping,
                    ]);
            }
        // return "view is not completed yet!! its from controller .";
    }

    public function checkoutPage(){
        return view('frontend.order.checkout');
    }

    public function orderSave(Request $request){
        $customerId = Session::get('customerId');
       /* $this->validate(request(), [
            'fullName' => 'required|string|max:100',
            'email' => 'nullable|string|max:100',
            'phone' => 'required|numeric|max:100',
            'address' => 'required|string|max:150',
        ]);

*/
        $existCustomer = Customer::where('email',$request->email)->orWhere('mobile',$request->phone)->first();
        if($existCustomer){
            $customer = Customer::find($existCustomer->id);
            $customer->update( [
                'name'=>$request->fullName,
                'email'=>$request->email,
                'mobile'=>$request->phone,
                'address'=>$request->address,
            ]);
            }else{
                $customer = Customer::create([
                'name'=>$request->fullName,
                'email'=>$request->email,
                'mobile'=>$request->phone,
                'address'=>$request->address,
            ]);
        }

        $shipping = Shipping::create([
            'name'=>$request->fullName,
            'mobile'=>$request->phone,
            'email'=>$request->email,
            'address'=>$request->address,
        ]);
            $carts=Cart::getContent();
            $checkout = Checkout::create([
                'customer_id'=>$customerId,
                'shipping_id'=>$shipping->id
            ]);

            $total = 0;

            foreach($carts as $cart){
                $product=Product::find($cart->id);
                $order = Order::create([
                    'checkout_id'=>$checkout->id,
                    'product_id'=>$product->id,
                    'qty'=>$cart->qty,
                    'weight'=>'',
                    'price'=>$cart->price,
                    'discount'=>$product->discount,
                ]);

                $total+=$cart->subtotal;
            }
            if($request->payment_method=='bkash') $reference = $request->bkash_number;

            $transaction = Transaction::create([
                'checkout_id'=>$checkout->id,
                'total'=>$total,
                'method'=>$request->payment_method,
                'payment'=>0,
                'reference'=>$customer->id,
            ]);

            Cart::destroy();
            return view('frontend.order.ordersuccess');

    }

    public function invoices($id){
        $company = Settings::first();
        $checkouts = Checkout::where('id',$id)->first();
        $shippings = Shipping::where('id',$checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id',$id)->first();
        $orders = Order::select('orders.*', 'products.name','product_sections.free_shipping', 'products.deal_code')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
                    ->where('orders.checkout_id', $id)
                    ->get();

        return view('admin.checkouts.invoice')->with(compact('shippings','orders','transactions','checkouts','company'));
    }

    public function downloadInvoices($checkoutId){
        $company = Settings::first();
        $checkouts = Checkout::where('id',$checkoutId)->first();
        $shippings = Shipping::where('id',$checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id',$checkoutId)->first();
        $orders = Order::select('orders.*', 'products.name','product_sections.free_shipping', 'products.deal_code')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                     ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
                    ->where('orders.checkout_id', $checkoutId)
                    ->get();
        $pdf = PDF::loadView('admin.checkouts.downloadInvoices',['shippings'=>$shippings,'orders'=>$orders,'transactions'=>$transactions,'checkouts'=>$checkouts,'company'=>$company]);

        return $pdf->download('invoice.pdf');
        }

        public function viewPdf($checkoutId){
        $company = Settings::first();
        $checkouts = Checkout::where('id',$checkoutId)->first();
        $shippings = Shipping::where('id',$checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id',$checkoutId)->first();
        $orders = Order::select('orders.*', 'products.name', 'products.deal_code','product_sections.free_shipping')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
                    ->where('orders.checkout_id', $checkoutId)
                    ->get();
        $pdf = PDF::loadView('admin.checkouts.viewPdf',['shippings'=>$shippings,'orders'=>$orders,'transactions'=>$transactions,'checkouts'=>$checkouts,'company'=>$company]);

        return $pdf->stream('invoice.pdf');
        }

    public function validation(Request $request)
    {
        $this->validate(request(), [
            'first_name' => 'required|string|max:100',
            'mobile' => 'required|string|max:100',
            'email' => 'nullable|string|max:100',
            'address' => 'required|string|max:150',
        ]);
    }
}
