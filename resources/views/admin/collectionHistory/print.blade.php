@extends('admin.layouts.print.printApp')

@section('content')

<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Collection History On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To {{ Date('d-M-Y',strtotime($toDate)) }}
</div>

<table class="print-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Date</th>
            <th>Dealer Name</th>
            <th>Money Receipt</th>
            <th>Pay Mode</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
        $totalCollection = 0;
        @endphp
        @foreach ($reports as $item)
        @php
        $totalCollection += $item->payment_amount;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->payment_date }}</td>
            <td>{{ $item->dealer->name }} ({{ $item->dealer->username }})</td>
            <td>{{ $item->payment_no }}</td>
            <td>{{ $item->money_receipt_type }}</td>
            <td>{{ $item->payment_amount }}</td>
        </tr>
    @endforeach
    </tbody>

</table>

<div class="footer">
    <table width="100%">
        <tr>
            <th style="text-align: center;">Total Collection Summery :
                {{ number_format($totalCollection,'2','.','') }}</th>
        </tr>
    </table>
</div>

<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
