@extends('dashboard.layouts.app')

@section('content')
    <form method="POST" action="{{ route('logisticCharge.store') }}">
        @csrf
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
                        @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass' => 'col-md-4',
                            'company_id' => 0,
                        ])
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="project">Project</label>
                                <select name="project" id="project" class="select2" required>
                                    <option value="">Select Project</option>
                                    @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="general_transportation_charge">General Transportation Charge</label>
                                <input type="number" step="any" class="form-control"
                                    name="general_transportation_charge" required>
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
                                <tbody id="tbody">
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
    <script>
        $(document).ready(function() {

            // get projectwise materials start
            $('#project').on('change', function() {
                var project_id = $(this).val();

                if (project_id == '') {
                    $('#tbody').html('');
                    return false;
                }

                if (project_id != '') {
                    $.ajax({
                        url: "{{ route('logisticCharge.getMaterials') }}",
                        type: "GET",
                        data: {
                            project_id: project_id,
                        },
                        success: function(data) {
                            $('#tbody').html(data);
                        }
                    });
                }
            });
            // get projectwise materials end

        });
    </script>
@endsection
