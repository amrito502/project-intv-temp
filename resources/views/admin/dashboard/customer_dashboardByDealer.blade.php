@php
use Illuminate\Support\Carbon;
@endphp
@extends('admin.layouts.master')


@section('custom_css')

<style>
    table thead th {
        font-weight: bold !important;
        text-transform: uppercase;
        font-size: 12px;
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

    .card {
        margin-bottom: 10px !important;
    }

    .card-head{
        padding: 38px 0;
    }
</style>


<style>
    .noticeBox {
        width: 100%;
        margin: 0 auto;
        border: 1px solid black;
        padding: 20px 0;
        height: 240px;
        /* overflow: hidden; */
        overflow: auto;
    }

    .noticeBox li p {
        font-size: 22px;
    }
</style>

@endsection

@section('content')

<div class="row mb-4">
    <div class="col-md-6">
        <div id="bchart1_div" style="height: 438px;"></div>
    </div>

    <div class="col-md-3">

        <div class="d-flex flex-column text-center text-light mb-2">
            <div class="card-head p-4" style="background-color: #56b6c2">
                <h1 class="mt-1">{{ number_format($data->commission_cards['total_purchase'], 2, '.', '') }}</h1>

            </div>
            <div class="card-foot p-2" style="background-color: #5298a0">
                <p class="mb-0">Total Purchase</p>
            </div>
        </div>

        <div class="d-flex flex-column text-center text-light mb-2">
            <div class="card-head p-4" style="background-color: #69b0f3">
                <h1 class="mt-1">{{ number_format($data->commission_cards['total_payment'], 2, '.', '') }}</h1>

            </div>
            <div class="card-foot p-2" style="background-color: #589bc7;">
                <p class="mb-0">Total Payment</p>
            </div>
        </div>

        <div class="d-flex flex-column text-center text-light">
            <div class="card-head p-4" style="background-color: #d36ef1">
                <h1 class="mt-1">{{ number_format($data->commission_cards['total_due'], 2, '.', '') }}</h1>

            </div>
            <div class="card-foot p-2" style="background-color: #b768bf">
                <p class="mb-0">Total Due</p>
            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="d-flex flex-column text-center text-light mb-2">
            <div class="card-head p-4" style="background-color: #56b6c2">
                <h1 class="mt-1">{{ number_format($data->commission_cards['commission_achieve'], 2, '.', '') }}</h1>
            </div>
            <div class="card-foot p-2" style="background-color: #5298a0">
                <p class="mb-0">Commission Achieve</p>
            </div>
        </div>

        <div class="d-flex flex-column text-center text-light mb-2">
            <div class="card-head p-4" style="background-color: #69b0f3">
                <h1 class="mt-1">{{ number_format($data->commission_cards['commission_payment'], 2, '.', '') }}</h1>
            </div>
            <div class="card-foot p-2" style="background-color: #589bc7;">
                <p class="mb-0">Commission Payment</p>
            </div>
        </div>

        <div class="d-flex flex-column text-center text-light">
            <div class="card-head p-4" style="background-color: #d36ef1">
                <h1 class="mt-1">{{ number_format($data->commission_cards['commission_due'], 2, '.', '') }}</h1>
            </div>
            <div class="card-foot p-2" style="background-color: #b768bf">
                <p class="mb-0">Commission Due</p>
            </div>
        </div>

    </div>

</div>

<div class="row">

    {{-- left side start --}}
    <div class="col-md-7" style="margin-top: 10px;">

        {{-- stock summary start --}}
        <div class="row">
            <div class="col-md-4">

                <div class="d-flex flex-column text-center text-light mb-3">
                    <div class="card-head" style="background-color: #56b6c2">
                        <h1 class="mt-1">{{ $data->stock_summary->total_receive }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #5298a0">
                        <p class="mb-0">Total Receive (Pcs)</p>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="d-flex flex-column text-center text-light mb-3">
                    <div class="card-head" style="background-color: #69b0f3">
                        <h1 class="mt-1">{{ $data->stock_summary->total_distribution }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #589bc7;">
                        <p class="mb-0">Total Distribution (Pcs)</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex flex-column text-center text-light mb-3">
                    <div class="card-head" style="background-color: #d36ef1">
                        <h1 class="mt-1">{{ $data->stock_summary->total_balance }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #b768bf">
                        <p class="mb-0">Total Balance (Pcs)</p>
                    </div>
                </div>
            </div>

        </div>
        {{-- stock summary end --}}


        {{-- point summary start --}}
        <div class="row">

            <div class="col-md-4">

                <div class="d-flex flex-column text-center text-light mb-2">
                    <div class="card-head" style="background-color: #56b6c2">
                        <h1 class="mt-1">{{ number_format($data->point_summary->total_authorize, 2, '.', '') }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #5298a0">
                        <p class="mb-0">Point Authorization</p>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="d-flex flex-column text-center text-light mb-2">
                    <div class="card-head" style="background-color: #69b0f3">
                        <h1 class="mt-1">{{ number_format($data->point_summary->total_distribution, 2, '.', '') }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #589bc7;">
                        <p class="mb-0">Point Distribution</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="d-flex flex-column text-center text-light">
                    <div class="card-head" style="background-color: #d36ef1">
                        <h1 class="mt-1">{{ number_format($data->point_summary->available_balance, 2, '.', '') }}</h1>
                    </div>
                    <div class="card-foot p-2" style="background-color: #b768bf">
                        <p class="mb-0">Available Balance</p>
                    </div>
                </div>
            </div>

        </div>
        {{-- point summary end --}}

    </div>
    {{-- left side end --}}

    {{-- right side start --}}
    <div class="col-md-5">

        {{-- popular product start --}}
        <div class="row">
            <div class="col-md-12">
                <div class="title_block" style="width: 100%;margin-top: 10px;">
                    <h4>Popular Product (Top 10)</h4>
                </div>

                <div class="card">
                    <div class="card-body" style="height: 304px;">
                        <div class="row">
                            <table class="middle-table-fz text-dark w-100">

                                @foreach ($data->popular_products as $popular_product)

                                <tr>
                                    <td style="font-size: 16px;" class="text-left ">
                                        {{ $popular_product['product']->name }} ({{
                                        $popular_product['product']->deal_code }})
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
            </div>
        </div>

        {{-- popular product end --}}

    </div>
    {{-- right side end --}}

</div>

{{-- notice board start --}}
<div class="row">
    <div class="col-md-12">
        <div class="title_block" style="width: 100%;margin-top: 10px;">
            <h4>Notice Board</h4>
        </div>
        <div class="card p-0">
            <div class="d-flex" style="justify-content:center;">
                <div class="noticeBox">

                    <ul class="noticeList">
                        @foreach ($data->notices as $notices)
                        <li>
                            <p>{{ $notices->description }}</p>
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
{{-- notice board end --}}

@endsection

{{-- file for javascript code --}}
{{-- @include('admin.dashboard.element.js_code') --}}


@section('custom-js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawBarChart1);


    function drawBarChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Sale', 'Purchase'],
          @foreach ($data->dealerTransactionFlow as $dealerTransactionFlow)
            ['{{ $dealerTransactionFlow["month"] }}', {{ $dealerTransactionFlow["SaleTotal"] }}, {{ $dealerTransactionFlow['purchaseTotal'] }}],
        @endforeach
        ]);

        var options = {
          chart: {
            title: 'MonthWise Sales Qty And Package',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('bchart1_div'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
</script>
@endsection
