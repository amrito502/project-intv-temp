@extends('admin.layouts.print.printApp')

@section('content')

<p style="text-align: center;text-decoration: underline;margin-top: 0;margin-bottom: 15px;">
    Dealer Sales History @if ($data->searched == 'summary') (Summary).@endif @if ($data->searched == 'details') (Details).@endif From {{ $data->fromDateUI }} to {{ $data->toDateUI }}
</p>


@if (request()->searched == "details")

    <table class="print-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Invoice Date</th>
                <th>Invoice No</th>
                <th>Dealer Name</th>
                <th>Product Name</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Amount</th>
                <th class="text-right">PP</th>
            </tr>
        </thead>

        <tbody id="tbody">
            @php
            $i = 1;
            $totalQty = 0;
            $totalAmount = 0;
            $totalPP = 0;
            @endphp
            @foreach ($data->reports as $memberSale)
            @foreach ($memberSale->items as $item)
            @php
            $totalQty += $item->item_quantity;
            $totalAmount += $item->item_price;
            $totalPP += $item->item_quantity * $item->pp;
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ date('d-m-Y', strtotime($memberSale->invoice_date)) }}</td>
                <td>{{ $memberSale->invoice_no }}</td>
                <td>{{ $memberSale->dealer->name }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->item_quantity }}</td>
                <td class="text-right">{{ number_format($item->item_price, 2, ".", "") }}</td>
                <td class="text-right">{{ number_format($item->item_quantity * $item->pp, 2, ".", "") }}
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5">Total</th>
                <th class="text-center">{{ $totalQty }}</th>
                <th class="text-right">{{ number_format($totalAmount, 2, ".", "") }}</th>
                <th class="text-right">{{ number_format($totalPP, 2, ".", "") }}</th>
            </tr>
        </tfoot>

    </table>

@endif


@if (request()->searched == "summary")

<table class="print-table">
    <thead>
        <tr>
            <th>Sl</th>
            <th>Category</th>
            <th>Product</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Amount</th>
            <th class="text-right">PP</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @php
        $totalQty = 0;
        $totalAmount = 0;
        $totalPP = 0;
        @endphp
        @foreach ($data->reports as $key => $itemGroup)

        @php
        $lineTotalAmount = 0;
        $lineTotaltotalPP = 0;
        $lineTotalQty = 0;

        foreach ($itemGroup as $item) {

        // if ($key == 181) {
        // dd($itemGroup);
        // }

        $lineTotalAmount += $item->item_price;
        $lineTotaltotalPP += $item->item_quantity * $item->pp;
        $lineTotalQty += $item->item_quantity;
        }

        @endphp

        @php
        $totalQty += $lineTotalQty;
        $totalAmount += $lineTotalAmount;
        $totalPP += $lineTotaltotalPP;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $itemGroup->first()->product->category->categoryName }}</td>
            <td>{{ $itemGroup->first()->product->name }} ({{ $itemGroup->first()->product->deal_code
                }})</td>
            <td class="text-center">{{ $lineTotalQty }}</td>
            <td class="text-right">{{ number_format($lineTotalAmount, 2, ".", "") }}
            </td>
            <td class="text-right">{{ number_format($totalPP, 2, ".", "") }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th class="text-center">{{ $totalQty }}</th>
            <th class="text-right">{{ round((float)$totalAmount, 2) }}</th>
            <th class="text-right">{{ round((float)$totalPP, 2) }}</th>
        </tr>
    </tfoot>

</table>

@endif


<br>
<br>
<br>

<p>Print Time : {{ date('d-m-Y h:i:s') }}</p>

@endsection
