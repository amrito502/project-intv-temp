@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center">Agent List</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 px-0">

    <div class="tile">
        <div class="tile-body" style="overflow-y: auto">
            <table class="table table-hover table-bordered" id="dtb">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Area</th>
                        <th>Fund Wallet</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i=1;
                    @endphp
                    @foreach ($data->founders as $founder)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $founder->username }}</td>
                        <td>{{ $founder->name }}</td>
                        <td>{{ $founder->mobile }}</td>
                        <td>
                            @if ($founder->district)
                            {{ $founder->district->name }}
                            @endif
                            -
                            @if ($founder->thana)
                            {{ $founder->thana->name }}
                            @endif
                        </td>
                        <td>{{ $founder->fundWallet() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
