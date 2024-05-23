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
                <h4 class="card-title">Manage Policies</h4>


                <a href="{{ route('offer.add') }}" type="submit" class="btn btn-info" style="float: right;">Add new</a>

                <div class="table-responsive">
                     <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg');

                ?>
                    <table id="offersTable" class="table table-bordered table-striped"  name="offersTable">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Promo Code</th>
                                <th>Start Date</th>
                                <th>Expire Date</th>
                                <th>Discount Type</th>
                                <th>Minimum Purchase</th>
                                <th>Amount/Percent</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($offers as $offer)
                        	<tr id="{{$offer->id}}">
                        	    <td>{{ $loop->iteration }}</td>
                                <td>{{ $offer->promo_code }}</td>
                                <td>{{ date('d-m-Y', strtotime($offer->start)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($offer->expire)) }}</td>
                                <td class="text-capitalize">{{ $offer->type }}</td>
                                <td class="text-right">{{ $offer->minimum_amount }}</td>
                                <td class="text-right">
                                    @if($offer->type == 'fix')
                                    {{ number_format($offer->discount,2 ,'.', '') }} Tk
                                    @else
                                    {{ round($offer->discount) }} %
                                    @endif
                                </td>
                                <td>
                                    <?php echo \App\Link::status($offer->id,$offer->status)?>
                                </td>
                                <td class="text-nowrap">
                                    <?php echo \App\Link::action($offer->id)?>
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

            var table = $('#offersTable').DataTable( {
                "order": [[ 2, "asc" ]]
            } );

         //ajax delete code
            $('#offersTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                var id = $(this).parent().data('id');

                console.log(id);
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
                            type: "post",
                            url: "{{ route('offer.delete') }}",
                            data: {id:id},
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Offer deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row($('#' + id))
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
                            text: "Your offer is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });
        });


        //ajax status change code
        function statusChange(id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('offer.status', 0) }}",
                    data: "id=" + id,
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
