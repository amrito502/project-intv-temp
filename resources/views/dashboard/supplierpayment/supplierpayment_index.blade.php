@extends('dashboard.layouts.app')


@section('custom-css')
<style>
    .nav-link {
        padding: 0.5rem 3rem;
    }

    .nav-tabs .nav-item {
        border: 1px solid #cdc8c8;
    }

    .nav-tabs .nav-item a {
        font-size: 15px;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center text-uppercase">Supplier Payment</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs" id="myTab" role="tablist">

    @if (Auth::user()->can('cash'))
    {{-- cash start --}}
    <li class="nav-item">
        <a class="nav-link active" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash"
            aria-selected="true">
            Cash
        </a>
    </li>
    {{-- cash end --}}
    @endif

    @if (Auth::user()->can('material'))
    {{-- material start --}}
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
            aria-selected="false">
            Material
        </a>
    </li>
    {{-- material end --}}
    @endif

    @if (Auth::user()->can('transportation'))
    {{-- transportation start --}}
    <li class="nav-item">
        <a class="nav-link" id="transportation-tab" data-toggle="tab" href="#transportation" role="tab"
            aria-controls="profile" aria-selected="false">
            Transportation
        </a>
    </li>
    {{-- transportation end --}}
    @endif

</ul>

<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="cash" role="tabpanel" aria-labelledby="cash-tab">

        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row justify-content-center" style="overflow-y: auto">

                        {{-- <div class="col-md-12 text-right">
                            <a href="{{ route('cashrequisition.payment.view') }}" class="btn btn-info ">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create
                            </a>
                        </div> --}}


                        <div class="col-md-12 mt-5" style="overflow-y: auto">

                            <table class="table table-hover table-bordered" id="cashrequisition-payment-table">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Action</th>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Project</th>
                                        <th>Tower</th>
                                        <th>Remarks</th>
                                        <th>Requisition</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row justify-content-center">

                        <div class="col-md-12 text-right">
                            <a href="{{ route('materialvendorpayment.create') }}" class="btn btn-info ">
                                <i class="fa fa-plus" aria-hidden="true"></i> Create
                            </a>
                        </div>

                        <div class="col-md-12 mt-5" style="overflow-y: auto">
                            <table class="table table-hover table-bordered" id="supplierpayment-material-table"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>Project</th>
                                        <th>Tower</th>
                                        <th>Payment No</th>
                                        <th>Payment Date</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="tab-pane fade" id="transportation" role="tabpanel" aria-labelledby="transportation-tab">
        <div class="tile">
            <div class="tile-body">
                <div class="">
                    <div class="row justify-content-center">

                        <div class="col-md-12 mt-5" style="overflow-y: auto">
                            <table class="table table-hover table-bordered" id="tbp-payment-table"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>System Serial</th>
                                        <th>Cost Head</th>
                                        <th>Project</th>
                                        <th>Vendor</th>
                                        <th>Bill</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@section('custom-script')

<script>
    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('cashrequisition.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }

    function deleteRowCash(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('cashrequisition.payment.delete', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }

    function deleteRowMaterial(id) {

        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('materialvendorpayment.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }

    }
</script>

@endsection
