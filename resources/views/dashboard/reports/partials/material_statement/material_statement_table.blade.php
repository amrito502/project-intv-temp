<table class="table table-hover table-bordered mt-2">
    <thead>
        <tr>
            <th colspan="7" class="text-right">Previous Balance</th>
            <th>{{ $data->prev_balance }}</th>
        </tr>
        <tr class="heading-color-two">
            <th style="width:0px;">#</th>
            <th style="width:80px;">Date</th>
            <th style="width:100px;">Lifting</th>
            <th style="width:100px;">Receive</th>
            <th style="width:100px;">Local Issue</th>
            <th style="width:100px;">Consumption</th>
            <th style="width:100px;">Return/Transfer</th>
            <th style="width:100px;">Balance</th>
        </tr>
    </thead>

    <tbody>
        @php
        $previous_balance = $data->prev_balance;
        $total_lifting = 0;
        $total_receive = 0;
        $total_local_issue = 0;
        $total_uses = 0;
        $total_return = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $total_lifting += $ld['lifting'];
        $total_receive += $ld['receive'];
        $total_local_issue += $ld['localissue'];
        $total_uses += $ld['uses'];
        $total_return += $ld['return'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['lifting'] }}</td>
            <td>{{ $ld['receive'] }}</td>
            <td>{{ $ld['localissue'] }}</td>
            <td>{{ $ld['uses'] }}</td>
            <td>{{ $ld['return'] }}</td>
            <td>{{ $ld['balance'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="2" class="text-right font-weight-bold">Total</th>
            <th>{{ $total_lifting }}</th>
            <th>{{ $total_receive }}</th>
            <th>{{ $total_local_issue }}</th>
            <th>{{ $total_uses }}</th>
            <th>{{ $total_return }}</th>
            <th></th>
        </tr>
    </tfoot>

</table>
