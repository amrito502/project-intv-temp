@extends('admin.layouts.master')

@section('custom_css')

@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-title">Approve Withdraw</h4>
            </div>

        </div>
    </div>

    <div class="card-body">
        <div style="height:450px;">

            <table class="table table-hover table-bordered" id="dtb">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Withdraw By</th>
                        <th>Withdraw Point</th>
                        <th>Withdraw Amount</th>
                        <th>Withdraw Charge</th>
                        <th>Final Amount</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data->withdraws as $withdraw)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $withdraw->from->username }}</td>
                            <td>{{ $withdraw->to->username }} ({{ $withdraw->payment_gateway }})</td>
                            <td>{{ $withdraw->amount + $withdraw->charge }}</td>
                            <td>{{ $withdraw->charge }}</td>
                            <td>{{ $withdraw->amount }}</td>
                            <td>{{ $withdraw->dealer_sale_invoice_id ? "Dealer" : "Customer" }}</td>
                            <td>
                                <a href="{{ route('balanceWithdrawApprove', $withdraw->id) }}" class="btn btn-success btn-sm">Approve</a>
                                <a href="{{ route('balanceWithdrawReject', $withdraw->id) }}" class="btn btn-danger btn-sm">Reject</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>



@endsection


@section('custom-js')


@endsection
