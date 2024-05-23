<table class="table table-hover table-bordered mt-2">

    <thead>
        <tr>
            <th colspan="10">Project: {{ $data->project->project_name }}</th>
        </tr>
        <tr class="heading-color-two">
            <th style="width:50px;">#</th>
            <th>Date</th>
            <th>Unit Name</th>
            <th>Tower Name</th>
            <th>Pile No</th>
            <th style="">Material Name</th>
            <th style="text-align:right;">Budget Qty</th>
            <th style="text-align:right;">Used Qty</th>
            <th style="text-align:right;">Diff</th>
            <th>Remarks</th>
        </tr>
    </thead>

    <tbody>
        @php
        $total_budget_qty = 0;
        $total_used_qty = 0;
        $total_diff = 0;
        @endphp
        @foreach ($data->report['report_table'] as $ld)
        @php
        $total_budget_qty += $ld['budget_qty'];
        $total_used_qty += $ld['used_qty'];
        $total_diff += $ld['qtyString'];
        @endphp
        <tr class="{{ $ld['rowHtmlClass'] }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['unit'] }}</td>
            <td>{{ $ld['tower'] }}</td>
            <td>{{ $ld['pile_no'] }}</td>
            <td>{{ $ld['material'] }}</td>
            <td style="text-align:right;">{{ $ld['budget_qty'] }}</td>
            <td style="text-align:right;">{{ $ld['used_qty'] }}</td>
            <td style="text-align:right;">{{ $ld['qtyString'] }}</td>
            <td>{{ $ld['remarks'] }}</td>
        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <th colspan="6" class="text-right font-weight-bold">Total</th>
            <th style="text-align:right;">{{ $total_budget_qty }}</th>
            <th style="text-align:right;">{{ $total_used_qty }}</th>
            <th style="text-align:right;">{{ $total_diff }}</th>
            <th></th>
        </tr>
    </tfoot>

</table>
