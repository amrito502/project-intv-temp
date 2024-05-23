@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Packages</h4>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addNewvendor" aria-hidden="true" style="float: right;" onclick="summernote()">Add new</button>
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table id="packagesTable" class="table table-bordered table-striped"  name="packagesTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($packages as $package)
                            <tr>
                                <td>{{ $package->packageName }}</td>

                                <td>
                                    <span class="switchery-demo m-b-30" onclick="statusChange({{ $package->id }})">
                                    <input type="checkbox" {{ $package->packageStatus ? 'checked':'' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="{{ $package->id }}"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                                    <a href="{{ route('package.edit',$package->id) }}" data-toggle="tooltip" data-original-title="Edit" data-id="{{ $package->id }}"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$package->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
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
<!-- ============================================================== -->
<!-- End PAge Content -->




<!-- sample modal content for show vendor-->
<div id="showvendor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show vendor</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="showContent"  style="max-height: 80vh; overflow-y: scroll;">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@endsection

@section('custom-js')

    <!-- This is data table -->
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#packagesTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax


            //ajax show code
            $('#packagesTable tbody').on( 'click', 'i.fa-eye', function () {
                updateThis = this;
                package_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('categories.index') }}" + "/" + package_id + "/edit",
                    data: "package_id=" + package_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        vendor = response.vendor;
                        showFunction(vendor);
                    },
                    error: function(response) {
                        error = "Something wrong.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });



            //ajax delete code
            $('#packagesTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                package_id = $(this).parent().data('id');
                var package = this;

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                        $.ajax({
                            type: "DELETE",
                            // url: "{!! url('categories' ) !!}" + "/" + package_id,
                            url: "{{ route('packages.index') }}" + "/" + package_id,
                            // data: "package_id=" + package_id,
                            dataType: "JSON",
                            data: {
                                id:package_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Package Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(package).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>",
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });
                    } else {
                        swal({
                            title: "Cancelled",
                            type: "error",
                            text: "Your package is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

       //ajax status change code
        function statusChange(package_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('package.changeStatus', 0) }}",
                    data: "package_id=" + package_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });
                    }
                });
            }
    </script>
@endsection
