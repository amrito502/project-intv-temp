@extends('admin.layouts.masterPrint')

@section('content')

<p style="text-align: center;text-decoration: underline;margin-top: 0;margin-bottom: 0;">Cash Purchase</p>

<div>
    <div>
        <p style="margin-bottom: 0;">
            <span style="text-align: left;">
                System No : {{ $cashPurchase->cash_serial }}
            </span>
        </p>
        <p style="margin-top: 0;">
            <span style="text-align: left;">
                Purchase Date : {{ date('d-m-Y', strtotime($cashPurchase->voucher_date)) }}
            </span>
        </p>
    </div>
    <div>
        <p style="margin-bottom: 0;">Vendor Voucher : {{ $cashPurchase->voucher_no }}</p>
        <p style="margin-top: 0;">Vendor Name : {{ $cashPurchase->supplier->vendorName }}</p>
    </div>
</div>

<table id="report-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th style="text-align: right;">Qty</th>
            <th style="text-align: right;">Rate</th>
            <th style="text-align: right;">Amount</th>
        </tr>
    </thead>
    <tbody>

        @php
        $totalQty = 0;
        $totalAmount = 0;
        @endphp

        @foreach ($cashPurchaseItems as $cashPurchaseItem)
        @php
        $totalQty += $cashPurchaseItem->qty;
        $totalAmount += $cashPurchaseItem->amount_cash;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $cashPurchaseItem->product->name }} ({{ $cashPurchaseItem->product->deal_code }})</td>
            <td style="text-align: right;">{{ $cashPurchaseItem->qty }}</td>
            <td style="text-align: right;">{{ $cashPurchaseItem->rate_cash }}</td>
            <td style="text-align: right;">{{ $cashPurchaseItem->amount_cash }}</td>
        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <td colspan="2" style="text-align: right;">Total</td>
            <td style="text-align: right;">{{$totalQty}}</td>
            <td></td>
            <td style="text-align: right;">{{ $totalAmount }}</td>
        </tr>
    </tfoot>
</table>

@endsection
