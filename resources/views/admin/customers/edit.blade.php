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
						<form class="form-horizontal" action="{{ route('customer.customerUpdate') }}" method="post" enctype="multipart/form-data">
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

							<input type="hidden" name="customerId" value="{{ $customer->id }}">

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('customer_name') ? ' has-danger' : '' }}">
	                                    <label for="full_name">Full Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ $customer->name }}" required/>
                                        @if ($errors->has('customer_name'))
                                            @foreach($errors->get('customer_name') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>

								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('gender') ? ' has-danger' : '' }}">
	                                    <label for="gender">Gender</label>

	                                    <div class="form-group">
	                                    	<select class="form-control" id="gender" name="gender">
	                                    		<option value="">Select Gender</option>
	                                    		@php
	                                    			$male = "";
	                                    			$female = "";
	                                    			if ($customer->gender == "Male")
	                                    			{
	                                    				$male = "selected";
	                                    			}
	                                    			else
	                                    			{
	                                    				$female = "selected";
	                                    			}
	                                    		@endphp
	                                    		<option value="Male" {{ $male }}>Male</option>
	                                    		<option value="Female" {{ $female }}>Female</option>
	                                    	</select>
	                                    </div>

	                                    @if ($errors->has('gender'))
	                                        @foreach($errors->get('gender') as $error)
	                                            <div class="form-control-feedback">{{ $error }}</div>
	                                        @endforeach
	                                    @endif
	                                </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('dob') ? ' has-danger' : '' }}">
	                                    <label for="birthday">Birthday</label>
	                                    <input type="text" class="form-control datepicker" id="dob" value="{{ date('d-m-Y', strtotime($customer->dob)) }}" name="dob" placeholder="Select Your Date Of Birth">
	                                    @if ($errors->has('dob'))
	                                        @foreach($errors->get('dob') as $error)
	                                            <div class="form-control-feedback">{{ $error }}</div>
	                                        @endforeach
	                                    @endif
	                                </div>
								</div>
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('client_group') ? ' has-danger' : '' }}">
	                                    <label for="client-group">Client Group</label>

	                                    <div class="form-group">
	                                    	<select class="form-control" id="client_group" name="client_group">
	                                    		<option value="">Select Customer Group</option>
	                                    		@foreach ($customerGroup as $group)
	                                    			@if ($group->id == $customer->clientGroup)
	                                    				<option value="{{ $group->id }}" selected>{{ $group->groupName }}</option>
	                                    			@else
	                                    				<option value="{{ $group->id }}">{{ $group->groupName }}</option>
	                                    			@endif
	                                    		@endforeach
	                                    	</select>
	                                    </div>

	                                    @if ($errors->has('client_group'))
	                                        @foreach($errors->get('client_group') as $error)
	                                            <div class="form-control-feedback">{{ $error }}</div>
	                                        @endforeach
	                                    @endif
	                                </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('phone_number') ? ' has-danger' : '' }}">
	                                    <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $customer->mobile }}" required/>
                                        @if ($errors->has('phone_number'))
                                            @foreach($errors->get('phone_number') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>

								<div class="col-md-6">
	                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
	                                    <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" required/>
                                        @if ($errors->has('email'))
                                            @foreach($errors->get('email') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
	                                <div class="form-group {{ $errors->has('address') ? ' has-danger' : '' }}">
	                                    <label for="address">Address</label>
                                        <textarea class="form-control form-control-danger" name="address" rows="5">{{ $customer->address }}</textarea>
                                        @if ($errors->has('address'))
                                            @foreach($errors->get('address') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
	                                </div>
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
    	function save()
    	{
    		var password = $('#password').val();
    		var confirm_password = $('#confirm_password').val();
    		var gender = $('#gender').val();

    		if (gender == "")
    		{
    			alert("Gender Is Not Selected.");
    			return false;
    		}

    		if (password != confirm_password)
    		{
    			alert("Password Don't Match");
    			return false;
    		}
    	}
    </script>
@endsection
