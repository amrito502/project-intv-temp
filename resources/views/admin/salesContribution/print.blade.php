@extends('admin.layouts.print.printApp')

@section('content')

<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Sales Contributes By {{ $params['option'] }}
</div>
<table class="print-table">
    <thead>
        <tr>
            <th width="20px">Sl</th>
            @if ($params['option'] == 'Categories')
            <th>Category Name</th>
            @endif

            @if ($params['option'] == 'Products')
            <th>Products Name</th>
            @endif

            @if ($params['option'] == '' && $params['option'] == '')
            <th>Name</th>
            @endif
            <th>Sale Qty</th>
            <th>% By Qty</th>
            <th>Sale Amount</th>
            <th>% By Amount</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
        $totalSaleQty = 0;
        $totalSaleAmount = 0;
        @endphp
        @foreach ($reports as $report)
        @php
        $totalSaleQty += $report['qty'];
        $totalSaleAmount += $report['amount'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $report['name'] }}</td>
            <td>{{ $report['qty'] }}</td>
            <td>{{ $report['percentage_qty'] }}</td>
            <td>{{ $report['amount'] }}</td>
            <td>{{ $report['percentage_amount'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="2" class="text-right">Total</th>
            <th>{{ $totalSaleQty }}</th>
            <th></th>
            <th>{{ $totalSaleAmount }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>

<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
