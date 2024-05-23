@extends('dashboard.layouts.app')


@section('custom-css')
<style>
    #materialissue-table_length {
        display: flex;
    }

    div.dataTables_wrapper div.dataTables_filter {
        margin-top: 30px;
    }

    #materialissue-table_length > label{
        margin-top: 30px;
        margin-right: 30px;
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
                    <h2 class="h2 text-center text-uppercase">Material Transfer List</h2>
                </div>
                @can('create materialissue')
                <div class="col-md-2 text-right">
                    <a href="{{ route('materialissue.create') }}" class="btn btn-info"><i class="fa fa-plus"
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
                <div class="form-group w-50">
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

                <table class="table table-hover table-bordered" id="materialissue-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>#</th>
                            <th>Date</th>
                            <th>System Serial</th>
                            <th>Source Project</th>
                            <th>Issue Project</th>
                            <th>Materials</th>
                            <th>Status</th>
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
            axios.delete(route('materialissue.destroy', id))
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
            window.location.href = route('materialissue.index') + "?project_id=" + projectId;
        }else{
            window.location.href = route('materialissue.index');
        }
    }

    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            redirectProjectFilter();

        });


        let url = window.location.href;

        $("#materialissue-table").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
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
                    data: "vouchar_date_formatted",
                    name: "vouchar_date_formatted"
                },
                {
                    data: "system_serial",
                    name: "system_serial"
                },
                {
                    data: "source_project_name",
                    name: "source_project_name"
                },
                {
                    data: "issue_project_name",
                    name: "issue_project_name"
                },
                {
                    data: "materials",
                    name: "materials"
                },
                {
                    data: "status",
                    name: "status"
                }
            ]
        });


        let projectDropdown = $('#project-dropdown').html();

        $('#materialissue-table_length').append(projectDropdown);

        $('#project-dropdown').html('');

        $('#project').select2();


    });


</script>

@endsection
