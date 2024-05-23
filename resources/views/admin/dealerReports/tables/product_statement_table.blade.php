<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th class="text-right" colspan="5">Previous Balance</th>
            <th class="text-right">{{ $data->previousBalance }}</th>
        </tr>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Date</th>
            <th class="text-left">Remarks</th>
            <th class="text-right">Stock In</th>
            <th class="text-right">Stock Out</th>
            <th class="text-right">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
        $totalStockIn = 0;
        $totalStockOut = 0;
        @endphp
        @foreach ($data->reports as $report)
        @php
        $totalStockIn += $report['in'];
        $totalStockOut += $report['out'];
        @endphp
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-center">{{ $report['date'] }}</td>
            <td class="text-left">{{ $report['remarks'] }}</td>
            <td class="text-right">{{ $report['in'] }}</td>
            <td class="text-right">{{ $report['out'] }}</td>
            <td class="text-right">{{ $report['balance'] }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" colspan="3">Total</th>
            <th class="text-right">{{ $totalStockIn }}</th>
            <th class="text-right">{{ $totalStockOut }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>
