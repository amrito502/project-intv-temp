@extends('dashboard.layouts.app')

@section('custom-css')

<style>
    .heading-color-one th,
    .heading-color-one td {
        background-color: rgb(0, 120, 109) !important;
    }

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

    .no-padding td {
        padding: 0 5px !important;
        font-weight: bold;
    }

    .text-danger {
        color: #fd041c !important;
    }
</style>

@endsection

@section('content')
@include('dashboard.layouts.partials.error')


<div class="d-print-none tile mb-3">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center text-uppercase">{{ $data->title }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>


@php

$towerIds = [];
if(request()->tower){
foreach (request()->tower as $towerId) {
array_push($towerIds, (int)$towerId);
}
}

@endphp

<div class="d-print-none tile">
    <div class="tile-body">
        <div class="container-fluid">

            <form action="" method="get">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if (request()->project == $project->id)
                                    selected
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower[]" id="tower" multiple>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary mb-2" name="search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search
                        </button>

                        <a target="_blank" href="{{ route('cash.due.status.print', request()->all()) }}"
                            class="btn btn-primary mb-2" name="search">
                            <i class="fa fa-print" aria-hidden="true"></i>
                            Print
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    @if (request()->has('search'))

                    @include('dashboard.reports.partials.cash_due_status.with_unit')

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-script')
{{-- projectwise unit start --}}
<script>
    function getProjectWiseTower(){

        let projectId = $('#project option:selected').val();

        let towerIds = {{ json_encode($towerIds) }};

        console.log(towerIds);

        // fetch tower start
        axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

            const data = response.data.project_towers;

            let options = ``;

            data.forEach(el => {

                let selected = "";

                if(towerIds.includes(el.id)){
                    selected = "selected";
                }

                let option = `<option value="${el.id}" ${selected}>${el.name}</option>`;

                options += option;

            });


            $('#tower').html(options);

        })
        .catch(function (error) {
        })
        // fetch tower end
    }

    $(document).ready(function () {

        getProjectWiseTower();

        $('#project').change(function (e) {
            e.preventDefault();

            getProjectWiseTower();

        });

    });
</script>
{{-- projectwise unit end --}}
@endsection
