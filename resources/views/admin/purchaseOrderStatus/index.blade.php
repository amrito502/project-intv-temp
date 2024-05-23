@php
use App\PurchaseOrder;
@endphp

@extends('admin.layouts.master')

@section('content')
    <style type="text/css">
        #dataTable th {
            background: #00c292;
            font-weight: bold;
            padding: 5px;
            font-size: 13px;
        }

    </style>
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
                                if (isset($message)) {
                                    echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" . $message . '</strong></div>';
                                }
                                Session::forget('msg');
                            @endphp
                        </div>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" action="{{ route('purchaseOrderStatus.index') }}" method="post"
                            enctype="multipart/form-data">
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
                                                    $select = '';
                                                    if ($supplier) {
                                                        if (in_array($vendor->id, $supplier)) {
                                                            $select = 'selected';
                                                        } else {
                                                            $select = '';
                                                        }
                                                    }
                                                @endphp
                                                <option value="{{ $vendor->id }}" {{ $select }}>
                                                    {{ $vendor->vendorName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="from_date">From Date</label>
                                            <input type="text" class="form-control datepicker"
                                                {{ $fromDate == '1970-01-01' ? 'id=from_date' : 'value=' . date('d-m-Y', strtotime($fromDate)) }}
                                                name="from_date" placeholder="Select Date From">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="to_date">To Date</label>
                                            <input type="text" class="form-control datepicker"
                                                {{ $toDate == '1970-01-01' ? 'id=to_date' : 'value=' . date('d-m-Y', strtotime($toDate)) }}
                                                name="to_date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right" style="padding-bottom: 10px;">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                        <span style="font-size: 16px;">
                                            <i class="fa fa-save"></i> Search
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
                            <form class="form-horizontal" action="{{ route('purchaseOrderStatus.print') }}"
                                target="_blank" method="post" enctype="multipart/form-data">
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
                                        <i class="fa fa-save"></i> Print Data
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @php
                        $message = Session::get('msg');
                        if (isset($message)) {
                            echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" . $message . '</strong></div>';
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
                                    <th width="25px">Sl</th>
                                    <th width="80px">PO No</th>
                                    <th>Product Name</th>
                                    <th width="100px">Order Qty</th>
                                    <th width="100px">Receive Qty</th>
                                    <th width="110px">Remaining Qty</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                @php
                                    $sl = 0;
                                    $row = 0;
                                    $remainingQty = 0;
                                    $currentOrderNo = 0;
                                @endphp

                                @foreach ($poStatus as $pos)
                                    @php
                                        $sl++;
                                        $remainingQty = $pos->orderQty - $pos->receiveQty;
                                        if ($currentOrderNo == $pos->orderNo) {
                                            $row++;
                                        } else {
                                            $currentOrderNo = $pos->orderNo;
                                            $rowSpan = DB::table('purchase_order_status')
                                                ->where('supplierId', $pos->supplierId)
                                                ->where('orderNo', $pos->orderNo)
                                                ->where('orderQty', '>', 0)
                                                ->distinct('productId')
                                                ->count('productId');
                                            $row = 1;
                                        }

                                        $purchaseOrder = PurchaseOrder::with(['poRecieve.items'])
                                            ->where('order_no', $pos->orderNo)
                                            ->first();

                                        $receiveQty = $purchaseOrder->poRecieve->sum(function ($items) use($pos) {
                                            return $items->items->where('product_id', $pos->productId)->sum('qty');
                                        });

                                    @endphp
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        @if ($row == 1)
                                            <td rowspan="{{ $rowSpan }}">{{ $pos->orderNo }}</td>
                                            <td>{{ $pos->productName }}</td>
                                            <td style="text-align: right;">{{ $pos->orderQty }}</td>
                                            <td style="text-align: right;">
                                                {{ $receiveQty }}
                                            </td>
                                            <td style="text-align: right;">{{ $remainingQty }}</td>
                                        @else
                                            <td>{{ $pos->productName }}</td>
                                            <td style="text-align: right;">{{ $pos->orderQty }}</td>
                                            <td style="text-align: right;">
                                                {{ $receiveQty }}
                                            </td>
                                            <td style="text-align: right;">{{ $remainingQty }}</td>
                                        @endif
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
    <script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var updateThis;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#dataTable').DataTable({
                "order": [
                    [0, "asc"]
                ]
            });

            var table = $('#dataTable').DataTable({
                'rowsGroup': [0]
                'rowsGroup': [1]
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

    </script>
@endsection
