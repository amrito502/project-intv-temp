@extends('admin.layouts.masterPrint')

@section('content')
<table id="report-header">
    <tr>
        <td>Debit Voucher</td>
    </tr>
</table>

{{-- <div id="pad-bottom"></div> --}}

<table id="account-voucher-header">
    <thead>
        <tr>
            <th align="left">
                Voucher No: {{ $debitEntry->voucher_no }}
            </th>
            <th align="right">
                Date: {{ date('d-m-Y',strtotime($debitEntry->voucher_date)) }}
            </th>
        </tr>
    </thead>
</table>

{{-- <div id="pad-bottom"></div> --}}

<table id="account-voucher-table">
    <thead>
        <tr>
            <th colspan="2" style="padding: 10px 10px; text-align: left;">Account Head Of: {{ $debitEntry->narration }}
            </th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td style="padding: 60px 10px">{{ $debitEntry->narration }}</td>
            <td align="right" style="padding: 60px 10px">{{ $debitEntry->credit_amount }}</td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <th style="text-align: left; padding: 10px" colspan="2">
                @php
                $inWords = \App\helperClass::numberToWords($debitEntry->credit_amount);
                @endphp
                In Words : {{ $inWords }} Taka Only.
                <b></b>
            </th>
        </tr>
    </tfoot>
</table>

<div style="padding: 20px"></div>

<table id="voucher-sign-table">
    <tr>
        <td align="center">
            -----------------------
        </td>
        <td align="center">
            -----------------------
        </td>
        <td align="center">
            -----------------------
        </td>
    </tr>
    <tr>
        <td align="center">
            <h3 style="margin:0;">Prepared</h3>
        </td>
        <td align="center">
            <h3 style="margin:0;">Accountant</h3>
        </td>
        <td align="center">
            <h3 style="margin:0;">Receive By</h3>
        </td>
    </tr>
</table>
@endsection
