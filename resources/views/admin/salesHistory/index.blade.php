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
                    <form class="form-horizontal" action="{{ route('salesHistory.index') }}" method="get"
                        enctype="multipart/form-data">

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

                            <div class="col-md-3 form-group">
                                <label for="from_date">From Date</label>
                                <input type="text" class="form-control datepicker" name="from_date"
                                    value="{{ $data->dateRangeUi->start_date }}" autocomplete="off" required>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="to_date">To Date</label>
                                <input type="text" class="form-control datepicker" name="to_date"
                                    value="{{ $data->dateRangeUi->end_date }}" autocomplete="off" required>
                            </div>

                            <div class="col-md-6">
                                <label for="dealer">Dealer</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" id="dealer" name="dealer[]" multiple>
                                        @foreach ($data->dealers as $dealer)
                                        <option value="{{ $dealer->id }}" @if (request()->dealer)
                                            @if (in_array($dealer->id, request()->dealer))
                                            selected
                                            @endif
                                            @endif
                                            >
                                            {{ $dealer->name }} ({{ $dealer->username }})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select class="form-control chosen-select" id="category" name="category[]" multiple>
                                        @foreach ($data->categories as $cat)
                                        <option value="{{ $cat->id }}" @if (request()->category)
                                            @if (in_array($cat->id, request()->category))
                                            selected
                                            @endif
                                            @endif
                                            >
                                            {{ $cat->categoryName }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="product">Product</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" id="product" name="product[]" multiple>
                                        @foreach ($data->products as $pro)
                                        <option value="{{ $pro->id }}" @if (request()->product)
                                            @if (in_array($pro->id, request()->product))
                                            selected
                                            @endif
                                            @endif
                                            >{{ $pro->name }} ({{ $pro->deal_code }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right" style="padding-bottom: 10px;">

                                <button name="searched" value="details" type="submit"
                                    class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search Details
                                    </span>
                                </button>

                                <button name="searched" value="summary" type="submit"
                                    class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search Summary
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
                        <form class="form-horizontal" action="{{ route('salesHistory.print') }}" target="_blank"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{-- {{ dd(request()) }} --}}
                            <input type="hidden" name="from_date" value="{{ request()->from_date }}">
                            <input type="hidden" name="to_date" value="{{ request()->to_date }}">
                            <input type="hidden" name="dealer" value="{{ json_encode(request()->dealer) }}">
                            <input type="hidden" name="category" value="{{ json_encode(request()->category) }}">
                            <input type="hidden" name="product" value="{{ json_encode(request()->product) }}">
                            <input type="hidden" name="searched" value="{{ request()->searched }}">
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
                echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                        .$message."</strong></div>";
                }
                Session::forget('msg');
                // echo $fromDate;
                // echo "<pre>";
                    // print_r($data);
                    // echo "</pre>";
                @endphp

                @if (request()->searched == "details")

                <div class="table-responsive">
                    <table id="dataTable" name="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="30px">Sl</th>
                                <th width="100px">Invoice Date</th>
                                <th width="110px">Invoice No</th>
                                <th width="130px">Dealer Name</th>
                                <th>Product Name</th>
                                <th class="text-right" width="100px">Qty</th>
                                <th class="text-right" width="100px">Amount</th>
                                <th class="text-right" width="100px">PP</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @php
                            $i = 1;
                            $totalQty = 0;
                            $totalAmount = 0;
                            $totalPP = 0;
                            @endphp
                            @foreach ($data->reports as $memberSale)
                            @foreach ($memberSale->items as $item)
                            @php
                            $totalQty += $item->item_quantity;
                            $totalAmount += $item->item_price;
                            $totalPP += $item->item_quantity * $item->pp;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ date('d-m-Y', strtotime($memberSale->invoice_date)) }}</td>
                                <td>{{ $memberSale->invoice_no }}</td>
                                <td>{{ $memberSale->dealer->name }}</td>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-right">{{ $item->item_quantity }}</td>
                                <td class="text-right">{{ number_format($item->item_price, 2, ".", "") }}</td>
                                <td class="text-right">{{ number_format($item->item_quantity * $item->pp, 2, ".", "") }}
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="5">Total</th>
                                <th class="text-right">{{ $totalQty }}</th>
                                <th class="text-right">{{ number_format($totalAmount, 2, ".", "") }}</th>
                                <th class="text-right">{{ number_format($totalPP, 2, ".", "") }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                @endif


                @if (request()->searched == "summary")

                <div class="table-responsive">
                    <table id="dataTable" name="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="30px">Sl</th>
                                <th>Category</th>
                                <th>Product</th>
                                <th class="text-right" width="200px">Qty</th>
                                <th class="text-right" width="200px">Amount</th>
                                <th class="text-right" width="200px">PP</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @php
                            $totalQty = 0;
                            $totalAmount = 0;
                            $totalPP = 0;
                            @endphp
                            @foreach ($data->reports as $key => $itemGroup)

                            @php
                            $lineTotalAmount = 0;
                            $lineTotaltotalPP = 0;
                            $lineTotalQty = 0;

                            foreach ($itemGroup as $item) {

                            // if ($key == 181) {
                            // dd($itemGroup);
                            // }

                            $lineTotalAmount += $item->item_price;
                            $lineTotaltotalPP += $item->item_quantity * $item->pp;
                            $lineTotalQty += $item->item_quantity;
                            }

                            @endphp

                            @php
                            $totalQty += $lineTotalQty;
                            $totalAmount += $lineTotalAmount;
                            $totalPP += $lineTotaltotalPP;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $itemGroup->first()->product->category->categoryName }}</td>
                                <td>{{ $itemGroup->first()->product->name }} ({{ $itemGroup->first()->product->deal_code
                                    }})</td>
                                <td class="text-right">{{ $lineTotalQty }}</td>
                                <td class="text-right">{{ number_format($lineTotalAmount, 2, ".", "") }}
                                </td>
                                <td class="text-right">{{ number_format($totalPP, 2, ".", "") }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th class="text-right">{{ $totalQty }}</th>
                                <th class="text-right">{{ round((float)$totalAmount, 2) }}</th>
                                <th class="text-right">{{ round((float)$totalPP, 2) }}</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>

                @endif


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
