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

            <form class="form-horizontal" action="{{ route('paymentRequestReport') }}" method="get"
                enctype="multipart/form-data">
                <input type="hidden" name="searched" value="1">
                <div class="card-body">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control datepicker" name="start_date" id="start_date"
                                        type="text" value="{{ $data->start_date_ui }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control datepicker" name="end_date" id="end_date" type="text"
                                        value="{{ $data->end_date_ui }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Type</label>
                                    <select name="user_type" id="user_type" class="chosen-select" required>
                                        <option value="">Select User Type</option>
                                        <option value="3" @if (request()->user_type == 3)
                                            selected
                                            @endif>Customer</option>
                                        <option value="4" @if (request()->user_type == 4)
                                            selected
                                            @endif>Dealer</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Mode</label>
                                    <select name="payment_way" id="payment_way" class="chosen-select">
                                        <option value="">Select Option</option>
                                        <option value="cash" @if (request()->payment_way == 'cash')
                                            selected
                                            @endif
                                            >Hand Cash</option>
                                        <option value="bKash" @if (request()->payment_way == 'bKash')
                                            selected
                                            @endif
                                            >bKash</option>
                                        <option value="Nagad" @if (request()->payment_way == 'Nagad')
                                            selected
                                            @endif
                                            >Nagad</option>
                                        <option value="Rocket" @if (request()->payment_way == 'Rocket')
                                            selected
                                            @endif
                                            >Rocket</option>
                                        <option value="Bank" @if (request()->payment_way == 'Bank')
                                            selected
                                            @endif
                                            >Bank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select name="payment_status" id="payment_status" class="chosen-select" required>

                                        <option value="approved" @if (request()->payment_status == 'approved')
                                            selected
                                            @endif
                                            >Approved</option>

                                        <option value="pending" @if (request()->payment_status == 'pending')
                                            selected
                                            @endif
                                            >Pending</option>

                                        <option value="paid" @if (request()->payment_status == 'paid')
                                            selected
                                            @endif
                                            >Paid</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dealers</label>
                                    <select name="dealer" id="dealer" class="chosen-select">
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
                        <a href="{{ route('paymentRequestReport') }}?{{ http_build_query(request()->all()) }}&submitType=print"
                            class="btn btn-outline-info btn-lg waves-effect">
                            <span style="font-size: 16px;">
                                <i class="fa fa-print"></i> Print
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">

                                @include('admin.paymentLog.table.payment_request_report_table')

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

@endsection
