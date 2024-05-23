@extends('admin.layouts.masterPrint')


@section('content')

<h2 style="text-align: center;margin-bottom: 0px;margin-top: 0;font-size: 19px;">{{ $title }}</h2>

<hr>

<table id="report-table"">
    <thead>
        <tr>
            <th width=" 20px" rowspan="2">Sl</th>
    <th style="width:150px;" rowspan="2">Supplier Name</th>
    <th style="width:50px;" rowspan="2">Previous Years</th>
    <th colspan="3">For The Years {{ $year }}</th>
    <th colspan="3">For The Month November</th>
    <th style="width:50px;" rowspan="2">Current Balance</th>
    </tr>
    <tr>
        <th>Purchase</th>
        <th>Payments</th>
        <th>Balance</th>
        <th>Purchase</th>
        <th>Payments</th>
        <th>Balance</th>
    </tr>
    </thead>

    <tbody id="tbody">
        @php
        $sl = 0;
        $currentId = 0;


        $totalPreviousYearBalance = 0;
        $totalCurrentYearPurchase = 0;
        $totalCurrentYearPayment = 0;
        $totalCurrentYearBalance = 0;
        $totalThisMonthPurchase = 0;
        $totalThisMonthPayment = 0;
        $totalThisMonthBalance = 0;
        @endphp

        @foreach ($supplierStatements as $supplierStatement)
        @php
        $sl++;
        $yearlyPurchase = 0;
        $yearlyPayment = 0;
        $monthlyPurchase = 0;
        $monthlyPayment = 0;




        @endphp
        @if ($supplierStatement->vendorId != $currentId)
        @foreach ($supplierStatements as $value)
        @php
        if ($supplierStatement->vendorId == $value->vendorId)
        {
        $yearlyPurchase = $yearlyPurchase + $value->yearlyPurchase;
        $yearlyPayment = $yearlyPayment + $value->yearlyPayment;
        $monthlyPurchase = $monthlyPurchase + $value->monthlyPurchase;
        $monthlyPayment = $monthlyPayment + $value->monthlyPayment;
        }
        $currentId = $supplierStatement->vendorId;
        @endphp
        @endforeach

        @php
        $totalPreviousYearBalance += $supplierStatement->previousPayment - $supplierStatement->previousPurchase;
        $totalCurrentYearPurchase += $yearlyPurchase;
        $totalCurrentYearPayment += $yearlyPayment;
        $totalCurrentYearBalance += $yearlyPayment - $yearlyPurchase;
        $totalThisMonthPurchase += $monthlyPurchase;
        $totalThisMonthPayment += $monthlyPayment;
        $totalThisMonthBalance += $monthlyPayment - $monthlyPurchase;
        @endphp
        <tr>
            <td>{{ $sl }}</td>
            <td>{{ $supplierStatement->vendorName }}</td>
            <td style="text-align: right;">{{ $supplierStatement->previousPayment - $supplierStatement->previousPurchase }}</td>
            <td style="text-align: right;">{{ $yearlyPurchase }}</td>
            <td style="text-align: right;">{{ $yearlyPayment }}</td>
            <td style="text-align: right;">{{ $yearlyPayment - $yearlyPurchase }}</td>
            <td style="text-align: right;">{{ $monthlyPurchase }}</td>
            <td style="text-align: right;">{{ $monthlyPayment }}</td>
            <td style="text-align: right;">{{ $monthlyPayment - $monthlyPurchase }}</td>
            <td style="text-align: right;">{{ $supplierStatement->previousPayment - $supplierStatement->previousPurchase + $yearlyPayment - $yearlyPurchase }}</td>
        </tr>
        @endif
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="2" style="text-align: right;">Total</th>
            <th style="text-align: right;">{{ $totalPreviousYearBalance }}</th>
            <th style="text-align: right;">{{ $totalCurrentYearPurchase }}</th>
            <th style="text-align: right;">{{ $totalCurrentYearPayment }}</th>
            <th style="text-align: right;">{{ $totalCurrentYearBalance }}</th>
            <th style="text-align: right;">{{ $totalThisMonthPurchase }}</th>
            <th style="text-align: right;">{{ $totalThisMonthPayment }}</th>
            <th style="text-align: right;">{{ $totalThisMonthBalance }}</th>
            <th style="text-align: right;">{{ $totalPreviousYearBalance + $totalCurrentYearBalance }}</th>
        </tr>
    </tfoot>
</table>

@endsection
