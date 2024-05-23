<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Project</th>
            <th>Remarks</th>
            <th>Purchase</th>
            <th>Payment</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total_purchase = 0;
        $total_payment = 0;
        @endphp
        @foreach ($data->report as $ld)
        @php
        $total_purchase += $ld['purchase'];
        $total_payment += $ld['payment'];
        @endphp
        <tr>
            <td>{{ $ld['sl'] }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['project'] }}</td>
            <td>{{ $ld['remarks'] }}</td>
            <td>{{ $ld['purchase'] }}</td>
            <td>{{ $ld['payment'] }}</td>
            <td>{{ $ld['balance'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" class="text-right">Total</th>
            <th>{{ $total_purchase }}</th>
            <th>{{ $total_payment }}</th>
            <th>{{ $total_purchase - $total_payment }}</th>
        </tr>
    </tfoot>
</table>
