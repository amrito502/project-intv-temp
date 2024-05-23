@php
use Carbon\CarbonPeriod;
@endphp
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
<div class="card" style="margin-bottom: 50px;height:800px;">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ $data->title }}</h4>
            </div>
            <div class="col-md-6 text-right">
            </div>
        </div>
    </div>

    <div class="card-body">

        <div class="links">
            <div class="row">

                <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link"
                    href="{{ route('generation.distribution') }}">
                    <span class="link-item">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        Team Bonus Distribution
                    </span>
                </a>

                <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" href="{{ route('rank.update') }}">
                    <span class="link-item">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        Rank Level Update
                    </span>
                </a>

                <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" data-toggle="modal"
                    data-target="#rankBonusModal">
                    <span class="link-item">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        Rank Bonus Distribution
                    </span>
                </a>

                <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" data-toggle="modal"
                    data-target="#investorBonusModal">
                    <span class="link-item">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        Investor Profit Distribution
                    </span>
                </a>

                <a class="col-lg-3 col-md-6 col-sm-6 col-xs-12" id="identity-link" data-toggle="modal" data-target="#operationalBonusModal">
                    <span class="link-item">
                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                        Operational Bonus Distribution
                    </span>
                </a>


                {{-- rank bonus modal start --}}
                <div class="modal fade" id="rankBonusModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('rank.bonus.distribution') }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Rank Bonus Distribution</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Year</label>
                                                <select name="year" class="chosen-select" id="year">
                                                    @for ($i = 2022; $i < 2030; $i++) <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Month</label>
                                                <select name="month" class="chosen-select" id="month">
                                                    @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month',
                                                    now()->addMonths(11)->startOfMonth()) as $date)
                                                    <option value="{{ $date->format('m') }}">
                                                        {{ $date->format('F') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Distribute</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- rank bonus modal end --}}

                {{-- investor profit modal start --}}
                <div class="modal fade" id="investorBonusModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('investor.profit.distribution') }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Investor Profit Distribution</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Year</label>
                                                <select name="year" class="chosen-select" id="year">
                                                    @for ($i = 2022; $i < 2030; $i++) <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Month</label>
                                                <select name="month" class="chosen-select" id="month">
                                                    @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month',
                                                    now()->addMonths(11)->startOfMonth()) as $date)
                                                    <option value="{{ $date->format('m') }}">
                                                        {{ $date->format('F') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Distribute</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- investor profit modal end --}}

                {{-- investor profit modal start --}}
                <div class="modal fade" id="operationalBonusModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('operational.bonus.distribution') }}">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Operational Bonus Distribution</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Year</label>
                                                <select name="year" class="chosen-select" id="year">
                                                    @for ($i = 2022; $i < 2030; $i++) <option value="{{ $i }}">{{ $i }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group text-center">
                                                <label for="">Month</label>
                                                <select name="month" class="chosen-select" id="month">
                                                    @foreach(CarbonPeriod::create(now()->startOfMonth(), '1 month',
                                                    now()->addMonths(11)->startOfMonth()) as $date)
                                                    <option value="{{ $date->format('m') }}">
                                                        {{ $date->format('F') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Distribute</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- investor profit modal end --}}

            </div>
        </div>

    </div>

</div>
@endsection

@section('custom-js')

@endsection
