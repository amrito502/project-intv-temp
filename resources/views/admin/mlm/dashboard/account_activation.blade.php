@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('account.activation') }}" method="POST" enctype="multipart/form-data">
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
                        <h3 class="text-center">Account Activation</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="container-fluid">

                <div class="row mb-5">
                    <div class="col-md-4">
                        <p class="text-danger" style="font-size: 18px;">{!! $data->businessSetting->payment_info !!}
                        </p>

                        <p class="text-danger" style="font-size: 18px;">Account Price:
                            {{ $data->businessSetting->account_price }} BDT/=
                        </p>
                    </div>
                    <div class="col-md-8 text-right">
                        @if ($data->showAutoActivationButton)
                        <a href="{{ route('account.activation.auto') }}" class="btn btn-primary">Activate Account</a>
                        @endif

                    </div>
                </div>


                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="username">Customer/Mobile/User/ID</label>
                            <input class="form-control" name="username" id="username" type="text" required>
                        </div>
                    </div>

                </div>


                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">Transaction Type</label>
                            <select name="payment_type" class="form-control select2" id="payment_type" required>
                                <option value="">Select Option</option>
                                <option value="Account Wallet">Fund Wallet</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 gateway">
                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input class="form-control" name="mobile_no" id="mobile_no" type="text">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 gateway">
                        <div class="form-group">
                            <label for="transaction_no">Transaction No</label>
                            <input class="form-control" name="transaction_no" id="transaction_no" type="text">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 funds">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" name="password" id="password" type="password">
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
                    <button type="submit" class="btn btn-primary">Activate</button>
                </div>
            </div>
        </div>
    </div>


</form>

@endsection

@section('custom-script')

<script>
    $(document).ready(function () {


        function formChanger() {

            let wallets = ['bKash', 'Nagad', 'Rocket', 'Bank'];
            let funds = ['Account Wallet'];

            let PaymentType = $('#payment_type').val();


            if(wallets.includes(PaymentType)){
                $('.gateway').show();
            }else{
                $('.gateway').hide();

            }

            if(funds.includes(PaymentType)){
                $('.funds').show();
            }else{
                $('.funds').hide();

            }


         }

         formChanger();

            $('#payment_type').change(function (e) {

                formChanger();

            });

        });
</script>

@endsection
