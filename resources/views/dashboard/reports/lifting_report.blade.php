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
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2">
                                <option value="">Select an Option</option>
                                <option value="999999">Central Store</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if ($project->id == request()->project))
                                    selected
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unit_id">Unit</label>
                            <select class="select2" name="unit_id" id="unit_id">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ request()->start_date ? request()->start_date : $data->defaultDates['start_date'] }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ request()->end_date ? request()->end_date : $data->defaultDates['end_date'] }}"
                                required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logistics_associate">Logistics Associate</label>
                            <select name="logistics_associates[]" id="logistics_associate" class="select2" multiple>
                                {{-- <option value="">Select Vendor</option> --}}
                                @foreach ($data->logistics_vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if (request()->logistics_associates)
                                    @if (in_array($vendor->id, request()->logistics_associates))
                                    selected
                                    @endif
                                    @endif
                                    >{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vendors">Vendor</label>
                            <select name="vendors[]" id="vendors" class="select2" multiple>
                                {{-- <option value="">Select Material</option> --}}
                                @foreach ($data->vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if (request()->vendors)
                                    @if (in_array($vendor->id, request()->vendors))
                                    selected
                                    @endif
                                    @endif
                                    >{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lifting_type">Lifting Type</label>
                            <select name="lifting_type" id="lifting_type" class="select2">
                                <option value="">Select an option</option>

                                <option value="Client Provide To Project"
                                @if (request()->lifting_type == 'Client Provide To Project')
                                    selected
                                @endif
                                    >Client Provide To Project</option>

                                <option value="Client Provide To Central Store"
                                @if (request()->lifting_type == 'Client Provide To Central Store')
                                    selected
                                    @endif
                                    >Client Provide To Central Store</option>

                                <option value="Local Lifting To Project" @if (request()->lifting_type == 'Local Lifting To Project') selected @endif>Local Lifting To Project</option>
                                <option value="Product Lifting To Central Store" @if (request()->lifting_type == 'Product Lifting To Central Store') selected @endif>Product Lifting To
                                    Central Store</option>
                            </select>
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

                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary mb-2" name="search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search
                        </button>

                        <a target="_blank" href="{{ route('lifting.report.print', request()->all()) }}"
                            class="btn btn-primary mb-2">
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

                    @include('dashboard.reports.partials.lifting_log.lifting_log_table')

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('custom-script')
<script>
    function getProjectTower(){

        // get searched tower id from url
        let tower_id = "{{ request()->tower }}";

        let projectId = $('#project option:selected').val();

        // fetch tower start
        axios.get(route('projectwise.tower', projectId))
            .then(function (response) {

            const data = response.data.project_towers;

            let options = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let selected = "";

                if(el.id == tower_id){
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


    function projectWiseUnits(){

        // get searched unit id from request url
        let unit_id = "{{ request()->unit_id }}";


        // get input values
        const projectId = +$('#project option:selected').val();


        // if(projectId == ''){
        //     $('#unit_id').html('');
        //     return false;
        // }

        // fetch unit start
        axios.get(route('project.units', projectId))
            .then(function (response) {

            const data = response.data.project_units;

            let options = `<option value="">Select An Option</option>`;

            data.forEach(el => {

                let selected = "";

                if(el.unit.id == unit_id){
                    selected = "selected";
                }

                let option = `<option value="${el.unit.id}" ${selected}>${el.unit.name}</option>`;

                options += option;

            });


            $('#unit_id').html(options);


        })
        .catch(function (error) {
        })
        // fetch unit end

    }

    $(document).ready(function () {

        getProjectTower();
        projectWiseUnits();

        $('#project').change(function (e) {
            e.preventDefault();

            projectWiseUnits();
            getProjectTower();

        });

    });
</script>
@endsection
