<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use Cart;
use Session;
use App\Order;
use App\Product;
use App\Checkout;
use App\Customer;
use App\Settings;
use App\Shipping;
use App\Transaction;
use App\CustomerAddress;
use App\ProductSections;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $title = "Manage Orders";
        $checkouts = Checkout::latest()->get();
        return view('admin.checkouts.index')->with(compact('title', 'checkouts'));
    }


    public function create()
    {

        return view('frontend.products.checkout');
    }

    public function show(Checkout $checkout)
    {
    }

    public function edit(Checkout $checkout, Request $request)
    {
        $checkout = Checkout::find($request->checkout_id);
        if ($request->ajax()) {
            if ($request->option == 'customer')
                return response()->json([
                    'customer' => $checkout->customer
                ]);
            if ($request->option == 'order') {
                $products = Order::select('orders.*', 'products.name', 'products.deal_code')
                    ->join('products', 'products.id', '=', 'orders.product_id')
                    ->where('orders.checkout_id', $request->checkout_id)->get();
                return response()->json([
                    'products' => $products
                ]);
            }

            if ($request->option == 'transaction')
                return response()->json([
                    'payment' => $checkout->transaction
                ]);
            if ($request->option == 'shipping')
                return response()->json([
                    'shipping' => $checkout->shipping
                ]);

            $courierName = "None";

            if ($checkout->courier !== null) {
                $courierName = $checkout->courier->name;
            }

            if ($request->option == 'status')
                return response()->json([
                    'courier_name' => $courierName,
                    'checkout' => $checkout,
                    'transaction' => $checkout->transaction->status,
                    'shipping' => $checkout->shipping->status
                ]);
        }
        // return "view is not completed yet!! its from controller .";
    }


    public function status(Request $request)
    {
        $checkout = Checkout::find($request->checkout_id);

        if ($request->ajax()) {
            $courier = $checkout->courier_id;

            if ($request->courier_id != "") {
                $courier = $request->courier_id;
            }

            if ($request->option == 'checkout') {
                if ($request->status == 'Waiting') {
                    $checkout->shipping->update(['status' => 'Waiting']);
                    $checkout->update(['status' => 'Waiting', 'courier_id' => $request->courier_id,]);
                } else if ($request->status == 'Processing') {
                    $checkout->shipping->update(['status' => 'Processing']);
                    $checkout->update(['status' => 'Processing', 'courier_id' => $request->courier_id,]);
                } else if ($request->status == 'Shipping') {
                    $checkout->shipping->update(['status' => 'Shipping']);
                    $checkout->update(['status' => 'Shipping', 'courier_id' => $request->courier_id,]);
                } else if ($request->status == 'Cancel') {
                    $checkout->shipping->update(['status' => 'Cancel']);
                    $checkout->update(['status' => 'Cancel', 'courier_id' => $request->courier_id,]);
                } else if ($request->status == 'Return') {
                    $checkout->shipping->update(['status' => 'Return']);
                    $checkout->update(['status' => 'Return', 'courier_id' => $request->courier_id,]);
                } else if ($request->status == 'Complete') {
                    $checkout->transaction->update(['status' => 'Complete']);
                    $checkout->shipping->update(['status' => 'Complete']);
                    $checkout->update(['status' => 'Complete', 'courier_id' => $request->courier_id,]);

                    $userId = User::where('id', $checkout->customer->user_id)->first();
                    if ($userId) {
                        Wallet::create([
                            'from_id' => $userId->id,
                            'pp' => $checkout->pp,
                            'remarks' => 'Purchase Point',
                            'status' => 1,
                        ]);
                    }
                }
            }

            $checkout->update();

            return response()->json([
                'checkout' => $checkout,
                'transaction' => $checkout->transaction,
                'shipping' => $checkout->shipping,
                'courier_id' => $request->courier_id,
            ]);
        }
        // return "view is not completed yet!! its from controller .";
    }

    public function checkoutPage()
    {
        $customerId = 0;

        if (Auth::guard('customer')->check()) {
            $customerId = Auth::guard('customer')->user()->id;
        }

        if ($customerId) {
            // $customer = Customer::findOrFail(Session::get('customerId'));
            return redirect(route('order.save'));
        }

        return view('frontend.pages.checkout');
    }

    public function orderSave(Request $request)
    {

        $carts = Cart::getContent();
        $customer = Auth::guard('customer')->user();


        // return back if no cart product

        if (!$carts->count()) {
            return back()->with('class_name', 'danger')->with('msg', 'Please Add Product to Cart');
        }


        // dd($request->all());

        //Guest Customer
        if ($request->guestPhone) {
            $checkCustomerMobile = Customer::where('mobile', $request->guestPhone)->first();
            $checkCustomerEmail = Customer::where('mobile', $request->guestEmail)->first();

            if ($checkCustomerMobile) {
                $checkCustomerMobile->update([
                    'name' => $request->guestName,
                    'email' => $request->guestEmail,
                    'mobile' => $request->guestPhone,
                ]);
                $customer = $checkCustomerMobile;
            } elseif ($checkCustomerEmail) {
                $checkCustomerEmail->update([
                    'name' => $request->guestName,
                    'email' => $request->guestEmail,
                    'mobile' => $request->guestPhone,
                ]);
                $customer = $checkCustomerEmail;
            } else {
                $customer = Customer::create([
                    'name' => $request->guestName,
                    'email' => $request->guestEmail,
                    'mobile' => $request->guestPhone,
                ]);
            }

            Auth::guard('customer')->loginUsingId($customer->id);
        }




        // if request has phone number and
        if ($request->customerPhone) {
            $customer = Customer::find($customer->id);

            $customer->update([
                'mobile' => $request->customerPhone,
            ]);
        }


        // fetch selected Addresses from
        if ($request->selectedAddress) {
            $address = CustomerAddress::findOrFail($request->selectedAddress);
        } else {
            $address = CustomerAddress::create([
                'customer_id' => $customer->id,
                'address' => $request->guestAddress,
            ]);
        }


        if (!empty($request->discount) && $request->discount > 0) {
            $discount = $request->discount;
        } else {
            $discount = 0;
        }


        $shipping = Shipping::create([
            'name' => $customer->name,
            'mobile' => $customer->mobile,
            'email' => $customer->email,
            'address' => $address->address,
            'comment' => $request->comment,
        ]);


        $checkout = Checkout::create([
            'customer_id' => $customer->id,
            'shipping_id' => $shipping->id,
            'discount' => $discount,
            'shipping_charge' => $request->shipping,
        ]);


        $total = 0;
        $totalPP = 0;

        foreach ($carts as $cart) {

            $product = Product::find($cart->id);
            $order = Order::create([
                'checkout_id' => $checkout->id,
                'product_id' => $product->id,
                'qty' => $cart->quantity,
                'weight' => '',
                'price' => $cart->price,
                'discount' => $product->discount,
                'vat' => $cart->attributes->vat,
                'pp' => $cart->attributes->pp * $cart->quantity
            ]);

            $total += ($cart->subtotal + $cart->attributes->vat);
            $totalPP += $cart->attributes->pp * $cart->quantity;
        }
        $checkout->update([
            'pp' => $totalPP
        ]);


        $total -= $discount;
        $total += floatval($checkout->shipping_charge);

        if ($request->payment_method == 'bkash') $reference = $request->bkash_number;

        $transaction = Transaction::create([
            'checkout_id' => $checkout->id,
            'total' => $total,
            'method' => $request->payment_method,
            'payment' => 0,
            'reference' => $customer->id,
        ]);

        // dd($checkout);

        Cart::clear();

        // return view('frontend.order.ordersuccess');
        return view('frontend.pages.complete_order');
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
