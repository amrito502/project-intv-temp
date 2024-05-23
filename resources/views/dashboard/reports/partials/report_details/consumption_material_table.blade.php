<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr>
            <td colspan="3" style="font-size: 15px;" class="font-weight-bold">Project :: {{ $data->report['project']->project_name }}</td>
            <td colspan="2" style="font-size: 15px;" class="text-right font-weight-bold">Unit :: {{ $data->report["unit"]->name }}</td>
        </tr>
        <tr class="heading-color-two">
            <th>#</th>
            <th>Tower</th>
            <th>Budget Head</th>
            <th>Qty ({{ $data->report["material_uom"] }})</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($data->report['report_table'] as $ld)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['tower'] }}</td>
            <td>{{ $ld['budgethead'] }}</td>
            <td>{{ $ld['qty'] }}</td>
            <td>{{ $ld['amount'] }}</td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr class="heading-color-two">
            <th colspan="3" class="text-right">Total Summary</th>
            <th>{{ $data->report['report_total']['TotalQty'] }}</th>
            <th>{{ $data->report['report_total']['TotalAmount'] }}</th>
        </tr>
    </tfoot>

</table>
