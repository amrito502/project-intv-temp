@extends('admin.layouts.master')

@section('custom-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
    $months = array('1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12 form-group">
            <div class="card" style="margin-bottom: 0px;">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
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
                        <form class="form-horizontal" action="{{ route('salesCollectionOutstanding.index') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="customer">Dealer</label>
                                    <div class="form-group">
                                        <select class="form-control chosen-select" id="customer" name="customer[]" multiple>
                                            @foreach ($customers as $customerInfo)
                                                @php
                                                    $select = "";
                                                    if ($customer)
                                                    {
                                                        if (in_array($customerInfo->id, $customer))
                                                        {
                                                            $select = "selected";
                                                        }
                                                        else
                                                        {
                                                            $select = "";
                                                        }
                                                    }
                                                @endphp
                                                <option value="{{ $customerInfo->id }}" {{ $select }}>{{ $customerInfo->name }} ({{ $customerInfo->username }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="month">Month</label>
	                                        <select class="form-control" id="month" name="month">
                                            	<option value="">Select Month</option>
                                            	@php
                                                    $select = "";
                                                    if ($month == "")
                                                    {
                                                        $month = date('m');
                                                    }
                                                @endphp
			                                    @foreach ($months as $key => $value)
			                                    	@php
			                                    		if ($key == $month)
			                                    		{
			                                    			$select = "selected";
			                                    		}
			                                    		else
			                                    		{
			                                    			$select = "";
			                                    		}
			                                    	@endphp
			                                        <option value="{{ $key }}" {{ $select }}>{{ $value }}</option>
			                                    @endforeach
	                                        </select>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="from_date">Year</label>
	                                        <select class="form-control" id="year" name="year">
                                            	<option value="">Select Year</option>
	                                        	@php
	                                        		$select = "";
                                                    if ($year == "")
                                                    {
                                                        $year = date('Y');
                                                    }
	                                        		$currentYear = date('Y');
	                                        	@endphp
	                                        	@for ($i = $currentYear; $i >= 1900; $i--)
	                                        		@php
	                                        			if ($i == $year)
	                                        			{
	                                        				$select = "selected";
	                                        			}
	                                        			else
	                                        			{
	                                        				$select = "";
	                                        			}
	                                        		@endphp
	                                                <option value="{{ $i }}" {{ $select }}>{{ $i }}</option>
	                                        	@endfor
	                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right" style="padding-bottom: 10px;">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
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
                        <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                        <div class="col-md-6 text-right">
                            <form class="form-horizontal" action="{{ route('salesCollectionOutstanding.print') }}" target="_blank" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="month" value="{{ $month }}">

                                @if ($customer)
                                    @foreach ($customer as $customerInfo)
                                        <input type="hidden" name="customer[]" value="{{ $customerInfo }}">
                                    @endforeach
                                @endif

                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-print"></i> Print
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
                            echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                        }
                        Session::forget('msg');
                        // echo $fromDate;
                        // echo "<pre>";
                        // print_r($data);
                        // echo "</pre>";
                    @endphp

                    <div class="table-responsive">
                        @include('admin.salesCollectionOutstanding.patrial.dealer_outstanding_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <!-- This is data table -->
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            // var table = $('#dataTable').DataTable( {
            //     "order": [[ 0, "asc" ]]
            // } );

            // table.on('order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();
        });
    </script>
@endsection
