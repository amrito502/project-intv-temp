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
                    <h2 class="h2 text-center">Customer List</h2>
                </div>
            </div>


            <form action="" class="mt-5">
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Fund Wallet</label>
                            <input type="checkbox" name="fundWallet" value="1" @if (request()->fundWallet)
                            checked
                            @endif
                            >
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Success Wallet</label>
                            <input type="checkbox" name="successWallet" value="1" @if (request()->successWallet)
                            checked
                            @endif
                            >
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Withdraw Amount</label>
                            <input type="checkbox" name="withdrawAmount" value="1" @if (request()->withdrawAmount)
                            checked
                            @endif
                            >
                        </div>
                    </div>

                    <div class="col-md-2 offset-md-4 text-right">
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" value="Search">
                        </div>
                    </div>


                </div>
            </form>

        </div>
    </div>
</div>

<div class="col-md-12 px-0">


    <div class="tile">
        <div class="tile-body" style="overflow-y: auto">
            <table class="table table-hover table-bordered dtb">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>
                            Fund Balance
                        </th>
                        <th>
                            Success Balance
                        </th>
                        <th>
                            Total Withdraw
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i=1;

                    $totalFundBalance = 0;
                    $totalSuccessBalance = 0;
                    $totalWithdrawAmount = 0;

                    @endphp

                    @foreach ($data->members as $member)

                    @php

                    $renderThisRow = 0;

                    if(request()->fundWallet){
                        if($member->FundWallet() > 0){
                            $renderThisRow = 1;
                        }
                    }

                    if(request()->successWallet){
                        if($member->SuccessWallet() > 0){
                            $renderThisRow = 1;
                        }
                    }

                    if(request()->withdrawAmount){
                        if($member->withdrawWallet() > 0){
                            $renderThisRow = 1;
                        }
                    }

                    if(!$renderThisRow){
                        continue;
                    }

                    $totalFundBalance += $member->FundWallet();
                    $totalSuccessBalance += $member->SuccessWallet();
                    $totalWithdrawAmount += $member->withdrawWallet();

                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $member->refMember->username }}</td>
                        <td>{{ $member->username }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->mobile }}</td>
                        <td>{{ $member->FundWallet() }}</td>
                        <td>{{ $member->SuccessWallet() }}</td>
                        <td>{{ $member->withdrawWallet() }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5">Total</th>
                        <th>{{ $totalFundBalance }}</th>
                        <th>{{ $totalSuccessBalance }}</th>
                        <th>{{ $totalWithdrawAmount }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

@endsection

@section('custom-script')


@endsection
