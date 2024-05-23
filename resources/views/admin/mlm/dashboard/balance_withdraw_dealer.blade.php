@extends('admin.layouts.master')

@section('custom_css')
<style>
    #payment_info {
        font-weight: 700;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-title">Balance Withdraw</h4>
            </div>

            <div class="col-md-6 text-right">
                <h4 class="card-title">Wallet Balance: {{ Auth::user()->dealerCommissionWallet() }} &#2547;</h4>
            </div>

        </div>
    </div>

    <div class="card-body">
        <div style="height:450px;">

            <!-- Nav tabs -->
            {{-- <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#withdraw">Withdraw</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#transfer">Transfer</a>
                </li>
            </ul> --}}

            <!-- Tab panes -->
            {{-- <div class="tab-content"> --}}

                {{-- <div class="tab-pane container active" id="withdraw"> --}}

                    <form action="{{ route('dealerBalanceWithdraw') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-5">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="withdraw_type">Withdraw Type</label>
                                    <select name="withdraw_type" class="chosen-select" id="withdraw_type" required>
                                        <option value="">Select Option</option>
                                        <option value="cash">Hand Cash</option>
                                        <option value="bKash">bKash</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Rocket">Rocket</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <input type="hidden" name="withdraw_from" value="161">

                                {{-- <div class="row">
                                    <div class="col-md-12 d-none" id="withdrawFromUser">
                                        <div class="form-group">
                                            <label for="withdraw_from">Withdraw From</label>
                                            <select name="withdraw_from" class="form-control chosen-select"
                                                id="withdraw_from" required>
                                                @foreach ($data->withdrawFromUsers as $users)
                                                <option value="{{ $users->id }}">{{ $users->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="row">
                                    <div class="col-md-12">
                                        <p id="payment_info" style="margin-top: 36px;"></p>
                                        <input type="hidden" name="account_no" id="account_no">
                                    </div>
                                </div>

                            </div>

                        </div>

                        @include('admin.mlm.dashboard.layouts.withdraw_form')

                        <div class="tile">
                            <div class="tile-body">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">Withdraw</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                {{-- </div> --}}

                {{-- <div class="tab-pane container fade" id="transfer">
                    <form action="{{ route('balanceTransfer') }}" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf


                        @include('admin.mlm.dashboard.layouts.transfer_form')


                        @if (Auth::user()->status == 1)

                        <div class="tile">
                            <div class="tile-body">
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endif


                    </form>
                </div> --}}

            {{-- </div> --}}

        </div>
    </div>
</div>



@endsection


@section('custom-js')


<script>
    $(document).ready(function () {

        let getWayInfo = {
                'bKash': '{{ Auth::user()->bKash_no }}',
                'Nagad': '{{ Auth::user()->nagad_no }}',
                'Rocket': '{{ Auth::user()->rocket_no }}',
                'Bank': '{{ Auth::user()->bank_info }}',
            };

        $('#withdraw_type').change(function (e) {
            e.preventDefault();

            let withdrawType = $(this).val();


            if(withdrawType !== ''){

                let msg = `${withdrawType} : ${getWayInfo[withdrawType]}`;

                $('#payment_info').text(msg);

                $('#account_no').val(getWayInfo[withdrawType]);

                if(withdrawType == 'cash'){
                    // $('#withdrawFromUser').removeClass('d-none');
                    $('#payment_info').addClass('d-none');
                }else{
                    // $('#withdrawFromUser').addClass('d-none');
                    $('#payment_info').removeClass('d-none');

                }

            }else{
                $('#payment_info').text('');
                $('#account_no').val('');
                // $('#withdrawFromUser').addClass('d-none');
                $('#payment_info').removeClass('d-none');

            }


        });


        $('#withdraw_from').change(function (e) {
            e.preventDefault();

            let withDrawFrom = $(this).val();

            if(withDrawFrom == 'Admin'){

                $('#username').val('admin');

            }else{

                $('#username').val('');
            }


        });

    });
</script>

@endsection
