@extends('dashboard.layouts.app')

@section('custom-css')

<style>
    .heading-color-two th,
    .heading-color-three td {
        background-color: #9ad5c5 !important;
    }

    .heading-color-four th,
    .heading-color-four td {
        background-color: #5ec7e7 !important;
    }

    .footer-heading th {
        background-color: #000 !important;
        color: #fff;
    }
</style>

@endsection

@section('content')
@include('dashboard.layouts.partials.error')


<div class="d-print-none tile mb-3">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <h3 class="text-center text-uppercase">{{ $data->title }}</h3>
                </div>
                <div class="col-md-2 text-right">
                    <a target="_blank" href="{{ url()->current() }}?print=true" class="btn btn-primary">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        Print
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    @include('dashboard.reports.partials.report_details.consumption_material_table')

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-script')

@endsection
