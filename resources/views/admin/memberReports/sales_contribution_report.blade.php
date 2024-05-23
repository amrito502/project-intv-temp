@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 50px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            {{-- <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a> --}}
                    </div>
                </div>
            </div>

            <form class="form-horizontal" id="form-id" action="{{ route('salesCont') }}" method="get"
                enctype="multipart/form-data">

                <input type="hidden" id="searched" name="searched" value="1">

                <div class="card-body">


                    <div class="modal-body">

                        <div class="row mt-3">

                            <div class="col-md-1 offset-md-2">

                                <div class="form-check mt-2" style="margin-bottom: 40px;">
                                    <input class="form-check-input" type="radio" name="type" id="dealerWise"
                                        value="dealerWise">
                                    <label class="form-check-label" for="dealerWise">
                                        Dealer
                                    </label>
                                </div>

                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="radio" name="type" id="categoryWise"
                                        value="categoryWise">
                                    <label class="form-check-label" for="categoryWise">
                                        Category
                                    </label>
                                </div>

                                <div class="form-check mb-5">
                                    <input class="form-check-input" type="radio" name="type" id="productWise"
                                        value="productWise">
                                    <label class="form-check-label" for="productWise">
                                        Product
                                    </label>
                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="form-group mb-4">
                                    {{-- <label for="">Dealer</label> --}}
                                    <select name="dealer" class="chosen-select" id="dealer">
                                        <option value="">Select Dealer</option>
                                        @foreach ($data->dealers as $dealer)
                                        <option value="{{ $dealer->id }}">{{ $dealer->name }} ({{ $dealer->username }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    {{-- <label for="">Category</label> --}}
                                    <select name="category" class="chosen-select" id="category">
                                        <option value="">Select Category</option>
                                        @foreach ($data->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="form-group mb-4">
                                    <select name="product" class="chosen-select" id="product">
                                        <option value="">Select Product</option>
                                        @foreach ($data->products as $products)
                                        <option value="{{ $products->id }}">{{ $products->name }} ({{
                                            $products->deal_code }})</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                            </div>

                            <div class="col-md-4 offset-md-1">

                                <div class="form-group row">
                                    <div class="col-md-3 mt-2">
                                        <label>Start Date</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control datepicker" name="start_date"
                                            value="{{ $data->dateRangeUi->start_date }}" placeholder="Select Date"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-3 mt-2">
                                        <label>End Date</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control datepicker" name="end_date"
                                            value="{{ $data->dateRangeUi->end_date }}" placeholder="Select Date"
                                            required>
                                    </div>
                                </div>

                                <div class="text-right w-75">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                        <span style="font-size: 16px;">
                                            <i class="fa fa-search"></i> Search
                                        </span>
                                    </button>
                                </div>

                            </div>

                        </div>

                        {{-- <div class="row">
                            <div class="col-md-12 text-right">
                                <br>
                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search
                                    </span>
                                </button>
                            </div>
                        </div> --}}

                    </div>

                </div>
            </form>


        </div>
    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Report</h4>
                    </div>
                    <div class="col-md-6 text-right">

                        <a href="{{ route('salesCont') }}?{{ http_build_query (request()->query()) }}&submitType=print" type="button"
                            class="btn btn-outline-info btn-lg waves-effect">
                            <span style="font-size: 16px;">
                                <i class="fa fa-print"></i> Print
                            </span>
                        </a>

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="table-responsive">
                                @include('admin.memberReports.tables.sales_contribution_table')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('custom-js')

<script>

    $(document).ready(function () {
        $('input[name="type"]').click(function (e) {

            let type = $(this).val();

            if(type == "productWise"){
                $('#category').attr('required', true);
                console.log(type, $('#category'));
            }else{
                $('#category').attr('required', false);
            }

        });
    });

</script>

<script>
    // function printThisPage(){

    //     let input = `<input type="hidden" name="submitType" value="print">`;

    //     $('#form-id').append(input);

    //     $('#form-id').submit();

    // }
</script>

@endsection
