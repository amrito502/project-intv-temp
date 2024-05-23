@extends('admin.mlm.dashboard.layouts.app')

@section('custom-css')
<style>
    .bg-success-light {
        background-color: #009688;
    }

    .bg-success-dark {
        background-color: #187970;
    }

    .custom-fz {
        font-size: 70px !important;
    }

    .right {
        text-align: right !important;
    }

    .right p {
        font-size: 16px;
    }

    @media (max-width: 576px) {
        .right {
            text-align: center !important;
        }

    }
</style>
@endsection

@section('content')

@include('admin.mlm.dashboard.layouts.partials.error')


@if (Auth::user()->hasRole(['Customer']))
<div class="alert bg-dark text-light" role="alert">
    <marquee direction="left" class="w-100" style="font-size: 18px">
        {{ $data->lastNotice->description }}
    </marquee>
</div>
@endif

<div class="">

    @if (Auth::user()->hasRole(['Customer']))
    @include('admin.mlm.dashboard.member_dashboard')
    @endif

    @if (Auth::user()->hasRole(['Software Admin', 'System Admin']))
    @include('admin.mlm.dashboard.admin_dashboard')
    @endif

</div>
@endsection
