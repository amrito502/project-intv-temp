@extends('dashboard.layouts.app')

@section('custom-css')
<style>
    .key {
        width: 45%;
    }

    .value {
        width: 50%;
    }

    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
        position: relative;
        display: block;
        margin-bottom: 20px;
    }

    .callout,
    .card,
    .info-box,
    .mb-3,
    .my-3,
    .small-box {
        margin-bottom: 1rem !important;
    }

    .small-box>.inner {
        padding: 10px;
    }

    .small-box h3,
    .small-box p {
        z-index: 5;
    }

    .small-box h3 {
        font-size: 38px;
        font-weight: 700;
        margin: 0 0 10px 0;
        white-space: nowrap;
        padding: 0;
    }

    .small-box h3,
    .small-box p {
        z-index: 5;
    }

    .small-box p {
        font-size: 15px;
    }

    .small-box .icon {
        transition: all .3s linear;
        position: absolute;
        top: -10px;
        right: 10px;
        z-index: 0;
        font-size: 90px;
        color: rgba(0, 0, 0, .15);
    }

    .small-box>.small-box-footer {
        /* position: relative; */
        text-align: center;
        padding: 3px 0;
        color: #fff;
        color: rgba(255, 255, 255, .8);
        display: block;
        z-index: 10;
        background: rgba(0, 0, 0, .1);
        text-decoration: none;
    }

    .bg-gray {
        color: #000;
        background-color: #adb5bd;
    }

    .bg-info-gradient {
        background: #17a2b8;
        background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #17a2b8), color-stop(1, #1fc8e3));
        background: -ms-linear-gradient(bottom, #17a2b8, #1fc8e3);
        background: -moz-linear-gradient(center bottom, #17a2b8 0, #1fc8e3 100%);
        background: -o-linear-gradient(#1fc8e3, #17a2b8);
        color: #fff;
    }

    .custom_shadow {
        -webkit-box-shadow: 5px 5px 15px 5px #000000;
        box-shadow: 5px 5px 15px 5px #000000;
    }

    .inventoryStatusColumnWidth {
        width: calc(100% / 6);
    }

    .title-bg-1{
        background-color: #17a2b8;
        color: #fff;
    }

    .title-bg-2{
        background-color: #17b8b1;
        color: #fff;
    }

    h2{
        font-size: 1.4rem !important;
    }

    .tile{
        padding: 11px !important;
    }
</style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<div class="contianer">

    {{-- <div class="row mt-4"> --}}

        {{-- @foreach ($data->dashboard_project_overall_cards as $dashboard_project_overall_card) --}}

        {{-- card start --}}
        {{-- <div class="col-md-4">
            <div class="tile">
                <div class="tile-body">

                    <h5 class="text-center">
                        {{ $dashboard_project_overall_card['project_name'] }}

                        @if ($dashboard_project_overall_card['tower_name'] != '')
                        - {{ $dashboard_project_overall_card['tower_name'] }}
                        @endif

                        ({{ $dashboard_project_overall_card['by_date']['completed'] }} / {{
                        $dashboard_project_overall_card['by_date']['total'] }})
                    </h5>

                    <div class="items mt-4">

                        <div class="item my-3">
                            <div class="row">
                                <div class="col-md-3">
                                    Material
                                </div>
                                <div class="col-md-7">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped" role="progressbar"
                                            style="width: {{ $dashboard_project_overall_card['by_qty'] }}%"
                                            aria-valuenow="{{ $dashboard_project_overall_card['by_qty'] }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">{{ $dashboard_project_overall_card['by_qty'] }}%</div>
                            </div>
                        </div>

                        <div class="item my-3">
                            <div class="row">
                                <div class="col-md-3">
                                    Cost
                                </div>
                                <div class="col-md-7">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                                            style="width: {{ $dashboard_project_overall_card['by_cash'] }}%"
                                            aria-valuenow="{{ $dashboard_project_overall_card['by_cash'] }}"
                                            aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">{{ $dashboard_project_overall_card['by_cash'] }}%</div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div> --}}
        {{-- card end --}}

        {{-- @endforeach --}}

    {{-- </div> --}}

    <div class="tile title-bg-1 mb-2" id="inventoryStatusHeader">
        <div class="tile-body">
            <div class="row">

                <div class="col-md-4">
                    <h2 class="ml-2 mb-0 d-inline">Inventory Status</h2>
                </div>

                <div class="col-md-4"></div>

                <div class="col-md-2 d-none">
                    <input type="text" value="0000-01-01" name="start_date_is" id="start_date_is"
                        class="form-control IS datepicker" autocomplete="off">
                </div>

                <div class="col-md-2 d-none">
                    <input type="text" value="2050-01-01" name="end_date_is" id="end_date_is"
                        class="form-control IS datepicker pr-3" autocomplete="off">
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-2" id="inventoryCards">
    </div>

    <div class="tile title-bg-2 mb-0 mt-4" id="localIssueHeader">
        <div class="tile-body">

            <div class="row">
                <div class="col-md-4">
                    <h2 class="ml-2 mb-0 d-inline">Daily Local Issue</h2>
                </div>
                <div class="col-md-4"></div>
                <div class="d-none">
                    <input type="text" value="0000-01-01" name="start_date" id="start_date"
                        class="form-control datepicker dailyMaterialIssueDateInput" autocomplete="off">
                </div>
                <div class="d-none">
                    <input type="text" value="2050-01-01" name="end_date" id="end_date"
                        class="form-control datepicker pr-3 dailyMaterialIssueDateInput" autocomplete="off">
                </div>
            </div>

        </div>
    </div>

    <div class="row mt-2" id="projectCards">
    </div>

    <div class="row mt-4">
        {{-- <div class="col-md-12">
            <div class="tile">
                <div class="tile-body text-center">
                    <h2>Project Status</h2>
                </div>
            </div>
        </div> --}}

        @foreach ($data->dashboardProjectDetailsOverAll as $dashboardProjectDetails)

        @php
            $style = "background: rgb(13 141 17) !important; color: white;";

            if($dashboardProjectDetails['total_expense'] > $dashboardProjectDetails['total_budget']){
                $style = "background: rgb(237 40 40) !important; color:white;";
            }
        @endphp

        <div class="col-md-6">
            <div class="tile">
                <div class="tile-body">
                    <table style="font-size: 19px; width: 100%;" class="table-striped">

                        <tr style="font-size: 22px;font-weight: bold; {{ $style }}">
                            <td colspan="3" class="text-center key">Project : {{ @$dashboardProjectDetails['project_name'] }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Project Type</td>
                            <td>:</td>
                            <td class="text-right value">{{ @$dashboardProjectDetails['project_type'] }}</td>
                        </tr>

                        @if ($dashboardProjectDetails['project_type'] == 'tower')

                        <tr>
                            <td class="text-left key">Total Tower</td>
                            <td>:</td>
                            <td class="text-right value">{{ @$dashboardProjectDetails['tower_count'] }}</td>
                        </tr>

                        @endif


                        <tr>
                            <td class="text-left key">Project Units</td>
                            <td>:</td>
                            <td class="text-right value">{{ @$dashboardProjectDetails['project_units'] }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Project Time</td>
                            <td>:</td>
                            <td class="text-right value">{{ @$dashboardProjectDetails['project_time']['total'] }} Days
                            </td>
                        </tr>

                        <tr>
                            <td class="text-left key">Project Running</td>
                            <td>:</td>
                            <td class="text-right value">{{ @$dashboardProjectDetails['project_time']['completed'] }}
                                Days</td>
                        </tr>

                        <tr>
                            <td class="text-left key"></td>
                            <td>&nbsp;</td>
                            <td class="text-right value"></td>
                        </tr>

                        <tr style="border-top: 1px solid black;"></tr>


                        <tr>
                            <td class="text-left key">Total Budget</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['total_budget'], 2)  }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Total Expense</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['total_expense'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key"> - Material Expense</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['material_expense'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key"> - Self Define Expense</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['self_define_cost'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key"> - Logistics Expense</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['logistics_expense'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key"> - ROA Expense</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['roa_expense'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Additional Amount</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['additional_budget'], 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-left key"></td>
                            <td>&nbsp;</td>
                            <td class="text-right value"></td>
                        </tr>

                        <tr style="border-top: 1px solid black;"></tr>

                        <tr>
                            <td class="text-left key"></td>
                            <td>&nbsp;</td>
                            <td class="text-right value"></td>
                        </tr>

                        <tr>
                            <td class="text-left key">Lifting Amount</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['lifting_amount'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Issue Amount</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['issue_amount'], 2) }}</td>
                        </tr>

                        <tr>
                            <td class="text-left key">Consumption Value</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['consumption_value'], 2) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="text-left key">Stock Value</td>
                            <td>:</td>
                            <td class="text-right value">{{ number_format($dashboardProjectDetails['stock_value'], 2) }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

        @endforeach


    </div>

</div>

@endsection


@section('custom-script')

{{-- API functions start --}}
<script>
    function getDateRangeWiseProjects(){
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();


        axios.get(route('datewiseIssueProject'), {
            params: {
                start_date:start_date,
                end_date:end_date,
            }
        })
        .then(function (response) {

            if(response.data.length == 0){
                // hide title
                $('#localIssueHeader').hide();
            }

            addProjectTowerCards(response.data);
        })
        .catch(function (error) {
        })

    }

    function getIssueCardDetails(e, cardId, projectId, towerId){
        e.preventDefault();

        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();

        axios.get(route('datewiseIssueDetails'), {
            params: {
                start_date:start_date,
                end_date:end_date,
                project_id: projectId,
                tower_id: towerId,
            }
        })
        .then(function (response) {
            $('#hideBtn-' + cardId).removeClass('d-none');
            $('#detailsBtn-' + cardId).addClass('d-none');
            showIssueDetailsData(cardId, response.data);
        })
        .catch(function (error) {
        })

    }

    function hideCardData(cardId){
        $('#hideBtn-' + cardId).addClass('d-none');
        $('#detailsBtn-' + cardId).removeClass('d-none');
        $('#table-' + cardId).addClass('d-none');
        $('#tbody-' + cardId).html('');
    }


    function getInventoryStatusProject(){
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();


        axios.get(route('datewiseIssueNoTowerProject'), {
            params: {
                start_date:start_date,
                end_date:end_date,
            }
        })
        .then(function (response) {

            console.log(response.data.length);

            if(response.data.length == 0){
                // hide title
                $('#inventoryStatusHeader').hide();
            }

            addInventoryStatusCards(response.data);
        })
        .catch(function (error) {
        })

    }

    function getInventoryStatusCardDetails(e, cardId, projectId){
        e.preventDefault();

        const start_date = $('#start_date_is').val();
        const end_date = $('#end_date_is').val();

        axios.get(route('datewiseInventoryStatus'), {
            params: {
                start_date:start_date,
                end_date:end_date,
                project_id: projectId,
            }
        })
        .then(function (response) {

            $('#table-is-'+ cardId).html('');

            let report_table = response.data.report_table;

            let tbody = ``;

            report_table.forEach(function(i){

                const stockInQty = i.lifting + i.receive;
                const stockOutQty = i.localIssueStockQty + i.return;

                let trClass = '';

                if(stockOutQty > i.design_qty){
                    console.log(stockOutQty, i.design_qty);
                    trClass = 'text-danger';
                }

                tbody += `
                <tr class="${trClass}">
                    <td>${i.material}</td>
                    <td class="text-center">${i.design_qty}</td>
                    <td class="text-center">${i.additional_qty}</td>
                    <td class="text-center">${stockInQty}</td>
                    <td class="text-center">${stockOutQty}</td>
                    <td class="text-center">${i.balance}</td>
                </tr>
                `;
            });


            let table = `
                <thead>
                <tr>
                    <th>Material</th>
                    <th class="text-center inventoryStatusColumnWidth">Design Qty</th>
                    <th class="text-center inventoryStatusColumnWidth">Additional Qty</th>
                    <th class="text-center inventoryStatusColumnWidth">Stock In</th>
                    <th class="text-center inventoryStatusColumnWidth">Stock Out</th>
                    <th class="text-center inventoryStatusColumnWidth">Balance</th>
                </tr>
                </thead>
                <tbody>
                ${tbody}
                </tbody>
            `;

            $('#table-is-'+ cardId).html(table);

            $('.inventoryStatusShowBtn-' + cardId).addClass('d-none');
            $('.inventoryStatusHideBtn-' + cardId).removeClass('d-none');

        })
        .catch(function (error) {
        })

    }

    function hideInventoryStatusCardDetails(e, cardId) {

        $('.inventoryStatusShowBtn-' + cardId).removeClass('d-none');
        $('.inventoryStatusHideBtn-' + cardId).addClass('d-none');
        $('#table-is-'+ cardId).html('');

    }
</script>
{{-- API functions end --}}


{{-- DOM functions start --}}
<script>
    function addProjectTowerCards(data){

        $('#projectCards').html('');

        data.forEach((a) => {

            let card = `
            <div class="col-md-12" id="card-${a.id}">
            <div class="tile mb-1">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                ${a.project.project_name}
                                ${a.type == 'tower' ? ' / ' +a.tower.name : ""}
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-right" id="detailsBtn-${a.id}">
                                <a href="#" onclick="getIssueCardDetails(event, ${a.id}, ${a.project.id}, ${a.tower.id})">Detail</a>
                            </h5>
                            <h5 class="text-right d-none" id="hideBtn-${a.id}">
                                <a href="#" onclick="hideCardData(${a.id})">Hide</a>
                            </h5>
                        </div>
                    </div>

                    <div style="overflow-y: auto">
                    <table class="table table-striped mt-3 d-none" id="table-${a.id}">
                        <thead>
                            <tr>
                                <th>Material & Uom</th>
                                <th class="text-right">Design Qty</th>
                                <th class="text-right">Local Issue</th>
                                <th class="text-right">Consumption</th>
                                <th class="text-right">Stock Qty</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-${a.id}">

                        </tbody>
                    </table>

                </div>
                </div>
            </div>
        </div>
            `;

            // <th class="text-right">Balance</th>

            $('#projectCards').append(card);

        })
    }

    function showIssueDetailsData(cardId, data){

        $('#table-' + cardId).removeClass('d-none');
        $('#tbody-' + cardId).html('');

        let rows = '';

        data.forEach((a) => {
            let row = `
            <tr>
                <td>${a.budgetHeadName} ( ${a.uom} )</td>
                <td class="text-right">${a.design_qty}</td>
                <td class="text-right">${a.local_issue}</td>
                <td class="text-right">${a.consumption}</td>
                <td class="text-right">${a.stock_qty}</td>
            </tr>
            `;

            rows += row;
        });

        $('#tbody-' + cardId).append(rows);

    }

    function addInventoryStatusCards(data){

        $('#inventoryCards').html('');

        data.forEach((a) => {

            let card = `
            <div class="col-md-12" id="card-is-${a.id}">
            <div class="tile mb-1">
                <div class="tile-body">

                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                Store : ${a.project.project_name}
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-right inventoryStatusShowBtn-${a.id}">
                                <a href="#" onclick="getInventoryStatusCardDetails(event, ${a.id}, ${a.project.id})">Detail</a>
                            </h5>

                            <h5 class="text-right inventoryStatusHideBtn-${a.id} d-none">
                                <a href="#" onclick="hideInventoryStatusCardDetails(event, ${a.id})">Hide</a>
                            </h5>
                        </div>
                    </div>

                    <div style="overflow-y: auto">
                        <table class="table table-striped mt-3" id="table-is-${a.id}">

                        </table>
                    </div>

                </div>
            </div>
        </div>`;

            $('#inventoryCards').append(card);

        })
    }

</script>
{{-- DOM functions end --}}



<script>
    $(document).ready(function () {

        getDateRangeWiseProjects();
        getInventoryStatusProject();

        $('.dailyMaterialIssueDateInput').change(function (e) {
            e.preventDefault();

            getDateRangeWiseProjects();

        });

        $('.IS').change(function (e) {
            e.preventDefault();

            getInventoryStatusProject();

        });

    });
</script>
@endsection
