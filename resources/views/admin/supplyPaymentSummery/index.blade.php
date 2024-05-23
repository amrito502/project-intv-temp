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
                        <form class="form-horizontal" action="{{ route('supplyPaymentSummery.index') }}" method="post" enctype="multipart/form-data">
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
                                    <label for="supplier">Supplier</label>
                                    <div class="form-group">
                                        <select class="form-control chosen-select" id="supplier" name="supplier[]" multiple>
                                            @foreach ($vendors as $vendor)
                                                @php
                                                    $select = "";
                                                    if ($supplier)
                                                    {
                                                        if (in_array($vendor->id, $supplier))
                                                        {
                                                            $select = "selected";
                                                        }
                                                        else
                                                        {
                                                            $select = "";
                                                        }
                                                    }
                                                @endphp
                                                <option value="{{ $vendor->id }}" {{ $select }}>{{ $vendor->vendorName }}</option>
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
                            <form class="form-horizontal" action="{{ route('supplyPaymentSummery.print') }}" target="_blank" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="month" value="{{ $month }}">

                                @if ($supplier)
                                    @foreach ($supplier as $supplierInfo)
                                        <input type="hidden" name="supplier[]" value="{{ $supplierInfo }}">
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
                        <table id="dataTable" name="dataTable" class="table table-bordered">
                            <thead>
                            	<tr>
                                    <th width="20px" rowspan="2">Sl</th>
                            		<th rowspan="2">Supplier Name</th>
                            		<th rowspan="2" width="120px">Previous Years</th>
                            		<th colspan="3" class="text-center">For The Years {{ $year }}</th>
                            		<th colspan="3" class="text-center">For The Month {{ date('F', mktime(0, 0, 0,$month, 10)) }}</th>
                            		<th rowspan="2" width="120px">Current Balance</th>
                            	</tr>
                                <tr>
                                	<th width="90px">Purchase</th>
                                	<th width="90px">Payments</th>
                                	<th width="90px">Balance</th>
                                	<th width="90px">Purchase</th>
                                	<th width="90px">Payments</th>
                                	<th width="90px">Balance</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                @php
                                    $sl = 0;
                                    $currentId = 0;


                                    $totalPreviousYearBalance = 0;
                                    $totalCurrentYearPurchase = 0;
                                    $totalCurrentYearPayment = 0;
                                    $totalCurrentYearBalance = 0;
                                    $totalThisMonthPurchase = 0;
                                    $totalThisMonthPayment = 0;
                                    $totalThisMonthBalance = 0;
                                @endphp

                                @foreach ($supplierStatements as $supplierStatement)
                                    @php
                                        $sl++;
                                        $yearlyPurchase = 0;
                                        $yearlyPayment = 0;
                                        $monthlyPurchase = 0;
                                        $monthlyPayment = 0;




                                    @endphp
                                    @if ($supplierStatement->vendorId != $currentId)
                                        @foreach ($supplierStatements as $value)
                                            @php
                                                if ($supplierStatement->vendorId == $value->vendorId)
                                                {
                                                    $yearlyPurchase = $yearlyPurchase + $value->yearlyPurchase;
                                                    $yearlyPayment = $yearlyPayment + $value->yearlyPayment;
                                                    $monthlyPurchase = $monthlyPurchase + $value->monthlyPurchase;
                                                    $monthlyPayment = $monthlyPayment + $value->monthlyPayment;
                                                }
                                                $currentId = $supplierStatement->vendorId;
                                            @endphp
                                        @endforeach

                                        @php
                                        $totalPreviousYearBalance += $supplierStatement->previousPayment - $supplierStatement->previousPurchase;
                                        $totalCurrentYearPurchase += $yearlyPurchase;
                                        $totalCurrentYearPayment += $yearlyPayment;
                                        $totalCurrentYearBalance += $yearlyPayment - $yearlyPurchase;
                                        $totalThisMonthPurchase += $monthlyPurchase;
                                        $totalThisMonthPayment += $monthlyPayment;
                                        $totalThisMonthBalance += $monthlyPayment - $monthlyPurchase;
                                        @endphp
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $supplierStatement->vendorName }}</td>
                                            <td style="text-align: right;">{{ $supplierStatement->previousPayment - $supplierStatement->previousPurchase }}</td>
                                            <td style="text-align: right;">{{ $yearlyPurchase }}</td>
                                            <td style="text-align: right;">{{ $yearlyPayment }}</td>
                                            <td style="text-align: right;">{{ $yearlyPayment - $yearlyPurchase }}</td>
                                            <td style="text-align: right;">{{ $monthlyPurchase }}</td>
                                            <td style="text-align: right;">{{ $monthlyPayment }}</td>
                                            <td style="text-align: right;">{{ $monthlyPayment - $monthlyPurchase }}</td>
                                            <td style="text-align: right;">{{ $supplierStatement->previousPayment - $supplierStatement->previousPurchase + $yearlyPayment - $yearlyPurchase }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align: right;">Total</th>
                                    <th style="text-align: right;">{{ $totalPreviousYearBalance }}</th>
                                    <th style="text-align: right;">{{ $totalCurrentYearPurchase }}</th>
                                    <th style="text-align: right;">{{ $totalCurrentYearPayment }}</th>
                                    <th style="text-align: right;">{{ $totalCurrentYearBalance }}</th>
                                    <th style="text-align: right;">{{ $totalThisMonthPurchase }}</th>
                                    <th style="text-align: right;">{{ $totalThisMonthPayment }}</th>
                                    <th style="text-align: right;">{{ $totalThisMonthBalance }}</th>
                                    <th style="text-align: right;">{{ $totalPreviousYearBalance + $totalCurrentYearBalance }}</th>
                                </tr>
                            </tfoot>
                        </table>
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
