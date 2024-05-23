@extends('admin.layouts.master')

@section('custom-css')
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

            <form id="form-id" class="form-horizontal" action="{{ route('dealerStatement.report') }}" method="get"
                enctype="multipart/form-data">
                <input type="hidden" name="searched" value="1">
                <div class="card-body">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" class="form-control datepicker" name="start_date"
                                        value="{{ $data->dateRangeUi["start_date"] }}" placeholder="Select Date"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" class="form-control datepicker" name="end_date"
                                        value="{{ $data->dateRangeUi["end_date"] }}" placeholder="Select Date"
                                        required>
                                </div>
                            </div>

                            @if (in_array(auth()->user()->role, [1, 2, 6, 7]))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dealers</label>
                                    <select name="dealer" id="dealer" class="chosen-select" required>
                                        <option value="">Select Dealer</option>
                                        @foreach ($data->dealers as $dealer)
                                        <option value="{{ $dealer->id }}" @if (request()->dealer == $dealer->id)
                                            selected
                                            @endif
                                            >{{ $dealer->name }} ({{ $dealer->username }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="dealer" value="{{ auth()->user()->id }}">
                            @endif

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

                            {{-- <button type="submit" name="submitType" value="print"
                                class="btn btn-outline-info btn-lg waves-effect">
                                <span style="font-size: 16px;">
                                    <i class="fa fa-print"></i> Print
                                </span>
                            </button> --}}

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
                    <div class="col-md-6 text-right">
                        <button onclick="printThisPage()" type="button"
                            class="btn btn-outline-info btn-lg waves-effect">
                            <span style="font-size: 16px;">
                                <i class="fa fa-print"></i> Print
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                @include('admin.dealerReports.tables.dealer_statement_table')

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
    function printThisPage(){

        let input = `<input type="hidden" name="submitType" value="print">`;

        $('#form-id').append(input);

        $('#form-id').submit();

    }
</script>

@endsection
