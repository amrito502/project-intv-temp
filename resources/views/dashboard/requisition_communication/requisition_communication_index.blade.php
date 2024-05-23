@extends('dashboard.layouts.app')

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
                    <h2 class="h2 text-center text-uppercase">Requisition Communication List</h2>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">

                @foreach ($data->cashRequisitions as $cashRequisition)

                <div class="col-md-4 my-1">

                    @include('dashboard.requisition_communication.partials.cash_requisition_card', ['cashRequisition' =>
                    $cashRequisition])

                </div>

                @endforeach


                <div class="col-md-12 mt-4">
                    {{ $data->cashRequisitions->links() }}
                </div>
            </div>

        </div>
    </div>
</div>


@endsection
