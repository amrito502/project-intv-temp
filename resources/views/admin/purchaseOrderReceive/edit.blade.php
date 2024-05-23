@extends('admin.layouts.master')

@section('content')

<?php
    $receive_date = Date('d-m-Y',strtotime($purchaseOrderReceive->receive_date));
?>

<div class="row">
    <div class="col-md-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                         <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
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

                            <form class="form-horizontal" action="{{ route('purchaseOrderReceive.update') }}" method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
                            {{ csrf_field() }}

                            @if( count($errors) > 0 )

                            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

                        @endif
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">

                                           <div class="col-6">
                                                <label for="po-no">PO NO</label>
                                                <div class="form-group {{ $errors->has('purchaseOrderNo') ? ' has-danger' : '' }}">
                                                    @foreach ($purchaseOrder as $order)
                                                        @if ($order->id == $purchaseOrderReceive->purchaseOrderNo)
                                                            <input type="hidden" name="purchaseOrderId" value="{{ $order->id }}">
                                                            <input class="form-control purchaseOrderNo" type="text" name="purchaseOrderNo" value="{{ $order->order_no }}" readonly required="">
                                                        @endif
                                                    @endforeach

                                                    @if ($errors->has('purchaseOrderNo'))
                                                        @foreach($errors->get('purchaseOrderNo') as $error)
                                                            <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <label for="receive-date">Receive Date</label>
                                                <div class="form-group {{ $errors->has('receive_date') ? ' has-danger' : '' }}">
                                                    <input type="text" class="form-control form-control-danger datepicker" name="receive_date" value="{{$receive_date}}" required readonly>
                                                    @if ($errors->has('receive_date'))
                                                        @foreach($errors->get('receive_date') as $error)
                                                            <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-right">
                                        <br>
                                        <button type="submit" class="btn btn-outline-info waves-effect">
                                            <span style="font-size: 16px;">
                                                <i class="fa fa-edit"></i> Update Data
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="purchaseOrderReceiveId" value="{{$purchaseOrderReceive->id}}">
                                    <div class="row">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for=""></label>
                                            <div class="form-group">
                                                <table class="table table-striped gridTable" >
                                                    <thead>
                                                        <tr>
                                                            <th width="20%">Product Name</th>
                                                            <th>Order Qty</th>
                                                            <th>Rec Qty</th>
                                                            <th>Cur Qty</th>
                                                            <th>Bal Qty</th>
                                                            <th>Rate</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                        @php
                                                            $i = 0;
                                                        @endphp
                                                        @foreach ($purchaseOrderItems as $item)
                                                            @php
                                                                $qty = 0;
                                                                $i++;
                                                            @endphp

                                                            @foreach ($purchaseOrderReceiveItem as $itemInfo)
                                                                @if ($itemInfo->product_id == $item->productId && $itemInfo->purchase_order_receive_id != $purchaseOrderReceive->id)
                                                                    @php
                                                                        $qty = $qty + $itemInfo->qty;
                                                                    @endphp
                                                                @endif

                                                                @if ($itemInfo->product_id == $item->productId && $itemInfo->purchase_order_receive_id == $purchaseOrderReceive->id)
                                                                    @php
                                                                        $curQty = $itemInfo->qty;
                                                                        $amount = $itemInfo->amount;
                                                                    @endphp
                                                                @endif
                                                            @endforeach

                                                            <tr id="itemRow_{{$i}}">
                                                                <td>
                                                                    <input type="hidden" name="product_id[]" value="{{$item->product_id}}">
                                                                  <input class="" type="text" name="product_name[]" value="{{$item->name}}" readonly required>
                                                                </td>
                                                                <td><input style="text-align: right;" class="qty qty_{{$i}}" type="number" name="qty[]" value="{{ $item->qty }}" oninput="totalAmount({{$i}})" readonly required></td>
                                                                <td><input style="text-align: right;" class="rec_qty rec_qty_{{$i}}" type="number" name="rec_qty[]" value="{{ $qty }}" oninput="totalAmount({{ $i }})"></td>
                                                                <td><input style="text-align: right;" class="cur_qty cur_qty_{{$i}}" type="number" name="cur_qty[]" value="{{ $curQty }}" oninput="totalAmount({{$i}})"></td>
                                                                <td><input style="text-align: right;" class="due_qty due_qty_{{$i}}" type="number" name="due_qty[]" oninput="totalAmount({{$i}})" readonly></td>
                                                                <td><input style="text-align: right;" class="rate_{{$i}}" type="number" name="rate[]" value="{{ $item->rate }}" oninput="totalAmount({{$i}})" required readonly></td>
                                                                <td>
                                                                    <input style="text-align: right;" class="amount amount_{{$i}}" type="number" name="amount[]" value="{{ $amount }}" required readonly>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>

                                                    <tfoot>
                                                        <tr style="text-align: right;">
                                                            <th>Total Summary</th>
                                                            <td><input style="text-align: right;" class="total_qty" type="number" name="total_qty" value="{{$purchaseOrderReceive->total_qty}}" readonly></td>
                                                            <td><input style="text-align: right;" class="total_rec_qty" type="number" name="total_rec_qty" readonly></td>
                                                            <td><input style="text-align: right;" class="total_cur_qty" type="number" name="total_cur_qty" readonly></td>
                                                            <td><input style="text-align: right;" class="total_due_qty" type="number" name="total_due_qty" readonly></td>
                                                            <th>Total Amount</th>
                                                            <td><input style="text-align: right;" class="total_amount" type="number" name="total_amount" value="{{$purchaseOrderReceive->total_amount}}" readonly></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 m-b-20 text-right">
                                            <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                                <span style="font-size: 16px;">
                                                    <i class="fa fa-edit"></i> Update Data
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
    $(".add_item").click(function () {
        var row_count = $('.row_count').val();
        var total = parseInt(row_count) + 1;
        $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
            '<td>'+
            '<select name="product_id[]" class="form-control chosen-select itemList_'+total+'">'+
            '</select>'+
            '</td>'+
            '<td><input style="text-align: right;" class="qty qty_'+total+'" type="number" name="qty[]" required oninput="totalAmount('+total+')"></td>'+
            '<td><input style="text-align: right;" class="rate_'+total+'" type="number" name="rate[]" required oninput="totalAmount('+total+')"></td>'+
            '<td><input style="text-align: right;" style="text-align: right;" class="amount amount_'+total+'" type="number" name="amount[]" required readonly></td>'+
            '<td align="center"><span class="btn btn-danger item_remove" onclick="itemRemove(' + total + ')"><i class="fa fa-trash"></i> Delete</span></td>'+
            '</tr>');
        $('.row_count').val(total);
        var itemList = $("#itemList div select").html();
        $('.itemList_'+total).html(itemList);
         $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");
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
        var qty = parseFloat($(".qty_" + i).val());
        var rate = parseFloat($(".rate_" + i).val());

        if ($(".rec_qty_" + i).val() == 0) {
            var rec_qty = 0;
        }
        else {
            var rec_qty = parseFloat($(".rec_qty_" + i).val());
        }

        var check_qty = qty - rec_qty;

        if ($(".cur_qty_" + i).val() > check_qty)
        {
            due_qty = qty - rec_qty;
            $(".cur_qty_" + i).val(due_qty);
            totalAmount(i);
        }

        var cur_qty = $(".cur_qty_" + i).val();
        var due_qty = parseFloat(qty) - (parseFloat(rec_qty) + parseFloat(cur_qty));

        var sum_total = parseFloat(cur_qty) * parseFloat(rate);
        $(".amount_" + i).val(sum_total.toFixed(2));

        $(".due_qty_" + i).val(due_qty.toFixed(2));

        row_sum();
        netAmount();

    }

    function netAmount(){
        var net_amount = 0;
        var total_amount = $(".total_amount").val();
        if($(".discount").val() == ''){
            var discount = 0;
        }else{
           var discount = $(".discount").val();
        }
        if($(".vat").val() == ''){
            var vat = 0;
        }else{
           var vat = $(".vat").val();
        }

        net_amount = (parseFloat(total_amount) + parseFloat(vat)) - parseFloat(discount);
        $('.net_amount').val(net_amount.toFixed(2));
    }

    function row_sum() {
        var total_qty = 0;
        var total_amount = 0;
        var total_rec_qty = 0;
        var total_cur_qty = 0;
        var total_due_qty = 0;
        $(".qty").each(function () {
            var stvalTotal = parseFloat($(this).val());
            // console.log(stval);
            total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
        });

        $(".amount").each(function () {
            var stvalAmount = parseFloat($(this).val());
            // console.log(stval);
            total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
        });

        $(".rec_qty").each(function () {
            var rec_qty = parseFloat($(this).val());
            total_rec_qty += isNaN(rec_qty) ? 0 : rec_qty;
        });

        $(".cur_qty").each(function () {
            var cur_qty = parseFloat($(this).val());
            total_cur_qty += isNaN(cur_qty) ? 0 : cur_qty;
        });

        $(".due_qty").each(function () {
            var due_qty = parseFloat($(this).val());
            total_due_qty += isNaN(due_qty) ? 0 : due_qty;
        });

        $('.total_qty').val(total_qty.toFixed(2));
        $('.total_amount').val(total_amount.toFixed(2));
        $('.total_rec_qty').val(total_rec_qty.toFixed(2));
        $('.total_cur_qty').val(total_cur_qty.toFixed(2));
        $('.total_due_qty').val(total_due_qty.toFixed(2));

    }

</script>



@endsection
