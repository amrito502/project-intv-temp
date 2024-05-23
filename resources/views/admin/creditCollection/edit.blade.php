@extends('admin.layouts.master')

@section('custom-css')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
						<form class="form-horizontal" action="{{ route('creditCollection.update') }}" method="post" enctype="multipart/form-data">
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
								<div class="col-md-12 text-right" style="padding-bottom: 10px;">
	                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect" onclick="return save()">
	                                    <span style="font-size: 16px;">
	                                        <i class="fa fa-save"></i> Update Data
	                                    </span>
	                                </button>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('client') ? ' has-danger' : '' }}">
	                                    <label for="client">Client</label>
	                                    <input type="hidden" class="form-control" id="credit_collection_id" name="credit_collection_id" value="{{ $creditCollection->id }}">
	                                    <input type="hidden" class="form-control" id="client" name="client" value="{{ $clientEntry->id }}">
	                                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $clientEntry->name }}" readonly>

	                                    @if ($errors->has('client'))
	                                        @foreach($errors->get('client') as $error)
	                                            <div class="form-control-feedback">{{ $error }}</div>
	                                        @endforeach
	                                    @endif
	                                </div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
			                                <div class="form-group {{ $errors->has('phone') ? ' has-danger' : '' }}">
			                                    <label for="birthday">Phone</label>
			                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $clientEntry->mobile }}" readonly />
			                                    @if ($errors->has('phone'))
			                                        @foreach($errors->get('phone') as $error)
			                                            <div class="form-control-feedback">{{ $error }}</div>
			                                        @endforeach
			                                    @endif
			                                </div>
										</div>

										<div class="col-md-6">
			                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
			                                    <label for="full_name">Email</label>
			                                    <input type="text" class="form-control" id="email" name="email" value="{{ $clientEntry->email }}" readonly />
			                                    @if ($errors->has('email'))
			                                        @foreach($errors->get('email') as $error)
			                                            <div class="form-control-feedback">{{ $error }}</div>
			                                        @endforeach
			                                    @endif
			                                </div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('payment_no') ? ' has-danger' : '' }}">
	                                    <label for="phone">Payment No</label>
                                        <input type="text" class="form-control" id="payment_no" name="payment_no" value="{{ $creditCollection->payment_no }}" required readonly/>
                                        @if ($errors->has('payment_no'))
                                            @foreach($errors->get('payment_no') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>

								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('payment_date') ? ' has-danger' : '' }}">
	                                    <label for="payment_date">Payment Date</label>
	                                    <input type="text" class="form-control datepicker" id="payment_date" name="payment_date" value="{{ Date('d-m-Y',strtotime($creditCollection->payment_date)) }}" readonly>
                                        @if ($errors->has('payment_date'))
                                            @foreach($errors->get('payment_date') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('money_receipt_no') ? ' has-danger' : '' }}">
	                                    <label for="phone">Money Receipt No</label>
                                        <input type="text" class="form-control" id="money_receipt_no" name="money_receipt_no" value="{{ $creditCollection->money_receipt_no }}" required/>
                                        @if ($errors->has('money_receipt_no'))
                                            @foreach($errors->get('money_receipt_no') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>

								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('money_receipt_type') ? ' has-danger' : '' }}">
	                                    <label for="money_receipt_type">Money Receipt Type</label>

	                                    <div class="form-group">
	                                    	<select class="form-control" id="money_receipt_type" name="money_receipt_type" required="">
	                                    		<option value="">Select Money Receipt Type</option>
	                                    		@php
	                                    			$cash = "";
	                                    			$bkash = "";
	                                    			$others = "";
	                                    			if ($creditCollection->money_receipt_type == 'Cash')
	                                    			{
	                                    				$cash = "selected";
	                                    			}
	                                    			else
	                                    			{
	                                    				if ($creditCollection->money_receipt_type == 'Bkash')
	                                    				{
	                                    					$bkash = "selected";
	                                    				}
	                                    				else
	                                    				{
	                                    					$others = "selected";
	                                    				}

	                                    			}
	                                    		@endphp
	                                    		<option value="Cash" {{ $cash }}>Cash</option>
	                                    		<option value="Bkash" {{ $bkash }}>Bkash</option>
	                                    		<option value="Others" {{ $others }}>Others</option>
	                                    	</select>
	                                    </div>

	                                    @if ($errors->has('money_receipt_type'))
	                                        @foreach($errors->get('money_receipt_type') as $error)
	                                            <div class="form-control-feedback">{{ $error }}</div>
	                                        @endforeach
	                                    @endif
	                                </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('due_amount') ? ' has-danger' : '' }}">
	                                    <label for="due_amount">Due Amount</label>
                                        <input type="number" class="form-control" id="due_amount" name="due_amount" value="{{ $due_amount }}" required readonly />
                                        @if ($errors->has('due_amount'))
                                            @foreach($errors->get('due_amount') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6">
			                                <div class="form-group {{ $errors->has('new_paid') ? ' has-danger' : '' }}">
			                                    <label for="new_paid">New paid</label>
		                                        <input type="text" class="form-control" id="new_paid" name="new_paid" value="{{ $creditCollection->payment_amount }}" required/>
		                                        @if ($errors->has('new_paid'))
		                                            @foreach($errors->get('new_paid') as $error)
		                                                <div class="form-control-feedback">{{ $error }}</div>
		                                            @endforeach
		                                        @endif
			                                </div>
										</div>

										<div class="col-md-6">
			                                <div class="form-group {{ $errors->has('balance') ? ' has-danger' : '' }}">
			                                    <label for="balance">Balance</label>
		                                        <input type="number" class="form-control" id="balance" name="balance" value="" required readonly />
		                                        @if ($errors->has('balance'))
		                                            @foreach($errors->get('balance') as $error)
		                                                <div class="form-control-feedback">{{ $error }}</div>
		                                            @endforeach
		                                        @endif
			                                </div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group {{ $errors->has('remarks') ? ' has-danger' : '' }}">
										<label for="remarks">Remarks</label>
										<textarea class="form-control" id="remarks" name="remarks" rows="5">{{ $creditCollection->remarks }}</textarea>
										@if ($errors->has('remarks'))
											@foreach ($errors->get('remarks') as $error)
												<div class="form-control-feedback">{{ $error }}</div>
											@endforeach
										@endif
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('custom-js')
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
    	$(document).ready(function(){
    		// $('#client').on('change',function(){
    		// 	var clientId = $(this).val();

    		// 	$.ajax({
    		// 		headers: {
    		// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    		// 		},
    		// 		type: 'POST',
    		// 		url: "{{ route('getClientInfo') }}",
    		// 		data: {
    		// 			clientId : clientId
    		// 		},
    		// 		success: function(data){
    		// 			var clientInfo = data.clientInfo;
    		// 			var creditSalesInfo = data.creditSalesInfo;
    		// 			var creditCollectionsInfo = data.creditCollectionsInfo;
    		// 			var net_amounts = 0;
    		// 			var payment_amounts = 0;
    		// 			$('#phone').val(clientInfo.phone);
    		// 			$('#email').val(clientInfo.email);
    		// 			$('#payment_no').val(data.payment_no);

    		// 			for (var creditCollection of creditCollectionsInfo)
    		// 			{
    		// 				payment_amounts = payment_amounts + parseFloat(creditCollection.payment_amount);
    		// 			}

    		// 			for (var creditSale of creditSalesInfo)
    		// 			{
    		// 				net_amounts = net_amounts + parseFloat(creditSale.net_amount);
    		// 			}

    		// 			var due_amount = net_amounts - payment_amounts;
    		// 			$('#due_amount').val(due_amount.toFixed(2));
    		// 		}
    		// 	})
    		// });

    		$('#new_paid').on('input',function(){
				var balance = parseFloat($('#due_amount').val()) - parseFloat($(this).val());
				$('#balance').val(balance.toFixed(2));
    		});
    	});
    </script>
@endsection
