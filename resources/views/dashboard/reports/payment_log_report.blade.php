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

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2">
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if (request()->project)
                                    @if ($project->id == request()->project)
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
                            <label for="tower">Tower</label>
                            <select class="select2" name="tower" id="tower">
                                <option value="">Select Project First</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="select2">
                                <option value="">Select Vendor</option>
                                @foreach ($data->vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if (request()->vendor)
                                    @if ($vendor->id == request()->vendor)
                                    selected
                                    @endif
                                    @endif
                                    >{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="units">Unit</label>
                            <select name="units[]" id="units" class="select2" multiple>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date"
                                value="{{ request()->start_date ? request()->start_date : $data->defaultDates['start_date'] }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date"
                                value="{{ request()->end_date ? request()->end_date : $data->defaultDates['end_date'] }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="budgetHeads">Budget Head</label>
                            <select name="budgetHeads[]" id="budgetHeads" class="select2" multiple>
                                @foreach ($data->budgetHeads as $budgetHead)
                                <option value="{{ $budgetHead->id }}" @if (request()->budgetHeads)
                                    @if (in_array($budgetHead->id, request()->budgetHeads))
                                    selected
                                    @endif
                                    @endif
                                    >{{ $budgetHead->name }}</option>
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

                        <a target="_blank" href="{{ route('payment.log.report.print', request()->all()) }}"
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

                    @include('dashboard.reports.partials.payment_log.payment_log_table')

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

        // get searched unit id from request url
        @if(request()->units)
        let unit_ids = [{{ implode(',', request()->units) }}];
        @else
        let unit_ids = [];
        @endif

        const projectId = +$('#project').val();

        // if(projectId == ''){
        //     $('#unit_ids').html('');
        //     return false;
        // }

        axios.get(route('project.units', projectId))
        .then(function (response) {

            const data = response.data.project_units;

            let options = '';

            data.forEach(el => {

                let selected = "";

                if(unit_ids.includes(el.unit.id)){
                    selected = "selected";
                }

                let option = `<option value="${el.unit.id}" ${selected}>${el.unit.name}</option>`;

                options += option;

            });


            $('#units').html(options);

        })
        .catch(function (error) {
        })

    }

    $(function () {

        getProjectTower();
        getProjectWiseUnits();

        $('#project').change(function (e) {
            e.preventDefault();

            getProjectWiseUnits();
            getProjectTower();

        });

    });

</script>


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

</script>
@endsection
