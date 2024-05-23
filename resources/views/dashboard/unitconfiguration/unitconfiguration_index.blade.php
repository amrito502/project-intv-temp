@extends('dashboard.layouts.app')


@section('custom-css')
<style>
    div.dataTables_wrapper div.dataTables_filter {
        margin-top: 30px;
    }
</style>
@endsection

@section('content')

@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center text-uppercase">Unit Estimation List</h2>
                </div>
                @can('create unitconfiguration')
                <div class="col-md-2 text-right">
                    <a href="{{ route('unitconfiguration.create') }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body" style="overflow-y: auto">

        <div class="row d-none">
            <div class="col-md-4" id="project-dropdown">
                <div class="form-group-inline  w-50">
                    <label for="">Project: </label>
                    <select name="project" id="project" onchange="redirectProjectFilter()" class="form-control">
                        <option value="">All</option>
                        @foreach ($projects as $project)
                        <option value="{{ $project->id }}" @if (request()->project_id == $project->id)
                            selected
                            @endif
                            >{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table table-hover table-bordered" id="unitconfiguration-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>#</th>
                            <th>Project Name</th>
                            <th>Unit Name</th>
                            <th>Unit Config</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@endsection


@section('custom-script')

<script>
    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('unitconfiguration.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }

    function redirectProjectFilter(){

        let projectId = $('#project').val();

        if(projectId){
            window.location.href = route('unitconfiguration.index') + "?project_id=" + projectId;
        }else{
            window.location.href = route('unitconfiguration.index');
        }
    }

    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            redirectProjectFilter();

        });

        let url = window.location.href;

        $("#unitconfiguration-table").DataTable({
            // dom: '<"toolbar">frtip',
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: url,
            rowId: "id",
            columns: [{
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "DT_RowIndex",
                    name: "DT_RowIndex",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "project.project_name",
                    name: "project.project_name"
                },
                {
                    data: "unit.name",
                    name: "unit.name"
                },
                {
                    data: "unit_name",
                    name: "unit_name"
                },
            ]
        });

        $('#unitconfiguration-table_length').html('');

        let projectDropdown = $('#project-dropdown').html();

        $('#unitconfiguration-table_length').html(projectDropdown);

        $('#project-dropdown').html('');

        $('#project').select2();

    });

</script>

@endsection
