<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
    <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
    body {
    font-family: 'common', sans-serif;
}
</style>
</head>

<body>

<?php
    use App\CashPurchaseItem;
   use App\CreditPurchaseItem;
   use App\PurchaseOrderItem;
   use App\Product;
   use App\Vendors;
   $supplierList = Vendors::all();
?>

<table width="100%" class="mainTable">
    <tr>
        <td>
            <table class="companyTable" width="100%">
                <tr>
                    <td>
                        <h3>Techno Park Bangladesh</h3>
                        <h5 style="margin-top:-15px; ">DIT Project, Badda, Dhaka</h5>
                        <h5 style="margin-top:-15px; ">Email:technoparkbd@gmail.com</h5>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td>
            <br>
             <h4 align="center" style="border-bottom: 1px solid #333;width: 350px;margin: 0 auto;">Purchase History Report On Date: 9-jun-2018</h4>
             <br>
                <table border="1">
                        <thead>
                            <tr>
                                <th width="5%">SL</th>
                                <th width="15%">Purchase Date</th>
                                <th width="15%">Supplier Name</th>
                                <th width="30%">Item</th>
                                <th class="center">QTY</th>
                                <th class="center">Price</th>
                                <th width="14%" class="center">Total Price</th>
                                <th width="13%">Purchase Type</th>
                            </tr>
                        </thead>
                        <?php if (@$purchaseLog) { ?>
                        <tbody id="tbody">
                            <?php $i = 0; ?>
                            @foreach($purchaseLog as $log)
                            <?php
                                $i++;
                                $purchase_date = Date('d-m-Y',strtotime($log->purchase_date));
                                $supplier = Vendors::where('id',$log->supplier_id)->first();
                                if($log->purchase_type == 'cash'){
                                $ItemDetails = CashPurchaseItem::where('cash_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }
                                if($log->purchase_type == 'credit'){
                                $ItemDetails = CreditPurchaseItem::where('credit_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }
                                if($log->purchase_type == 'purchase_order'){
                                $ItemDetails = PurchaseOrderItem::where('purchase_order_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }
                             ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $purchase_date }}</td>
                                <td>{{ @$supplier->vendorName }}</td>
                                <td colspan="4">
                                    <table class="itemTable">
                                        <?php foreach ($ItemDetails as $item){
                                           $products = Product::where('id',$item->product_id)->first();
                                         ?>
                                            <tr style="line-height: 4px;">
                                                <td width="52%">{{$products->name}}</td>
                                                <td width="12%" class="center">{{$item->qty}}</td>
                                                <td width="12%" class="center">{{$item->rate}}</td>
                                                <td class="center">{{$item->amount}}</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </td>
                                <td width="13%">{{$log->purchase_type}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    <?php } ?>
                </table>
        </td>

    </tr>
</table>

</body>
</html>

