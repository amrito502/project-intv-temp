<table class="table table-hover table-bordered dtb unverified">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Payment Option</th>
            <th>Account No</th>
            <th>Transaction No</th>
            <th>Status</th>
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
            <td>{{ $fund->amount }}</td>
            <td>{{ $fund->payment_gateway }}</td>
            <td>{{ $fund->account_no }}</td>
            <td>{{ $fund->transaction_no }}</td>
            <td>
                {{ $fund->status == 1 ? 'Verified' : 'UnVerified' }}
            </td>
            <td>
                <div class="toggle">
                    <label>
                        <input onclick="toggleStatus('{{ $fund->id }}')" type="checkbox" @if ($fund->status == 1) checked @endif><span class="button-indecator"></span>
                    </label>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>