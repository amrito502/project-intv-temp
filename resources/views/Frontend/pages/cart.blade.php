@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">
        <nav data-depth="1" class="breadcrumb hidden-sm-down">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="#">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
            </ol>
        </nav>


        <div id="content-wrapper">


            <div class="container">

                @if($customer)
                <header class="page-header">
                    <h1>
                        Phone
                    </h1>
                </header>

                <div class="form-group row ">
                    <div class="col-md-12">
                        <input class="form-control" name="customerPhone" id="customerPhone" type="text"
                            value="{{ $customer->mobile }}" required="">
                    </div>
                </div>
                @else
                <header class="page-header">
                    <h1>Order Information</h1>
                </header>

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="customer_name" id="guest_name" value="" oninput="guestValueType('name');" placeholder="Your Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Phone No</label>
                                    <input type="text" class="form-control" name="contact_no" id="guest_phone" value="" oninput="guestValueType('phone');" placeholder="01XXXXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" id="guest_email" value="" oninput="guestValueType('email');" placeholder="demo@gmail.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <textarea class="form-control" name="address" id="guest_address" rows="9" oninput="guestValueType('address');" placeholder="Your Address"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @endif

            </div>

            <input type="hidden" name="selectedAddress" id="selectedAddress" value="">


            <section id="content" class="page-content">


            <!--Customer Information-->
            @if($customer)
                <div class="container">
                    <header class="page-header">
                        <h1>
                            Select Addresses
                        </h1>
                    </header>
                </div>

                @php
                $i = 0;
                @endphp

                @foreach ($customer->addresses as $address)

                @php
                $i++;
                @endphp

                @include('frontend.partial.customer_profile.customer_address_card', ['address' => $address,
                'sl' => $i])

                @endforeach


                <div class="clearfix"></div>
                @include('frontend.partial.customer_profile.address_add_btn')
                @endif
                <!--Customer Information-->
            </section>
            <div class="">
                <header class="page-header">
                    <h1 class="h1">Shipping Method</h1>
                </header>
                <input type="hidden" id="Samoun" value="60">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td width="20px"><input type="radio" class="shipping_charge" name="shipping_charge" value="60" checked></td>
                            <td>Shipping in Dhaka City.</td>
                            <td align="right">BDT 60.00</td>
                        </tr>
                        <tr>
                            <td width="20px"><input type="radio" class="shipping_charge" name="shipping_charge" value="120"></td>
                            <td>Shipping Whole Bangladesh.</td>
                            <td align="right">BDT 120.00</td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="form-group">
                                    <label><b>Add Comments About Your Order</b></label>
                                    <textarea class="form-control" id="orderComments" name="order_comments" rows="5"></textarea>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <section id="main">
                <header class="page-header">
                    <h1 class="h1">Shopping Cart</h1>
                </header>
                <div class="cart-grid row">

                    <!-- Left Block: cart product informations & shpping -->
                    <div class="cart-grid-body col-xs-12 col-lg-8">

                        <!-- cart products detailed -->
                        <div class="card cart-container">
                            <div class="cart-overview js-cart" data-refresh-url="#">
                                <ul class="cart-items" id="cart-items">


                                </ul>
                            </div>
                        </div>


                        <a class="label" href="#">
                            <i class="fa fa-angle-left" aria-hidden="true"></i> Continue shopping
                        </a>
                        <!-- shipping informations -->
                    </div>

                    <!-- Right Block: cart subtotal & cart total -->
                    <div class="cart-grid-right col-xs-12 col-lg-4">
                        <div class="card cart-summary">
                            <div class="cart-detailed-totals">
                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal" id="itemCount">Total Amount</span>
                                        <span class="value" id="total"></span>
                                    </div>
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal">Discount</span>
                                        <span class="value" id="discount">BDT 0.00</span>
                                    </div>
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal">Subtotal</span>
                                        <span class="value" id="subtotal">BDT 0</span>
                                    </div>
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal">Shipping Charge</span>
                                        <span class="value" id="shipping_charge">BDT 60.00</span>
                                    </div>
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal">Vat (5%)</span>
                                        <span class="value" id="totalVat">BDT 0.00</span>
                                    </div>
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line cart-total">
                                        <span class="label">Net Total</span>
                                        <span class="value" id="grandTotal">BD: 0.00</span>
                                    </div>

                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line">
                                        <span class="label">
                                            <input type="radio" class="form-check-input pay_mode" value="cod" name="pay_mode" checked>Cash on delivery
                                        </span>
                                        <span class="value">
                                            <input type="radio" class="form-check-input pay_mode" value="online" name="pay_mode"> Online Payment
                                        </span>
                                    </div>

                                </div>

                                <hr class="separator">

                                <div class="card-block form-inline">
                                    <input type="text" class="form-control" value="" id="voucher_code" placeholder="Voucher/Promo Code">
                                    <span class="btn btn-info" onclick="voucherApprove()">Apply</span>
                                </div>
                            </div>

                            <div class="checkout cart-detailed-actions card-block" id="cod">
                                <div class="text-sm-center">
                                    <a href="#" class="btn btn-primary" id="checkoutNow">
                                        Proceed to checkout
                                    </a>
                                </div>
                            </div>

                            <form action="{{ url('/pay') }}" method="POST" class="needs-validation" id="payForm">
                                {{ csrf_field() }}
                                <input type="hidden" value="" name="amount" id="total_amount" value="0" required/>
                                <input type="hidden" name="discount" id="total_discount" value="0">
                                <input type="hidden" class="form-control" name="comment" id="orderComment" value="">
                                <input type="hidden" class="form-control" name="shipping" id="guestShipping" value="60">

                                 @if($customer)
                                <input class="form-control" name="customerPhone" type="hidden" value="{{ $customer->mobile }}">
                                <input type="hidden" name="selectedAddress" id="addressVal" value="">
                                @else
                                <input type="hidden" class="form-control" name="customer_name" id="guestName" value="">
                                <input type="hidden" class="form-control" name="contact_no" id="guestPhone" value="">
                                <input type="hidden" class="form-control" name="email" id="guestEmail" value="">
                                <input type="hidden" class="form-control" name="address" id="guestAddress" value="">
                                @endif

                                <div class="checkout cart-detailed-actions card-block" id="online" style="display: none">
                                    <div class="mb-2">
                                        <input type="checkbox" id="terms"> I have read & agree to the <a href="{{ route('termsandCondition') }}" target="_blank">Terms & Conditions</a> <br>
                                    </div>

                                    <div class="text-sm-center">
                                        <button type="submit" class="btn btn-primary" id="payNow">
                                            Pay Now
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>


        </div>
    </div>
