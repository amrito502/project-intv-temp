@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center">Modules List</h2>
                </div>
                @can('create module')
                <div class="col-md-2">
                    <a href="{{ route('module.create') }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create New</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body" style="overflow-y: auto">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <table class="table table-hover table-bordered" id="module-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Parent Name</th>
                                <th>Module Name</th>
                                <th>Module Url</th>
                                {{-- <th>Is Action Menu</th> --}}
                                <th>Action</th>
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


<script>
    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('module.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }
</script>

@endsection