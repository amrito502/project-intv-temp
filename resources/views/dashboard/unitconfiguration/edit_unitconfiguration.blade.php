@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<input type="hidden" id="unitConfigFullJson" value="{{ $data->unitconfiguration->toJson() }}">

<form action="{{ route('unitconfiguration.update', $data->unitconfiguration->id) }}" method="POST">
    @csrf
    @method('patch')

    <div class="tile mb-3">
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
                                'company_id' => $data->unitconfiguration->company_id,
                            ])

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="project">Project</label>
                                    <select name="project_id" id="project" class="select2" required readonly>
                                        <option value="">Select Project</option>
                                        @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}" @if ($data->unitconfiguration->project_id ==
                                            $project->id)
                                            selected
                                            @endif
                                            >{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="units">Unit Name</label>
                                    <select name="unit_id" id="units" class="select2" required readonly>
                                        <option value="">Select Unit</option>
                                        @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}" @if ($data->unitconfiguration->unit_id == $unit->id)
                                            selected
                                            @endif
                                            >{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unit_id">Unit Config</label>
                                    <input type="text" class="form-control" name="unit_name"
                                        value="{{ $data->unitconfiguration->unit_name }}" readonly>
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
                <div class="col-md-12">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>


</form>

@endsection

@section('custom-script')

<script>
    $(function () {
        $("#project").select2({disabled:'readonly'});
        $("#units").select2({disabled:'readonly'});
    });
</script>

@include('dashboard.helper_js')
@include('dashboard.unitconfiguration.partials.change_forms')
@include('dashboard.unitconfiguration.partials.unitNameGeneration')


@endsection
