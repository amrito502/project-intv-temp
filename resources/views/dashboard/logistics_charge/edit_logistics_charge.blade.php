@extends('dashboard.layouts.app')

@section('content')
    @include('dashboard.layouts.partials.error')
    <form action="{{ route('logisticCharge.update', $data->logisticCharge->id) }}" method="POST">
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
                        @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass' => 'col-md-4',
                            'company_id' => $data->logisticCharge->company_id,
                        ])

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="project">Project</label>
                                <select name="project" id="project" class="select2" required>
                                    <option value="">Select Project</option>
                                    @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}"
                                            @if ($project->id == $data->logisticCharge->project_id) selected @endif>{{ $project->project_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="general_transportation_charge">General Transportation Charge</label>
                                <input type="number" step="any" class="form-control"
                                    name="general_transportation_charge"
                                    value="{{ $data->logisticCharge->general_transportation_charge }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 33%;">Material & UOM</th>
                                        <th>Rate Per UOM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->materials as $material)
                                        <tr>
                                            <td>{{ $material->name }} ({{ $material->materialUnit->name }})</td>
                                            <td>
                                                <input type="number" step="any" class="form-control"
                                                    name="materials[{{ $material->id }}]"
                                                    value="{{ @$data->logisticCharge->items->where('material_id', $material->id)->first()->material_rate }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        $(document).ready(function() {
            let parentValue = $('#parent_id').val();
            if (parentValue != '') {
                $('#action_menu').show();
            } else {
                $('#action_menu').hide();
            }

            $('#parent_id').change(function(e) {
                e.preventDefault();
                let parentValue = $(this).val();
                if (parentValue != '') {
                    $('#action_menu').show();
                } else {
                    $('#action_menu').hide();
                }
            });
        });
    </script>
@endsection
