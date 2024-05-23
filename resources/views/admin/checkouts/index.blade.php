@extends('admin.layouts.master')


@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style type="text/css">
    .serial_no{
      width: 4%
    }
    .mobile{
        width: 15%
    }
    .status{
        width: 10%
    }
    .name{
        width: 23%
    }

    .action{
        width: 10%
    }

    /*table th{
        text-align: center;
    }*/


</style>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="checkoutsTable" class="table table-bordered table-striped"  name="checkoutsTable">
                        <thead>
                            <tr>
                                <th class="serial_no">S/L</th>
                                <th class="name">Name</th>
                                <th class="mobile">Mobile</th>
                                <th>Address</th>
                                <th class="status">Order status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach($checkouts as $checkout)
                            <?php
                                if($checkout->status == 'pending')
                                    $badge = '"badge badge-pill badge-info"';
                                else if($checkout->status == 'ordered')
                                    $badge = '"badge badge-pill badge-danger"';
                                else if($checkout->status == 'shipping')
                                    $badge = '"badge badge-pill badge-warning"';
                                else if($checkout->status == 'completed')
                                    $badge = '"badge badge-pill badge-success"';
                                else
                                    $badge = '"badge badge-pill badge-danger"';
                            ?>
                            <tr>
                                <td class="serial_no"></td>
                                <td class="name">{{ $checkout->shipping->name }}</td>
                                <td class="mobile">{{ $checkout->shipping->mobile }}</td>
                                <td>{{ $checkout->shipping->address }}</td>
                                <td class="status">
                                    {!! "<span class=$badge>" . $checkout->status ."</span>" !!}

                                </td>


                                <td class="text-nowrap action">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Order status" data-id="{{ $checkout->id }}"> <i class="fa fa-shopping-bag text-danger m-r-10"></i>
                                    </a>

                                     <a href="{{route('view.invoices',$checkout->id)}}" title="Order Details"> <i class="fa fa-eye text-success m-r-10"></i> </a>

                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$checkout->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
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


<!-- sample modal content for show checkout with detail-->
<div id="showCheckout" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show checkout</h4>
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


