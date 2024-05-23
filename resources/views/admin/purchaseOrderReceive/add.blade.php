@extends('admin.layouts.master')

<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\PurchaseOrderReceive;
use App\PurchaseOrderReceiveItem;
@endphp

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card" style="margin-bottom: 200px;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">{{ $title }}</h4>
                        </div>
                        <div class="col-md-6">
                            <span class="shortlink">
                                <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"
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
                    echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" . $message .
                            '</strong></div>';
                    }

                    Session::forget('msg');
                    ?>

                    <div id="addNewMenu" class="">
                        <div class="">
                            <div class="">

                                <form class="form-horizontal" action="{{ route('purchaseOrderReceive.save') }}"
                                    method="POST" enctype="multipart/form-data" id="newMenu" name="newMenu">
                                    {{ csrf_field() }}

                                    @if (count($errors) > 0)

                                        <div style="display:inline-block;width: auto;" class="alert alert-danger">
                                            {{ $errors->first() }}</div>

                                    @endif
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label for="po-no">Purchase Order NO</label>
                                                                <div
                                                                    class="form-group {{ $errors->has('purchaseOrderNo') ? ' has-danger' : '' }}">
                                                                    <select
                                                                        class="form-control form-control-danger chosen-select purchaseOrderNo"
                                                                        name="purchaseOrderNo" required>
                                                                        <option value=" ">Select Purchase Order Number
                                                                        </option>
                                                                        @foreach ($purchaseOrder as $order)
                                                                            @php
                                                                                $qtySum = 0;
                                                                                $purchaseOrderReceives = PurchaseOrderReceive::where('purchaseOrderNo', $order->id)->get();
                                                                                foreach ($purchaseOrderReceives as $purchaseOrderReceive) {
                                                                                    $purchaseOrderReceiveItemSum = PurchaseOrderReceiveItem::where('purchase_order_receive_id', $purchaseOrderReceive->id)->sum('qty');
                                                                                    $qtySum = $qtySum + $purchaseOrderReceiveItemSum;
                                                                                }
                                                                            @endphp
                                                                            @if (@$qtySum != $order->total_qty)
                                                                                <option value="{{ $order->id }}">
                                                                                    {{ $order->order_no }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('purchaseOrderNo'))
                                                                        @foreach ($errors->get('purchaseOrderNo') as $error)
                                                                            <div class="form-control-feedback">
                                                                                {{ $error }}</div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="receive-date">Receive Date</label>
                                                                <div
                                                                    class="form-group {{ $errors->has('receive_date') ? ' has-danger' : '' }}">
                                                                    <input type="text"
                                                                        class="form-control form-control-danger add_datepicker"
                                                                        name="receive_date" required readonly>
                                                                    @if ($errors->has('receive_date'))
                                                                        @foreach ($errors->get('receive_date') as $error)
                                                                            <div class="form-control-feedback">
                                                                                {{ $error }}</div>
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
                                                                <i class="fa fa-save"></i> Save Data
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for=""></label>
                                                        <div class="form-group">
                                                            <table class="table table-striped gridTable">
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
                                                                    <tr>
                                                                        <td>
                                                                            <input style="text-align: right;" type="text"
                                                                                name="product_id">
                                                                        </td>
                                                                        <td><input style="text-align: right;"
                                                                                class="qty qty_1" type="number" name="qty[]"
                                                                                oninput="totalAmount('1')"></td>
                                                                        <td><input style="text-align: right;"
                                                                                class="rec_qty rec_qty_1" type="number"
                                                                                name="rec_qty[]" oninput="totalAmount('1')">
                                                                        </td>
                                                                        <td><input style="text-align: right;"
                                                                                class="cur_qty cur_qty_1" type="number"
                                                                                name="cur_qty[]" oninput="totalAmount('1')">
                                                                        </td>
                                                                        <td><input style="text-align: right;"
                                                                                class="due_qty due_qty_1" type="number"
                                                                                name="due_qty[]" oninput="totalAmount('1')">
                                                                        </td>
                                                                        <td><input style="text-align: right;" class="rate_1"
                                                                                type="number" name="rate[]"
                                                                                oninput="totalAmount('1')"></td>
                                                                        <td><input style="text-align: right;"
                                                                                class="amount amount_1" type="number"
                                                                                name="amount[]" readonly></td>
                                                                    </tr>
                                                                </tbody>

                                                                <tfoot>
                                                                    <tr style="text-align: right;">
                                                                        <th>Total Summary</th>
                                                                        <td><input style="text-align: right;"
                                                                                class="total_qty" type="number"
                                                                                name="total_qty" readonly></td>
                                                                        <td><input style="text-align: right;"
                                                                                class="total_rec_qty" type="number"
                                                                                name="total_rec_qty" readonly></td>
                                                                        <td><input style="text-align: right;"
                                                                                class="total_cur_qty" type="number"
                                                                                name="total_cur_qty" readonly></td>
                                                                        <td><input style="text-align: right;"
                                                                                class="total_due_qty" type="number"
                                                                                name="total_due_qty" readonly></td>
                                                                        <th>Total Amount</th>
                                                                        <td><input style="text-align: right;"
                                                                                class="total_amount" type="number"
                                                                                name="total_amount" readonly></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
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
                <?php foreach ($products as $product) { ?>
                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->deal_code }})</option>
                <?php } ?>
            </select>
        </div>
    </div>

