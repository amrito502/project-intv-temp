@extends('admin.layouts.masterPrint')

@section('content')
    <table id="report-header">
        <tr>
            <td>Income Statement On {{ date('Y-m-d',strtotime($fromDate)) }} To {{ date('Y-m-d',strtotime($toDate)) }}</td>
        </tr>
    </table>

    <div id="pad-bottom"></div>

    <table id="report-table">
        <thead class="thead-green">
            <tr>
                <td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center;">Income</td>
            </tr>

            <tr>
                <th width="20px">Sl</th>
                <th width="100px">Head Code</th>
                <th>Head Name</th>
                <th width="80px">Balance</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sl = 1;
                $totalIncome = 0;
            @endphp
            @foreach ($incomeLists as $incomeList)
                @php
                    $totalIncome = $totalIncome + $incomeList->amount;
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $incomeList->headCode }}</td>
                    <td>{{ $incomeList->headName }}</td>
                    <td align="right">{{ $incomeList->amount > 0 ? $incomeList->amount : '('.abs($incomeList->amount).')' }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="right" style="font-weight: bold;">{{ $totalIncome >= 0 ? $totalIncome : '('.abs($totalIncome).')' }}</td>
            </tr>
        </tfoot>
    </table>

    <div id="pad-bottom"></div>

    <table id="report-table">
        <thead class="thead-green">
            <tr>
                <td colspan="4" style="font-size: 20px; font-weight: bold; text-align: center;">Expense</td>
            </tr>

            <tr>
                <th width="20px">Sl</th>
                <th width="100px">Head Code</th>
                <th>Head Name</th>
                <th width="80px">Balance</th>
            </tr>
        </thead>

        <tbody>
            @php
                $sl = 1;
                $totalExpanse = 0;
            @endphp
            @foreach ($expenseLists as $expenseList)
                @php
                    $totalExpanse = $totalExpanse + $expenseList->amount;
                @endphp
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $expenseList->headCode }}</td>
                    <td>{{ $expenseList->headName }}</td>
                    <td align="right">{{ $expenseList->amount > 0 ? $expenseList->amount : '('.abs($expenseList->amount).')' }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <td align="right" style="font-weight: bold;">{{ $totalExpanse >= 0 ? $totalExpanse : '('.abs($totalExpanse).')' }}</td>
            </tr>
        </tfoot>
    </table>

    <div id="pad-bottom"></div>

    <table id="report-table">
        <tr>
            @if ($totalIncome > $totalExpanse)
                <td style="background: green; font-size: 20px; font-weight: bold; color: white; text-align: center;">Net Profit: {{ $totalIncome - $totalExpanse }}</td>
            @endif

            @if ($totalIncome < $totalExpanse)
                <td style="background: red; font-size: 20px; font-weight: bold; color: white; text-align: center;">Net Lose: {{ $totalExpanse - $totalIncome }}</td>
            @endif
        </tr>
    </table>
@endsection