<!-- sample modal content for show customer-->
<div id="showCustomer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container " id="customerContent">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content for show product-->
<div id="showProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show products</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container " id="productContent">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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

            //seperate the show function to understand
            function showFunction(category){
                if(category.status == 1)
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-success">Active</span>
                                </div>`;
                else
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-danger">In-active</span>
                                </div>`
                var content =  + status;

                $('#showContent').html(content);
                $("#showCheckout").modal();
            }

            //ajax edit code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-pencil', function () {
                checkout_id = $(this).parent().data('id');
                window.location.replace("{{ route('checkouts.index') }}" + "/" + checkout_id+"/edit");
                //redirect to edit
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
                            type: "DELETE",
                            url: "{{ route('checkouts.index') }}" + "/" + checkout_id,
                            dataType: "JSON",
                            data: {
                                id:checkout_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Order information deleted successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(checkout).parent('td').parent('tr'))
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


            //ajax show customer code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-user', function () {
                checkout_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/edit",
                    data: "checkout_id=" + checkout_id + "&option=customer" ,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        customer = response.customer;
                        showCustomer(customer);
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

            //seperate the show customer view function
            function showCustomer(customer){
                if(customer.gender == 1)
                    gender = `<span class="badge badge-pill badge-success" style="float: right;"> Male </span>`;
                else
                    gender = `<span class="badge badge-pill badge-success" style="float: right;"> Female </span>`;
                var content =   `<div class="form-group row">
                                    <div class="col-sm-12 ">`+customer.name+gender+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">`+customer.email+`</div>
                                    <div class="col-sm-6">`+customer.mobile+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-12 ">`+customer.address+`</div>
                                </div>`
                                ;

                var noCustomer = `<div class="form-group row alert alert-danger">
                                    <div class="col-sm-12 ">Customer not registered</div>
                                </div>`;
                if(customer.id == 1)
                    $('#customerContent').html(noCustomer);
                else
                    $('#customerContent').html(content);
                $("#showCustomer").modal();
            }

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

            //ajax show shipping code
            $('#checkoutsTable tbody').on( 'click', 'i.fa-ambulance', function () {
                checkout_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkouts.index') }}" + "/" + checkout_id + "/edit",
                    data: "checkout_id=" + checkout_id + "&option=shipping" ,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        shipping = response.shipping;
                        showShipping(shipping, checkout_id);
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

            //seperate the show shipping view function
            function showShipping(shipping, checkout_id){
                <?php $shippingStatus = ['pending', 'ordered', 'shipping', 'delivered'] ?>
                var content =   `<div class="form-group text-center">
                                    <h4><span class="badge badge-success" style="float: center;"> `+shipping.status+`</span></h4>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-4 ">Delivery name</div>
                                    <div class="col-sm-8">`+shipping.name+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-4 ">Delivery mobile</div>
                                    <div class="col-sm-8">`+shipping.mobile+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-4 ">Delivery address</div>
                                    <div class="col-sm-8">`+shipping.address+`</div>
                                </div>`+
                                `<form action="javascript:void(0)" method="POST" name="shippingForm">
                                    <div class="form-group row">
                                    <input type="hidden" name="checkout_id" value="`+checkout_id+`">
                                        <div class="col-sm-6 ">
                                            <select class="form-control" name="status">
                                                <option value="">--- Select status ---</option>
                                                @foreach($shippingStatus as $key=>$value)
                                                    <option value="{{ $value }}" >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6"><button type="button" class="btn btn-info waves-effect" onclick="shippingFunction()">Update status</button>
                                        </div>
                                    </div>
                                </form>`
                                ;
                $('#shippingContent').html(content);
                $("#showShipping").modal();

                document.forms['shippingForm'].elements['status'].value = shipping.status;
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

            //seperate the show payment view function
            function showPayment(payment){
                var due = Number(payment.total)-Number(payment.payment);
                <?php $paymentStatus = ['pending', 'recieved']; ?>
                var content =   `<div class="form-group text-center">
                                    <h4><span class="badge badge-success" style="float: center;"> `+payment.status+`</span></h4>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">Total price</div>
                                    <div class="col-sm-6">`+payment.total+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">Total payment</div>
                                    <div class="col-sm-6">`+payment.payment+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">Total due</div>
                                    <div class="col-sm-6">`+due+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">Payment method</div>
                                    <div class="col-sm-6">`+payment.method+`</div>
                                </div>`+
                                `<div class="form-group row">
                                    <div class="col-sm-6 ">Payment reference</div>
                                    <div class="col-sm-6">`+payment.reference+`</div>
                                </div>`+
                                `<form action="javascript:void(0)" method="POST" name="paymentForm">
                                    <div class="form-group row">
                                    <input type="hidden" name="checkout_id" value="`+payment.checkout_id+`">
                                        <div class="col-sm-6 ">
                                            <select class="form-control" name="status">
                                                <option value="">--- Select status ---</option>
                                                @foreach($paymentStatus as $key=>$value)
                                                    <option value="{{ $value }}" >{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6"><button type="button" class="btn btn-info waves-effect" onclick="paymentFunction(this)">Update status</button>
                                        </div>
                                    </div>
                                </form>`
                                ;

                $('#paymentContent').html(content);
                $("#showPayment").modal();

                document.forms['paymentForm'].elements['status'].value = payment.status;
            }



            $( "form[name='paymentForm']" ).on( "submit", function( event ) {
                alert();
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('categories.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var category = response.category;
                        $('#addNewCategory').modal('hide');

                        status = '';
                        if(category.status==1) status = 'checked';

                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Category successfully added!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.name) {
                            $( "input[name='name']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.name +"</li>";
                        }
                        if(data.errors.position){
                            $( "input[name='position']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.position +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });

        });

        function paymentFunction(){
            checkout_id = $("form[name='paymentForm'] input[name='checkout_id']").val();
            status = $("form[name='paymentForm'] select[name='status']").val();
            statusChange(checkout_id, 'payment', status);
        }

        function shippingFunction(){
            checkout_id = $("form[name='shippingForm'] input[name='checkout_id']").val();
            status = $("form[name='shippingForm'] select[name='status']").val();
            statusChange(checkout_id, 'shipping', status);
        }

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
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Checkout successfully updated!",
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
        }
    </script>
@endsection
