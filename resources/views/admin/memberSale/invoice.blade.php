<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet">
</head>

<body>
    @php
    use App\Settings;
    use App\ShippingCharges;
    use App\helperClass;


    $settings = Settings::first();
    // $invoice_date = $checkouts->created_at->format('d-m-Y');
    // $invoice_no = 10000000 + $checkouts->id;

    $invoice_no = $memberSale->invoice_no;
    @endphp

    <table style="width: 100%">
        <tbody>
            <tr>
                <td><img src="{{ asset('/').@$information->adminLogo }}" style="width:200px; height: 60px" /></td>
                <td align="right">
                    <h2 style="margin: 0; font-size: 40px; font-weight: 300; text-align: right; color: #828282;">INVOICE
                    </h2>
                </td>
            </tr>
        </tbody>
    </table>
    <hr style="padding:0; margin: 0 0 10px 0;">
    <table width="100%">
        <tbody>
            <tr>
                <td width="70%">{{ $memberSale->customer->name }} ({{ $memberSale->customer->username }})</td>
                <td style="text-align:right;"><strong>Invoice Date:</strong> {{ date('d-m-Y',
                    strtotime($memberSale->invoice_date)) }}</td>
            </tr>
            <tr>
                <td width="70%">{{ $memberSale->customer->mobile }}</td>
                <td style="text-align:right;"><strong>Invoice No:</strong> #{{ $invoice_no }}</td>
            </tr>
        </tbody>
    </table>


    <table class="product-table">
        <thead>
            <tr>
                <th align="left" width="35%">Description</th>
                <th width="10%">Qty</th>
                <th>Rate</th>
                <th width="15%">Amount</th>
                <th>PP</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalItemQty = 0;
            $subtotal = 0;
            $totalPurchasePoint = 0;
            ?>
            @foreach($memberSaleItems as $memberSaleItem)
            <?php
            $totalItemQty += $memberSaleItem->item_quantity;
            $totalPurchasePoint += $memberSaleItem->pp;
            $subtotal += $memberSaleItem->item_rate * $memberSaleItem->item_quantity;

        ?>
            <tr>
                <td>{{ $memberSaleItem->product_name }}</td>
                <td align="center">{{ $memberSaleItem->item_quantity }}</td>
                <td align="right">{{ number_format($memberSaleItem->item_rate, 2, '.', ',') }}</td>
                <td align="right">{{ number_format(($memberSaleItem->item_rate * $memberSaleItem->item_quantity), 2, '.', ',') }}
                </td>
                <td align="right">{{ $memberSaleItem->pp }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <table style="margin-top: 10px;float:right;overflow:hidden;">
        <tbody>
            <tr>

                <td width="150px;">Total Qty</td>
                <td> - </td>
                <td align="right" width="60px">{{ $totalItemQty }}</td>
            </tr>

            <tr>
                <td width="150px;">Total PP</td>
                <td> - </td>
                <td width="60px;" align="right">{{ $totalPurchasePoint }}</td>
            </tr>

            <tr>
                <td width="150px;">Total Amount</td>
                <td> - </td>
                <td width="60px;" align="right">{{ $subtotal }}</td>
            </tr>
{{--
            <tr>
                <td width="150px;">Net Payable</td>
                <td> - </td>
                <td width="60px;" align="right">{{ $subtotal }}</td>
            </tr> --}}

        </tbody>
    </table>


    <div style="margin-top:100px;">
        In Word: {{ helperClass::numberToWords($subtotal) }}
    </div>


    <div style="margin-top:50px;">
        <table style="text-align: center;" width="100%">
            <tr>
                <td>
                    ---------------------
                </td>
                <td>
                    ---------------------
                </td>
                <td>
                    ---------------------
                </td>
            </tr>
            <tr>
                <td>
                    Prepared By
                </td>
                <td>
                    Authorized By
                </td>
                <td>
                    Received By
                </td>
            </tr>
        </table>
    </div>


    <footer>
        <p style="text-align: right">Print Time: {{ Carbon\Carbon::parse(now())->format('d-m-Y h:i:s') }}</p>
    </footer>



    <style>
        .invoice-table-address {
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
