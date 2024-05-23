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
                    <h3 class="text-center">Transfer Statement</h3>
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
                                <th>Date</th>
                                <th>Send User</th>
                                <th>Receive User</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            @endphp
                            @foreach ($data->statements as $statement)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ date('d-m-Y', strtotime($statement->created_at)) }}</td>
                                <td>{{ $statement->from->name }}</td>
                                <td>{{ $statement->to->name }}</td>
                                <td>{{ $statement->amount }}</td>
                                <td>{{ $statement->remarks }}</td>
                                <td>
                                    {{ $statement->status == 1 ? 'Completed' : 'Processing' }}</td>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
