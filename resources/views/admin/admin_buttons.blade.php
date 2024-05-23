@extends('admin.layouts.master')

@section('custom_css')
<style>
    .links a {
        text-align: center;
        display: inline-block;
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #7a7a7a;
        padding: 0 .9375rem;
        margin-bottom: 1.875rem;
    }

    .links a span.link-item,
    body#checkout section.checkout-step {
        box-shadow: 0 0 0;
        border: 1px solid #e8e8e8;
    }

    .links a span.link-item {
        display: block;
        height: 100%;
        box-shadow: 2px 2px 8px 0 rgb(0 0 0 / 20%);
        background: #fff;
        padding: 1rem;
    }

    .links a i {
        display: block;
        font-size: 2.6rem;
        width: 100%;
        color: #232323;
        padding-bottom: 1.4rem;
    }
</style>
@endsection

@section('content')

<div class="container-fluid">
    <div class="links">
        <div class="row">

            <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="{{ route('set.user.ranks') }}">
                <span class="link-item">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                    Update Ranks
                </span>
            </a>

            <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="{{ route('convert.user.points') }}">
                <span class="link-item">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    Convert Points
                </span>
            </a>

            <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="{{ route('rank.user.bonus') }}">
                <span class="link-item">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    Rank Bonus
                </span>
            </a>

        </div>

    </div>
</div>

@endsection

@section('custom-js')

@endsection
