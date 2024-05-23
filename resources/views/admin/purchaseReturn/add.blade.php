@extends('admin.layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<?php
    use App\PurchaseReturn;
    $purchae_return = PurchaseReturn::whereRaw('id = (select max(`id`) from purchase_returns)')->first();
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

                            <form class="form-horizontal" action="{{ route('purchaseReturn.save') }}" method="POST"
                                enctype="multipart/form-data" id="newMenu" name="newMenu">
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
                                                        @if ($errors->has('purchase_return_serial'))
                                                        @foreach($errors->get('purchase_return_serial') as
                                                        $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="date">Date</label>
                                                    <div
                                                        class="form-group {{ $errors->has('purchase_return_date') ? ' has-danger' : '' }}">
                                                        <input type="text"
                                                            class="form-control form-control-danger add_datepicker"
                                                            name="purchase_return_date" required readonly>
                                                        @if ($errors->has('purchase_return_date'))
                                                        @foreach($errors->get('purchase_return_date') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="supplier">Supplier</label>
                                                    <div
                                                        class="form-group {{ $errors->has('supplier_id') ? ' has-danger' : '' }}">
                                                        <select
                                                            class="form-control form-control-danger chosen-select supplier"
                                                            name="supplier_id" required="">
                                                            <option value=" ">Select Supplier</option>
                                                            <?php
                                                                        foreach ($vendors as $vendor) {
                                                                    ?>
                                                            <option value="{{$vendor->id}}">
                                                                {{$vendor->vendorName}}</option>
                                                            <?php } ?>
                                                        </select>
                                                        @if ($errors->has('supplier_id'))
                                                        @foreach($errors->get('supplier_id') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div
                                                        class="form-group {{ $errors->has('remarks') ? ' has-danger' : '' }}">
                                                        <label for="remarks">Remarks</label>
                                                        <input type="text" name="remarks" class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for=""></label>
                                                    <div class="form-group">
                                                        <table class="table table-striped gridTable">
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
                                                                            class="form-control form-control-danger chosen-select"
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
                                                    <button type="submit"
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

<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $("form").submit(function(e){
            var supplier = $(".supplier").val();
            var supplier = $.trim(supplier);
            if(supplier == ''){
                alert('Please Select Supplier !');
                e.preventDefault();
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

        row_sum();
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
    }

    function totalAmount(i){
         var qty = $(".qty_" + i).val();
        var rate = $(".rate_" + i).val();
        var sum_total = parseFloat(qty) *parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(2));

        row_sum();
        netAmount()
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

@endsection
