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
                    <h2 class="h2 text-center text-uppercase">User List</h2>
                </div>

                @can('create user')

                <div class="col-md-2 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create</a>
                </div>

                @endcan

            </div>
        </div>
    </div>
</div>

<div class="">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="tile">
                <div class="tile-body" style="overflow-y: auto">
                    <table class="table table-hover table-bordered" id="user-table">
                        <thead>
                            <tr>
                                <th style="width:210px;">Action</th>
                                <th style="width:40px;">Status</th>
                                <th>#</th>
                                <th>Roles</th>
                                <th>Username</th>
                                <th>Company Name</th>
                                <th>Wing Name</th>
                                <th>Project Name</th>
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
        axios.get(route('user.toggle.status', id))
        .then(function (response) {
        })
        .catch(function (error) {
        })
    }

    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c){
            axios.delete(route('user.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            });

            trEl.remove();
        }
    }
</script>

@endsection
