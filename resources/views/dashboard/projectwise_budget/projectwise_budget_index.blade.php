@extends('dashboard.layouts.app')


@section('custom-css')
<style>
    #projectwisebudget-table_length {
        display: flex;
    }

    div.dataTables_wrapper div.dataTables_filter {
        margin-top: 30px;
    }

    #projectwisebudget-table_length > label{
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
                    <h2 class="h2 text-center text-uppercase">Budget Prepare List</h2>
                </div>
                @can('create projectwisebudget')
                <div class="col-md-2 text-right">
                    <a href="{{ route('projectwisebudget.create') }}" class="btn btn-info"><i class="fa fa-plus"
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

                <table class="table table-hover table-bordered" id="projectwisebudget-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>#</th>
                            <th>DateRange</th>
                            <th>Project</th>
                            <th>Unit</th>
                            <th>Unit Configuration</th>
                            <th>Long/Volume</th>
                            <th>Pile Qty</th>
                            <th>Total Amount</th>
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
            axios.delete(route('projectwisebudget.destroy', id))
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
            window.location.href = route('projectwisebudget.index') + "?project_id=" + projectId;
        }else{
            window.location.href = route('projectwisebudget.index');
        }
    }


    $(document).ready(function () {

        $('#project').change(function (e) {
            e.preventDefault();

            redirectProjectFilter();

        });

        let url = window.location.href;

        $("#projectwisebudget-table").DataTable({
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
                    data: "dateRange",
                    name: "dateRange"
                },
                {
                    data: "project_name",
                    name: "project_name"
                },
                {
                    data: "unit_name",
                    name: "unit_name"
                },
                {
                    data: "unit_config_name",
                    name: "unit_config_name"
                },
                {
                    data: "longOrVolume",
                    name: "longOrVolume"
                },
                {
                    data: "number_of_pile",
                    name: "number_of_pile"
                },
                {
                    data: "total_amount",
                    name: "total_amount"
                }
            ]
        });

        let projectDropdown = $('#project-dropdown').html();

        $('#projectwisebudget-table_length').append(projectDropdown);

        $('#project-dropdown').html('');

        $('#project').select2();

    });
</script>



@endsection
