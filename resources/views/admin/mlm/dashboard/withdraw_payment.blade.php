@extends('admin.layouts.master')

@section('custom_css')

@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-title">Withdraw Payment</h4>
            </div>

        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="dtb">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Withdraw Point</th>
                        <th>Withdraw By</th>
                        @if (auth::user()->role != 4)
                        <th>Withdraw Amount</th>
                        <th>Withdraw Charge</th>
                        @endif
                        <th>Final Amount</th>
                        <th>Type</th>
                        <th>Mode</th>
                        <th>Transaction No.</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data->withdraws as $withdraw)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $withdraw->to->username }}</td>
                        <td>{{ $withdraw->from->username }}</td>
                        @if (auth::user()->role != 4)
                        <td>{{ $withdraw->amount + $withdraw->charge }}</td>
                        <td>{{ $withdraw->charge }}</td>
                        @endif
                        <td>{{ $withdraw->amount }}</td>
                        <td>{{ $withdraw->from->role == 4 ? "Dealer" : "Customer" }}</td>
                        <td>{{ $withdraw->payment_gateway }}</td>
                        <td>
                            <form action="{{ route('balanceWithdrawPayment', $withdraw->id) }}" method="post"
                                id="payment_form_{{ $loop->iteration }}">
                                @csrf
                                <input type="text" class="form-control" name="transaction_no" @if ($withdraw->payment_gateway == "cash")
                                readonly
                                @endif>
                            </form>
                        </td>
                        <td class="text-center">

                            <button class="btn btn-success btn-sm"
                                onclick="$('#payment_form_{{ $loop->iteration }}').submit()"><i class="fa fa-money"></i></button>

                            <a target="_blank" href="{{ route('balanceWithdrawPaymentVoucherPrint', $withdraw->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-print"></i>
                            </a>

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
