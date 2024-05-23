@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{--  <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>  --}}
                    <h3 class="text-center">Withdraw History</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12" style="overflow-y: auto;">

                    <table class="table table-hover table-bordered" id="dtb">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Request Date</th>
                                <th>Request Amount</th>
                                <th>Paid Amount</th>
                                <th>Service Charge</th>
                                <th>Type</th>
                                <th>Number</th>
                                <th>Transaction No</th>
                                <th>Approved By</th>
                                <th>Status</th>
                                <th>Paid Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $totalAmount = 0;
                            $totalCharge = 0;
                            @endphp
                            @foreach ($data->statements as $statement)
                            @php
                            $totalAmount += $statement->amount;
                            $totalCharge += $statement->charge;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ date('d-m-Y', strtotime($statement->created_at)) }}</td>
                                <td>{{ $statement->amount + $statement->charge }}</td>
                                <td>{{ $statement->amount }}</td>
                                <td>{{ $statement->charge }}</td>
                                <td>{{ $statement->payment_gateway }}</td>
                                <td>{{ $statement->account_no }}</td>
                                <td>{{ $statement->transaction_no }}</td>
                                <td>{{ $statement->ApprovedBy->name }}</td>

                                <td>
                                    {{ $statement->status == 1 ? 'Paid' : 'Pending' }}
                                </td>
                                <td>

                                    @if ($statement->created_at != $statement->updated_at && $statement->status == 1)
                                    {{ date('d-m-Y', strtotime($statement->updated_at)) }}
                                    @endif

                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th>{{ $totalAmount + $totalCharge }}</th>
                                <th>{{ $totalAmount }}</th>
                                <th>{{ $totalCharge }}</th>
                                <th colspan="6"></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
