@extends('admin.layouts.master')

@section('custom_css')

@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-title">Approve transfer</h4>
            </div>

        </div>
    </div>

    <div class="card-body">
        <div style="height:450px;">

            <table class="table table-hover table-bordered" id="dtb">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Transfer By</th>
                        <th>Transfer To</th>
                        <th>Transfer Amount</th>
                        <th>Transfer Charge</th>
                        <th>Final Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data->transfers as $transfer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transfer->from->username }}</td>
                            <td>{{ $transfer->to->username }}</td>
                            <td>{{ $transfer->amount + $transfer->charge }}</td>
                            <td>{{ $transfer->charge }}</td>
                            <td>{{ $transfer->amount }}</td>
                            <td>
                                <a href="{{ route('balanceTransferApprove', $transfer->id) }}" class="btn btn-success btn-sm">Approve</a>
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
