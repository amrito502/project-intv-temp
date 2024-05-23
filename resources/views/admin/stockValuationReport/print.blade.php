@extends('admin.layouts.print.printApp')

@section('content')

<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Stock Valuation Report
</div>

<table class="print-table">
    <thead>
        <tr>
            <th style="text-align: center;" width="20px">SL#</th>
            <th style="text-align: center;" width="120px">Category</th>
            <th style="text-align: center;" width="80px">Code</th>
            <th style="text-align: center;">Product Name</th>
            <th style="text-align: center;" class="text-center" width="100px">MRP Rate</th>
            <th style="text-align: center;" class="text-center" width="100px">DP Rate</th>
            <th style="text-align: center;" width="80px" style="text-align: right;">Purchase Avg</th>
            <th style="text-align: center;" width="50px" style="text-align: right;">Stock Qty</th>
            <th style="text-align: center;" class="text-center" width="100px">MRP Value</th>
            <th style="text-align: center;" class="text-center" width="100px">DP Value</th>
            <th style="text-align: center;" width="80px" style="text-align: right;">Purchase Value</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
        // $sl = 0;
        $totalQty = 0;
        $totalMRP = 0;
        $totalDP = 0;
        $totalPurchase = 0;
        @endphp

        @foreach ($stockValuationReports as $stockValuationReport)
        @php
        // dd($stockValuationReport);

        $totalQty += $stockValuationReport['stock_qty'];
        $totalMRP += $stockValuationReport['mrp_value'];
        $totalDP += $stockValuationReport['dp_value'];
        $totalPurchase += $stockValuationReport['purchase_value'];

        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stockValuationReport['product_category'] }}</td>
            <td>{{ $stockValuationReport['product_code'] }}</td>
            <td>{{ $stockValuationReport['product_name'] }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['sale_price_mrp'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['sale_price_dp'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['purchase_avg'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['stock_qty'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['mrp_value'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['dp_value'], 2) }}</td>
            <td style="text-align: center;">{{ round($stockValuationReport['purchase_value'], 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="7" style="text-align: right;">Total Summary</th>
            <th>{{ $totalQty }}</th>
            <th>{{ $totalMRP }}</th>
            <th>{{ $totalDP }}</th>
            <th>{{ $totalPurchase }}</th>
        </tr>
    </tbody>


</table>

<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
