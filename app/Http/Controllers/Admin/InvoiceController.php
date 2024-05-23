<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Order;
use App\Product;
use App\Settings;
use App\Checkout;
use App\Shipping;
use App\Transaction;
use App\ProductSections;
use PDF;

class InvoiceController extends Controller
{
	public function addtoInvoice($orderId)
    {
		$orderInfo = Order::where('id',$orderId)->first();
		$products = Product::where('id',$orderInfo->product_id)->first();
		$productAmount = $orderInfo->qty*$orderInfo->price;
		$invoices = Invoice::create([
                    'invoiceId'=>$orderInfo->checkout_id,
                    'orderId'=>$orderId,
                    'productCode'=>$products->deal_code,
                    'productName'=>$products->name,
                    'productQuantity'=>$orderInfo->qty,
                    'productPrice'=>$orderInfo->price,
                    'productAmount'=>$productAmount,
                ]);

		return redirect(url('/admin/list-product/'.$orderInfo->checkout_id))->with('msg','Added Invoices Successfully');
	}


	public function viewInvoice($invoiceId)
    {
        $title = "View Invoice";
		$company = Settings::first();
        $checkouts = Checkout::where('id',$invoiceId)->first();
        $shippings = Shipping::where('id',$checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id',$invoiceId)->first();
        $orders = Invoice::select('invoices.*','product_sections.free_shipping')
                    ->join('products', 'products.deal_code', '=', 'invoices.productCode')
                    ->join('product_sections', 'product_sections.productId', '=', 'products.id')
                    ->where('invoices.invoiceId', $invoiceId)
                    ->get();

        return view('admin.orders.invoices.viewInvoice')->with(compact('title','shippings','orders','transactions','checkouts','company'));
	}

	public function manualInvoicePdf($invoiceId){
        $company = Settings::first();
        $checkouts = Checkout::where('id',$invoiceId)->first();
        $shippings = Shipping::where('id',$checkouts->shipping_id)->first();
        $transactions = Transaction::where('checkout_id',$invoiceId)->first();
        $orders = Invoice::select('invoices.*','product_sections.free_shipping')
                    ->join('products', 'products.deal_code', '=', 'invoices.productCode')
                    ->join('product_sections', 'product_sections.productId', '=', 'products.id')
                    ->where('invoices.invoiceId', $invoiceId)
                    ->get();

        $pdf = PDF::loadView('admin.orders.invoices.manualInvoicePdf',['shippings'=>$shippings,'orders'=>$orders,'transactions'=>$transactions,'checkouts'=>$checkouts,'company'=>$company]);

        return $pdf->stream('invoice.pdf');
        }

    public function deletefromInvoice($orderId){
    	$orderInfo = Order::where('id',$orderId)->first();
        Invoice::where('orderId',$orderId)->delete();

        return redirect(url('/admin/list-product/'.$orderInfo->checkout_id))->with('msg','Added Invoices Successfully');
    }

}