</div>

@endsection

@section('custom-css')


<style>
    .active-address {
        border: 1px solid red !important;
    }

    .lab-menu-vertical .menu-vertical,
    .laberMenu-top .menu-vertical {
        display: none !important;
    }

    .lab-menu-vertical .menu-vertical.lab-active,
    .laberMenu-top .menu-vertical.lab-active {
        display: block !important;
    }
    .pay_mode{
        margin-right: 5px;
        margin-left: 5px;
    }
    .card-block {
        padding: 0.75rem !important;
    }
</style>

@endsection

@section('custom-js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function () {

        $('.pay_mode').click(function(){
            var mode = $(this).val();

            if(mode == 'cod'){
                $('#cod').show();
                $('#online').hide();
            }

            if(mode == 'online'){
                $('#cod').hide();
                $('#online').show();

                @if($customer)
                $('#addressVal').val($('#selectedAddress').val());
                @else
                    var guestName = $('#guest_name').val();
                    var guestEmail = $('#guest_email').val();
                    var guestPhone = $('#guest_phone').val();
                    var guestAddress = $('#guest_address').val();
                    var shipping = parseInt($('.shipping_charge').html().replace('BDT ' , ''));

                    $('#guestName').val(guestName);
                    $('#guestEmail').val(guestEmail);
                    $('#guestPhone').val(guestPhone);
                    $('#guestAddress').val(guestAddress);
                    $('#guestShipping').val(shipping);


                @endif
                var total = $('#grandTotal').html().replace('BDT ' , '');
                $('#total_amount').val(parseInt(total));
            }


        });



        @if($customer)
            $("#payNow").click(function(e) {
                e.preventDefault();

                var selectedAddress = $('#selectedAddress').val();
                var customerPhone = $('#customerPhone').val();

                if(!selectedAddress){
                    swal("Please Select an address", {
                        button: "OK",
                        timer: 5000,
                        icon: 'error',
                        ButtonColor: "#DD6B55",
                    });
                    return;
                }

                if (selectedAddress != '' && customerPhone != '') {
                    var terms = $('#terms').is(":checked");
                    if(!terms){
                        swal("Please check terms & condition to continue;", {
                            timer: 5000,
                            icon: 'error',
                        });
                        return;
                    }
                    $('#payForm').submit();
                }
            });
        @else
            $("#payNow").click(function(e) {
                e.preventDefault();

                var guestName = $('#guestName').val();
                var guestEmail = $('#guestEmail').val();
                var guestPhone = $('#guestPhone').val();
                var guestAddress = $('#guestAddress').val();

                if(!guestName){
                    swal("Please enter your name.", {
                        button: "OK",
                        timer: 5000,
                        icon: 'error',
                        ButtonColor: "#DD6B55",
                    });
                    return;
                }
                if(!guestPhone){
                    swal("Please enter your contact no.", {
                        button: "OK",
                        timer: 5000,
                        icon: 'error',
                        ButtonColor: "#DD6B55",
                    });
                    return;
                }
                if(!guestEmail){
                    swal("Please enter email.", {
                        button: "OK",
                        timer: 5000,
                        icon: 'error',
                        ButtonColor: "#DD6B55",
                    });
                    return;
                }
                if(!guestAddress){
                    swal("Please enter your address", {
                        button: "OK",
                        timer: 5000,
                        icon: 'error',
                        ButtonColor: "#DD6B55",
                    });
                    return;
                }



                if (guestName != '' && guestEmail != '' && guestPhone != '' && guestAddress != '') {
                     var terms = $('#terms').is(":checked");
                    if(!terms){
                        swal("Please check terms & condition to continue;", {
                            timer: 5000,
                            icon: 'error',
                        });
                        return;
                    }
                    $('#payForm').submit();
                }
            });
        @endif


        // on address box click
        $('.addressParent').click(function (e) {
            e.preventDefault();

            const parentDiv = $(this);

            removeAllActivation();
            addSelectedCss(parentDiv);
            changeAddressValue(parentDiv);

        });


        // on checkout button pressed

        //
        function checkoutNow(){
            var selectedAddress = $('#selectedAddress').val();
            var customerPhone = $('#customerPhone').val();


            if(!customerPhone){

                swal("Please enter phone number", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });

                return "";

            }

            if(!selectedAddress){

                swal("Please select address", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });
                return "";

            }

        }

        @if($customer)
        $('#checkoutNow').click(function (){
            checkoutNow();
            var selectedAddress = $('#selectedAddress').val();
            var customerPhone = $('#customerPhone').val();
            var discount = parseInt($('#discount').html().replace('BDT ' , ''));
            var shipping = parseInt($('#Samoun').val());
            var comment = $('#orderComments').val();
            window.location = '{{ route('order.save') }}?customerPhone=' + customerPhone + '&selectedAddress=' + selectedAddress + '&discount=' + discount + '&shipping=' + shipping + '&comment=' + comment;
        });
        @else
        $('#checkoutNow').click(function (){

            var guestName = $('#guest_name').val();
            var guestEmail = $('#guest_email').val();
            var guestPhone = $('#guest_phone').val();
            var guestAddress = $('#guest_address').val();
            var discount = parseInt($('#discount').html().replace('BDT ', ''));
            var shipping = parseInt($('#Samoun').val());
            var comment = $('#orderComments').val();


            if(!guestName){
                swal("Please enter your name.", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });
                return;
            }
            if(!guestPhone){
                swal("Please enter your contact no.", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });
                return;
            }
            if(!guestEmail){
                swal("Please enter email.", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });
                return;
            }
            if(!guestAddress){
                swal("Please enter your address", {
                    button: "OK",
                    timer: 5000,
                    icon: 'error',
                    ButtonColor: "#DD6B55",
                });
                return;
            }


            window.location = '{{ route('order.save') }}?guestName=' + guestName + '&guestEmail=' + guestEmail + '&guestPhone=' + guestPhone + '&guestAddress=' + guestAddress + '&discount=' + discount + '&shipping=' + shipping + '&comment=' + comment;
        });
        @endif

    });

    function removeAllActivation(){
        $('.addressParent').each((i,j) => {

            const parentDiv = $(j);
            const address = parentDiv.find('#address');
            address.removeClass('active-address');
        })
    }

    function addSelectedCss(parentDiv){
        const address = parentDiv.find('#address');
        address.addClass('active-address');
    }

    function changeAddressValue(parentDiv){

        // const value = parentDiv;
        const value = parentDiv.attr('targetVal');

        $('#selectedAddress').val(value);
        var total = $('#grandTotal').html().replace('BDT ', '');
        $('#addressVal').val(value);
        $('#total_amount').val(parseInt(total));
    }



    function voucherApprove(){
        var voucher = $('#voucher_code').val();

        if(voucher == ''){
            swal("Enter a voucher code", {
                button: "OK",
                timer: 5000,
                icon: 'warning',
                ButtonColor: "#DD6B55",
            });
            return;
        }

        var total = $('#grandTotal').html().replace('BDT ' , '');

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
            type: 'post',
            url: "{{ route('voucher.check') }}",
            data: {
                code: voucher,
            },
            success: function (response) {
                if(response.status == true){
                    if(parseInt(total) >= response.offer.minimum_amount){
                        var discount = $('#discount').html().replace('BDT ' , '');
                        var subtotal = $('#subtotal').html().replace('BDT ' , '');
                        var grandTotal = $('#grandTotal').html().replace('BDT ' , '');

                        if(response.offer.type == 'percent'){
                            var voucherAmount = (response.offer.discount / 100) * parseInt(grandTotal);
                        }else{
                           var voucherAmount = response.offer.discount;
                        }

                        var netDiscount = parseInt(discount) + parseInt(voucherAmount);

                        $('#discount').html('BDT '+ netDiscount);
                        $('#subtotal').html('BDT '+ (parseInt(subtotal) - netDiscount));
                        $('#grandTotal').html('BDT '+ (parseInt(grandTotal) - netDiscount));
                        $('#total_amount').val(parseInt(grandTotal) - netDiscount);
                        $('#total_discount').val(netDiscount);

                        swal("Successfully Applied", {
                            button: "OK",
                            timer: 2000,
                            icon: 'success',
                            ButtonColor: "#DD6B55",
                        });
                    }else{
                        swal("Minimum Purchse Amount BDT" + response.offer.minimum_amount, {
                            button: "OK",
                            icon: 'warning',
                            ButtonColor: "#DD6B55",
                        });
                    }
                }
                if(response.status == false){
                    swal("Enter a valid code!", {
                        button: "OK",
                        timer: 5000,
                        icon: 'warning',
                        ButtonColor: "#DD6B55",
                    });
                }
            },
            error: function (response) {
                swal("Enter a valid code!", {
                    button: "OK",
                    timer: 5000,
                    icon: 'warning',
                    ButtonColor: "#DD6B55",
                });
            }

        });
    }




    @if(!$customer)
    function guestValueType(type){
        if(type == 'name'){
            var guestName = $('#guest_name').val();
            $('#guestName').val(guestName);
        }
        if(type == 'phone'){
            var guestPhone = $('#guest_phone').val();
            $('#guestPhone').val(guestPhone);
        }
        if(type == 'email'){
            var guestEmail = $('#guest_email').val();
            $('#guestEmail').val(guestEmail);
        }
        if(type == 'address'){
            var guestAddress = $('#guest_address').val();
            $('#guestAddress').val(guestAddress);
        }

    }
    @endif


    $('.shipping_charge').click(function() {
        var grandTotal = parseInt($('#grandTotal').html().replace('BDT ' , ''));

        var shipping = parseInt($(this).val());
        if(shipping == 60){
            var total = (grandTotal - 120) + shipping;
        }else{
            var total = (grandTotal - 60) + shipping;
        }

        $('#grandTotal').html('BDT ' + total.toFixed(2));
        $('#shipping_charge').html('BDT ' + shipping.toFixed(2));
        $('#guestShipping').val(shipping.toFixed(2));
        $('#Samoun').val(shipping.toFixed(2));

    });

      $('#orderComments').on('input', function() {
          var comment = $('#orderComments').val();
        $('#orderComment').val(comment);
      });

</script>
@endsection
