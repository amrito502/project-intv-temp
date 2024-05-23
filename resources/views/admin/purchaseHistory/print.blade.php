@extends('admin.layouts.print.printApp')

@section('content')

<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Purchase History On Date {{ Date('d-M-Y', strtotime($fromDate)) }} To
    {{ Date('d-M-Y', strtotime($toDate)) }}
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Sys No</th>
            <th>Type</th>
            <th>Supplier</th>
            <th>Category</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @php
        $sl = 1;
        $totalCashPurchaseQty = 0;
        $totalCashPurchaseAmount = 0;

        $totalCreditPurchaseQty = 0;
        $totalCreditPurchaseAmount = 0;

        $purchaseOrderQty = 0;
        $purchaseOrderAmount = 0;
        @endphp

        @foreach ($cashPurchases as $cashPurchase)
        @php
        $totalCashPurchaseQty = $totalCashPurchaseQty + $cashPurchase->qty;
        $totalCashPurchaseAmount = $totalCashPurchaseAmount + $cashPurchase->amount;
        @endphp
        <tr>
            <td>{{ $sl++ }}</td>
            <td>{{ Date('d-m-Y', strtotime($cashPurchase->voucher_date)) }}</td>
            <td>{{ $cashPurchase->cash_serial }}</td>
            <td>{{ $cashPurchase->type }}</td>
            <td>{{ $cashPurchase->vendorCode }}</td>
            <td>{{ $cashPurchase->categoryName }}</td>
            <td>{{ $cashPurchase->name }} ({{ $cashPurchase->deal_code }})</td>
            <td style="text-align: right;">{{ $cashPurchase->qty }}</td>
            <td style="text-align: right;">{{ $cashPurchase->rate }}</td>
            <td style="text-align: right;">{{ $cashPurchase->amount }}</td>
        </tr>
        @endforeach

        @foreach ($creditPurchases as $creditPurchase)
        @php
        $totalCreditPurchaseQty = $totalCreditPurchaseQty + $creditPurchase->qty;
        $totalCreditPurchaseAmount = $totalCreditPurchaseAmount + $creditPurchase->amount;
        @endphp
        <tr>
            <td>{{ $sl++ }}</td>
            <td>{{ Date('d-m-Y', strtotime($creditPurchase->voucher_date)) }}</td>
            <td>{{ $creditPurchase->credit_serial }}</td>
            <td>{{ $creditPurchase->type }}</td>
            <td>{{ $creditPurchase->vendorName }}</td>
            <td>{{ $creditPurchase->categoryName }}</td>
            <td>{{ $creditPurchase->name }}</td>
            <td>{{ $creditPurchase->qty }}</td>
            <td>{{ $creditPurchase->rate }}</td>
            <td>{{ $creditPurchase->amount }}</td>
        </tr>
        @endforeach

        @if ($purchaseRecieve)

        @foreach ($purchaseRecieve as $pr)
        @foreach ($pr->poRecieve as $por)
        @foreach ($por->items as $item)
        {{-- {{ dd($item) }} --}}
        @php
        $purchaseOrderQty = $purchaseOrderQty + $item->qty;
        $purchaseOrderAmount = $purchaseOrderAmount + $item->amount;
        @endphp
        <tr>
            <td>{{ $sl++ }}</td>
            <td>{{ Date('d-m-Y', strtotime($pr->order_date)) }}</td>
            <td>{{ $pr->order_no }}</td>
            <td>Purchase Order</td>
            <td>{{ $pr->supplier->vendorName }}</td>
            <td>{{ $item->product->category->categoryName }}</td>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->qty }}</td>
            <td>{{ $item->rate }}</td>
            <td>{{ $item->amount }}</td>
        </tr>
        @endforeach
        @endforeach
        @endforeach

        @endif

    </tbody>
</table>


<div style="border: 1px solid black; padding: 0px; margin-top: 20px;">
    <table class="total-table">
        <tr>
            <td>Total Cash Purchase Quantity</td>
            <td>{{ $totalCashPurchaseQty }}</td>
            <td>Total Cash Purchase Amount</td>
            <td>{{ $totalCashPurchaseAmount }}</td>
        </tr>

        <tr>
            <td>Total Credit Purchase Quanity</td>
            <td>{{ $totalCreditPurchaseQty }}</td>
            <td>Total Credit Purchase Amount</td>
            <td>{{ $totalCreditPurchaseAmount }}</td>
        </tr>

        <tr>
            <td>Total Purchase Order Quanity</td>
            <td>{{ $purchaseOrderQty }}</td>
            <td>Total Purchase Order Amount</td>
            <td>{{ $purchaseOrderAmount }}</td>
        </tr>

        <tr>
            <td>Grand Total Quantity</td>
            <td>{{ $totalCashPurchaseQty + $totalCreditPurchaseQty + $purchaseOrderQty }}</td>
            <td>Grand Total Amount</td>
            <td>{{ $totalCashPurchaseAmount + $totalCreditPurchaseAmount + $purchaseOrderAmount }}</td>
        </tr>
    </table>
</div>

<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
