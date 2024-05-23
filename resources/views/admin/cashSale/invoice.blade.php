
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link href="{{ asset('admin-elite/dist/css/prints.css') }}" rel="stylesheet">

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
</head>

<body>
    @php
    use App\Settings;
    use App\ShippingCharges;
    use App\helperClass;

    $settings = Settings::first();
    // $invoice_date = $checkouts->created_at->format('d-m-Y');
    // $invoice_no = 10000000 + $checkouts->id;

    $invoice_no = $cashSale->invoice_no;

    if($cashSale->dealer->is_agent){
    $commissionAmount = 0.32;
    }

    if($cashSale->dealer->is_founder){
    $commissionAmount = 0.48;
    }

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
                <td width="70%"><strong>Name:</strong> {{ $cashSale->dealer->username }}</td>
                <td style="text-align:right;"><strong>Invoice Date:</strong> {{ date('d-m-Y',
                    strtotime($cashSale->invoice_date)) }}</td>
            </tr>
            <tr>
                <td width="70%"><strong>Mobile:</strong> {{ $cashSale->dealer->mobile }}</td>
                <td style="text-align:right;"><strong>Invoice No:</strong> #{{ $invoice_no }}</td>
            </tr>
            <tr>
                <td width="70%"><strong>Address:</strong> {{ @$cashSale->dealer->district->name }}, {{ @$cashSale->dealer->thana->name }}</td>
                {{-- <td style="text-align:right;"><strong>Invoice No:</strong> #{{ $invoice_no }}</td> --}}
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
                <th width="20%">Commission</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $subtotal = 0;
        $itemQty = 0;
        $totalPurchasePoint = 0;
        $totalCommission = 0;
        ?>
            @foreach($cashSaleItems as $cashSaleItem)
            <?php
            $itemRate = $cashSaleItem->item_rate;
            $itemDealerRate = $cashSaleItem->item_dealer_price / $cashSaleItem->item_quantity;
            $purchasePoint = $cashSaleItem->pp * $cashSaleItem->item_quantity;

            $itemQty += $cashSaleItem->item_quantity;
            $totalPurchasePoint += $purchasePoint;
            $totalCommission += $purchasePoint * $commissionAmount;
            $subtotal += $cashSaleItem->item_rate * $cashSaleItem->item_quantity;
            ?>
            <tr>
                <td>{{ $cashSaleItem->product_name }} {{ $cashSaleItem->code }}</td>
                <td align="center">{{ $cashSaleItem->item_quantity }}</td>
                <td align="right">{{ number_format($cashSaleItem->item_rate, 2, '.', ',') }}</td>
                <td align="right">{{ number_format(($cashSaleItem->item_quantity * $cashSaleItem->item_rate), 2, '.',
                    ',') }}
                <td align="right">{{ number_format($purchasePoint, 2, '.', ',') }}</td>
                <td align="right">{{ number_format($purchasePoint * $commissionAmount, 2, '.', ',') }}</td>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>


    <table style="margin-top: 10px;float:right;overflow:hidden;">
        <tbody>
            <tr>

                <td width="150px;">Total Qty</td>
                <td> - </td>
                <td align="right" width="60px">{{ $itemQty }}</td>
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

            <tr>
                <td width="150px;">Total Commission</td>
                <td> - </td>
                <td width="60px;" align="right">{{ $totalCommission }}</td>
            </tr>

            <tr>
                <td width="150px;">Net Payable</td>
                <td> - </td>
                <td width="60px;" align="right">{{ $subtotal - $totalCommission }}</td>
            </tr>

        </tbody>
    </table>

    <div style="margin-top:130px;">
        In Word: {{ helperClass::numberToWords($subtotal - $totalCommission) }}
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

    <p style="margin-top: 30px;">Print Time: {{ Carbon\Carbon::parse(now())->format('d-m-Y h:i:s') }}</p>

    {{-- <footer>
        <p style="text-align: right">Print Time: {{ Carbon\Carbon::parse(now())->format('d-m-Y h:i:s') }}</p>
    </footer> --}}


</body>

</html>
