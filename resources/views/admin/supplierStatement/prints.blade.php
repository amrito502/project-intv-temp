@extends('admin.layouts.print.printApp')

@section('content')
<div
    style="border: 1px solid black; box-shadow: 5px 5px #888888; padding: 0px; margin-bottom: 10px; text-align: center;">
    Supplier Statement History On Date {{ Date('d-M-Y',strtotime($fromDate)) }} To
    {{ Date('d-M-Y',strtotime($toDate)) }}
</div>


<table class="print-table">
    <thead>
        <tr>
            <th colspan="5" style="text-align: right; font-weight: bold;">Previous Balance</th>
            <th style="text-align: right;">{{ $previousBalance }}</th>
        </tr>
        <tr>
            <th width="20px">#</th>
            <th width="100px">Date</th>
            <th>Description</th>
            <th width="90px">Lifting</th>
            <th width="90px">Payment</th>
            <th width="90px">Balance</th>
        </tr>
    </thead>
    <tbody id="tbody">
        @foreach ($reports as $ld)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['description'] }}</td>
            <td style="text-align: right;">{{ $ld['lifting'] }}</td>
            <td style="text-align: right;">{{ $ld['payment'] }}</td>
            <td style="text-align: right;">{{ $ld['balance'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


<p>Print Time: {{ date('d-m-Y h:i:s') }}</p>

@endsection
