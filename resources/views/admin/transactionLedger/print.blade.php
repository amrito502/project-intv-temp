@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
            <td>Transaction Ledger On {{ date('Y-m-d',strtotime($fromDate)) }} To {{ date('Y-m-d',strtotime($toDate)) }}</td>
        </tr>

        @if (@$transactionLedgerHeadName->head_name)
            <tr>
                <td>Accounts Head : {{ $transactionLedgerHeadName->head_name }}</td>
            </tr>
        @endif
    </table>

    <div id="pad-bottom"></div>

    <table id="report-table">
        <thead>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;"><h2>Previous Balance</h2></td>
                <td style="text-align: right; font-weight: bold;"><b>{{ $previousBalance->previousBalance == "" ? 0 : $previousBalance->previousBalance }}</b></td>
            </tr>
            <tr>
                <th width="20px">Sl</th>
                <th width="130px">Voucher No</th>
                <th width="80px">Date</th>
                <th>Prticular</th>
                <th width="60px">Debit</th>
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
            @foreach ($transactionLedgerReports as $transactionLedgerReports)
                @php
                    $totalDebit = $totalDebit + $transactionLedgerReports->debit_amount;
                    $totalCredit = $totalCredit + $transactionLedgerReports->credit_amount;
                    if ($sl == 1)
                    {
                        $balance = $previousBalance->previousBalance + $balance + $transactionLedgerReports->debit_amount - $transactionLedgerReports->credit_amount;
                    }
                    else
                    {
                        $balance = $balance + $transactionLedgerReports->debit_amount - $transactionLedgerReports->credit_amount;
                    }
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $transactionLedgerReports->voucher_no }}</td>
                    <td>{{ date('d-m-Y',strtotime($transactionLedgerReports->voucher_date)) }}</td>
                    <td>{{ $transactionLedgerReports->narration }}</td>
                    <td align="right">{{ $transactionLedgerReports->debit_amount }}</td>
                    <td align="right">{{ $transactionLedgerReports->credit_amount }}</td>
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
