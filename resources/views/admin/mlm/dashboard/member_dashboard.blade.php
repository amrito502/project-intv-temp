@php
$type = "Customer";

$UserActivationCardColors = [];

$UserActivationCardColors[0] = '#ff7167';
$UserActivationCardColors[1] = '#da5950';

if(Auth::user()->is_agent){
$type = "Agent";
}

if(Auth::user()->is_founder){
$type = "Founder";
}

if (Auth::user()->status == 1){
$UserActivationCardColors[0] = '#57ce3f';
$UserActivationCardColors[1] = '#32a54f';
}
@endphp

<div class="row">

    <div class="col-md-3 my-3">
        <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

            <div class="d-flex flex-column text-center">
                <div class="card-head p-4" style="background-color: #fff;height: 102px;">
                    <p style="font-size: 20px; font-weight: bold;" class="mt-1 mb-0">{{ Auth::user()->username }}</p>

                    @if (Auth::user()->is_agent)
                    <p style="font-size: 20px" class="mt-1 mb-0">{{ Auth::user()->district->name }} -
                        {{ Auth::user()->thana->name }}</p>
                    @endif
                </div>
                <div class="card-foot p-2" style="background-color: rgb(199, 195, 195)">
                    <p class="mb-0">{{ $type }} Info</p>
                </div>
            </div>

        </div>
    </div>


    <div class="col-md-3 my-3">
        <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

            <div class="d-flex flex-column text-center text-light">
                <div class="card-head p-4" style="background-color: {{ $UserActivationCardColors[0] }}">
                    <h1 class="mt-1">
                        @if (Auth::user()->status == 0)
                        Inactive
                        @else
                        Active
                        @endif
                    </h1>

                </div>
                <div class="card-foot p-2" style="background-color: {{ $UserActivationCardColors[1] }}">
                    <p class="mb-0">Account Status</p>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3 my-3">
        <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

            <div class="d-flex flex-column text-center text-light">
                <div class="card-head p-4" style="background-color: #3e61fd">
                    <h1 class="mt-1">
                        {{ Auth::user()->urank() }}
                    </h1>

                </div>
                <div class="card-foot p-2" style="background-color: #2c4bd4">
                    <p class="mb-0">Rank</p>
                </div>
            </div>

        </div>
    </div>

    <div class="col-md-3 my-3">
        <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

            <div class="d-flex flex-column text-center text-light">
                <div class="card-head p-4" style="background-color: #b64ffa">
                    <h1 class="mt-1">
                        {{ Auth::user()->DaysSinceJoined() }} Days
                    </h1>

                </div>
                <div class="card-foot p-2" style="background-color: #9740d1">
                    <p class="mb-0">Joining</p>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="row">

            <div class="col-md-6">

                {{-- fund wallet start --}}
                <div class="col-md-12 px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #fc4a4a">
                                <h1 class="mt-1">{{ $data->receiveAmount }} ৳</h1>

                            </div>
                            <div class="card-foot p-2" style="background-color: #b93030">
                                <p class="mb-0">Fund Wallet
                                    @if (Auth::user()->status == 1)
                                    <span class="p-1 bg-success rounded" data-toggle="modal"
                                        data-target="#fund-transfer-modal">Transfer!</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- fund wallet transfer Modal -->
                    <div class="modal fade" id="fund-transfer-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('balanceTransfer') }}" method="POST">
                                @csrf

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Transfer</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="transfer_from" value="fund_wallet">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="transfer_account">Transfer To User</label>
                                                    <input class="form-control" name="transfer_account"
                                                        id="transfer_account" type="text">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="transfer_amount">Transfer Amount</label>
                                                    <input class="form-control" name="transfer_amount"
                                                        id="transfer_amount" type="text"
                                                        onfocus="this.removeAttribute('readonly');" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        type="password" onfocus="this.removeAttribute('readonly');"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Transfer</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                {{-- fund wallet end --}}

                {{-- success wallet start --}}
                <div class="col-md-12 px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">

                            <div class="card-head p-4" style="background-color: #01BFEF">
                                <h1 class="mt-1">{{ $data->successWallet }} ৳</h1>
                            </div>

                            <div class="card-foot p-2" style="background-color: #0c8aaa">
                                <p class="mb-0">Success Wallet
                                    <span class="p-1 bg-danger rounded" data-toggle="modal"
                                        data-target="#withdraw-modal">WithDraw!</span>

                                    {{-- <span class="p-1 bg-success rounded" data-toggle="modal"
                                        data-target="#success-transfer-modal">Transfer!</span> --}}

                                    <span class="p-1 bg-warning rounded" data-toggle="modal"
                                        data-target="#success-convert-modal">Convert!</span>

                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- success wallet convert Modal -->
                    <div class="modal fade" id="success-convert-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('balanceTransfer') }}" method="POST">
                                @csrf

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Convert</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="transfer_from" value="success_wallet">

                                        <div class="row d-none">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="transfer_account">Transfer Account</label>
                                                    <input class="form-control" name="transfer_account"
                                                        id="transfer_account" value="{{ Auth::user()->username }}"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="transfer_amount">Convert Amount</label>
                                                    <input class="form-control" name="transfer_amount"
                                                        id="transfer_amount" type="text"
                                                        onfocus="this.removeAttribute('readonly');" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        type="password" onfocus="this.removeAttribute('readonly');"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Convert</button>
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>


                    <!-- Withdraw Modal -->
                    <div class="modal fade" id="withdraw-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('balanceWithdraw') }}" method="POST">
                                @csrf

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @include('admin.mlm.dashboard.layouts.withdraw_form')
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Withdraw</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
                {{-- success wallet end --}}


                <div class="col-md-12 d-none d-md-block px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #f736cd">
                                <h1 class="mt-1">{{ $data->withdrawAmount }} ৳</h1>

                            </div>
                            <div class="card-foot p-2" style="background-color: #be1c9b">
                                <p class="mb-0">Withdraw <a target="_blank" href="{{ route('withdraw.history') }}"
                                        class="p-1 bg-danger rounded text-light">Log!</a></p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 d-none d-md-block px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 #5591ff;">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #5591ff">
                                <h1 class="mt-1">{{ $data->pp }}</h1>

                            </div>
                            <div class="card-foot p-2" style="background-color: #3b4250">
                                <p class="mb-0">Purchase Point</p>
                            </div>
                        </div>

                    </div>
                </div>

                @if (Auth::user()->is_founder == 1)


                <div class="col-md-12 d-none d-md-block px-0 my-3">

                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #53f83d">
                                <h1 class="mt-1">{{ Auth::user()->FounderWallet() }} ৳</h1>

                            </div>
                            <div class="card-foot p-2" style="background-color: #3dbd2c">
                                <p class="mb-0">Founder Wallet
                                    @if (Auth::user()->status == 1)
                                    <span class="p-1 bg-warning rounded" data-toggle="modal"
                                        data-target="#founder-convert-modal">Convert!</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Daily Income Convert Form -->
                    <div class="modal fade" id="founder-convert-modal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('convertWalletFunds') }}" method="POST">
                                @csrf

                                <input type="hidden" name="wallet" value="FounderWallet">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Convert Daily Income</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input class="form-control" name="amount" id="amount" type="number"
                                                        min="200" required>
                                                </div>
                                            </div>

                                            <input type="hidden" name="type" value="success">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        type="password" required
                                                        onfocus="this.removeAttribute('readonly');" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Convert</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>



                </div>

                @endif

            </div>


            <div class="col-md-6">

                {{-- daily income start --}}

                <div class="col-md-12 px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #3b9efa">
                                <h1 class="mt-1">{{ $data->dailyIncome }} ৳</h1>

                            </div>

                            <div class="card-foot p-2" style="background-color: #2567a5">
                                <p class="mb-0">Daily Income
                                    @if (Auth::user()->status == 1)
                                    <span class="p-1 bg-danger rounded" data-toggle="modal"
                                        data-target="#daily-income">Convert!</span>
                                    @endif
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Daily Income Convert Form -->
                    <div class="modal fade" id="daily-income" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('convertWalletFunds') }}" method="POST">
                                @csrf

                                <input type="hidden" name="wallet" value="dailyWallet">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Convert Daily Income</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input class="form-control" name="amount" id="amount" type="number"
                                                        min="200" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="type">Convert To</label>
                                                    <select name="type" class="form-control select2" id="type" required>
                                                        <option value="success">Success Wallet</option>
                                                        <option value="fund">Fund Wallet</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        type="password" required
                                                        onfocus="this.removeAttribute('readonly');" readonly>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Convert</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

                {{-- daily income end --}}

                {{-- rank start --}}
                <div class="col-md-12 px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #38cf2a">
                                <h1 class="mt-1">{{ $data->rankWallet }} ৳</h1>

                            </div>

                            <div class="card-foot p-2" style="background-color: #6eaf18">
                                <p class="mb-0">Rank Wallet
                                    @if (Auth::user()->status == 1)
                                    <span class="p-1 bg-danger rounded" data-toggle="modal"
                                        data-target="#rank-income">Convert!</span>
                                    @endif
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="modal fade" id="rank-income" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">

                            <form action="{{ route('convertWalletFunds') }}" method="POST">
                                @csrf

                                <input type="hidden" name="wallet" value="rankWallet">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Convert Rank Income</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input class="form-control" name="amount" id="amount" type="number"
                                                        max="{{ $data->rankWallet }}"
                                                        onfocus="this.removeAttribute('readonly');" readonly required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="type">Convert To</label>
                                                    <select name="type" class="form-control select2" id="type" required>
                                                        <option value="success">Success Wallet</option>
                                                        <option value="fund">Fund Wallet</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input class="form-control" name="password" id="password"
                                                        type="password" onfocus="this.removeAttribute('readonly');"
                                                        readonly required>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Convert</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>


                </div>
                {{-- rank end --}}

                <div class="col-md-12 d-block d-md-none px-0 my-3">
                    <div class="card"
                        style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                        <div class="d-flex flex-column text-center text-light">
                            <div class="card-head p-4" style="background-color: #f736cd">
                                <h1 class="mt-1">{{ $data->withdrawAmount }} ৳</h1>

                            </div>
                            <div class="card-foot p-2" style="background-color: #be1c9b">
                                <p class="mb-0">Withdraw <a target="_blank" href="{{ route('withdraw.history') }}"
                                        class="p-1 bg-danger rounded text-light">Log!</a></p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 px-0 my-3">
                    <div class="mt-5">

                        <input type="text" class="form-control"
                            value="{{ route('memberRegister') }}?uid={{ Auth::user()->id }}" id="url" readonly>
                    </div>
                    <br>

                    <div>
                        <button onclick="copyUrl()" class="btn btn-block btn-primary"><i class="fa fa-clone"
                                aria-hidden="true"></i> Copy
                            Link</button>
                    </div>
                </div>


            </div>

        </div>

    </div>


    <div class="col-md-4 offset-md-2">

        <div class="row">

            @php
            $i = 0;
            @endphp

            @foreach ($data->ranks as $rank)


            <div class="col-md-12 my-3 px-4 my-2">
                <div class="card">
                    <div class="row">
                        <div class="p-3 col-4 text-center text-light left"
                            style="background-color:{{ $data->rankCardColors[$i][0] }}">
                            <i class="fa fa-lightbulb-o custom-fz" aria-hidden="true"></i>
                        </div>
                        <div class="p-3 col-8 text-center" style="background-color:{{ $data->rankCardColors[$i][1] }}">
                            <p class="text-light mb-1  text-uppercase" style="font-weight: bold;font-size: 16px;">
                                {{ $rank->rank_name }}
                            </p>

                            <a href="{{ route('rank.members', $rank->id) }}" class="btn btn-danger btn-block mt-2">View
                                Now</a>
                        </div>
                    </div>
                </div>
            </div>

            @php
            $i++;
            @endphp

            @endforeach

        </div>

    </div>

</div>

@section('custom-script')

<script>
    function copyUrl() {
    /* Get the text field */
    var copyText = document.getElementById("url");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);

    }


    function addSelfUsernameAsTransferAccount() {
    const UserName = "{{ Auth::user()->username }}";

    $('#transfer_account').val(UserName);
    }


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

    }else{
        $('#payment_info').text('');
        $('#account_no').val('');
    }


});

$('#withdrawUserColumn').hide();

$('#withdraw_from').change(function (e) {
    e.preventDefault();

    let withDrawFrom = $(this).val();

    if(withDrawFrom == 'Admin'){

        $('#username').val('admin');
        $('#withdrawUserColumn').hide();



    }else{

        $('#username').val('');
        $('#withdrawUserColumn').show();

    }


});

</script>

@endsection
