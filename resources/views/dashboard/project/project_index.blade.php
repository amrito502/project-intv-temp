@extends('dashboard.layouts.app')

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
                    <h2 class="h2 text-center text-uppercase">Project List</h2>
                </div>
                @can('create project')
                <div class="col-md-2 text-right">
                    <a href="{{ route('project.create') }}" class="btn btn-info"><i class="fa fa-plus"
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
        <div class="">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <table class="table table-hover table-bordered" id="project-table">
                        <thead>
                            <tr>
                                <th style="width:20px;">Dashboard</th>
                                <th style="width:50px;">Action</th>
                                <th>#</th>
                                <th style="width:90px;">Company</th>
                                <th style="width:100px;">Branch</th>
                                <th >Project</th>
                                <th>Units</th>
                                <th>Towers</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
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
            axios.delete(route('project.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }

    function toggleDashboardStatus(id){
        axios.get(route('project.toggleDashboardStatus', id))
        .then(function (response) {
        })
        .catch(function (error) {
        })
    }
</script>
@endsection
