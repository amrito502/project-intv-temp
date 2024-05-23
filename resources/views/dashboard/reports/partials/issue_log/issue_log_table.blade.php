<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr class="heading-color-two">
            <th>#</th>
            <th>Date</th>
            <th>Material</th>
            <th>Issue From</th>
            <th>Issue Qty</th>
            <th>Receive To</th>
            <th>Receive Qty</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data->report['report_table'] as $ld)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['material'] }}</td>
            <td>{{ $ld['source_project'] }}</td>
            <td>{{ $ld['issued_qty'] }}</td>
            <td>{{ $ld['issue_project'] }}</td>
            <td>{{ $ld['receive_qty'] }}</td>
        </tr>
        @endforeach

    </tbody>

    {{-- <tfoot>
        <tr>
            <th colspan="4">Total</th>
            <th>{{ $totalQty }}</th>
        </tr>
    </tfoot> --}}

</table>
