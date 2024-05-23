@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a target="_blank" style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                            href="{{ route('productStatus.report') }}?print=true">
                            <i class="fa fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div style="overflow-x:auto;">
                                @include('admin.dealerReports.tables.product_status_table')
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
</script>

@endsection
