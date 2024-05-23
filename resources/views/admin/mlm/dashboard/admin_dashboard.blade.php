<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    {{-- google.charts.setOnLoadCallback(userRegistrationChart); --}}
    google.charts.setOnLoadCallback(IncomeExpense);

    {{-- function userRegistrationChart() {
        var userRegistrationChartData = google.visualization.arrayToDataTable([
            ['Day', 'Users'],
            @foreach ($data->dateWiseUsers as $d)
                ['{{ $d[0] }}', {{ $d[1] }}],
            @endforeach
        ]);

        var userRegistrationoptions = {
            title: 'Customer Joining Flow',
            hAxis: {title: 'Day', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var UserRegistrationChartInit = new google.visualization.AreaChart(document.getElementById('userChart'));
        UserRegistrationChartInit.draw(userRegistrationChartData, userRegistrationoptions);
    } --}}

    function IncomeExpense() {
        var IncomeExpenseChartData = google.visualization.arrayToDataTable([
            ['Day', 'Income', 'Expense'],

            @foreach ($data->dateWisePaymentFlow as $d)
            ['{{ $d["date"] }}', {{ $d['income'] }}, {{ $d['Expense'] }}],
            @endforeach
        ]);

        var IncomeExpenseOptions = {
            title: 'Income / Expense Flow',
            hAxis: {title: 'Day', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        var IncomeExpenseChartInit = new google.visualization.LineChart(document.getElementById('incomeExpense'));
        IncomeExpenseChartInit.draw(IncomeExpenseChartData, IncomeExpenseOptions);
    }

</script>

<div class="row">



</div>


<div class="row">

    <div class="col-md-8">
        <div class="row">


            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #01BFEF">
                            <h1 class="mt-1">{{ $data->todayMembers }}</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #0c8aaa">
                            <p class="mb-0">Day Customer</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #56b6c2">
                            <h1 class="mt-1">{{ $data->todayIncome }} ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #5298a0">
                            <p class="mb-0">Day Income</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #5f5cfa">
                            <h1 class="mt-1">{{ $data->todayPayment }}  ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #3f3db4">
                            <p class="mb-0">Day Payment</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #38dd64">
                            <h1 class="mt-1">{{ $data->totalMembers }}</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #24ab47">
                            <p class="mb-0">Total Customer</p>
                        </div>
                    </div>

                </div>
            </div>



            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #ff6beb">
                            <h1 class="mt-1">{{ $data->totalIncome }}  ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #9c388f">
                            <p class="mb-0">Total Income</p>
                        </div>
                    </div>

                </div>
            </div>



            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #fc4f6c">
                            <h1 class="mt-1">{{ $data->totalPayment }} ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #942437">
                            <p class="mb-0">Total Payment</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #a841fd">
                            <h1 class="mt-1">{{ $data->totalFundWallet }} ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #5f2192">
                            <p class="mb-0">Total Fund Wallet Balance</p>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #fc9f48">
                            <h1 class="mt-1">{{ $data->totalSuccessWallet }} ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #CD7F34">
                            <p class="mb-0">Total Success Wallet Balance</p>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-4 my-3">
                <div class="card" style="transform: translate3d(0, -1px, 0); box-shadow: 0 4px 8px 0 rgb(0 0 0 / 40%);">

                    <div class="d-flex flex-column text-center text-light">
                        <div class="card-head p-4" style="background-color: #018548">
                            <h1 class="mt-1">{{ $data->totalWithdrawRequestPending }} ৳</h1>

                        </div>
                        <div class="card-foot p-2" style="background-color: #016A3A">
                            <p class="mb-0">Withdraw Request Pending</p>
                        </div>
                    </div>

                </div>
            </div>


            {{--  <div class="col-md-12 my-3">
                <div id="userChart" style="height: 300px"></div>
            </div>  --}}

            <div class="col-md-12 my-3">
                <div id="incomeExpense" style="height: 375px"></div>
            </div>

        </div>
    </div>

    <div class="col-md-4">
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
