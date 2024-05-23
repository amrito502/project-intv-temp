@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
        	<td>Payment Voucher</td>
        </tr>
    </table>

    {{-- <div id="pad-bottom"></div> --}}

    <table id="account-voucher-header">
        <thead>
        	<tr>
        		<th align="left">
        			Voucher No: {{ 'payment-10000' . $wallet->id }}
        		</th>
        		<th align="right">
        			Date: {{ date('d-m-Y', strtotime($wallet->created_at)) }}
        		</th>
        	</tr>
        </thead>
    </table>

    {{-- <div id="pad-bottom"></div> --}}

    <table  id="account-voucher-table">
        <thead>
            <tr>
                <th colspan="2" style="padding: 10px 10px;text-align: left;">Payment To : {{ $wallet->from->name }} ({{ $wallet->from->username }})</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="padding: 30px 10px">
                    Request Amount
                    <br>
                    <br>
                    Service Charge
                    <br>
                    <br>
                    Payable
                </td>
                <td align="right" style="padding: 30px 10px">
                    {{ $wallet->amount + $wallet->charge }}
                    <br>
                    <br>
                    {{ $wallet->charge }}
                    <br>
                    <br>
                    {{ $wallet->amount }}
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <th style="text-align: left; padding: 10px" colspan="2">
	                @php
	                    $inWords = \App\helperClass::numberToWords($wallet->amount);
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
