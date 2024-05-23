<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr class="heading-color-two">
            <th>#</th>
            <th style="width:300px;">Material Name</th>
            <th>Opening</th>
            <th>Lifting</th>
            <th>Receive</th>
            <th>Transfer/Return</th>
            <th>Local Issue</th>
            <th>Stock Balance</th>
            <th>Consumption</th>
            <th>Field Stock</th>
        </tr>
    </thead>

    <tbody>
        @php
        $total_opening = 0;
        $total_lifting = 0;
        $total_receive = 0;
        $total_return = 0;
        $total_local_issue = 0;
        $total_stock_balance = 0;
        $total_consumption = 0;
        $total_balance = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $total_opening += $ld['opening'];
        $total_lifting += $ld['lifting'];
        $total_receive += $ld['receive'];
        $total_return += $ld['return'];
        $total_local_issue += $ld['localIssueStockQty'];
        $total_balance += $ld['balance'];
        $total_consumption += $ld['consumption'];
        $total_stock_balance += $ld['field_stock'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['material'] }}</td>
            <td>{{ $ld['opening'] }}</td>
            <td>{{ $ld['lifting'] }}</td>
            <td>{{ $ld['receive'] }}</td>
            <td>{{ $ld['return'] }}</td>
            <td>{{ $ld['localIssueStockQty'] }}</td>
            <td>{{ $ld['balance'] }}</td>
            <td>{{ $ld['consumption'] }}</td>
            <td>{{ $ld['field_stock'] }}</td>
        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <th colspan="2" class="text-right font-weight-bold">Total</th>
            <th>{{ $total_opening }}</th>
            <th>{{ $total_lifting }}</th>
            <th>{{ $total_receive }}</th>
            <th>{{ $total_return }}</th>
            <th>{{ $total_local_issue }}</th>
            <th>{{ $total_balance }}</th>
            <th>{{ $total_stock_balance }}</th>
            <th>{{ $total_consumption }}</th>
        </tr>
    </tfoot>

</table>
