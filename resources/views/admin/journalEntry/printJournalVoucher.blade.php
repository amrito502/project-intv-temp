@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
        	<td>Journal Voucher</td>
        </tr>
    </table>

    {{-- <div id="pad-bottom"></div> --}}

    <table id="account-voucher-header">
        <thead>
        	<tr>
        		<th align="left">
        			Voucher No: {{ $journalEntry->voucher_no }}
        		</th>
        		<th align="right">
        			Date: {{ date('d-m-Y',strtotime($journalEntry->voucher_date)) }}
        		</th>
        	</tr>
        </thead>
    </table>

    {{-- <div id="pad-bottom"></div> --}}

    <table id="account-voucher-table">
        <thead>
            <tr>
                <th width="20px">SL</th>
                <th>Account Name</th>
                <th width="60px">Debit</th>
                <th width="60px">Credit</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sl = 1;
                $totalDebit = 0;
                $totalCredit = 0;
            @endphp
            @foreach ($journalEntries as $journalEntryInfo)
                @php
                    $totalDebit = $totalDebit + $journalEntryInfo->debit_amount;
                    $totalCredit = $totalCredit + $journalEntryInfo->credit_amount;
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $journalEntryInfo->accountHeadName }}</td>
                    <td align="right">{{ $journalEntryInfo->debit_amount }}</td>
                    <td align="right">{{ $journalEntryInfo->credit_amount }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
        	<tr>
        		<td colspan="4" style="padding: 20px 10px 20px 10px;">{{ $journalEntryInfo->narration }}</td>
        	</tr>

            <tr>
                <td style="text-align: center;" colspan="2"><b>Total</b></td>
                <td style="text-align: right;"><b>{{ $totalDebit }}</b></td>
                <td style="text-align: right;"><b>{{ $totalCredit }}</b></td>
            </tr>

            <tr>
                <th style="text-align: left; padding: 10px" colspan="4">
	                @php
	                    $inWords = \App\helperClass::numberToWords($totalDebit);
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
