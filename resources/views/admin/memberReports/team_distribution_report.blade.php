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

            <form class="form-horizontal" id="searchForm" action="{{ route('teamDistributionStatus') }}" method="get"
                enctype="multipart/form-data">

                <input type="hidden" id="searched" name="searched" value="1">

                <div class="card-body">


                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" class="form-control datepicker" name="start_date"
                                        value="{{ $data->dateRangeUi->start_date }}" placeholder="Select Date" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" class="form-control datepicker" name="end_date"
                                        value="{{ $data->dateRangeUi->end_date }}" placeholder="Select Date" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select class="form-control chosen-select" name="type[]" id="type" multiple>
                                        {{-- <option value="ConversionToCash">ConversionToCash</option> --}}

                                        <option value="TeamBonus" @if (request()->type && in_array("TeamBonus", request()->type))
                                            selected @endif>TeamBonus</option>

                                        <option value="SalesBonus" @if (request()->type && in_array("SalesBonus", request()->type))
                                            selected @endif
                                        >SalesBonus</option>

                                        <option value="RePurchaseBonus"
                                        @if (request()->type && in_array("RePurchaseBonus", request()->type))
                                            selected @endif
                                        >RePurchaseBonus</option>

                                        <option value="RankBonus"
                                        @if (request()->type && in_array("RankBonus", request()->type))
                                            selected @endif
                                        >RankBonus</option>


                                        {{-- <option value="LevelBonus">LevelBonus</option> --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Member</label>
                                    <select class="form-control chosen-select" name="members[]" id="member" multiple>
                                        @foreach($data->members as $member)
                                        <option value="{{ $member->id }}" @if (request()->members)
                                            @if (@in_array($member->id,request()->members))
                                            selected
                                            @endif
                                            @endif

                                            >
                                            {{ $member->name }} ({{ $member->username }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>



                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">

                                <br>
                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search
                                    </span>
                                </button>

                                <button type="submit" name="submitType" value="print" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-print"></i> Print
                                    </span>
                                </button>

                            </div>
                        </div>

                    </div>

                </div>
            </form>


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
                            {{-- <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a> --}}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (request()->searched)
                            <div class="table-responsive">
                                @include('admin.memberReports.tables.team_distribution_table')
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('custom-js')



@endsection
