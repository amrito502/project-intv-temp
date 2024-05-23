@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

<?php
    use App\Vendors;
?>

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route('cashPurchase.add')}}">
                                <i class="fa fa-plus-circle"></i> Add New
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

                    Session::forget('msg')
                @endphp
                <?php

                ?>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-striped" name="dataTable">
                        <thead>
                            <tr>
                                <th width="20px">SL</th>
                                <th>Voucher Serial</th>
                                <th>Voucher NO</th>
                                <th>Supplier</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total Quantity</th>
                                <th>Total Amount</th>
                                <th width="20px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @php $sl = 0; @endphp
                        	@foreach($cashPurchase as $purchase)
                            @php
                                $sl++;
                                $voucher_date = Date('d-m-Y',strtotime($purchase->voucher_date));
                             @endphp
                        	<tr>
                                <td>{{ $sl }}</td>
                                <td>{{ $purchase->cash_serial }}</td>
                                <td>{{ $purchase->voucher_no }}</td>
                                <td>{{ @$purchase->vendorName }}</td>
                                <td>{{ $voucher_date }}</td>
                                <td class="text-left">
                                    <ul>
                                        @foreach ($purchase->items as $item)
                                        <li>{{ $item->product->name }} - {{ $item->qty }}Pcs - {{
                                            $item->amount_cash }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ @$purchase->total_qty }}</td>
                                <td>{{ @$purchase->invoiceTotalCostAmount() }}</td>

                                <td class="text-nowrap">
                                    <?php echo \App\Link::action($purchase->id)?>
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

                cashPurchaseId = $(this).parent().data('id');
                var tableRow = this;
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
                           url : "{{ route('cashPurchase.destroy') }}",
                            data : {cashPurchaseId:cashPurchaseId},

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Cash Purchase Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(tableRow).parents('tr'))
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
