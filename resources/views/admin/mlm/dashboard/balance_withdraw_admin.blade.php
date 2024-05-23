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
                <h4 class="card-title" id="cashWalletBalance">Wallet Balance: 0 &#2547;</h4>
            </div>

        </div>
    </div>

    <div class="card-body">

        <form action="{{ route('balanceWithdrawAdminSave') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-5">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="user">Withdraw User</label>
                        <select name="user" class="form-control chosen-select" id="user"
                            required>
                            <option value="">Select User</option>
                            @foreach ($data->users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->username }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="userWithdrawInfo">

                </div>

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

                    <div class="row">
                        <div class="col-md-12 d-none" id="withdrawFromUser">
                            <div class="form-group">
                                <label for="withdraw_from">Withdraw From</label>
                                <select name="withdraw_from" class="form-control chosen-select" id="withdraw_from"
                                    required>
                                    @foreach ($data->withdrawFromUsers as $users)
                                    <option value="{{ $users->id }}">{{ $users->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 d-none" id="transactionNo">
                            <div class="form-group">
                                <label for="transaction_no">Transaction no.</label>
                                <input type="text" class="form-control" name="transaction_no">
                            </div>
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

    </div>
</div>



@endsection


@section('custom-js')


<script>
    $(document).ready(function () {

        $('#user').change(function (e) {
            e.preventDefault();

            let userId = $(this).val();

            // get user wallet info and wallet amount with axios
            axios.post(route('getUserWalletInfo'), {
                userId: userId
            }).then(response => {
                let data = response.data;

                let cashWalletString = `Wallet Balance: ${data.cashWalletAmount} &#2547`;
                $('#cashWalletBalance').html(cashWalletString);

                console.log(data);

                let withdrawInfoString = `
                <p>Bkash : ${data.walletInfo.bkash}</p>
                <p>Nagad : ${data.walletInfo.nagad}</p>
                <p>Rocket : ${data.walletInfo.rocket}</p>
                <p>Bank : ${data.walletInfo.bank}</p>
                `;

                $('#userWithdrawInfo').html(withdrawInfoString);


            }).catch(error => {
                console.log(error);
            });

        });


// old start
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

                if(withdrawType == 'cash'){
                    $('#withdrawFromUser').removeClass('d-none');
                    $('#transactionNo').addClass('d-none');
                }else{
                    $('#withdrawFromUser').addClass('d-none');
                    $('#transactionNo').removeClass('d-none');
                }

            }else{
                $('#withdrawFromUser').addClass('d-none');
                $('#removeClass').removeClass('d-none');

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
// old end

    });
</script>

@endsection
