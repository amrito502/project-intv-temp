<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr>
            <th class="text-right">Project Name</th>
            <th colspan="5">{{ $data->project->project_name }}</th>
        </tr>
        <tr class="heading-color-two">
            <th style="width:0px;">#</th>
            <th style="width:80px;">Date</th>
            <th style="width:100px;">Unit Name</th>
            <th style="width:100px;">Tower Name</th>
            <th style="width:100px;">Material Name</th>
            <th style="width:100px;">Qty</th>
        </tr>
    </thead>

    <tbody>
        @php
        $totalQty = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $totalQty += $ld['qty'];
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['unit'] }}</td>
            <td>{{ $ld['tower'] }}</td>
            <td>{{ $ld['material'] }}</td>
            <td>{{ $ld['qty'] }}</td>
        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <th colspan="5">Total</th>
            <th>{{ $totalQty }}</th>
        </tr>
    </tfoot>

</table>
