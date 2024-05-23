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
        @php
            use App\CashPurchaseItem;
            use App\CreditPurchaseItem;
            use App\PurchaseOrderItem;
            use App\Product;
            use App\Vendors;
            $supplierList = Vendors::all();
        @endphp

        <table class="companyTable" width="100%" style="border-bottom: 2px solid #000000;">
            <tr>
                <td>
                    <h3>Techno Park Bangladesh</h3>
                    <h5 style="margin-top:-15px; ">DIT Project, Badda, Dhaka</h5>
                    <h5 style="margin-top:-15px; ">Email:technoparkbd@gmail.com</h5>
                </td>
            </tr>
        </table>

        <table class="print-table">
            <caption>
                <h4 style="text-decoration: underline; text-underline-position: under;">
                    Purchase History Report On Date: 9-jun-2018
                </h4>
            </caption>

            <thead>
                <tr>
                    <th>SL</th>
                    <th>Purchase Date</th>
                    <th>Supplier Name</th>
                    <th>Item</th>
                    <th>QTY</th>
                    <th>Price</th>
                    <th>Total Price</th>
                    <th>Purchase Type</th>
                </tr>
            </thead>
                <tbody>
                    @if (@$purchaseLog)
                        @php $i = 0; @endphp

                        @foreach ($purchaseLog as $log)
                            @php
                                $i++;
                                $purchase_date = Date('d-m-Y',strtotime($log->purchase_date));
                                $supplier = Vendors::where('id',$log->supplier_id)->first();
                                if($log->purchase_type == 'cash')
                                {
                                    $ItemDetails = CashPurchaseItem::where('cash_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }

                                if($log->purchase_type == 'credit')
                                {
                                    $ItemDetails = CreditPurchaseItem::where('credit_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }

                                if($log->purchase_type == 'purchase_order')
                                {
                                    $ItemDetails = PurchaseOrderItem::where('purchase_order_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                }
                            @endphp
                                @php
                                    $row = 0;
                                    $rowSpan = count($ItemDetails);
                                @endphp
                                @foreach ($ItemDetails as $item)
                                    @php
                                        $products = Product::where('id',$item->product_id)->first();
                                        $row++;
                                    @endphp

                                    @if ($row == 1)
                                        <tr>
                                            <td rowspan="{{ $rowSpan }}">{{ $i }}</td>
                                            <td rowspan="{{ $rowSpan }}">{{ $purchase_date }}</td>
                                            <td rowspan="{{ $rowSpan }}">{{ @$supplier->vendorName }}</td>
                                            <td>{{$products->name}}</td>
                                            <td style="text-align: right;">{{$item->qty}}</td>
                                            <td style="text-align: right;">{{$item->rate}}</td>
                                            <td style="text-align: right;">{{$item->amount}}</td>
                                            <td rowspan="{{ $rowSpan }}" style="text-align: center;">{{$log->purchase_type}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td>{{$products->name}}</td>
                                            <td style="text-align: right;">{{$item->qty}}</td>
                                            <td style="text-align: right;">{{$item->rate}}</td>
                                            <td style="text-align: right;">{{$item->amount}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                        @endforeach
                    @endif
                </tbody>
        </table>
    </body>
</html>

