@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
            <td>Bank Book On {{ date('Y-m-d',strtotime($fromDate)) }} To {{ date('Y-m-d',strtotime($toDate)) }}</td>
        </tr>
    </table>

    <div id="pad-bottom"></div>

    <table id="report-table">
        <thead>
            <tr>
                <th colspan="6" style="text-align: right; font-weight: bold;">Previous Balance</th>
                <th style="text-align: right; font-weight: bold;">{{ $previousBalance->previousBalance == "" ? 0 : $previousBalance->previousBalance }}</th>
            </tr>
            <tr>
                <th width="20px">Sl</th>
                <th width="130px">Voucher No</th>
                <th width="80px">Date</th>
                <th>Prticular</th>
                <th width="80px">Debit</th>
                <th width="60px">Credit</th>
                <th width="60px">Balance</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sl = 1;
                $balance = 0;
                $totalDebit = 0;
                $totalCredit = 0;
            @endphp
            @foreach ($bankBooksReports as $bankBooksReport)
                @php
                    $totalDebit = $totalDebit + $bankBooksReport->debit_amount;
                    $totalCredit = $totalCredit + $bankBooksReport->credit_amount;
                    if ($sl == 1)
                    {
                        $balance = $previousBalance->previousBalance + $balance + $bankBooksReport->debit_amount - $bankBooksReport->credit_amount;
                    }
                    else
                    {
                        $balance = $balance + $bankBooksReport->debit_amount - $bankBooksReport->credit_amount;
                    }
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $bankBooksReport->voucher_no }}</td>
                    <td>{{ date('d-m-Y',strtotime($bankBooksReport->voucher_date)) }}</td>
                    <td>{{ $bankBooksReport->narration }}</td>
                    <td align="right">{{ $bankBooksReport->debit_amount }}</td>
                    <td align="right">{{ $bankBooksReport->credit_amount }}</td>
                    <td align="right">{{ $balance > 0 ? $balance : '('.abs($balance).')' }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="4" align="right"><b>Total</b></td>
                <td align="right">{{ $totalDebit }}</td>
                <td align="right">{{ $totalCredit }}</td>
                <td align="right">{{ $balance > 0 ? $balance : '('.abs($balance).')' }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
