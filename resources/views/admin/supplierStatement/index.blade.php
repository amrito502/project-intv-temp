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
                    <form class="form-horizontal" action="{{ route('supplierStatement.index') }}" method="post"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

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
                            <div class="col-md-6">
                                <label for="supplier">Supplier</label>
                                <div class="form-group">
                                    <select class="form-control chosen-select" id="supplier" name="supplier[]">
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
                                        <option value="{{ $vendor->id }}" {{ $select }}>{{ $vendor->vendorName }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="from_date">From Date</label>
                                        <input type="text" class="form-control datepicker" {{ $fromDate=='1970-01-01'
                                            ? 'id=from_date' : 'value=' .date("d-m-Y",strtotime($fromDate)) }}
                                            name="from_date" placeholder="Select Date From">

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="to_date">To Date</label>
                                        <input type="text" class="form-control datepicker" {{ $toDate=='1970-01-01'
                                            ? 'id=to_date' : 'value=' .date("d-m-Y",strtotime($toDate)) }}
                                            name="to_date">
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
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <form class="form-horizontal" action="{{ route('supplierStatement.print') }}" target="_blank"
                            method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="from_date" value="{{ $fromDate }}">
                            <input type="hidden" name="to_date" value="{{ $toDate }}">

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

            @if (request()->searched)
            <div class="card-body">

                <div class="table-responsive">
                    <table id="dataTable" name="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="5" style="text-align: right; font-weight: bold;">Previous Balance</th>
                                <th style="text-align: right;">{{ $previousBalance }}</th>
                            </tr>
                            <tr>
                                <th width="20px">#</th>
                                <th width="100px">Date</th>
                                <th>Description</th>
                                <th width="90px">Lifting</th>
                                <th width="90px">Payment</th>
                                <th width="90px">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @foreach ($reports as $ld)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ld['date'] }}</td>
                                <td>{{ $ld['description'] }}</td>
                                <td style="text-align: right;">{{ $ld['lifting'] }}</td>
                                <td style="text-align: right;">{{ $ld['payment'] }}</td>
                                <td style="text-align: right;">{{ $ld['balance'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @endif

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
