@extends('admin.layouts.print.printApp')

@section('content')

<p style="text-align: center;text-decoration: underline;margin-top: 0;margin-bottom: 20;">Stock Status Report.
    @if (date('d-m-Y', strtotime($fromDate)) != "01-01-1970")
    From {{ date('d-m-Y', strtotime($fromDate)) }} to {{ date('d-m-Y', strtotime($toDate)) }}
    @endif
</p>

<table class="print-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Category</th>
            <th>Product (code)</th>
            <th>Opening</th>
            <th>Purchase Qty</th>
            <th>Purchase Return</th>
            <th>Sales Qty</th>
            <th>Sales Return</th>
            <th>Balance</th>
            <th>PP Value</th>
        </tr>
    </thead>
    <tbody id="tbody">
        @php
        $sl = 0;

        $totalOpening = 0;
        $totalPurchaseQty = 0;
        $totalPurchaseReturn = 0;
        $totalSalesQty = 0;
        $totalSalesReturn = 0;
        $totalBalance = 0;
        $totalPPValue = 0;
        @endphp

        @foreach ($stockInfos as $stockInfo)
        @php
        $sl++;
        $balance = $stockInfo['opening'] + $stockInfo['total_purchase'] -
        $stockInfo['total_purchase_return'] - $stockInfo['total_sales'] +
        $stockInfo['total_sales_return'];
        $rowPPValue = $balance * $stockInfo['purchase_point'];

        $totalOpening += $stockInfo['opening'];
        $totalPurchaseQty += $stockInfo['total_purchase'];
        $totalPurchaseReturn += $stockInfo['total_purchase_return'];
        $totalSalesQty += $stockInfo['total_sales'];
        $totalSalesReturn += $stockInfo['total_sales_return'];
        $totalBalance += $balance;
        $totalPPValue += $rowPPValue;


        @endphp
        <tr>
            <td>{{ $sl }}</td>
            <td>{{ $stockInfo['productCategory']->categoryName }}</td>
            <td>{{ $stockInfo['product']->name }} {{ ($stockInfo['product']->deal_code) }}</td>
            <td style="text-align: right;">{{ $stockInfo['opening'] }}</td>
            <td style="text-align: right;">{{ $stockInfo['total_purchase'] }}</td>
            <td style="text-align: right;">{{ $stockInfo['total_purchase_return'] }}</td>
            <td style="text-align: right;">{{ $stockInfo['total_sales'] }}</td>
            <td style="text-align: right;">{{ $stockInfo['total_sales_return'] }}</td>
            <td style="text-align: right;">
                {{ $balance }}
            </td>
            <td style="text-align: right;">
                {{ $rowPPValue }}
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3" style="text-align: right;">Total</td>
            <td style="text-align: right;">{{ $totalOpening }}</td>
            <td style="text-align: right;">{{ $totalPurchaseQty }}</td>
            <td style="text-align: right;">{{ $totalPurchaseReturn }}</td>
            <td style="text-align: right;">{{ $totalSalesQty }}</td>
            <td style="text-align: right;">{{ $totalSalesReturn }}</td>
            <td style="text-align: right;">{{ $totalBalance }}</td>
            <td style="text-align: right;">{{ $totalPPValue }}</td>
        </tr>
    </tfoot>
</table>

<br>
<br>

<p>Print Time : {{ date('d-m-Y h:i:s') }}</p>
@endsection
