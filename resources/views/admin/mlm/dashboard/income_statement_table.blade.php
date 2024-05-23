<table class="table table-bordered table-striped" id="{{ $id }}">
    <thead>
        <tr>
            <th>#</th>
            <th>Income By</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=1;
        $totalAmount = 0;
        @endphp
        @foreach ($data->statements as $statement)
        @php
        $totalAmount += $statement->amount;
        @endphp
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $statement->from->name }} ({{ $statement->from->username }})</td>
            <td>{{ date('d-m-Y', strtotime($statement->created_at)) }}</td>
            <td>{{ $statement->amount }}</td>
            <td>{{ $statement->remarks }}</td>

        </tr>
        @endforeach

    </tbody>

    <tfoot>
        <tr>
            <th colspan="2">Total</th>
            <th>{{ $totalAmount }}</th>
            <th colspan="2"></th>
        </tr>
    </tfoot>
</table>
