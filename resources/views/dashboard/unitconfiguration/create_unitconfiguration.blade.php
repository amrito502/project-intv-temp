@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form method="POST" action="{{ route('unitconfiguration.store') }}">
    @csrf

    <input type="hidden" id="unitConfigFullJson" value="{}">


    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-3">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">


                <div class="row">

                    <div class="col-md-4">
                        <div class="row">

                            @include('dashboard.layouts.partials.company_dropdown', [
                                'columnClass'=> 'col-md-12',
                                'company_id' => 0,
                            ])

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project">Project</label>
                                    <select name="project_id" id="project" onchange="getProjectWiseUnit()"
                                        class="select2" required>
                                        <option value="">Select Project</option>
                                        @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}" code="{{ $project->project_code }}">{{
                                            $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="units">Unit Name</label>
                                    <select name="unit_id" id="units" class="select2" required>
                                        <option value="">Select Project First</option>
                                        {{-- @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}" code="{{ $unit->code }}">{{ $unit->name }}
                                        </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_id">Unit Config</label>
                                    <input type="text" class="form-control" name="unit_name" id="unit_name" readonly>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row dynamic-form">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>


</form>
@endsection
@section('custom-script')

@include('dashboard.helper_js')
@include('dashboard.unitconfiguration.partials.change_forms')
@include('dashboard.unitconfiguration.partials.unitNameGeneration')


<script>
    function getProjectWiseUnit() {
        const projectId = +$('#project').val();

        if(projectId == ''){
            $('#units').html('');
            return false;
        }

        axios.get(route('project.units', projectId))
        .then(function (response) {

            const data = response.data.project_units;

            let options = '<option>Select An Option</option>';

            data.forEach(el => {

                let option = `<option code="${el.unit.code}" value="${el.unit.id}">${el.unit.name}</option>`;

                options += option;

            });


            $('#units').html(options);

        })
        .catch(function (error) {
        })
    }
</script>

@endsection
