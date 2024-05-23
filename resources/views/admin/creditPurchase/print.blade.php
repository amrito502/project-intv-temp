@extends('admin.layouts.masterPrint')

@section('content')

<p style="text-align: center;text-decoration: underline;margin-top: 0;margin-bottom: 0;">Credit Purchase</p>

<div>
    <div>
        <p style="margin-bottom: 0;">
            <span style="text-align: left;">
                System No : {{ $creditPurchase->credit_serial }}
            </span>
        </p>
        <p style="margin-top: 0;">
            <span style="text-align: left;">
                Purchase Date : {{ date('d-m-Y', strtotime($creditPurchase->voucher_date)) }}
            </span>
        </p>
    </div>
    <div>
        <p style="margin-bottom: 0;">Vendor Voucher : {{ $creditPurchase->vouchar_no }}</p>
        <p style="margin-top: 0;">Vendor Name : {{ $creditPurchase->supplier->vendorName }}</p>
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

        @foreach ($creditPurchaseItems as $creditPurchaseItem)
        @php
        $totalQty += $creditPurchaseItem->qty;
        $totalAmount += $creditPurchaseItem->amount_cash;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $creditPurchaseItem->product->name }} ({{ $creditPurchaseItem->product->deal_code }})</td>
            <td style="text-align: right;">{{ $creditPurchaseItem->qty }}</td>
            <td style="text-align: right;">{{ $creditPurchaseItem->rate_cash }}</td>
            <td style="text-align: right;">{{ $creditPurchaseItem->amount_cash }}</td>
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
