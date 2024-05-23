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
                        <form class="form-horizontal" action="{{ route('outOfStockReport.index') }}" method="post" enctype="multipart/form-data">
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
                                                <option value="{{ $categoryInfo->id }}"
                                                    @if (in_array($categoryInfo->id, $category))
                                                        selected
                                                    @endif
                                                    >{{ $categoryInfo->categoryName }}</option>
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
                                                    <option value="{{ $productInfo->id }}">{{ $productInfo->name }}</option>
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

                                    <button type="submit" name="submitType" value="print" class="btn btn-outline-info btn-lg waves-effect">
                                        <span style="font-size: 16px;">
                                            <i class="fa fa-print"></i> Print
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
                        @include('admin.outOfStockReport.table.out_of_stock_table', ['id' => 'dtb2'])
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

            var table = $('#dtb2').DataTable( {
                // "order": [[ 0, "asc" ]]
                "ordering": false
            } );

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
    			url:'{{ route('outOfStockReport.getAllProductByCategory') }}',
    			data:{id:id},
    			success:function(data){
    				$('#prodct-select-menu').html(data);
                    $(".chosen-select").chosen();
    			}
    		});
    	});

    </script>
@endsection
