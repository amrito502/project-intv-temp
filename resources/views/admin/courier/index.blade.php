@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<?php
    use App\Category;

?>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style=" font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('courieradd.page')}}">
                                <i class="fa fa-plus-circle"></i> Add new
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                   <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                ?>
                    <table id="categoriesTable" class="table table-bordered table-striped"  name="categoriesTable">
                        <thead>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th width="20px">Status</th>
                                <th width="20px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $i= 1; ?>
                        	@foreach($couriers as $courier)
                        	<tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $courier->name }}</td>
                                <td>{{ $courier->contact_person }}</td>
                                <td>{{ $courier->contact_number }}</td>
                                <td>{{ $courier->email }}</td>
                                <td>{{ $courier->address }}</td>
                                <td>
                                    <?php echo \App\Link::status($courier->id,$courier->status)?>
                                </td>
                                <td class="text-nowrap">
                                   <?php echo \App\Link::action($courier->id)?>
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
<!-- ============================================================== -->


<!-- sample modal content for show category-->
<div id="showCategory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="showContent">
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

            var table = $('#categoriesTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax



            //ajax delete code
            $('#categoriesTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                charge_id = $(this).parent().data('id');
                var shippingCharges = this;
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
                            type: "POST",
                            url: "{{ route('courier.delete') }}",
                            data: {
                                charge_id:charge_id
                            },

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Courier Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(shippingCharges).parents('tr'))
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
                            text: "Courier is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(charge_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('courier.status', 0) }}",
                    data: "charge_id=" + charge_id,

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
