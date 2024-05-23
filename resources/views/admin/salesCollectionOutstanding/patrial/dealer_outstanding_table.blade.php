<table class="table table-bordered" id="report-table">
    <thead>
        <tr>
            <th width="20px" rowspan="2">Sl</th>
            <th rowspan="2">Dealer Name</th>
            <th rowspan="2" width="120px">Previous Years</th>
            <th colspan="3">For The Year {{ $year }}</th>
            <th colspan="3">For The Month {{ date('F', mktime(0, 0, 0,$month, 10)) }}</th>
            <th rowspan="2" width="120px">Current Balance</th>
        </tr>
        <tr>
            <th width="90px">Sales</th>
            <th width="90px">Collection</th>
            <th width="90px">Due</th>
            <th width="90px">Sales</th>
            <th width="90px">Collection</th>
            <th width="90px">Due</th>
        </tr>
    </thead>

    <tbody id="tbody">
        @foreach ($report as $ld)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $ld['name'] }}</td>
                <td>{{ $ld['previous_year_balance'] }}</td>
                <td>{{ $ld['this_year_sales'] }}</td>
                <td>{{ $ld['this_year_collection'] }}</td>
                <td>{{ $ld['this_year_balance'] }}</td>
                <td>{{ $ld['this_month_sales'] }}</td>
                <td>{{ $ld['this_month_collection'] }}</td>
                <td>{{ $ld['this_month_balance'] }}</td>
                <td>{{ $ld['current_balance'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
