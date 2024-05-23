@extends('admin.layouts.master')

@section('custom_css')
<style>
    th {
        font-weight: 700 !important;
        font-size: 14px !important;
    }

    .title_block {
        background: #08a9f5;
        padding: 4px;
        text-align: center;
        width: 95%;
        margin: 0 auto;
        margin-top: 61px;
    }

    .title_block h4 {
        margin: 5px 0px 8px 0px;
        font-weight: 900;
        font-size: 24px;
        font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
        color: #000;
    }
</style>
@endsection

@section('content')

<div class="container-fluid">

    <div class="row mb-4">
        <div class="col-md-9">
            <div id="curve_chart" style="height: 438px;"></div>
        </div>

        <div class="col-md-3">

            <div class="d-flex flex-column text-center text-light mb-2">
                <div class="card-head p-4" style="background-color: #56b6c2">
                    <h1 class="mt-1">{{ number_format($data->commission_cards['achieve'], 2, '.', '') }}</h1>

                </div>
                <div class="card-foot p-2" style="background-color: #5298a0">
                    <p class="mb-0">Commission Achieve</p>
                </div>
            </div>

            <div class="d-flex flex-column text-center text-light mb-2">
                <div class="card-head p-4" style="background-color: #69b0f3">
                    <h1 class="mt-1">{{ number_format($data->commission_cards['payment'], 2, '.', '') }}</h1>

                </div>
                <div class="card-foot p-2" style="background-color: #589bc7;">
                    <p class="mb-0">Commission Payment</p>
                </div>
            </div>

            <div class="d-flex flex-column text-center text-light">
                <div class="card-head p-4" style="background-color: #d36ef1">
                    <h1 class="mt-1">{{ number_format($data->commission_cards['due'], 2, '.', '') }}</h1>

                </div>
                <div class="card-foot p-2" style="background-color: #b768bf">
                    <p class="mb-0">Commission Due</p>
                </div>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-4">

            {{-- our team start --}}
            <div class="title_block text-left pl-2" style="width: 100%;margin-top: 0;">
                <h4>Our Team</h4>
            </div>
            <div class="bg-white">
                <table class="table table-bordered middle-table-fz text-dark w-100">

                    <thead>
                        <tr>
                            <th>Position</th>
                            <th class="text-right">Qty</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Customers
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'customers') }}">
                                    {{ $data->our_team['customers'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Members
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'members') }}">
                                    {{ $data->our_team['members'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Starters
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'starters') }}">
                                    {{ $data->our_team['starters'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Executives
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'executives') }}">
                                    {{ $data->our_team['executives'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Sr. Executives
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'sr_executives') }}">
                                    {{ $data->our_team['sr_executives'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Asst. Manager
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'asst_manager') }}">
                                    {{ $data->our_team['asst_manager'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of Manager
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'manager') }}">
                                    {{ $data->our_team['manager'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of AGM
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'agm') }}">
                                    {{ $data->our_team['agm'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of GM
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'gm') }}">
                                    {{ $data->our_team['gm'] }}
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                No of ED
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                <a target="_blank" href="{{ route('our.team.details', 'ed') }}">
                                    {{ $data->our_team['ed'] }}
                                </a>
                            </td>
                        </tr>

                    </tbody>

                    <thead>
                        <tr>
                            <th class="text-right">Total</th>
                            <th class="text-right">{{ $data->our_team['total'] }}</th>
                        </tr>
                    </thead>

                </table>
            </div>
            {{-- our team end --}}


        </div>

        <div class="col-md-8">
            {{-- Reserve Status start --}}
            <div class="title_block text-left pl-2" style="width: 100%;margin-top: 0;">
                <h4>Reserve Status</h4>
            </div>
            <div class="bg-white">
                <table class="table table-bordered middle-table-fz text-dark w-100">

                    <thead>
                        <tr>
                            <th>Head Name</th>
                            <th class="text-right">Reserve</th>
                            <th class="text-right">Expense</th>
                            <th class="text-right">Due Balance</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Investment
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['investment']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['investment']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['investment']['reserve'] -
                                $data->reserve_status['investment']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Operational Team
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['operational_team']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['operational_team']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['operational_team']['reserve'] -
                                $data->reserve_status['operational_team']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Operational Cost
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['operational_cost']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['operational_cost']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['operational_cost']['reserve'] -
                                $data->reserve_status['operational_cost']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Business Development
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['business_development']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['business_development']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['business_development']['reserve'] -
                                $data->reserve_status['business_development']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Sales Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['sales_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['sales_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['sales_bonus']['reserve'] -
                                $data->reserve_status['sales_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Entertainment Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['entertainment_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['entertainment_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['entertainment_bonus']['reserve'] -
                                $data->reserve_status['entertainment_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Team Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['team_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['team_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['team_bonus']['reserve'] -
                                $data->reserve_status['team_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Rank Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['rank_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['rank_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['rank_bonus']['reserve'] -
                                $data->reserve_status['rank_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Repurchase Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['repurchase_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['repurchase_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['repurchase_bonus']['reserve'] -
                                $data->reserve_status['repurchase_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size: 14px;" class="text-left ">
                                Dealer / Agent Bonus
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['dealer_or_agent_bonus']['reserve'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ $data->reserve_status['dealer_or_agent_bonus']['due'] }}
                            </td>
                            <td style="font-size: 14px;" class="text-right">
                                {{ number_format($data->reserve_status['dealer_or_agent_bonus']['reserve'] -
                                $data->reserve_status['dealer_or_agent_bonus']['due'], 2, '.', '') }}
                            </td>
                        </tr>
                    </tbody>

                    <thead>
                        <tr>
                            <th class="text-right">Total</th>
                            <th class="text-right">{{ number_format($data->reserve_status['total']['reserve'], 2, '.',
                                '') }}</th>
                            <th class="text-right">{{ number_format($data->reserve_status['total']['due'], 2, '.', '')
                                }}</th>
                            <th class="text-right">{{ number_format($data->reserve_status['total']['reserve'] -
                                $data->reserve_status['total']['due'], 2, '.', '') }}</th>
                        </tr>
                    </thead>

                </table>
            </div>
            {{-- Reserve Status end --}}
        </div>

    </div>

    <div class="row">

        <div class="col-md-4">
            {{-- sales summary start --}}
            <div class="title_block" style="width: 100%;margin-top: 10px;">
                <h4>Sales Summary</h4>
            </div>

            <div class="card">
                <div class="card-body" style="height: 307px">
                    <div class="row">
                        <table class="middle-table-fz text-dark w-100">

                            @foreach ($data->top_rankings['sales_summary'] as $detail)

                            <tr>
                                <td style="font-size: 16px;" class="text-left">
                                    <span class="mb-0">
                                        {{ $detail['title'] }}
                                    </span>
                                </td>
                                <td style="font-size: 16px;" class="text-right">
                                    {{ $detail['value'] }}
                                </td>
                            </tr>

                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            {{-- sales summary end --}}
        </div>

        <div class="col-md-4">
            {{-- active leader start --}}
            <div class="title_block" style="width: 100%;margin-top: 10px;">
                <h4>Top 10 Earner</h4>
            </div>

            <div class="card">
                <div class="card-body" style="height: 307px">
                    <div class="row">
                        <table class="middle-table-fz text-dark w-100">

                            @foreach ($data->top_rankings['active_leaders'] as $active_leader)

                            <tr>
                                <td style="font-size: 16px;" class="text-left">
                                    <span class="mb-0" data-toggle="tooltip" data-placement="right"
                                        title="{{ $active_leader['customer']->UserAccount->name }}">
                                        {{ $active_leader['customer']->UserAccount->username }}
                                    </span>
                                </td>
                                <td style="font-size: 16px;" class="text-right">
                                    {{ $active_leader['income'] }}
                                </td>
                            </tr>

                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            {{-- active leader end --}}
        </div>

        <div class="col-md-4">
            {{-- popular product start --}}
            <div class="title_block" style="width: 100%;margin-top: 10px;">
                <h4>Top 10 Product</h4>
            </div>

            <div class="card">
                <div class="card-body" style="height: 307px;">
                    <div class="row">
                        <table class="middle-table-fz text-dark w-100">

                            @foreach ($data->top_rankings['popular_products'] as $popular_product)

                            <tr>
                                <td style="font-size: 16px;" class="text-left ">
                                    {{ $popular_product['product']->name }} ({{
                                    $popular_product['product']->deal_code
                                    }})
                                </td>
                                <td style="font-size: 16px;" class="text-right">
                                    {{ $popular_product['qty'] }}
                                </td>
                            </tr>

                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            {{-- popular product end --}}
        </div>

    </div>


    <div class="row">

        <div class="col-md-4">
            <div id="bChartPoint_div" style="height: 400px;"></div>

        </div>

        <div class="col-md-4">
            <div id="bChartPackage_div" style="height: 400px;"></div>
        </div>

        <div class="col-md-4">
            <div id="bChartAmount_div" style="height: 400px;"></div>
        </div>

    </div>

</div>

@endsection


@section('custom-js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Year', 'Sales Flow'],
        @foreach ($data->salesFlow as $salesFlow)
        @if ($salesFlow["dayCount"] > 4)
        ['{{ $salesFlow["dayCount"] }}', {{ $salesFlow['SaleTotal'] }}],
        @endif
        @endforeach
      ]);

      var options = {
        // title: 'Sales Flow',
        curveType: 'function',
        legend: { position: 'bottom' },
        hAxis: {
          title: 'Day'
        },
        vAxis: {
          title: 'Amount'
        },
        chartArea: {
            height: '100%',
            width: '100%',
            top: 48,
            left: 48,
            right: 16,
            bottom: 48
        },
        height: '100%',
        width: '100%',
        series: {
            0: { color: '#e2431e' },
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

      chart.draw(data, options);
    }
</script>


<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawBarChart);


    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Purchase Point'],
          @foreach ($data->monthWiseProductSaleQty as $monthWiseProductSale)
            ['{{ $monthWiseProductSale["month"] }}', {{ $monthWiseProductSale["totalPurchasePoint"] }}],
        @endforeach
        ]);

        var options = {
            title: 'MonthWise Sales Point',
            legend: {position: 'none'},
        };

        var chart = new google.charts.Bar(document.getElementById('bChartPoint_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
</script>


<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawBarChart1);


    function drawBarChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Month','Package'],
          @foreach ($data->monthWisePackageSale as $monthWisePackageSale)
            ['{{ $monthWisePackageSale["month"] }}', {{ $monthWisePackageSale['totalPackageCount'] }}],
        @endforeach
        ]);

        var options = {
            title: 'MonthWise Sales Package',
            legend: {position: 'none'},
            colors: ['green'],
        };

        var chart = new google.charts.Bar(document.getElementById('bChartPackage_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
</script>

<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawBarChart);


    function drawBarChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Amount'],
          @foreach ($data->monthWiseProductSaleQty as $monthWiseProductSale)
            ['{{ $monthWiseProductSale["month"] }}', {{ $monthWiseProductSale['totalSaleAmount'] }}],
        @endforeach
        ]);

        var options = {
            title: 'MonthWise Sales Amount',
            legend: {position: 'none'},
            colors: ['red'],
        };

        var chart = new google.charts.Bar(document.getElementById('bChartAmount_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

@endsection
