<table class="table table-hover table-bordered dtb unverified">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            @if (!Auth::user()->hasRole('Customer'))
            <th>Withdraw From</th>
            @endif
            <th>Withdraw By</th>
            <th>Total Amount</th>
            <th>Paid Amount</th>
            <th>Commission</th>
            <th>Payment Option</th>
            <th>Account No</th>
            <th>Status</th>
            <th>Transaction NO</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
        $i=1;
        @endphp
        @foreach ($data->funds->where('status', 0) as $fund)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ date('d-m-Y', strtotime($fund->created_at)) }}</td>
            @if (!Auth::user()->hasRole('Customer'))
            <td>{{ $fund->to->username }}</td>
            @endif
            <td>{{ $fund->from->username }}</td>
            <td>{{ $fund->amount + $fund->charge }}</td>
            <td>{{ $fund->amount }}</td>
            <td>{{ $fund->charge }}</td>
            <td>{{ $fund->payment_gateway }}</td>
            <td>{{ $fund->account_no }}</td>
            <td>
                {{ $fund->status == 1 ? 'Paid' : 'Pending' }}
            </td>
            <td>
                <input type="text" class="form-control" id="id_{{ $fund->id }}">
            </td>
            <td>
                <div class="toggle">
                    <label>
                        <input onclick="toggleStatus('{{ $fund->id }}')" type="checkbox" @if ($fund->status == 1)
                        checked @endif><span class="button-indecator"></span>
                    </label>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
