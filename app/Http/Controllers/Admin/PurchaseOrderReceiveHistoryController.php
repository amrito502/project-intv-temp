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

class PurchaseOrderReceiveHistoryController extends Controller
{
    public function index(Request $request)
    {
    	$title = "Purchase Order Receive Controller";

        $fromDate = Date('Y-m-d',strtotime($request->from_date));
        $toDate = Date('Y-m-d',strtotime($request->to_date));

        $supplier = $request->supplier;

        $previousBalances = array();
        $supplierStatements = array();

        $vendors = Vendors::orderBy('vendorName','asc')->get();

        $query = DB::select(
        	"
        	SELECT `purchase_orders`.`supplier_id` AS `supplierId`, `purchase_orders`.`order_no` AS `orderNo`,`purchase_orders`.`order_date` AS `date`,`purchase_order_items`.`product_id` AS `productId`,`purchase_order_items`.`qty` AS orderQty, 0 AS `receiveQty`
        	FROM `purchase_orders`
        	INNER JOIN `purchase_order_items` ON `purchase_order_items`.`purchase_order_id` = `purchase_orders`.`id`

        	UNION ALL

        	SELECT `purchase_orders`.`supplier_id` AS `supplierId`,`purchase_orders`.`order_no` AS `orderNo`,`purchase_order_receives`.`receive_date` AS `date`,`purchase_order_receive_items`.`product_id` AS `productId`,0 AS `orderQty`,`purchase_order_receive_items`.`qty` AS receiveQty
        	FROM `purchase_order_receives`
        	INNER JOIN `purchase_order_receive_items` ON `purchase_order_receive_items`.`purchase_order_receive_id` = `purchase_order_receives`.`id`
        	INNER JOIN `purchase_orders` ON `purchase_orders`.`id` = `purchase_order_receives`.`purchaseOrderNo`
        	"
        );

    	return view('admin.purchaseOrderReceiveHistory.index')->with(compact('title','vendors','supplier','fromDate','toDate','query'));
    }
}
