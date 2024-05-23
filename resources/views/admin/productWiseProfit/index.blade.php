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
                    <form class="form-horizontal" action="{{ route('productWiseProfit.index') }}" method="get"
                        enctype="multipart/form-data">
                        {{-- {{ csrf_field() }} --}}

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

                            <div class="col-md-4">
                                <label for="category">Categories</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" id="category" name="category[]" multiple>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @if ($selectedCategory &&
                                            in_array($category->id, $selectedCategory))
                                            selected
                                            @endif
                                            >{{ $category->categoryName }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="customer">Products</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" id="product" name="product[]" multiple>
                                        @foreach ($products as $productInfo)
                                        <option value="{{ $productInfo->id }}" @if ($selectedProduct &&
                                            in_array($productInfo->id, $selectedProduct))
                                            selected
                                            @endif
                                            >{{ $productInfo->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 form-group">
                                <label for="from_date">From Date</label>
                                <input type="text" class="form-control datepicker" {{ $fromDate=='1970-01-01'
                                    ? 'id=from_date' : 'value=' .date("d-m-Y",strtotime($fromDate)) }} name="from_date"
                                    placeholder="Select Date From">
                            </div>
                            <div class="col-md-2 form-group">
                                <label for="to_date">To Date</label>
                                <input type="text" class="form-control datepicker" {{ $toDate=='1970-01-01'
                                    ? 'id=to_date' : 'value=' .date("d-m-Y",strtotime($toDate)) }} name="to_date">
                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-12 text-right" style="padding-bottom: 10px;">

                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search
                                    </span>
                                </button>

                                <button type="submit" name="submitType" value="print"
                                    class="btn btn-outline-info btn-lg waves-effect">
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
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
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

                    @include('admin.productWiseProfit.table.product_wise_profit_table', ['id' => "dataTable2"])

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

            var table = $('#dataTable2').DataTable( {
                "order": [[ 11, "desc" ]]
            } );
        });
</script>
@endsection
