@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('fund.save') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" type="button"
                            class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Add Fund (Admin)</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="container">

                <div class="row mb-5">
                    <div class="col-md-4">
                        <p class="text-danger" style="font-size: 18px;font-weight: bold;">{!! $data->businessSetting->payment_info !!}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" name="username" id="username" type="text" required onfocus="this.removeAttribute('readonly');" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input class="form-control" name="amount" id="amount" type="number" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" name="password" id="password" type="password" required onfocus="this.removeAttribute('readonly');" readonly>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Add Fund</button>
                </div>
            </div>
        </div>
    </div>


</form>

@endsection
