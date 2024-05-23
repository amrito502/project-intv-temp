@extends('admin.layouts.print.printApp')

@section('content')

<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Purchase Return History On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To
    {{ Date('d-M-Y',strtotime($toDate)) }}
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Return SL</th>
            <th>Supplier Name</th>
            <th>Category Name</th>
            <th>Product Name</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @php
        $sl = 0;
        $totalPurchaseReturnQty = 0;
        $totalPurchaseReturnAmount = 0;
        @endphp

        @foreach ($purchaseReturns as $purchaseReturn)
        @php
        $sl++;
        $totalPurchaseReturnQty = $totalPurchaseReturnQty + $purchaseReturn->qty;
        $totalPurchaseReturnAmount = $totalPurchaseReturnAmount + $purchaseReturn->amount;
        @endphp
        <tr>
            <td>{{ $sl }}</td>
            <td>{{ Date('d-m-Y',strtotime($purchaseReturn->purchase_return_date)) }}</td>
            <td>{{ $purchaseReturn->purchase_return_serial }}</td>
            <td>{{ $purchaseReturn->vendorName }}</td>
            <td>{{ $purchaseReturn->categoryName }}</td>
            <td>{{ $purchaseReturn->name }}</td>
            <td>{{ $purchaseReturn->qty }}</td>
            <td>{{ $purchaseReturn->rate }}</td>
            <td>{{ $purchaseReturn->amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="border: 1px solid black; padding: 0px; margin-top: 20px;">
    <table class="total-table">
        <tr>
            <td>Total Purchase Return Quantity</td>
            <td>{{ $totalPurchaseReturnQty }}</td>
            <td>Total Purchase Return Amount</td>
            <td>{{ $totalPurchaseReturnAmount }}</td>
        </tr>
    </table>
</div>

<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
