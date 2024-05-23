<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr class="heading-color-two">
            <th>#</th>
            <th>Date</th>
            <th>Vendor</th>
            <th>Project</th>
            <th>Material</th>
            <th>Qty</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @php
        $total_qty = 0;
        $total_amount = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $total_qty += $ld['qty'];
        $total_amount += $ld['amount'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['vendor'] }}</td>
            <td>{{ $ld['project'] }}</td>
            <td>{{ $ld['material'] }}</td>
            <td>{{ $ld['qty'] }}</td>
            <td>{{ $ld['amount'] }}</td>
        </tr>
        @endforeach

    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" class="text-right font-weight-bold">Total</th>
            <th>{{ $total_qty }}</th>
            <th>{{ $total_amount }}</th>
        </tr>
    </tfoot>

</table>
