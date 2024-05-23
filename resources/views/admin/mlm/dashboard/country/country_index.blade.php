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
                    <h2 class="h2 text-center">Country List</h2>
                </div>

                @can('create country')

                <div class="col-md-2">
                    <a href="{{ route('country.create') }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create New</a>
                </div>

                @endcan

            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <table class="table table-hover table-bordered" id="country-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
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
    function toggleStatus(id){
        axios.get(route('country.toggle.status', id))
        .then(function (response) {
        })
        .catch(function (error) {
        })
    }

    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('country.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }
</script>

@endsection
