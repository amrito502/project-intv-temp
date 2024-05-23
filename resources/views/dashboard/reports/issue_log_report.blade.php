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
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ request()->start_date ? request()->start_date : $data->defaultDates['start_date'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ request()->end_date ? request()->end_date : $data->defaultDates['end_date'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="material">Material</label>
                            <select name="materials[]" id="materials" class="select2" multiple>
                                {{-- <option value="">Select Material</option> --}}
                                @foreach ($data->materials as $material)
                                <option value="{{ $material->id }}" @if (request()->materials)
                                    @if (in_array($material->id, request()->materials))
                                    selected
                                    @endif
                                    @endif
                                    >{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="source_project">Source Project</label>
                            <select name="source_project" id="source_project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if (request()->source_project)
                                    @if ($project->id == request()->source_project)
                                    selected
                                    @endif
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="source_tower">Source Tower</label>
                            <select class="select2" name="source_tower" id="source_tower">
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="destination_project">Destination Project</label>
                            <select name="destination_project" id="destination_project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if (request()->destination_project)
                                    @if ($project->id == request()->destination_project)
                                    selected
                                    @endif
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="destination_tower">Destination Tower</label>
                            <select class="select2" name="destination_tower" id="destination_tower">
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

                        <a target="_blank" href="{{ route('issue.log.report.print', request()->all()) }}"
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
                <div class="col-md-12" style="overflow-y: auto">

                    @if (request()->has('search'))

                    @include('dashboard.reports.partials.issue_log.issue_log_table')

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-script')
<script>
    function getProjectWiseTowers(id, outputEl) {

        // fetch tower start
        axios.get(route('projectwise.tower', id))
            .then(function (response) {

            const data = response.data.project_towers;

            let options = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let option = `<option value="${el.id}">${el.name}</option>`;

                options += option;

            });

            $(outputEl).html(options);

        })
        .catch(function (error) {
        })
        // fetch tower end

    }

    $(document).ready(function () {

        getProjectWiseTowers($('#source_project option:selected').val(), '#source_tower');
        getProjectWiseTowers($('#destination_project option:selected').val(), '#destination_tower');

        // source project wise units start
        $('#source_project').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            if(projectId == ''){
                $('#source_unit_id').html('');
                return false;
            }

            getProjectWiseTowers(projectId, '#source_tower');

        });
        // source project wise units end


        // issue project wise units start
        $('#destination_project').change(function (e) {
            e.preventDefault();

            const projectId = +$(this).val();

            if(projectId == ''){
                $('#issue_unit_id').html('');
                return false;
            }

            getProjectWiseTowers(projectId, '#destination_tower');


        });
        // issue project wise units end


    });
</script>
@endsection
