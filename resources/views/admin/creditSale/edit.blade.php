@extends('admin.layouts.master')

@section('custom-css')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
    use App\ProductSections;
@endphp

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card" style="margin-bottom: 200px;">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
						<div class="col-md-6">
                            <span class="shortlink">
                             <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
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
			                    	echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
			                    }
			                    Session::forget('msg')
							@endphp
						</div>
					</div>

					<div class="modal-body">
						<form class="form-horizontal" action="{{ route('creditSale.update') }}" method="post" enctype="multipart/form-data">
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
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('invoice_no') ? ' has-danger' : '' }}">
                                                <label for="inputHorizontalDnger">Invoice No</label>
                                                <input type="hidden" class="form-control form-control-danger" name="payment_type" value="Credit" required readonly/>
                                                <input type="hidden" class="form-control form-control-danger" name="creditSaleId" value="{{ $creditSale->id }}" required readonly/>
                                                <input type="text" class="form-control form-control-danger" name="invoice_no" value="{{ $creditSale->invoice_no }}" required readonly/>
                                                @if ($errors->has('invoice_no'))
                                                    @foreach($errors->get('invoice_no') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('invoice_date') ? ' has-danger' : '' }}">
                                                <label for="inputHorizontalDnger">Invoice Date</label>
                                                <input  type="text" class="form-control form-control-danger datepicker" name="invoice_date" value="{{ $creditSale->invoice_date }}">
                                                @if ($errors->has('invoice_date'))
                                                    @foreach($errors->get('invoice_date') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group {{ $errors->has('client') ? ' has-danger' : '' }}">
                                                <label for="inputHorizontalDnger">Customer</label>
                                                <div class="form-group">
                                                    <select class="form-control" id="client" name="client" readonly disabled>
                                                        <option value="">Select Client</option>
                                                        @foreach ($customers as $customer)
                                                            @if ($customer->id == $creditSale->customer_id)
                                                                <option value="{{ $customer->id }}" selected>{{ $customer->name }}</option>
                                                            @else
                                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>

                                                @if ($errors->has('client'))
                                                    @foreach($errors->get('client') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 text-right">
                                            <br>
                                            <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                                <span style="font-size: 16px;">
                                                    <i class="fa fa-save"></i> Update Data
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

							</div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped gridTable" >
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
                                            @php
                                                $i = 0;
                                                $total_qty = 0;
                                            @endphp
                                            @foreach ($creditSaleItems as $creditSaleItem)
                                                @php
                                                    $i++;
                                                    $product_info = ProductSections::where('productId',$creditSaleItem->product_id)->first();
                                                @endphp
                                                <tr id="itemRow_{{ $i }}">
                                                    <td>
                                                        <input type="hidden" name="product_id[]" value="{{$creditSaleItem->product_id}}">
                                                        <input class="" type="text" name="product_name[]" value="{{$creditSaleItem->product_name}}" readonly required>
                                                    </td>
                                                    <td>
                                                        <input style="text-align: right;" class="qty qty_{{ $i }}" type="number" name="qty[]" oninput="totalAmount({{ $i }})" value="{{ $creditSaleItem->item_quantity }}" required>
                                                    </td>

                                                    <td>
                                                        <input style="text-align: right;" class="rate_{{ $i }}" type="number" name="rate[]" oninput="totalAmount({{ $i }})" value="{{ $creditSaleItem->item_rate }}" required>
                                                    </td>

                                                    <td>
                                                        <input style="text-align: right;" class="amount amount_{{ $i }}" type="number" name="amount[]" value="{{ $creditSaleItem->item_price }}" required readonly>

                                                        <input style="text-align: right;" class="current_vat current_vat_{{$i}}" type="hidden" value="{{$product_info->vat_amount}}">

                                                        <input style="text-align: right;" class="vat_amount vat_amount_{{$i}}" type="hidden" value="{{($creditSaleItem->item_price*$product_info->vat_amount)/100}}">
                                                    </td>
                                                </tr>

                                                @php
                                                    $total_qty = $total_qty + $creditSaleItem->item_quantity;
                                                @endphp
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th>Total Quantity</th>
                                                <td>
                                                    <input class="total_qty" type="number" name="total_qty" readonly value="{{@$total_qty}}">
                                                </td>

                                                <th>Total Amount</th>
                                                <td>
                                                    <input style="text-align: right;" class="total_amount" type="number" name="total_amount" value="{{ $creditSale->invoice_amount }}" readonly>
                                                </td>

                                                <td align="center">
                                                    <input type="hidden" class="row_count" value="{{ $i }}">
                                                    <span class="btn btn-success add_item">
                                                        <i class="fa fa-plus-circle"></i> Add More
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                {{-- <td rowspan="5" colspan="2">
                                                    <div class="row" style="margin: 10px;">
                                                        <div class="col-md-12">
                                                            <label class="radio-inline">
                                                                <input type="radio" value="fixed" name="discountType"> Fixed Discount
                                                            </label>
                                                            &nbsp;&nbsp;
                                                            <label class="radio-inline">
                                                                <input type="radio" value="percentage" name="discountType" checked> Discount (%)
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="margin: 10px;">
                                                        <div class="col-md-3">Discount As %</div>
                                                        <div class="col-md-9">
                                                            <input style="text-align: right;" class="discount_percentage" type="number" name="discount_percentage" oninput="netAmount()" value="{{ $creditSale->discount_as }}">
                                                        </div>
                                                    </div>
                                                </td> --}}

                                                <td rowspan="5" style="border: none;">
                                                    <div class="row" style="margin: 6px;">
                                                        <div class="col-md-6">
                                                            <label class="radio-flex form-control"> <input type="radio" value="fixed" name="discountType" style="width: 15px !important" {{  $creditSale->discount_as == NULL ? "checked" : '' }}>
                                                                <span>
                                                                    Fixed Discount
                                                                </span>
                                                            </label>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="radio-flex form-control">
                                                                <input type="radio" value="percentage" name="discountType" style="width: 15px !important" {{  $creditSale->discount_as != NULL ? "checked" : '' }}>
                                                                <span>
                                                                    Discount As %
                                                                </span>

                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td rowspan="5" style="border: none;">
                                                    <input style="text-align: right;" class="discount_percentage" type="number" name="discount_percentage" oninput="netAmount()" value="{{@$creditSale->discount_as}}">
                                                </td>

                                                <th>Discount</th>
                                                <td>
                                                    <input style="text-align: right;" class="discount" type="number" name="discount" oninput="netAmount()" value="{{ $creditSale->discount_amount }}" readonly="">
                                                </td>

                                                <td rowspan="5" class="text-right" style="padding-top: 5px;">
                                                    <div style="padding-top: 10px;">
                                                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                                            <span style="font-size: 16px;">
                                                                <i class="fa fa-save"></i> Update Data
                                                            </span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Vat</th>
                                                <td>
                                                    <input style="text-align: right;" class="vat" type="number" name="vat" oninput="netAmount()"value="{{ $creditSale->vat_amount }}" readonly>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Net Amount</th>
                                                <td>
                                                    <input style="text-align: right;" class="net_amount" type="number" name="net_amount" value="{{ number_format(round($creditSale->net_amount),2,'.','0') }}" readonly>
                                                </td>
                                            </tr>

                                            {{-- <tr>
                                                <th>Customer Paid</th>
                                                <td>
                                                    <input style="text-align: right;" class="customer_paid" type="number" name="customer_paid" oninput="netAmount()" value="{{ $creditSale->customer_paid }}">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Change Amount</th>
                                                <td>
                                                    <input style="text-align: right;" class="change_amount" type="number" name="change_amount" value="{{ $creditSale->change_amount }}" readonly>
                                                </td>
                                            </tr> --}}
                                        </tfoot>
                                    </table>
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
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(".add_item").click(function () {
            var row_count = $('.row_count').val();
            var total = parseInt(row_count) + 1;
            $(".gridTable tbody").append('<tr id="itemRow_' + total + '">' +
                '<td>'+
                '<select name="product_id[]" class="form-control chosen-select itemList_'+total+' product_'+total+'">'+
                '</select>'+
                '</td>'+
                '<td>'+
                    '<input style="text-align: right;" class="qty qty_'+total+'" type="number" name="qty[]" value="1" required oninput="totalAmount('+total+')">'+
                '</td>'+
                '<td><input style="text-align: right;" class="rate_'+total+'" type="number" name="rate[]" required oninput="totalAmount('+total+')"></td>'+
                '<td>'+
                    '<input style="text-align: right;" class="amount amount_'+total+'" type="number" name="amount[]" required readonly>'+
                    '<input style="text-align: right;" class="current_vat current_vat_'+total+'" type="hidden" >'+
                    '<input style="text-align: right;" class="vat_amount vat_amount_'+total+'" type="hidden" >'+
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
                    var amount = 1*response.product.price;
                    var current_vat = response.product_info.vat_amount;
                    $('.current_vat_'+i).val(current_vat);
                    $('.rate_'+i).val(response.product.price);
                    $(".amount_" + i).val(amount.toFixed(2));

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
           row_sum();
           netAmount();
        }

        function netAmount(){
            var net_amount = 0;
            var total_vat_amount = 0;
            var total_amount = $(".total_amount").val();

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
            var total_amount = 0;
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

            $('.total_qty').val(total_qty);
            $('.total_amount').val(total_amount.toFixed(2));
        }
    </script>
@endsection