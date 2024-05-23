<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet">
</head>
<body>
<?php
    use App\ShippingCharges;
    $invoice_date = $checkouts->created_at->format('d-m-Y');
    $invoice_no = 10000000 + $checkouts->id;
?>
<table style="width: 100%">
    <tbody>
        <tr>
            <td><img src="{{ asset('/').@$company->adminLogo }}" style="width:60px; height: 60px"/></td>
            <td align="right"><h2 style="margin: 0; font-size: 40px; font-weight: 300; text-align: right; color: #828282;">INVOICE</h2></td>
        </tr>
    </tbody>
</table>
<hr style="padding:0; margin: 0 0 10px 0;">
    <table width="100%">
        <tbody>
            <tr>
                <td width="70%">{{ $company->siteName }}</td>
                <td><strong>Invoice Date:</strong> {{ $invoice_date }}</td>
            </tr>
            <tr>
                <td width="70%">{{ $company->siteAddress1 }}</td>
                <td><strong>Order No:</strong> #{{ $invoice_no }}</td>
            </tr>
            <tr>
                <td colspan="2">Telephone {{ $company->mobile1 }}</td>
            </tr>
            <tr>
                <td colspan="2">{{ $company->siteEmail1 }}</td>
            </tr>
            <tr>
                <td colspan="2">https://www.leadmartbd.com/</td>
            </tr>
        </tbody>
    </table>

    <table class="invoice-table-address">
        <thead>
            <tr>
                <th width="50%">To</th>
                <th width="50%">Ship To (if different address)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    {{ $shippings->name }} <br>
                    {{ $shippings->address }} <br>
                    {{ $shippings->mobile }}
                </td>
                <td>
                    {{ $shippings->name }} <br>
                    {{ $shippings->address }} <br>
                    {{ $shippings->mobile }}
                </td>
            </tr>
        </tbody>
    </table>

    <table class="product-table">
        <thead>
            <tr>
                <th align="left" width="35%">Product</th>
                <th width="10%">Qty</th>
                <th width="20%">Unit Price</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $subtotal = 0;
        $totalVat = 0;
        ?>
        @foreach($orders as $orderdetails)
        <?php
            $subtotal += $orderdetails->price * $orderdetails->qty;
            $vat = $orderdetails->vat * $orderdetails->qty;
            $totalVat += $vat;
        ?>
            <tr>
                <td>{{ $orderdetails->name }}</td>
                <td align="center">{{ $orderdetails->qty }}</td>
                <td align="right">BDT : {{ number_format($orderdetails->price, 2, '.', ',') }}</td>
                <td align="right">BDT : {{ number_format(($orderdetails->price * $orderdetails->qty), 2, '.', ',') }}</td>
            </tr>
        @endforeach
            <tr>
                <td colspan="3" align="right"><strong>Sub-Total:</strong></td>
                <td align="right">BDT : {{ number_format($subtotal, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><strong>Vat (5%):</strong></td>
                <td align="right">BDT : {{ number_format($totalVat, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><strong>Shipping Charge:</strong></td>
                <td align="right">BDT : {{ number_format($checkouts->shipping_charge, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td align="right">BDT : {{ number_format(($subtotal + $totalVat + $checkouts->shipping_charge), 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>


    <table class="product-table">
        <thead>
            <tr>
                <th align="left">Customer's order comment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $checkouts->comment }}</td>
            </tr>
        </tbody>
    </table>


    <style>

     .invoice-table-address{
     	border-collapse: collapse;
     	width: 100%;
     	margin-top: 40px;
     }

     .invoice-table-address th {
     	padding: 3px 3px;
     	font-size: 13px;
     	text-align: left;
     	/*border-top: 1px solid black;*/
     	border: 1px solid #ababab;
     	color: black;
     }

     .invoice-table-address td,
     .product-table td {
     	padding: 5px 3px;
     	font-size: 14px;
     	border: 1px solid #ababab;
     }

     .invoice-table-address,
     .product-table {
     	border-collapse: collapse;
     	width: 100%;
     	margin-top: 20px;
     }

     .product-table th {
     	padding: 3px 3px;
     	font-size: 13px;
     	text-align: center;
     	border: 1px solid #ababab;
     	color: black;
     }


    </style>
</body>
</html>

