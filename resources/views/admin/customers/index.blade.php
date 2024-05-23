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
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    {{-- <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 30px; font-size: 16px;" class="btn btn-info btn-lg" href="{{ route('customer.customerAdd')}}">
                                <i class="fa fa-puls-circle"></i> Add new
                            </a>
                        </span>
                    </div> --}}
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @php
                        $message = Session::get('msg');
                        if (isset($message)) {
                            echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                        }

                        Session::forget('msg');
                        $sl = 0;
                    @endphp

                    <table id="customersTable" class="table table-bordered table-striped"  name="customersTable">
                        <thead>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th width="20px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($customers as $customer)
                            @php $sl++; @endphp
                            <tr class="row_{{ @$customer->id }}">
                                <td>{{ $sl }}</td>
                                <td>{{ @$customer->name }}</td>
                                <td>{{ @$customer->email }}</td>
                                <td>{{ @$customer->mobile }}</td>
                                <td class="text-nowrap">
                                <?php echo \App\Link::action($customer->id)?>
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


<!-- sample modal content for show customer-->
<div id="showcustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show customer</h4>
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

            var table = $('#customersTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax


            //ajax delete code
            $('#customersTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                customerId = $(this).parent().data('id');
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
                            url : "{{ route('customer.customerDestroy') }}",
                            data : {customerId:customerId},
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Customer Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                $('.row_'+customerId).remove();
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
                            text: "Your article is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });


    </script>
@endsection
