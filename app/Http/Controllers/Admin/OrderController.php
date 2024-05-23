<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use App\Order;
use App\Courier;
use App\Product;
use App\Checkout;
use App\Customer;
use App\Settings;
use App\Shipping;
use App\Transaction;
use App\ProductSections;
use App\OnlineCollection;
use App\Models\MemberSale;
use Illuminate\Http\Request;
use App\CustomerRequestItemList;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function CustomerRequestItemList()
    {
        $title = "Customer Sleep Request List";
        $customerItemRequestList = CustomerRequestItemList::orderBy('id', 'dsc')->get();
        return view('admin.customers_item_request.index')->with(compact('title', 'customerItemRequestList'));
    }

    public function CustomerRequestItemDetails($id)
    {
        $title = "Customer Sleep Request Details";
        $customerItemRequest = CustomerRequestItemList::where('id', $id)->first();
        return view('admin.customers_item_request.details')->with(compact('title', 'customerItemRequest'));
    }

    public function CustomerRequestItemDelete(Request $request)
    {
        $customerItemRequest =  CustomerRequestItemList::find($request->customerItemRequestId);
        @unlink($customerItemRequest->itemList);
        $customerItemRequest->delete();
    }

    public function purchaseList()
    {

        $title = "My Purchase";

        // get this user customer id
        $customer = Auth::user()->CustomerAccount;

        $memberSales = MemberSale::with(['customer', 'items', 'items.product'])
            ->where('customer_id', $customer->id)
            ->orderBy('id', 'DESC')
            ->get();

        return view('admin.orders.purchaseList')->with(compact('title', 'memberSales'));
    }

    public function purchaseListPrint()
    {

        $title = "Purchase List";

        // get this user customer id
        $customer = Auth::user()->CustomerAccount;

        $memberSales = MemberSale::with(['customer', 'items', 'items.product'])
            ->where('customer_id', $customer->id)
            ->orderBy('id', 'DESC')
            ->get();

        $pdf = PDF::loadView('admin.orders.purchaseList_print', ['title' => $title, 'memberSales' => $memberSales]);

        return $pdf->stream('purchaseList.pdf');

        // purchaseList_print
    }

    public function neworderList()
    {
        $title = $this->title;
        $checkouts = Checkout::latest()->get();
        $couriers = Courier::all();
        return view('admin.orders.neworderList')->with(compact('title', 'checkouts', 'couriers'));
    }

    public function processingOrder()
    {
        $title = $this->title;
        $checkouts = Checkout::latest()->get();
        $couriers = Courier::all();
        return view('admin.orders.processingOrder')->with(compact('title', 'checkouts', 'couriers'));
    }

    public function shippingOrder()
    {
        $title = $this->title;
        $checkouts = Checkout::latest()->get();
        $couriers = Courier::all();
        return view('admin.orders.shippingOrder')->with(compact('title', 'checkouts', 'couriers'));
    }


    public function completeorderList()
    {
        $title = $this->title;
        $checkouts = Checkout::latest()->get();
        $couriers = Courier::all();
        return view('admin.orders.completeorderList')->with(compact('title', 'checkouts', 'couriers'));
    }

    public function listProduct($id)
    {
        $title = "Order List";
        $orders = Order::where('checkout_id', $id)->get();
        $invoiceId = $id;
        return view('admin.orders.listProduct')->with(compact('title', 'orders', 'invoiceId'));
    }

    public function updateQuantity(Request $request, $rowId, $qty)
    {
        if ($request->ajax()) {
            $orders = Order::find($rowId);
            $orders->update([
                'qty' => $qty,
            ]);

            return;
        }

        return redirect(route('orders.updateQuantity'));
    }

    public function updatePrice(Request $request, $rowId, $price)
    {
        if ($request->ajax()) {
            $orders = Order::find($rowId);
            $orders->update([
                'price' => $price,
            ]);
            print_r(1);
            return;
        }

        return redirect(route('orders.updateQuantity'));
    }

    public function monthlySales($month, Request $request)
    {
        $year = date("Y");
        $monthFrom = $year . "-" . $month . "-01";
        $monthTo = $year . "-" . $month . "-31";

        $monthName = date("F", mktime(0, 0, 0, $month, 10));

        $monthlyIncome =  Transaction::whereBetween('created_at', [$monthFrom, $monthTo])->sum('total');

        $salesbymonth = DB::table('orders')
            ->select('orders.product_id', DB::raw('sum(orders.price) as sum'))
            ->whereBetween('orders.created_at', [$monthFrom, $monthTo])
            ->groupBy('orders.product_id')
            ->orderBy('sum', 'DESC')
            ->get();

        $monthlySales = [];
        foreach ($salesbymonth as $monthlySale) {
            $products = Product::where('id', $monthlySale->product_id)->first();
            $sales = '
                            <tr>
                                <td class="txt-oflo" width="71%">' . $products->name . '</td>
                                <td><span class="text-success">' . $monthlySale->sum . ' BDT</span></td>

                            </tr>
                   ';
            array_push($monthlySales, $sales);
        }

        if ($request->ajax()) {
            return response()->json([
                'monthlySales' => $monthlySales,
                'monthlyIncome' => $monthlyIncome,
                'monthName' => $monthName,
            ]);
        }
    }

    public function deleteOrder(Request $request)
    {
        $shippingInfo = Checkout::where('id', $request->checkout_id)->first();
        if ($request->ajax()) {
            Checkout::where('id', $request->checkout_id)->delete();
            Transaction::where('checkout_id', $request->checkout_id)->delete();
            Order::where('checkout_id', $request->checkout_id)->delete();
            Shipping::where('id', $shippingInfo->shipping_id)->delete();
        }
    }

    public function invoices($id)
    {
        $title = "View Invoice";
        $company = Settings::first();
        $checkouts = Checkout::where('id', $id)->first();
        $shippings = Shipping::where('id', $checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id', $id)->first();
        $orders = Order::select('orders.*', 'products.name', 'product_sections.free_shipping', 'products.deal_code')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
            ->where('orders.checkout_id', $id)
            ->get();

        return view('admin.orders.invoice')->with(compact('title', 'shippings', 'orders', 'transactions', 'checkouts', 'company'));
    }

    public function downloadInvoices($checkoutId)
    {
        $company = Settings::first();
        $checkouts = Checkout::where('id', $checkoutId)->first();
        $shippings = Shipping::where('id', $checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id', $checkoutId)->first();
        $orders = Order::select('orders.*', 'products.name', 'product_sections.free_shipping', 'products.deal_code')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
            ->where('orders.checkout_id', $checkoutId)
            ->get();

        $pdf = PDF::loadView('admin.orders.downloadInvoices', ['shippings' => $shippings, 'orders' => $orders, 'transactions' => $transactions, 'checkouts' => $checkouts, 'company' => $company]);

        return $pdf->download('invoice.pdf');
    }

    public function viewPdf($checkoutId)
    {
        $company = Settings::first();
        $checkouts = Checkout::where('id', $checkoutId)->first();
        $shippings = Shipping::where('id', $checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id', $checkoutId)->first();
        $orders = Order::select('orders.*', 'products.name',  'product_sections.free_shipping')
            ->join('products', 'products.id', '=', 'orders.product_id')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('product_sections', 'product_sections.productId', '=', 'orders.product_id')
            ->where('orders.checkout_id', $checkoutId)
            ->get();

        // dd($orders);

        $pdf = PDF::loadView('admin.orders.viewPdf', ['shippings' => $shippings, 'orders' => $orders, 'transactions' => $transactions, 'checkouts' => $checkouts, 'company' => $company]);

        return $pdf->stream('invoice.pdf');
    }

    public function deleteOrderitem(Request $request)
    {
        Order::findOrFail($request->item_id)->delete();
    }

    public function onlineCollection()
    {
        $title = $this->title;
        $couriers = Courier::all();
        $orders = Order::with(['checkout'])->groupBy('checkout_id')->get();

        $completedOrders = [];

        foreach ($orders as $order) {
            if ($order->checkout->status == "Complete" && $order->checkout->paid == 0) {
                array_push($completedOrders, $order);
            }
        }

        return view('admin.orders.online_collection')->with(compact('title', 'completedOrders', 'couriers'));
    }

    public function onlineCollectionSave(Request $request)
    {
        if (!$request->has('checkout_id')) {
            return back()->with('msg', 'Please Select At least one Invoice');
        }

        // dd($request);

        foreach ($request->checkout_id as $checkOut_id) {

            // change checkout paid flag to 1
            $checkout = Checkout::findOrFail($checkOut_id);
            $checkout->update([
                'paid' => 1,
            ]);

            // add online collection

            // dd($request->checkout_receive[$checkOut_id]);

            OnlineCollection::create([
                'checkout_id' => $checkOut_id,
                'receive_amount' => $request->checkout_receive[$checkOut_id],
                'colleted_by' => Auth::user()->id,
            ]);

            // dd($checkOut);
        }

        return back();
    }

    public function courierWiseCheckouts(Request $request)
    {
        if ($request->ajax()) {

            $orders = Order::with(['checkout.shipping', 'checkout.transaction'])->groupBy('checkout_id')->get();

            $completedOrders = [];

            foreach ($orders as $order) {
                if ($order->checkout->status == "Complete" && $order->checkout->paid == 0 && $order->checkout->courier_id == $request->courier_id) {
                    array_push($completedOrders, $order);
                }
            }

            return $completedOrders;
        }
    }
}
