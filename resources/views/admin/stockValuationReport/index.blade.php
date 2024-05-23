@extends('admin.layouts.master')

@section('custom-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

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
                        <form class="form-horizontal" action="{{ route('stockValuationReport.index') }}" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group">
                                    	<label for="category">Category</label>
                                        <select class="form-control chosen-select" id="category" name="category[]" multiple>
                                            @foreach ($categories as $categoryInfo)
                                                @php
                                                    $select = "";
                                                    if ($category)
                                                    {
                                                        if (in_array($categoryInfo->id, $category))
                                                        {
                                                            $select = "selected";
                                                        }
                                                        else
                                                        {
                                                            $select = "";
                                                        }
                                                    }
                                                @endphp
                                                <option value="{{ $categoryInfo->id }}" {{ $select }}>{{ $categoryInfo->categoryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            	</div>
                            	<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product">product</label>
                                        <div id="prodct-select-menu">
                                            <select class="form-control chosen-select" id="product" name="product[]" multiple>
                                                @foreach ($products as $productInfo)
                                                    @php
                                                        $select = "";
                                                        if ($product)
                                                        {
                                                            if (in_array($productInfo->id, $product))
                                                            {
                                                                $select = "selected";
                                                            }
                                                            else
                                                            {
                                                                $select = "";
                                                            }
                                                        }
                                                    @endphp
                                                    <option value="{{ $productInfo->id }}" {{ $select }}>{{ $productInfo->name }}</option>
                                                @endforeach
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
                            <form class="form-horizontal" action="{{ route('stockValuationReport.print') }}" target="_blank" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                @if ($category)
                                    @foreach ($category as $categoryInfo)
                                        <input type="hidden" name="category[]" value="{{ $categoryInfo }}">
                                    @endforeach
                                @endif

                                @if ($product)
                                    @foreach ($product as $productInfo)
                                        <input type="hidden" name="product[]" value="{{ $productInfo }}">
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
                                    <th width="20px">Sl</th>
                                    <th width="120px">Category</th>
                                    <th width="120px">Product Code</th>
                                    <th>Product Name</th>
                                    <th class="text-center" width="100px">Stock Qty</th>
                                    <th class="text-center" width="100px">MRP Rate</th>
                                    <th class="text-center" width="100px">DP Rate</th>
                                    <th class="text-center" width="125px">Purchase Avg</th>
                                    <th class="text-center" width="100px">MRP Value</th>
                                    <th class="text-center" width="100px">DP Value</th>
                                    <th class="text-center" width="120px">Purchase Value</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                @php
                                    // $sl = 0;
                                    $sales = 0;
                                    $purchase = 0;
                                @endphp

                                @foreach ($stockValuationReports as $stockValuationReport)
                                    @php
                                        // $sl++;
                                        // $sales = $stockValuationReport->salesPrice * $stockValuationReport->stockQty;
                                        // $purchase = $stockValuationReport->avgLifting * $stockValuationReport->stockQty;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stockValuationReport['product_category'] }}</td>
                                        <td>{{ $stockValuationReport['product_code'] }}</td>
                                        <td>{{ $stockValuationReport['product_name'] }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['stock_qty'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['sale_price_mrp'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['sale_price_dp'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['purchase_avg'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['mrp_value'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['dp_value'], 2) }}</td>
                                        <td class="text-center">{{ round($stockValuationReport['purchase_value'], 2) }}</td>
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
    <!-- This is data table -->
    {{-- <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script> --}}

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

    <script type="text/javascript">
    	$(document).on('change', '#category', function(){
    		$.ajaxSetup({
    			headers: {
    				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    			}
    		});

    		var id = $('#category').val();

    		$.ajax({
    			type:'post',
    			url:'{{ route('stockValuationReport.getAllProductByCategory') }}',
    			data:{id:id},
    			success:function(data){
    				$('#prodct-select-menu').html(data);
                    $(".chosen-select").chosen();
    			}
    		});
    	});

    </script>
@endsection
