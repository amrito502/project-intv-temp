@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="container">
    <div class="main-body">

        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{ $data->user->profile_image() }}" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4>{{ $data->user->name }}</h4>
                                <p class="text-muted font-size-sm">{{ $data->user->urank() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->user->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Username</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->user->username }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mobile</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $data->user->mobile }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Joining Duration</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{  $data->user->DaysSinceJoined() }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Joining Date</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ date('d-m-Y', strtotime( $data->user->created_at)) }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Team Customer</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{  $data->user->DownLevelMemberCount() }}
                            </div>
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered bg-light">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Receive</th>
                                    <th>Usage / Withdraw</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Fund Wallet</td>
                                    <td>{{ $data->balanceInfo['fundBalances']['receive'] }}</td>
                                    <td>{{ $data->balanceInfo['fundBalances']['usage'] }}</td>
                                    <td>{{ $data->balanceInfo['fundBalances']['balance'] }}</td>
                                </tr>
                                <tr>
                                    <td>Success Wallet</td>
                                    <td>{{ $data->balanceInfo['successBalances']['receive'] }}</td>
                                    <td>{{ $data->balanceInfo['successBalances']['usage'] }}</td>
                                    <td>{{ $data->balanceInfo['successBalances']['balance'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@endsection
