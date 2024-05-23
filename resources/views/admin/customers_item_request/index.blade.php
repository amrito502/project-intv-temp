@extends('admin.layouts.master')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
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
                                    <th width="60px">Image</th>
                                    <th width="20px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                            	@foreach($customerItemRequestList as $customerItemRequest)
                                @php $sl++; @endphp
                                <tr class="row_{{ @$customerItemRequest->id }}">
                                    <td>{{ $sl }}</td>
                                    <td>{{ @$customerItemRequest->name }}</td>
                                    <td>{{ @$customerItemRequest->email }}</td>
                                    <td>{{ @$customerItemRequest->mobile }}</td>
                                    <td>
                                        @php
                                            if(file_exists(@$customerItemRequest->itemList)){
                                                $image = asset($customerItemRequest->itemList);
                                            }else{
                                                $image = $noImage;
                                            }
                                        @endphp
                                        <a data-fancybox="gallery" href="{{ $image }}">
                                            <img src="{{ $image }}" style="height: 40px;width: 60px;">
                                        </a>

                                    </td>
                                    <td class="text-nowrap">
                                    <?php echo \App\Link::action($customerItemRequest->id)?>
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

                customerItemRequestId = $(this).parent().data('id');
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
                            url : "{{ route('customer.itemRequestDelete') }}",
                            data : {customerItemRequestId:customerItemRequestId},
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Customer Item Request Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                $('.row_'+customerItemRequestId).remove();
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