@endsection

@section('custom-js')

    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {
            var updateThis;

            // Get Purchase order id
            $(".purchaseOrderNo").change(function() {
                var purchaseOrderId = $('.purchaseOrderNo').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: "{{ route('getPurchaseOrderItem') }}",
                    data: {
                        purchaseOrderId: purchaseOrderId,
                    },
                    success: function(data) {
                        var purchaseOrderItems = data.purchaseOrderItems;
                        var purchaseOrderReceiveItem = data.purchaseOrderReceiveItem;
                        var purchaseOrder = data.purchaseOrder;


                        let totalRecQty = 0;
                        let totalCurQty = 0;
                        let totalBalanceQty = 0;
                        let totalAmount = 0;

                        $(".total_qty").val(purchaseOrder.total_qty);
                        $(".gridTable tbody tr").remove();
                        var i = 0;
                        for (var row of purchaseOrderItems) {
                            var qty = 0;
                            i++;
                            for (var itemInfo of purchaseOrderReceiveItem) {
                                if (itemInfo.product_id == row.productId) {
                                    qty = qty + parseFloat(itemInfo.qty);

                                }
                            }
                            if (qty < 1) {
                                qty = parseFloat(0).toFixed('2');
                                qty = parseFloat(0).toFixed('2');
                                var curreny_qty = parseFloat(0).toFixed('2');
                                var balance_qty = parseFloat(0).toFixed('2');
                                var balance_qty = parseFloat(0).toFixed('2');
                                var amount = parseFloat(0).toFixed('2');
                            } else {
                                var curreny_qty = row.qty - parseFloat(qty);
                                var balance_qty = parseFloat(row.qty) - (parseFloat(qty) +
                                    parseFloat(curreny_qty));
                                var amount = row.rate * parseFloat(curreny_qty);
                            }

                            totalRecQty += qty;
                            totalCurQty += curreny_qty;
                            totalBalanceQty += balance_qty;
                            totalAmount += amount;

                            if (row.qty != qty) {
                                $(".gridTable tbody").append('<tr id="itemRow_' + i + '">' +
                                    '<td><input class="item item_' + i +
                                    '" type="hidden" name="product_id[]" value="' + row
                                    .productId + '" >' +
                                    '<input class="item item_' + i +
                                    '" type="text" name="product_name[]" value="' + row
                                    .name + '" required readonly></td>' +
                                    '<td><input style="text-align: right;" class="qty qty_' +
                                    i +
                                    '" type="number" name="qty[]" required oninput="totalAmount(' +
                                    i + ')" value="' + row.qty + '" readonly></td>' +
                                    '<td><input style="text-align: right;" class="rec_qty rec_qty_' +
                                    i +
                                    '" type="number" name="rec_qty[]" required onchange="totalAmount(' +
                                    i + ')" value="' + qty + '" readonly></td>' +
                                    '<td><input style="text-align: right;" class="cur_qty cur_qty_' +
                                    i + '" type="number" name="cur_qty[]" value="' +
                                    curreny_qty + '" required oninput="totalAmount(' + i +
                                    ')"></td>' +
                                    '<td><input style="text-align: right;" class="due_qty due_qty_' +
                                    i + '" type="number" name="due_qty[]" value="' +
                                    balance_qty + '" required oninput="totalAmount(' + i +
                                    ')" readonly></td>' +
                                    '<td><input style="text-align: right;" class="rate_' +
                                    i +
                                    '" type="number" name="rate[]" required oninput="totalAmount(' +
                                    i + ')" value="' + row.rate + '" readonly></td>' +
                                    '<td><input style="text-align: right;" class="amount amount_' +
                                    i +
                                    '" type="number" name="amount[]" required readonly value="' +
                                    amount + '"></td>' +
                                    '</tr>');
                            }
                        }

                        $('.total_rec_qty').val(totalRecQty);
                        $('.total_cur_qty').val(totalCurQty);
                        $('.total_due_qty').val(totalBalanceQty);
                        $('.total_amount').val(totalAmount);

                    }
                })
            });

            $("form").submit(function(e) {
                var purchaseOrderNo = $(".purchaseOrderNo").val();
                var purchaseOrderNo = $.trim(purchaseOrderNo);
                if (purchaseOrderNo == '') {
                    alert('Please Select PO No !');
                    e.preventDefault();
                }
            });
        });

    </script>

    <script type="text/javascript">
        $(".add_item").click(function() {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;
            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td>' +
                '<select name="product_id[]" class="form-control chosen-select itemList_' + total + '">' +
                '</select>' +
                '</td>' +
                '<td><input class="qty qty_' + total +
                '" type="number" name="qty[]" required oninput="totalAmount(' + total + ')"></td>' +
                '<td><input class="rate_' + total +
                '" type="number" name="rate[]" required oninput="totalAmount(' + total + ')"></td>' +
                '<td><span class="item_remove"><i class="fa fa-times" onclick="itemRemove(' + total +
                ')"></i>' +
                '<input class="amount amount_' + total +
                '" type="number" name="amount[]" required readonly></span></td>' +
                '</tr>');
            $('.row_count').val(total);
            var itemList = $("#itemList div select").html();
            $('.itemList_' + total).html(itemList);
            $('.chosen-select').chosen();
            $('.chosen-select').trigger("chosen:updated");
        });

        function itemRemove(i) {
            var total_qty = $('.total_qty').val();
            var total_amount = $('.total_amount').val();

            var quantity = $('.qty_' + i).val();
            var amount = $('.amount_' + i).val();

            total_qty = total_qty - quantity;
            total_amount = total_amount - amount;

            $('.total_qty').val(total_qty.toFixed(2));
            $('.total_amount').val(total_amount.toFixed(2));

            $("#itemRow_" + i).remove();
        }

        function totalAmount(i) {
            var qty = parseFloat($(".qty_" + i).val());
            var rate = parseFloat($(".rate_" + i).val());

            if ($(".rec_qty_" + i).val() == 0) {
                var rec_qty = 0;
            } else {
                var rec_qty = parseFloat($(".rec_qty_" + i).val());
            }

            var check_qty = qty - rec_qty;

            if ($(".cur_qty_" + i).val() > check_qty) {
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

        function netAmount() {
            var net_amount = 0;
            var total_amount = $(".total_amount").val();
            if ($(".discount").val() == '') {
                var discount = 0;
            } else {
                var discount = $(".discount").val();
            }
            if ($(".vat").val() == '') {
                var vat = 0;
            } else {
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
            $(".qty").each(function() {
                var stvalTotal = parseFloat($(this).val());
                // console.log(stval);
                total_qty += isNaN(stvalTotal) ? 0 : stvalTotal;
            });

            $(".amount").each(function() {
                var stvalAmount = parseFloat($(this).val());
                // console.log(stval);
                total_amount += isNaN(stvalAmount) ? 0 : stvalAmount;
            });

            $(".rec_qty").each(function() {
                var rec_qty = parseFloat($(this).val());
                total_rec_qty += isNaN(rec_qty) ? 0 : rec_qty;
            });

            $(".cur_qty").each(function() {
                var cur_qty = parseFloat($(this).val());
                total_cur_qty += isNaN(cur_qty) ? 0 : cur_qty;
            });

            $(".due_qty").each(function() {
                var due_qty = parseFloat($(this).val());
                total_due_qty += isNaN(due_qty) ? 0 : due_qty;
            });

            $('.total_qty').val(total_qty.toFixed(2));
            $('.total_amount').val(total_amount.toFixed(2));
            $('.total_rec_qty').val(total_rec_qty.toFixed(2));
            $('.total_cur_qty').val(total_cur_qty.toFixed(2));
            $('.total_due_qty').val(total_due_qty.toFixed(2));

        }


        /* $(".purchaseOrderNo").change(function () {
             var purchaseOrderId = $('.purchaseOrderNo').val();
             console.log(purchaseOrderId);
             $.ajax({
             type: 'GET',
             url: '<?php
        echo url('/get-purchase-order'); ?>
        /'+ purchaseOrderId,
        dataType: "JSON",
            success: function(response) {
                var blcntr = data.containers;
                $(".cntr tbody tr").remove();
                for (var row of blcntr) {
                    $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                        '<td>' +
                        '<select name="product_id[]" class="form-control chosen-select itemList_' + total + '">' +
                        '</select>' +
                        '</td>' +
                        '<td><input class="qty qty_' + total +
                        '" type="number" name="qty[]" required oninput="totalAmount(' + total + ')"></td>' +
                        '<td><input class="rate_' + total +
                        '" type="number" name="rate[]" required oninput="totalAmount(' + total + ')"></td>' +
                        '<td><span class="item_remove"><i class="fa fa-times" onclick="itemRemove(' + total +
                        ')"></i>' +
                        '<input class="amount amount_' + total +
                        '" type="number" name="amount[]" required readonly></span></td>' +
                        '</tr>');
                }
            }
        });

        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");

        });*/

    </script>

@endsection
