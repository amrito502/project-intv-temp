@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">


<style>

    @media (max-width: 575.98px) {

        .mobileWidth{
            width: 300% !important;
            max-width: 300% !important;
        }

        .overFlowOnMobileScreen{
            overflow-y: auto;
        }

    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @php
                        $message = Session::get('msg');
                        if (isset($message))
                        {
                        echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                                .$message."</strong></div>";
                        }
                        Session::forget('msg')
                        @endphp
                    </div>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('cashSale.save') }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-12">
                                @if (count($errors) > 0)
                                <div style="display:inline-block; width: auto;" class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-2">
                                        <div class="form-group {{ $errors->has('invoice_no') ? ' has-danger' : '' }}">
                                            <label for="inputHorizontalDnger">Invoice No</label>
                                            {{-- <input type="hidden" class="form-control form-control-danger"
                                                name="payment_type" value="Cash" required readonly /> --}}
                                            <input type="text" class="form-control form-control-danger"
                                                name="invoice_no" value="{{ $invoice_no }}" required readonly />
                                            @if ($errors->has('invoice_no'))
                                            @foreach($errors->get('invoice_no') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group {{ $errors->has('invoice_date') ? ' has-danger' : '' }}">
                                            <label for="inputHorizontalDnger">Invoice Date</label>
                                            <input type="text" class="form-control form-control-danger add_datepicker"
                                                name="invoice_date" value="{{ old('invoice_date') }}">
                                            @if ($errors->has('invoice_date'))
                                            @foreach($errors->get('invoice_date') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Type</label>
                                            <select class="form-control chosen-select" name="payment_type"
                                                id="payment_type" required>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dealer</label>
                                            <select class="form-control chosen-select" name="customer" id="customer"
                                                required>
                                                <option value="">Select Dealer</option>
                                                @foreach($users as $user)
                                                <option value="{{ $user->id }}" is-dealer="{{ $user->is_founder }}"
                                                    is-agent="{{ $user->is_agent }}">{{ $user->name
                                                    }} ({{
                                                    $user->username }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-12" style="height: 500px;">
                                <div class="overFlowOnMobileScreen">
                                    <table id="table" class="table table-bordered table-striped mobileWidth d-none">
                                        <thead>
                                            <tr>
                                                <th>Product Name & Code</th>
                                                <th class="text-right">Quantity</th>
                                                <th class="text-right">DP Rate</th>
                                                <th class="text-right">Product Price</th>
                                                <th class="text-right">Dealer Price</th>
                                                <th class="text-right">Point</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td>
                                                    <select
                                                        class="form-control product_1 form-control-danger chosen-select"
                                                        name="product_id[]" required="">
                                                        <option value=" ">Select Item</option>
                                                        <?php
                                                            foreach ($products as $product)
                                                            {
                                                        ?>
                                                        <option value="{{$product->id}}">{{$product->name}}
                                                            ({{$product->deal_code}})
                                                        </option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </td>

                                                <td >
                                                    <input style="text-align: right;" class="form-control qty qty_1" type="number"
                                                        name="qty[]" oninput="totalAmount('1')" value="1" required>
                                                </td>

                                                <td >
                                                    <input style="text-align: right;" class="form-control rate_1" type="number"
                                                        name="rate[]" oninput="totalAmount('1')" required>
                                                </td>

                                                <td>
                                                    <input style="text-align: right;" class="form-control amount amount_1"
                                                        type="number" name="amount[]" required readonly>
                                                    <input style="text-align: right;" class="current_vat current_vat_1"
                                                        type="hidden">
                                                    <input style="text-align: right;" class="vat_amount vat_amount_1"
                                                        type="hidden">
                                                </td>

                                                <td>
                                                    <input style="text-align: right;"
                                                        class="form-control dealer_price dealer_price_1" type="number" step="any"
                                                        name="dealer_price[]" required readonly>
                                                    <input class="dealer_price_val_1" step="any" type="hidden">
                                                </td>

                                                <td>
                                                    <input class="form-control text-right pp pp_1" type="number"
                                                        name="pp[]" step="any" required readonly>
                                                    <input class="pp_val_1" type="hidden">
                                                </td>

                                            </tr>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>Total Quantity</th>
                                                <td>
                                                    <input class="total_qty form-control" type="number" name="total_qty" readonly>
                                                </td>

                                                <th>Total Summary</th>
                                                <td>
                                                    <input style="text-align: right;" class="total_amount form-control" type="number"
                                                        name="total_amount" readonly>
                                                </td>

                                                <td>
                                                    <input style="text-align: right;" class="form-control total_dealer_price"
                                                        type="number" name="total_dealer_price" readonly>
                                                </td>

                                                <td>
                                                    <input style="text-align: right;" class="form-control total_point" type="number"
                                                        name="total_point" readonly>
                                                </td>

                                                <td align="center">
                                                    <input type="hidden" class="row_count" value="1">
                                                    <span class="btn btn-success add_item">
                                                        <i class="fa fa-plus-circle"></i> Add More
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td rowspan="5" style="border: none;">
                                                    <div class="row" style="margin: 6px;">

                                                        <div class="col-md-12">
                                                            <label class="form-control radio-flex form-control"> <input type="radio"
                                                                    value="fixed" name="discountType" checked
                                                                    style="width: 15px !important">
                                                                <span>
                                                                    Fixed Discount
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="radio-flex form-control">
                                                                <input type="radio" value="percentage"
                                                                    name="discountType" style="width: 15px !important">
                                                                <span>
                                                                    Discount As %
                                                                </span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </td>

                                                <td rowspan="5" style="border: none;">
                                                    <input style="text-align: right;" class="form-control discount_percentage"
                                                        type="number" name="discount_percentage" oninput="netAmount()"
                                                        required>
                                                </td>

                                                <td></td>

                                                <th>Discount</th>
                                                <td>
                                                    <input style="text-align: right;" class="form-control discount" type="number"
                                                        name="discount" oninput="netAmount()" readonly="" value="0.00">
                                                </td>

                                                <td></td>

                                                <td rowspan="5" class="text-right" style="padding-top: 5px;">
                                                    <div style="padding-top: 10px;">
                                                        <button type="submit"
                                                            class="btn btn-outline-info btn-lg waves-effect">
                                                            <span style="font-size: 16px;">
                                                                <i class="fa fa-save"></i> Save
                                                            </span>
                                                        </button>
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr class="d-none">
                                                <th>Vat</th>
                                                <td>
                                                    <input style="text-align: right;" class="vat" type="number"
                                                        name="vat" oninput="netAmount()" readonly>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <th>Net Amount</th>
                                                <td>
                                                    <input style="text-align: right;" class="form-control net_amount" type="number"
                                                        name="net_amount" readonly>
                                                </td>
                                            </tr>

                                            {{-- <tr>
                                                <th>Customer Paid</th>
                                                <td>
                                                    <input style="text-align: right;" class="customer_paid"
                                                        type="number" name="customer_paid" oninput="netAmount()"
                                                        value="0.00">
                                                </td>
                                            </tr> --}}

                                            {{-- <tr>
                                                <th>Change Amount</th>
                                                <td>
                                                    <input style="text-align: right;" class="change_amount"
                                                        type="number" name="change_amount" readonly>
                                                </td>
                                            </tr> --}}
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="itemList" style="display:none">
    <div class="input select">
        <select>
            <option value=" ">Select Item</option>
            <?php
                    foreach ($products as $product)
                    {
                ?>
            <option value="{{$product->id}}">{{$product->name}} ({{$product->deal_code}})</option>
            <?php
                    }
                ?>
        </select>
    </div>
</div>
@endsection

@section('custom-js')

<script>
    let isAgent = 0;
    let isDealer = 0;

    let customerAmount = 0;

    // show table on customer select
        $(document).ready(function(){
            $('#customer').change(function(){
                var customer_id = $(this).val();

                isAgent = +$('#customer :selected').attr('is-agent');
                isDealer = +$('#customer :selected').attr('is-dealer');

                if(isAgent){
                    customerAmount = 0.32;
                }

                if(isDealer){
                    customerAmount = 0.48;
                }

                if(customer_id != ''){
                    $('#table').removeClass('d-none');
                }else{
                    $('#table').addClass('d-none');
                }
            });
        });

</script>

<script type="text/javascript">
    $(".add_item").click(function () {

        var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;
            $("#tbody").append('<tr id="itemRow_' + total + '">' +
                '<td>'+
                '<select name="product_id[]" class="form-control chosen-select itemList_'+total+' product_'+total+'">'+
                '</select>'+
                '</td>'+
                '<td>'+
                    '<input style="text-align: right;" class="form-control qty qty_'+total+'" type="number" name="qty[]" value="1" required oninput="totalAmount('+total+')">'+
                '</td>'+
                '<td><input style="text-align: right;" class="form-control rate_'+total+'" type="number" name="rate[]" required oninput="totalAmount('+total+')"></td>'+
                '<td>'+
                    '<input style="text-align: right;" class="form-control amount amount_'+total+'" type="number" name="amount[]" required readonly>'+
                    '<input style="text-align: right;" class="form-control current_vat current_vat_'+total+'" type="hidden" >'+
                    '<input style="text-align: right;" class="form-control vat_amount vat_amount_'+total+'" type="hidden" >'+
                '</td>'+

                '<td>'+
                    '<input style="text-align: right;" step="any" class="form-control dealer_price dealer_price_'+total+'" type="number" name="dealer_price[]" required readonly>'+
                    '<input style="text-align: right;" step="any" class="dealer_price_val_'+total+'" type="hidden" >'+
                '</td>'+

                '<td>'+
                    '<input style="text-align: right;" class="form-control pp pp_'+total+'" type="number" step="any" name="pp[]" required readonly>'+
                    '<input style="text-align: right;" class="pp_val_'+total+'" type="hidden" >'+
                '</td>'+

                '<td align="center"><span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash"></i> Delete</span></td>'+
                '</tr>');
            $('.row_count').val(total);
            var itemList = $("#itemList div select").html();
            $('.itemList_'+total).html(itemList);
            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");

            $(".product_"+total).change(function(){
                totalVat(total);
            });
        });

        $(".product_1").change(function(){
            totalVat(1);
        });

        function itemRemove(i) {
            var total_qty = $('.total_qty').val();
            var total_amount = $('.total_amount').val();

            var quantity = $('.qty_'+i).val();
            var amount = $('.amount_'+i).val();

            total_qty = total_qty - quantity;
            total_amount = total_amount - amount;

            $('.total_qty').val(total_qty.toFixed(2));
            $('.total_amount').val(total_amount.toFixed(2));

            $("#itemRow_" + i).remove();

            netAmount();

        }

        if($("input[name='discountType']:checked").val() == "fixed")
            {
                $('.discount_percentage').prop('readonly', true);
                $('.discount_percentage').val("");
                $('.discount').prop('readonly', false);
                $("input[name='discount_percentage']").prop('required',false);
                $('.discount_percentage').hide();
            }

        $("input[type='radio']").click(function(){
            var radioValue = $("input[name='discountType']:checked").val();
            if(radioValue == "fixed")
            {
                $('.discount_percentage').prop('readonly', true);
            	$('.discount_percentage').val("");
                $('.discount').prop('readonly', false);
                $("input[name='discount_percentage']").prop('required',false);
                $('.discount_percentage').hide();
            	$('.discount_percentage').val();
            }

            if (radioValue == "percentage")
            {
            	$('.discount').prop('readonly', true);
                $('.discount').val("");
                $('.discount_percentage').prop('readonly', false);
                $("input[name='discount_percentage']").prop('required',true);
                $('.discount_percentage').show();
                $('.discount_percentage').val(0);
            }
        });


        function totalVat(i) {

            var product_id = $('.product_'+i).val();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

           $.ajax({
                type: "POST",
                url : "{{ route('getProductPrice') }}",
                data : {
                    product_id:product_id,
                },
                success: function(response) {

                    var amount = 1 * response.product.discount;
                    var current_vat = response.product_info.vat_amount;
                    let total_pp = (response.product.pp * $('.qty_'+i).val()).toFixed(2);

                    $('.current_vat_'+i).val(current_vat);
                    $('.rate_'+i).val(response.product.discount);
                    $(".amount_" + i).val(amount.toFixed(2));
                    $(".pp_" + i).val(total_pp);
                    $(".pp_val_" + i).val(parseFloat(response.product.pp).toFixed(2));

                    let dealerDiscount = total_pp * customerAmount * +$('.qty_'+i).val();

                    $(".dealer_price_" + i).val(amount - dealerDiscount);
                    $(".dealer_price_val_" + i).val(amount - dealerDiscount);

                    totalAmount(i)
                    netAmount();

                },
                error: function(response) {

                }

            });
        }

        function totalAmount(i){

           var qty = $(".qty_" + i).val();
           var rate = $(".rate_" + i).val();
           var sum_total = parseFloat(qty) *parseFloat(rate);
           $(".amount_" + i).val(sum_total.toFixed(2));

            var current_vat = $('.current_vat_'+i).val();
            var vat_amount = (parseFloat(sum_total) * current_vat)/100;
            $('.vat_amount_'+i).val(vat_amount);

            let dealerPrice = qty * $('.pp_val_'+i).val();
            let linePoint = qty * $('.dealer_price_val_'+i).val();

            if(rate == 0){
                dealerPrice = 0;
                linePoint = 0;
            }

            $('.pp_'+i).val((dealerPrice).toFixed(2));
            $('.dealer_price_'+i).val((linePoint).toFixed(2));


           row_sum();
           netAmount();
        }

        function netAmount(){
            var net_amount = 0;
            var total_vat_amount = 0;
            var total_amount = $(".total_dealer_price").val();

            if($(".discount_percentage").val() == '')
            {
                var discount_percentage = 0;
            }
            else
            {
                var discount_percentage = parseFloat($(".discount_percentage").val());
                var total_amount = parseFloat($('.total_amount').val());
                var discount = (total_amount * discount_percentage)/100;
                $('.discount').val(discount.toFixed(2));
            }

            if($(".discount").val() == '')
            {
                var discount = 0;
            }
            else
            {
                var discount = $(".discount").val();
            }

            $(".vat_amount").each(function () {
                var stvalAmount = parseFloat($(this).val());
                total_vat_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
            });

            var vat = total_vat_amount;
            $(".vat").val(vat.toFixed(2));

            net_amount = Math.round((parseFloat(total_amount)+parseFloat(vat))-parseFloat(discount));
            $('.net_amount').val(net_amount.toFixed(2));

            if ($(".customer_paid").val() != '')
            {
                var customer_paid = parseFloat($(".customer_paid").val());

                var change_amount = customer_paid - net_amount;
                $(".change_amount").val(change_amount.toFixed(2));
            }
        }

        function row_sum() {

            var total_qty = 0;
            $(".qty").each(function () {
                var stvalTotal = parseFloat($(this).val());
                // console.log(stval);
                total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
            });
            $('.total_qty').val(total_qty);


            var total_amount = 0;
            $(".amount").each(function () {
                var stvalAmount = parseFloat($(this).val());
                // console.log(stval);
                total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
            });
            $('.total_amount').val(total_amount.toFixed(2));


            var total_point = 0;
            $(".pp").each(function () {
                var stvalAmount = parseFloat($(this).val());
                // console.log(stval);
                total_point += isNaN(stvalAmount) ? 0 : stvalAmount;
            });
            $('.total_point').val(total_point.toFixed(2));


            var total_dealer_price = 0;
            $(".dealer_price").each(function () {
                var stvalAmount = parseFloat($(this).val());
                total_dealer_price += isNaN(stvalAmount) ? 0 : stvalAmount;
            });
            $('.total_dealer_price').val(total_dealer_price.toFixed(2));

        }
</script>


@endsection
