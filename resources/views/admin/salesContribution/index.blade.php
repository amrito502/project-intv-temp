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
                    <form class="form-horizontal" action="{{ route('salesContribution.index') }}" method="get"
                        enctype="multipart/form-data">

                        <input type="hidden" name="searched" value="1">

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
                            <div class="col-md-3" style="margin-top: 29px;">
                                <div class="form-group">

                                    <div class="form-check-inline mr-5">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="Categories"
                                                name="option" {{ request()->option == 'Categories' ? 'checked' : '' }}>
                                            CATEGORIES
                                        </label>
                                    </div>

                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" value="Products" name="option"
                                                {{ request()->option == 'Products' ? 'checked' : '' }}>
                                            PRODUCTS
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">

                                    <div class="row">
                                        <div class="col-md-2" style="margin-top: 29px;">
                                            <label for="">Dealer</label>
                                        </div>
                                        <div class="col-md-10" style="margin-top: 20px;">
                                            <select name="dealer" id="dealer" class="chosen-select">
                                                <option value="">Select Dealer</option>
                                                @foreach ($data->dealers as $dealer)
                                                <option value="{{ $dealer->id }}" @if (request()->dealer)
                                                    @if (request()->dealer == $dealer->id)
                                                    selected
                                                    @endif
                                                    @endif
                                                    >{{ $dealer->name }} ({{ $dealer->username }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-4 text-right" style="margin-top: 25px;">
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
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <form class="form-horizontal" action="{{ route('salesContribution.print') }}" target="_blank"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="option" value="{{ request()->option }}">
                            <input type="hidden" name="dealer" value="{{ request()->dealer }}">

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

                <div class="table-responsive">
                    <table id="dataTable" name="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="20px">Sl</th>
                                @if (request()->option == 'Categories')
                                <th>Category Name</th>
                                @endif

                                @if (request()->option == 'Products')
                                <th>Products Name</th>
                                @endif

                                @if (request()->option == '' && request()->option == '')
                                <th>Name</th>
                                @endif
                                <th width="100px">Sale Qty</th>
                                <th width="100px">% By Qty</th>
                                <th width="110px">Sale Amount</th>
                                <th width="105px">% By Amount</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @php
                            $totalSaleQty = 0;
                            $totalSaleAmount = 0;
                            @endphp
                            @foreach ($data->reports as $report)
                            @php
                            $totalSaleQty += $report['qty'];
                            $totalSaleAmount += $report['amount'];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $report['name'] }}</td>
                                <td>{{ $report['qty'] }}</td>
                                <td>{{ $report['percentage_qty'] }}</td>
                                <td>{{ $report['amount'] }}</td>
                                <td>{{ $report['percentage_amount'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-right">Total</th>
                                <th>{{ $totalSaleQty }}</th>
                                <th></th>
                                <th>{{ $totalSaleAmount }}</th>
                                <th></th>
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
