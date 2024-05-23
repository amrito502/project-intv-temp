@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

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
                    <h2 class="h2 text-center text-uppercase">Action Menu List</h2>
                </div>
                @can('create module')
                <div class="col-md-2">
                    <a href="{{ route('actionmenu.create', $menuId) }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create</a>
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

                    <table class="table table-hover table-bordered" id="action-menu-table">
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


    // action menu table

    document.addEventListener("DOMContentLoaded", function() {

        $("#action-menu-table").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: '{{ route("actionmenu.index", $menuId) }}',
            rowId: "id",
            columns: [
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            { data: "parent_menu_name", name: "parent_menu_name" },
            { data: "name", name: "name" },
            { data: "url", name: "url" },
            // { data: "is_action_menu", name: "is_action_menu" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }
            ]
        });

    });


</script>

@endsection
