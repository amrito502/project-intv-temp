@extends('admin.layouts.master')

@section('custom-css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@php
   use App\CashPurchaseItem;
   use App\CreditPurchaseItem;
   use App\PurchaseOrderItem;
   use App\Product;
   use App\Vendors;
   $supplierList = Vendors::all();
@endphp

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    @php
        $purchaseParam = array('cash' => 'Cash Purchase', 'credit' => 'Credit Purchase', 'purchase_order' => 'Purchase Order');
    @endphp

    <style type="text/css">
        .itemTable{
            margin-left: -19px;
            margin-top: -20px;
            width: 106%;
        }
        .itemTable td{
            border:none;
        }
        .center{
            text-align: center !important;
        }
        .printParam{
            background: no-repeat;
            color: #4653e9;
            font-size: 17px;
            margin-top: -11px;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @php
                        $message = Session::get('msg');
                        if (isset($message))
                        {
                            echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                        }
                        Session::forget('msg');
                    @endphp

                    <form class="form-horizontal" action="{{ route('purchaseLog.index') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-2">
                                <select name="purchaseSearch[]" class="chosen-select" multiple>
                                    <option value=" ">Select One</option>

                                    @foreach ($purchaseParam as $key => $value)
                                        @if ($purchaseSearch)
                                            @if (in_array($key, $purchaseSearch))
                                                @php $selected = 'selected'; @endphp

                                            @else
                                                @php $selected = ''; @endphp

                                            @endif
                                        @endif
                                        <option {{@$selected}} value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="supplier[]" class="chosen-select" value="ff" multiple>
                                    <option value=" ">Select One</option>

                                    @foreach ($supplierList as $vendor)
                                        @if ($supplierSearch)
                                            @if (in_array($vendor->id, @$supplierSearch))
                                                @php $selected = 'selected'; @endphp
                                            @else
                                                @php $selected = ''; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" class="btn btn-info waves-effect">Search</button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <h4 class="card-title">{{$title}}</h4>

                    @php
                        if(@$purchaseSearch)
                        {
                            $purchaseParam = implode(',', @$purchaseSearch);
                        }
                        else
                        {
                            $purchaseParam = '';
                        }

                        if(@$supplierSearch)
                        {
                            $supplierParam = implode(',', @$supplierSearch);
                        }
                        else
                        {
                            $supplierParam = '';
                        }
                    @endphp

                    <form action="{{route('purchaseLog.print')}}" target="_blank" method="get" enctype="multipart/form-data">
                        <input type="hidden" name="purchaseParam" value="{{@$purchaseParam}}">
                        <input type="hidden" name="supplierParam" value="{{@$supplierParam}}">
                        <button type="submit" class="btn btn-default printParam"><i class="fa fa-print">Print</i></button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Purchase Date</th>
                                    <th>Supplier Name</th>
                                    <th>Item</th>
                                    <th class="center">QTY</th>
                                    <th class="center">Price</th>
                                    <th class="center">Total Price</th>
                                    <th>Purchase Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                @if ($purchaseLog)
                                    @php $i = 0; @endphp

                                    @foreach ($purchaseLog as $log)
                                        @php
                                            $i++;
                                            $purchase_date = Date('d-m-Y',strtotime($log->purchase_date));
                                            $supplier = Vendors::where('id',$log->supplier_id)->first();
                                            if($log->purchase_type == 'cash')
                                            {
                                                $ItemDetails = CashPurchaseItem::where('cash_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                            }

                                            if($log->purchase_type == 'credit')
                                            {
                                                $ItemDetails = CreditPurchaseItem::where('credit_puchase_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                            }

                                            if($log->purchase_type == 'purchase_order')
                                            {
                                                $ItemDetails = PurchaseOrderItem::where('purchase_order_id',$log->purchase_id)->orderBy('id','ASC')->get();
                                            }
                                        @endphp
                                            @php
                                                $row = 0;
                                                $rowSpan = count($ItemDetails);
                                            @endphp
                                            @foreach ($ItemDetails as $item)
                                                @php
                                                    $products = Product::where('id',$item->product_id)->first();
                                                    $row++;
                                                @endphp

                                                @if ($row == 1)
                                                    <tr>
                                                        <td rowspan="{{ $rowSpan }}">{{ $i }}</td>
                                                        <td rowspan="{{ $rowSpan }}">{{ $purchase_date }}</td>
                                                        <td rowspan="{{ $rowSpan }}">{{ @$supplier->vendorName }}</td>
                                                        <td>{{$products->name}}</td>
                                                        <td style="text-align: right;">{{$item->qty}}</td>
                                                        <td style="text-align: right;">{{$item->rate}}</td>
                                                        <td style="text-align: right;">{{$item->amount}}</td>
                                                        <td rowspan="{{ $rowSpan }}" class="center">{{$log->purchase_type}}</td>
                                                        <td rowspan="{{ $rowSpan }}" class="text-nowrap center">
                                                            @php
                                                                echo \App\Link::action($log->purchase_id);
                                                            @endphp
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{$products->name}}</td>
                                                        <td style="text-align: right;">{{$item->qty}}</td>
                                                        <td style="text-align: right;">{{$item->rate}}</td>
                                                        <td style="text-align: right;">{{$item->amount}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                    @endforeach
                                @endif
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
    <script>
        $(document).ready(function() {
            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#dataTable').DataTable( {
                "order": [[ 0, "asc" ]],
                'autoWidth': false
            } );

            //ajax

            //ajax delete code
            $('#dataTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                purchaseReturnId = $(this).parent().data('id');
                var tableRow = this;
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this imaginary file!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                       $.ajax({
                            type: "POST",
                           url : "{{ route('purchaseReturn.destroy') }}",
                            data : {purchaseReturnId:purchaseReturnId},

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Purchase Order Receive Deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(tableRow).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>",
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });
                    } else {
                        swal({
                            title: "Cancelled",
                            type: "error",
                            text: "Your vendor is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });

        //ajax status change code
        function statusChange(vendor_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('vendor.status', 0) }}",
                    data: "vendor_id=" + vendor_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });
                    }
                });
            }

            function summernote(){
                $('.summernote').summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false // set focus to editable area after initializing summernote
                });
            }
    </script>
@endsection
