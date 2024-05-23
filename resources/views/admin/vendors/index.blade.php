@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<?php
    use App\UserMenu;
?>

@section('content')

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
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('vendor.add')}}">
                                <i class="fa fa-plus-circle"></i> Add new
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg');
                      $sl = 0;
                @endphp
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-striped"  name="dataTable">
                        <thead>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Order</th>
                                <th width="20px">Status</th>
                                <th width="20px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($vendors as $vendor)
                                @php $sl++; @endphp
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $vendor->vendor_serial }}</td>
                                    <td>{{ $vendor->vendorName }}</td>
                                    <td>{{ $vendor->vendorAddress }}</td>
                                    <td>{{ $vendor->vendorPhone }}</td>
                                    <td>{{ $vendor->vendorEmail }}</td>
                                    <td>{{ $vendor->orderBy }}</td>
                                    <td>
                                        <?php echo \App\Link::status($vendor->id,$vendor->vendorStatus)?>
                                    </td>
                                    <td class="text-nowrap">
                                    <?php echo \App\Link::action($vendor->id)?>
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

            // var table = $('#dataTable').DataTable( {
            //     "order": [[ 0, "asc" ]]
            // } );

            // table.on('order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();

            //ajax

            //ajax delete code
            $('#dataTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                vendorId = $(this).parent().data('id');
                var vendor = this;
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
                           url : "{{ route('vendor-delete') }}",
                            data : {vendorId:vendorId},

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Vendor Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(vendor).parents('tr'))
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
                            text: "Your vendor is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(vendor_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('vendor.status', 0) }}",
                    data: "vendor_id=" + vendor_id,
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

            function summernote(){
                $('.summernote').summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false // set focus to editable area after initializing summernote
                });
            }
    </script>
@endsection
