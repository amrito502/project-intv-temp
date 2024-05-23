<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vendors;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\PurchaseOrderReceive;
use App\PurchaseOrderReceiveItem;
use App\Product;

use DB;
use PDF;
use MPDF;

class PurchaseOrderStatusController extends Controller
{
    public function index(Request $request)
    {
        $title = $this->title;

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $supplier = $request->supplier;

        $poStatus = array();

        $vendors = Vendors::orderBy('vendorName', 'asc')->get();

        $poStatus = DB::table('purchase_order_status')
            ->select('purchase_order_status.supplierId', 'purchase_order_status.productId', 'purchase_order_status.orderNo', DB::raw('sum(purchase_order_status.orderQty) as orderQty'), DB::raw('sum(purchase_order_status.receiveQty) as receiveQty'), 'products.name as productName')
            ->join('products', 'products.id', '=', 'purchase_order_status.productId')
            ->orWhere(function ($cashQuery) use ($fromDate, $toDate, $supplier) {
                if (!empty($fromDate)) {
                    $cashQuery->whereBetween('purchase_order_status.date', array($fromDate, $toDate));
                }

                if (@$supplier) {
                    $cashQuery->whereIn('purchase_order_status.supplierId', $supplier);
                }
            })
            ->groupBy('purchase_order_status.supplierId', 'purchase_order_status.orderNo', 'products.name')
            ->orderBy('purchase_order_status.orderNo')
            ->orderBy('products.id')
            ->get();

        return view('admin.purchaseOrderStatus.index')->with(compact('title', 'vendors', 'poStatus', 'supplier', 'fromDate', 'toDate'));
    }

    public function print(Request $request)
    {
        $title = "Print Purchase Order Status";

        $fromDate = Date('Y-m-d', strtotime($request->from_date));
        $toDate = Date('Y-m-d', strtotime($request->to_date));

        $supplier = $request->supplier;

        $poStatus = array();

        $poStatus = DB::table('purchase_order_status')
            ->select('purchase_order_status.supplierId', 'purchase_order_status.orderNo', DB::raw('sum(purchase_order_status.orderQty) as orderQty'), DB::raw('sum(purchase_order_status.receiveQty) as receiveQty'), 'products.name as productName')
            ->join('products', 'products.id', '=', 'purchase_order_status.productId')
            ->orWhere(function ($cashQuery) use ($fromDate, $toDate, $supplier) {
                if (!empty($fromDate)) {
                    $cashQuery->whereBetween('purchase_order_status.date', array($fromDate, $toDate));
                }

                if (@$supplier) {
                    $cashQuery->whereIn('purchase_order_status.supplierId', $supplier);
                }
            })
            ->groupBy('purchase_order_status.supplierId', 'purchase_order_status.orderNo', 'products.name')
            ->orderBy('purchase_order_status.orderNo')
            ->orderBy('products.id')
            ->get();

        $pdf = PDF::loadView('admin.purchaseOrderStatus.print', ['title' => $title, 'fromDate' => $fromDate, 'toDate' => $toDate, 'poStatus' => $poStatus]);

        return $pdf->stream('purchase_order_status_' . $fromDate . '_to_' . $toDate . '.pdf');
    }
}
