@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card" style="margin-bottom: 30px;">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="card-title">{{ $title }}</h4>
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
					<form class="form-horizontal" action="{{ route('productWiseSales.index') }}" method="post"
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
							<div class="col-md-6">
								<label for="product">Products</label>
								<div class="form-group">
									<select class="form-control chosen-select" id="product" name="product">
										<option value="">Select Products</option>
										@foreach ($products as $productInfo)
										<option value="{{ $productInfo->id }}">{{ $productInfo->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6 form-group">
										<label for="from_date">From Date</label>
										<input type="text" class="form-control datepicker"
											{{ $fromDate == '1970-01-01' ? 'id=from_date' : 'value='.date("d-m-Y",strtotime($fromDate)) }}
											name="from_date" placeholder="Select Date From">
									</div>
									<div class="col-md-6 form-group">
										<label for="to_date">To Date</label>
										<input type="text" class="form-control datepicker"
											{{ $toDate == '1970-01-01' ? 'id=to_date' : 'value='.date("d-m-Y",strtotime($toDate)) }}
											name="to_date">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12 text-right" style="padding-bottom: 10px;">
								<button type="submit" class="btn btn-outline-info btn-lg waves-effect"
									onclick="return save()">
									<span style="font-size: 16px;">
										<i class="fa fa-search"></i> Search
									</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12 form-group">
		<div class="card" style="margin-bottom: 0px;">
			<div class="card-header">
				<div class="row">
					<div class="col-md-6">
						<h4 class="card-title">{{ $title }}</h4>
					</div>
					<div class="col-md-6 text-right">
						<form class="form-horizontal" action="{{ route('productWiseSales.print') }}" target="_blank"
							method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="from_date" value="{{ $fromDate }}">
							<input type="hidden" name="to_date" value="{{ $toDate }}">
							<input type="hidden" name="product" value="{{ $product }}">
							<button type="submit" class="btn btn-outline-info btn-lg waves-effect">
								<span style="font-size: 16px;">
									<i class="fa fa-save"></i> Print Data
								</span>
							</button>
						</form>
					</div>
				</div>
			</div>

			<div class="card-body">
				@php
				$message = Session::get('msg');
				if (isset($message))
				{
				echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
						.$message."</strong></div>";
				}
				Session::forget('msg');
				// echo $fromDate;
				// echo "<pre>";
					// print_r($data);
					// echo "</pre>";
				@endphp

				<div class="table-responsive">
					<table id="dataTable" name="dataTable" class="table table-bordered">
						<thead>
							<tr>
								<th>Sl</th>
								<th>Product Code</th>
								<th>Product Name</th>
								<th>Payment Type</th>
								<th>Qty</th>
								<th>Amount</th>
							</tr>
						</thead>

						<tbody id="tbody">
							@php
							$sl = 0;
							$itemId = 0;
							$cashItem = 0;
							$creditItem = 0;
							@endphp

							@foreach ($cashSales as $cashSaleItemId)
							@if ($cashSaleItemId->item_id != $cashItem)
							@php
							$sl++;
							$l = 0;
							$arrayCount = count($cashSales);
							$cashItem = 0;
							$itemName = 0;
							$totalQty = 0;
							$totalAmount = 0;
							@endphp
							@foreach ($cashSales as $cashSale)
							@php
							if ($cashSale->item_id == $cashSaleItemId->item_id)
							{
							$totalQty = $totalQty + $cashSale->item_quantity;
							$totalAmount = $totalAmount + ($cashSale->item_quantity * $cashSale->item_rate);
							$cashItem = $cashSale->item_id;
							$itemName = $cashSale->name;
							}
							$l++;
							@endphp

							@if ($arrayCount == $l)
							<tr>
								<td>{{ $sl }}</td>
								<td>{{ $cashItem }}</td>
								<td>{{ $itemName }}</td>
								<td>{{ $cashSale->payment_type }}</td>
								<td>{{ $totalQty }}</td>
								<td>{{ $totalAmount }}</td>
							</tr>
							@endif
							@endforeach
							@endif
							@endforeach

							@foreach ($creditSales as $creditSaleItemId)
							@if ($creditSaleItemId->item_id != $creditItem)
							@php
							$sl++;
							$l = 0;
							$arrayCount = count($creditSales);
							$creditItem = 0;
							$itemName = "";
							$totalQty = 0;
							$totalAmount = 0;
							@endphp
							@foreach ($creditSales as $creditSale)
							@php
							if ($creditSale->item_id == $creditSaleItemId->item_id)
							{
							$totalQty = $totalQty + $creditSale->item_quantity;
							$totalAmount = $totalAmount + ($creditSale->item_quantity * $creditSale->item_rate);
							$creditItem = $creditSale->item_id;
							$itemName = $creditSale->name;
							}
							$l++;
							@endphp

							@if ($arrayCount == $l)
							<tr>
								<td>{{ $sl }}</td>
								<td>{{ $creditItem }}</td>
								<td>{{ $itemName }}</td>
								<td>{{ $creditSale->payment_type }}</td>
								<td>{{ $totalQty }}</td>
								<td>{{ $totalAmount }}</td>
							</tr>
							@endif
							@endforeach
							@endif
							@endforeach

							@foreach ($onlineSales as $onlineSale)
							<tr>
								<td>{{ $sl++ }}</td>
								<td>{{ $onlineSale[0]->product_id }}</td>
								<td>{{ $onlineSale[0]->product->name }}</td>
								<td>Online</td>
								<td>{{ $onlineSale->sum('qty') }}</td>
								<td>{{ $onlineSale->sum('price') }}</td>
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
<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#dataTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();
        });
</script>
@endsection
