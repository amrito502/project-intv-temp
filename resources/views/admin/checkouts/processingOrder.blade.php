@extends('admin.layouts.master')

@section('title')
Admin
@endsection

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-name')
Checkout
@endsection

@section('content')
<?php
    use App\Transaction;
?>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Processing Orders</h4>
                <div class="table-responsive">
                    <table id="checkoutsTable" class="table table-bordered table-striped"  name="checkoutsTable">
                        <thead>
                            <tr>
                                <th width="5%">S/L</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                <th>Dellivery Aaddress</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <?php $i = 1; ?>
                            @foreach($checkouts as $checkout)
                            <?php
                                $transactions = Transaction::where('checkout_id',$checkout->id)->first();
                                $i++;
                                if ($checkout->status == "Processing") {
                            ?>

                              <tr class="pendingRow_{{ $checkout->id }}">
                                <td width="5%">{{$i}}</td>

                                <td>{{ $checkout->shipping->name }}</td>
                                <td>{{ $checkout->shipping->mobile }}</td>
                                <td>{{$transactions->total}}</td>
                                <td>{{@$checkout->shipping->address }}</td>

                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Order status" data-id="{{ $checkout->id }}"> <i class="fa fa-shopping-bag text-danger m-r-10"></i>
                                    </a>

                                    <a href="{{route('list.product',$checkout->id)}}" title="Product List"> <i class="fa fa-list text-success m-r-10"></i> </a>

                                     <a href="{{route('view.invoices',$checkout->id)}}" title="Order Details"> <i class="fa fa-eye text-success m-r-10"></i> </a>

                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$checkout->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                                </td>
                            </tr>
                        <?php } ?>

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


<!-- sample modal content for show shipping-->
<div id="showShipping" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show shipping detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container " id="shippingContent">
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

            table = $('#checkoutsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
            table.on( 'order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax
            //ajax show code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-eye', function () {
                updateThis = this;
                checkout_id = $(this).parent().data('id');
                showFunction(checkout_id);
                // $.ajax({
                //     type: "GET",
                //     url: "{{ route('checkouts.index') }}" + "/" + checkout_id ,
                //     data: "checkout_id=" + checkout_id,
                //     cache:false,
                //     contentType: false,
                //     processData: false,
                //     success: function(response) {
                //         checkout = response.checkout;
                //         showFunction(checkout_id);
                //     },
                //     error: function(response) {
                //         error = "Something wrong.";
                //         swal({
                //             title: "<small class='text-danger'>Error!</small>",
                //             type: "error",
                //             text: error,
                //             timer: 1000,
                //             html: true,
                //         });
                //     }
                // });
            });

            //ajax delete code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                checkout_id = $(this).parent().data('id');
                var checkout = this;
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
                            url: "{{ route('order.delete') }}",

                            data: {
                                checkout_id:checkout_id
                            },

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Order information deleted successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(checkout).parents('tr'))
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
                            text: "Your order detail is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });



            //ajax show product code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-archive', function () {
                checkout_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/edit",
                    data: "checkout_id=" + checkout_id + "&option=order" ,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        products = response.products;
                        showProduct(products);
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

            //seperate the show products view function
            function showProduct(products){
                var content =   `<table class="table table-bordered table-striped">
                        <tr>
                            <th>S/L</th>
                            <th>Name</th>
                            <th>Deal Code</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Total</th>
                        </tr>`;
                var i = 1;
                var total = 0;
                products.forEach(function(product) {
                    content = content + `<tr class="text-right">
                                            <td>`+ i++ +`</td>
                                            <td><a href="{!! route('products.index') !!}/`+ product.product_id +`" target="_blank">`+ product.name +`</a></td>
                                            <td>`+ product.deal_code +`</td>
                                            <td>`+ product.qty +`</td>
                                            <td>`+ product.price +`</td>
                                            <td>`+ product.discount +`</td>
                                            <td>`+ product.qty*(product.price-product.discount) +`</td>
                                        </tr>`;
                                    total = total + product.qty*(product.price-product.discount);
                });
                    content = content + `<tr class="text-right">
                                            <th colspan="5"> Grand Total </th>
                                            <td colspan="2">`+ total +`</td>
                                        </tr>`;
                    content = content + `</table>`;
                $('#productContent').html(content);
                $("#showProduct").modal();
            }

            //ajax show status code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-shopping-bag', function () {
                checkout_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/edit",
                    data: "checkout_id=" + checkout_id + "&option=status" ,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        showStatus(response);
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

            //seperate the all status view function
            function showStatus(response){
               <?php $checkoutStatus = ['Waiting', 'Processing', 'Shipping', 'Complete'] ?>

                if(response.checkout.status == 'Waiting')
                    badge = '"badge badge-pill badge-info"';
                else if(response.checkout.status == 'Processing')
                    badge = '"badge badge-pill badge-danger"';
                else if(response.checkout.status == 'Shipping')
                    badge = '"badge badge-pill badge-warning"';
                else if(response.checkout.status == 'Complete')
                    badge = '"badge badge-pill badge-success"';
                else
                    badge = '"badge badge-pill badge-danger"';

                var content =   `<div class="form-group text-center">
                                    <h4><span class=`+badge+`
                                    style="float: center;"> `+response.checkout.status+`</span></h4>
                                </div>`+
                                `<div class="row col-sm-12">
                                Total order status
                                </div>
                                <form action="javascript:void(0)" method="POST" name="checkoutForm">
                                    <div class="form-group row">
                                    <input type="hidden" name="checkout_id" value="`+response.checkout.id+`">
                                        <div class="col-sm-6 ">
                                            <select class="form-control" name="status">
                                                <option value="">--- Select status ---</option>
                                                @foreach($checkoutStatus as $key=>$value)
                                                    <option value="{{ $value }}" >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6"><button type="button" class="btn btn-info waves-effect" onclick="checkoutFunction(this)">Update status</button>
                                        </div>
                                    </div>
                                </form>`
                                ;
                $('#shippingContent').html(content);
                $("#showShipping").modal();

                document.forms['checkoutForm'].elements['status'].value = response.checkout.status;

            }

            //ajax show payment code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-money', function () {
                checkout_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/edit",
                    data: "checkout_id=" + checkout_id + "&option=transaction" ,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        payment = response.payment;
                        showPayment(payment);
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



        });



        function checkoutFunction(){
            checkout_id = $("form[name='checkoutForm'] input[name='checkout_id']").val();
            status = $("form[name='checkoutForm'] select[name='status']").val();
            statusChange(checkout_id, 'checkout', status);
        }

        function statusChange(checkout_id, option, status) {
            $.ajax({
                type: "GET",
                url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/status",
                data: "checkout_id=" + checkout_id + "&option=" +option+ "&status=" +status  ,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    checkout = response.checkout
                    $('.modal').modal('hide');
                    if(status != 'Processing'){
                        $(".pendingRow_"+checkout_id).remove();
                    }
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Order successfully updated!",
                            timer: 2000,
                            html: true,
                        });
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
        }    </script>
@endsection
