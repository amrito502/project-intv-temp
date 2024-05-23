@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')


<form action="{{ route('balanceTransfer') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                        <h3 class="text-center">Balance Transfer</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="container">

                <div class="row mb-3">
                    <div class="col-md-6">
                        Transfer from : <input type="radio" name="transfer_from"
                            onclick="ShowWalletBalance('successWallet')" value="success_wallet" required>
                        Success Wallet <input type="radio" name="transfer_from"
                            onclick="ShowWalletBalance('FundWallet')" value="fund_wallet" checked required>
                        Fund Wallet
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        Wallet Amount: <span id="amount"></span>
                    </div>
                </div>

                @include('admin.mlm.dashboard.layouts.transfer_form')

            </div>
        </div>
    </div>

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

@endsection

@section('custom-script')
<script>
    function addSelfUsernameAsTransferAccount() {
            const UserName = "{{ Auth::user()->username }}";

            $('#transfer_account').val(UserName);
        }

        let walletBalances = {
                'successWallet': '{{ Auth::user()->SuccessWallet() }}',
                'FundWallet': '{{ Auth::user()->FundWallet() }}',
            };


            function ShowWalletBalance(walletName) {
                let amount = walletBalances[walletName];

                $('#amount').html(amount);
            }

            ShowWalletBalance('FundWallet');

</script>
@endsection
