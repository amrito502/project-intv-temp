@extends('admin.layouts.master')

@section('custom_css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card" style="margin-bottom: 200px;">
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

            <div class="card-body">

                <div class="modal-body">

                    <form id="form-id" class="form-horizontal" action="{{ route('dealerInventory.report') }}" method="get"
                        enctype="multipart/form-data">

                        <input type="hidden" name="searched" value="1">

                        <div class="row">

                            @if (in_array(auth()->user()->role, [1, 2, 6, 7]))
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="label-control" for="dealer_id">Dealer</label>
                                    <select class="chosen-select" id="dealer_id" name="dealer_id">
                                        <option value="">Select Dealer</option>
                                        @foreach ($data->dealers as $user)
                                        <option value="{{ $user->id }}" @if (request()->dealer_id)
                                            {{ request()->dealer_id == $user->id ? 'selected' : '' }}
                                            @endif
                                            >
                                            {{ $user->name }} ({{ $user->username }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="dealer_id" value="{{ auth()->user()->id }}">
                            @endif

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Type</label>
                                    <select class="form-control" name="type" id="type">
                                        <option value="all" @if (request()->type == 'all')
                                            selected
                                            @endif
                                            >All</option>
                                        <option value="in_stock" @if (!request()->type)
                                            selected
                                            @endif

                                            @if (request()->type == 'in_stock')
                                            selected
                                            @endif
                                            >In Stock</option>
                                        <option value="out_of_stock" @if (request()->type == 'out_of_stock')
                                            selected
                                            @endif
                                            >Out of Stock</option>
                                    </select>
                                </div>

                            </div>

                            @php
                            $productColumn = "col-md-10";

                            if(in_array(auth()->user()->role, [1, 2, 6, 7])){
                            $productColumn = "col-md-6";
                            }
                            @endphp

                            <div class="{{ $productColumn }}">
                                <div class="form-group">
                                    <label for="">Products</label>
                                    <select class="chosen-select" name="products[]" id="products" multiple>
                                        @foreach ($data->products as $product)
                                        <option value="{{ $product->id }}" @if (request()->products)
                                            @if (in_array($product->id, request()->products)) selected @endif
                                            @endif
                                            >
                                            {{ $product->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <br>
                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search
                                    </span>
                                </button>

                            </div>
                        </div>

                    </form>

                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-right">
                        <button onclick="printThisPage()" type="button"
                            class="btn btn-outline-info btn-lg waves-effect">
                            <span style="font-size: 16px;">
                                <i class="fa fa-print"></i> Print
                            </span>
                        </button>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            @include('admin.dealerReports.tables.dealer_stock_table')
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
    function printThisPage(){

        let input = `<input type="hidden" name="submitType" value="print">`;

        $('#form-id').append(input);


        $('#form-id').submit();

    }
</script>

@endsection
