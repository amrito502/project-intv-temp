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

    @php
        $unitIds = [];
        if (request()->unit_ids) {
            foreach (request()->unit_ids as $unitId) {
                array_push($unitIds, (int) $unitId);
            }
        }

        $towerIds = [];
        if (request()->towers) {
            foreach (request()->towers as $towerId) {
                array_push($towerIds, (int) $towerId);
            }
        }

    @endphp

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
                                        <option value="{{ $project->id }}"
                                            @if (request()->project == $project->id) selected @endif>{{ $project->project_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unit_ids">Unit</label>
                                <select class="select2" name="unit_ids[]" id="unit_ids" multiple>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tower">Tower</label>
                                <select class="select2" name="towers[]" id="tower" multiple>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-right" style="margin-top: 29px;">
                            <button type="submit" class="btn btn-primary mb-1" name="search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Search
                            </button>

                            <a target="_blank" href="{{ route('plan.sheet.follow.up.print', request()->all()) }}"
                                class="btn btn-primary mb-1" name="search">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print
                            </a>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-2">
                            <div class="row">

                                <div class="col-md text-right">

                                    {{-- <button type="submit" class="btn btn-primary" name="search">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Search
                                </button>

                                <a target="_blank" href="{{ route('plan.sheet.follow.up.print', request()->all()) }}"
                                    class="btn btn-primary" name="search">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                    Print
                                </a> --}}
                                </div>

                            </div>
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
                            @include('dashboard.reports.partials.plan_sheet.with_unit')
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
        function getProjectWiseUnit() {
            const projectId = +$('#project').val();

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

                    $('#unit_ids').html(options);

                })
                .catch(function(error) {})
        }

        function getProjectWiseTower() {

            let projectId = $('#project option:selected').val();

            let towerIds = {{ json_encode($towerIds) }};

            // fetch tower start
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

                    $('#tower').html(options);

                })
                .catch(function(error) {})
            // fetch tower end
        }



        $(document).ready(function() {

            getProjectWiseUnit();
            getProjectWiseTower();

            $('#project').change(function(e) {
                e.preventDefault();


                getProjectWiseUnit();
                getProjectWiseTower();

            });

        });
    </script>
    {{-- projectwise unit end --}}
@endsection
