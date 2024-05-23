@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('save.fund') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        {{-- <button onclick="window.history.back()" type="button" type="button"
                            class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button> --}}
                        <h3 class="text-center">Add Fund</h3>
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
                        <p class="text-danger" style="font-size: 18px;">{!! $data->businessSetting->payment_info !!}
                        </p>
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
                            <label for="amount">Option</label>
                            <select name="payment_type" class="form-control select2" id="payment_type" required>
                                <option value="">Select Option</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="account_no">Account No</label>
                            <input class="form-control" name="account_no" id="account_no" type="text" required>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="transaction_no">Transaction No</label>
                            <input class="form-control" name="transaction_no" id="transaction_no" type="text" required>
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
