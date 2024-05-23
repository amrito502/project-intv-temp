<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr class="heading-color-two">
            <th>#</th>
            <th>Date</th>
            <th>Project</th>
            <th>Budget Head</th>
            <th>Vendor</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @php
        $total = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $total += $ld['amount'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['project'] }}</td>
            <td>{{ $ld['budgethead'] }}</td>
            <td>{{ $ld['vendor'] }}</td>
            <td>{{ $ld['amount'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" class="text-right font-weight-bold">Total</td>
            <td>{{ $total }}</td>
        </tr>
    </tfoot>

</table>
