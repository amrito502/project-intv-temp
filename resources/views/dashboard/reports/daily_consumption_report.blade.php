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

$unitIds = [];
if(request()->units){
foreach (request()->units as $unitId) {
array_push($unitIds, (int)$unitId);
}
}


$towerIds = [];
if(request()->towers){
foreach (request()->towers as $towerId) {
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
                            <select name="project" id="project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option pt="{{ $project->project_type }}" value="{{ $project->id }}" @if (request()->
                                    project == $project->id)
                                    selected
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="units">Unit</label>
                            <select name="units[]" id="units" class="select2" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="towers">Towers</label>
                            <select name="towers[]" id="towers" class="select2" multiple>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ request()->start_date ? request()->start_date : $data->defaultDates['start_date'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ request()->end_date ? request()->end_date : $data->defaultDates['end_date'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="material">Material</label>
                            <select name="materials[]" id="materials" class="select2" multiple>
                                @foreach ($data->materials as $material)
                                <option value="{{ $material->id }}" @if(request()->materials)
                                    @if ( in_array($material->id, request()->materials))
                                    selected
                                    @endif
                                    @endif
                                    >{{ $material->name }}</option>
                                @endforeach
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

                        <a target="_blank" href="{{ route('daily.consumption.report.print', request()->all()) }}" class="btn btn-primary mb-2" name="search">
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
                <div class="col-md-12" style="overflow-y: auto">

                    @if (request()->has('search'))

                    @include('dashboard.reports.partials.daily_consumption.daily_consumption_table')

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-script')

<script>
    function getProjectWiseUnits() {

        const projectId = +$('#project').val();

        // if(projectId == ''){
        //     $('#unit_ids').html('');
        //     return false;
        // }

        let unitIds = {{ json_encode($unitIds) }};

        axios.get(route('project.units', projectId))
            .then(function(response) {

                const data = response.data.project_units;

                let options = '';

                data.forEach(el => {

                    let selected = "";

                    if (unitIds.includes(el.unit.id)) {
                        selected = "selected";
                    }

                    let option = `<option value="${el.unit.id}" ${selected}>${el.unit.name}</option>`;

                    options += option;

                });


                $('#units').html(options);

            })
            .catch(function(error) {})

    }

    function getProjectWiseTowers() {

        let projectId = +$('#project').val();
        let projectType = $('#project option:selected').attr('pt');

        // if(projectId == ''){
        //     $('#unit_ids').html('');
        //     $('#towers').html('');
        //     return false;
        // }

        let towerIds = {{ json_encode($towerIds) }};

        axios.get(route('projectwise.tower', projectId))
            .then(function(response) {

                const data = response.data.project_towers;

                let options = '';

                data.forEach(el => {

                    let selected = "";

                    if (towerIds.includes(el.id)) {
                        selected = "selected";
                    }

                    let option = `<option value="${el.id}" ${selected}>${el.name}</option>`;

                    options += option;

                });

                $('#towers').html(options);

            })
            .catch(function(error) {})

    }

    $(function() {

        getProjectWiseUnits();
        getProjectWiseTowers();

        $('#project').change(function(e) {
            e.preventDefault();

            getProjectWiseUnits();
            getProjectWiseTowers()

        });

    });

</script>

@endsection
