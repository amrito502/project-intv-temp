<table class="table table-hover table-bordered" id="report-table">

    <thead>
        <tr>
            <th class="text-right" colspan="5">Previous Balance</th>
            <th class="text-right">{{ $data->previousBalance }}</th>
        </tr>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Description</th>
            <th class="text-right">Income</th>
            <th class="text-right">Withdraw</th>
            <th class="text-right">Balance</th>
        </tr>
    </thead>

    <tbody>

        @php
        $total_income = 0;
        $total_withdraw = 0;
        @endphp

        @foreach ($data->report as $ld)

        @php
        $total_income += $ld['income'];
        $total_withdraw += $ld['expense'];
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $ld['date'] }}</td>
            <td>{{ $ld['description'] }}</td>
            <td class="text-right">{{ $ld['income'] }}</td>
            <td class="text-right">{{ $ld['expense'] }}</td>
            <td class="text-right">{{ $ld['balance'] }}</td>
        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <th colspan="3" style="text-align: right;font-weight: bold;">Total</th>
            <th class="text-right">{{ number_format($total_income, 2, ".", "") }}</th>
            <th class="text-right">{{ number_format($total_withdraw, 2, ".", "") }}</th>
            <th></th>
        </tr>
    </tfoot>

</table>
