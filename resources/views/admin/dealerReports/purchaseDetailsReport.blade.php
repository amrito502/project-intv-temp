@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 50px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            {{-- <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a> --}}
                    </div>
                </div>
            </div>

            <div class="card-body">

                <form class="form-horizontal" id="searchForm" action="{{ route('dealerPurchaseDatewise.report') }}"
                    method="get" enctype="multipart/form-data">

                    <input type="hidden" id="searched" name="searched" value="1">

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-12">Start Date</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control datepicker" name="start_date"
                                            value="{{ $data->dateRangeUi["start_date"] }}" placeholder="Select Date"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="col-md-12">End Date</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control datepicker" name="end_date"
                                            value="{{ $data->dateRangeUi["end_date"] }}" placeholder="Select Date"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Products</label>
                                    <select class="chosen-select" name="products[]" id="products" multiple>
                                        @foreach ($data->products as $product)
                                        <option value="{{ $product->id }}" @if (request()->products)
                                            @if (in_array($product->id, request()->products)) selected @endif
                                            @endif
                                            >
                                            {{ $product->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <br>
                            <button type="button" onclick="submitFormFor('summary')"
                                class="btn btn-outline-info btn-lg waves-effect">
                                <span style="font-size: 16px;">
                                    <i class="fa fa-search"></i> Summary
                                </span>
                            </button>

                            <button type="button" onclick="submitFormFor('details')"
                                class="btn btn-outline-info btn-lg waves-effect">
                                <span style="font-size: 16px;">
                                    <i class="fa fa-search"></i> Details
                                </span>
                            </button>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Report</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            @php
                            $paramsArr = request()->query();
                            $paramsEncoded = http_build_query($paramsArr);
                            @endphp

                            <a href="{{ route('dealerPurchaseDatewise.report.print').'?'.$paramsEncoded }}"
                                class="btn btn-outline-info btn-lg waves-effect">
                                <span style="font-size: 16px;">
                                    <i class="fa fa-print"></i> Print
                                </span>
                            </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">

                                    @include('admin.dealerReports.tables.dealer_purchase_details')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection


    @section('custom-js')

    <script>
        function submitFormFor(keyWord) {
        $("#searched").val(keyWord);

        $('#searchForm').submit();
    }
    </script>

    @endsection
