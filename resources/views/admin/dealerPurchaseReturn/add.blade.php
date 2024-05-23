@extends('admin.layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<?php
    use App\Models\DealerPurchaseReturn;
    $purchae_return = DealerPurchaseReturn::whereRaw('id = (select max(`id`) from purchase_returns)')->first();
    if(!$purchae_return){
        $purchase_return_serial = 1000000+1;
    }else{
        $purchase_return_serial = 1000000+$purchae_return->id+1;
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{$title}}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 30px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                ?>

                <div id="addNewMenu" class="">
                    <div class="row">
                        <div class="col-md-12">

                            <form id="form" class="form-horizontal" action="{{ route('dealerPurchaseReturn.save') }}"
                                method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
                                {{ csrf_field() }}

                                @if( count($errors) > 0 )

                                <div style="display:inline-block;width: auto;" class="alert alert-danger">
                                    {{ $errors->first() }}</div>
                                @endif
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <label for="sl-no">SL No</label>
                                                    <div
                                                        class="form-group {{ $errors->has('purchase_return_serial') ? ' has-danger' : '' }}">
                                                        <input type="text" class="form-control form-control-danger"
                                                            value="{{$purchase_return_serial}}"
                                                            name="purchase_return_serial" required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="date">Date</label>
                                                    <div
                                                        class="form-group {{ $errors->has('purchase_return_date') ? ' has-danger' : '' }}">
                                                        <input type="text"
                                                            class="form-control form-control-danger add_datepicker"
                                                            name="purchase_return_date" required readonly>
                                                    </div>
                                                </div>

                                                @if (in_array(auth()->user()->role, [1, 2, 6, 7]))
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="dealer">Dealer</label>
                                                        <select name="dealer" id="dealer" class="chosen-select">
                                                            <option value="">Select Dealer</option>
                                                            @foreach ($dealers as $dealer)
                                                            <option value="{{ $dealer->id }}"
                                                                is-dealer="{{ $dealer->is_founder }}"
                                                                is-agent="{{ $dealer->is_agent }}">{{ $dealer->name }}
                                                                ({{
                                                                $dealer->username }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @else
                                                <input type="hidden" name="dealer" value="{{ auth()->user()->id }}">
                                                @endif


                                                <div class="col-md-5">
                                                    <label for="remarks">Remarks</label>
                                                    <div
                                                        class="form-group {{ $errors->has('remarks') ? ' has-danger' : '' }}">
                                                        <input type="text" name="remarks" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>


                                            {{-- <div class="row mb-3">


                                                <div class="col-md-12 text-right">
                                                    <br>
                                                    <button type="submit" class="btn btn-outline-info waves-effect">
                                                        <span style="font-size: 16px;">
                                                            <i class="fa fa-save"></i> Save Data
                                                        </span>
                                                    </button>
                                                </div>

                                            </div> --}}

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for=""></label>
                                                    <div class="form-group">
                                                        <table id="table" class="table table-striped gridTable d-none">
                                                            <thead>
                                                                <tr>
                                                                    <th width="40%">Product Name & Code</th>
                                                                    <th width="16%">Quantity</th>
                                                                    <th>Rate</th>
                                                                    <th>Amount</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tbody">
                                                                <tr>
                                                                    <td>
                                                                        <select
                                                                            class="itemList_1 form-control form-control-danger chosen-select"
                                                                            name="product_id[]" required="">
                                                                            <option value=" ">Select Item</option>
                                                                            <?php
                                                                foreach ($products as $product) {
                                                            ?>
                                                                            <option value="{{$product->id}}">
                                                                                {{$product->name}}
                                                                                ({{$product->deal_code}})</option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </td>
                                                                    <td><input style="text-align: right;"
                                                                            class="qty qty_1" type="number" name="qty[]"
                                                                            value="1" oninput="totalAmount('1')"
                                                                            required></td>
                                                                    <td><input style="text-align: right;" class="rate_1"
                                                                            type="number" name="rate[]" value="0"
                                                                            oninput="totalAmount('1')" required></td>
                                                                    <td><input style="text-align: right;"
                                                                            class="amount amount_1" type="number"
                                                                            name="amount[]" value="0" required readonly>
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                            <tfoot>
                                                                <tr>
                                                                    <th>Total Quantity</th>
                                                                    <td>
                                                                        <input class="total_qty" type="number"
                                                                            name="total_qty" value="1" readonly>
                                                                    </td>
                                                                    <th>Total Amount</th>
                                                                    <td>
                                                                        <input class="total_amount" type="number"
                                                                            name="total_amount" value="0" readonly>
                                                                    </td>

                                                                    <td align="center">
                                                                        <input type="hidden" class="row_count"
                                                                            value="1">
                                                                        <span class="btn btn-success add_item">
                                                                            <i class="fa fa-plus-circle"></i> Add More
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12 m-b-20 text-right">
                                                    <button type="button" onclick="saveData()"
                                                        class="btn btn-outline-info btn-lg waves-effect">
                                                        <span style="font-size: 16px;">
                                                            <i class="fa fa-save"></i> Save Data
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-dialog -->
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
            foreach ($products as $product) {
        ?>
            <option value="{{$product->id}}">{{$product->name}} ({{$product->deal_code}})</option>
            <?php } ?>
        </select>
    </div>
</div>

@endsection

@section('custom-js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>


<script type="text/javascript">
    let isAgent = 0;
    let isDealer = 0;

    let customerAmount = 0;

        // show table on customer select
        $(document).ready(function(){
            $('#dealer').change(function(){
                var customer_id = $(this).val();

                isAgent = +$('#dealer :selected').attr('is-agent');
                isDealer = +$('#dealer :selected').attr('is-dealer');

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


    $(".supplier").change(function (e) {
        e.preventDefault();

        let supplierId = $(this).val();

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('courier.delete') }}",
            data: {
                supplierId:supplierId
            },

            success: function(response) {

            },
        });

        console.log(supplierId);

    });


</script>

<script type="text/javascript">
    $(".add_item").click(function () {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;
        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="product_id[]" class="form-control chosen-select itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="qty qty_'+total+'" type="number" name="qty[]" value="1" required oninput="totalAmount('+total+')"></td>'+
            '<td><input style="text-align: right;" class="rate_'+total+'" type="number" name="rate[]" value="0" required oninput="totalAmount('+total+')"></td>'+
            '<td><input style="text-align: right;" class="amount amount_'+total+'" type="number" name="amount[]" value="0" required readonly></td>'+
            '<td align="center"><span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash"></i> Delete</span></td>'+
            '</tr>');
        $('.row_count').val(total);
        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
         $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        $(".itemList_"+total).change(function(){
            totalVat(total);
        });

        row_sum();
    });

    $(".itemList_1").change(function(){
        totalVat(1);
    });


    function totalVat(i) {

        var product_id = $('.itemList_'+i).val();
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

                // $('.current_vat_'+i).val(current_vat);
                // $('.rate_'+i).val(response.product.discount);
                // $(".amount_" + i).val(amount.toFixed(2));
                // $(".pp_" + i).val(total_pp);
                // $(".pp_val_" + i).val(parseFloat(response.product.pp).toFixed(2));

                let dealerDiscount = total_pp * customerAmount * +$('.qty_'+i).val();

                $(".rate_" + i).val(amount - dealerDiscount);
                // $(".dealer_price_val_" + i).val(amount - dealerDiscount);

                totalAmount(i)

            },
            error: function(response) {

            }

        });
    }

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
    }

    function totalAmount(i){
         var qty = $(".qty_" + i).val();
        var rate = $(".rate_" + i).val();
        var sum_total = parseFloat(qty) *parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(2));

        row_sum();
    }


    function row_sum() {
        var total_qty = 0;
        var total_amount = 0;
        $(".qty").each(function () {
            var stvalTotal = parseFloat($(this).val());
            //            console.log(stval);
            total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
        });

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            //            console.log(stval);
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));

    }


</script>


<script>

    function saveData(){

        let dealer_id = $('#dealer').val();

        let items = [];

        // validate stock
        let productsEl = $('select[name="product_id[]"]');
        let qtyEl = $('input[name="qty[]"]');

        let i = 0;
        for (const productEl of productsEl) {
            let productId = $(productEl).val();
            let qty = $(qtyEl[i]).val();
            items.push({
                product_id: productId,
                qty: qty
            });

            i++;
         }

        //  hit axios to check stock
        axios.post(route('DealerStockValidation'), {
            params: {
                dealer_id,
                items
            }
        })
        .then(function (response) {

            let data = response.data;

            if(data.status == false){
                let type = 'danger';

                let is_danger = type == 'danger' ? 'error' : 'success'

                swal(data.message, {
                    button: "OK",
                    timer: 5000,
                    icon: is_danger,
                });
                return false;
            }
            else{
                $('#form').submit();
            }

            console.log(data);
        })
        .catch(function (error) {
        })



    }
</script>

@endsection
