@extends('admin.layouts.master')

@section('custom-css')
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
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route('cashSale.add')}}">
                                <i class="fa fa-plus-circle"></i> Add new
                            </a>
                        </span>
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
                Session::forget('msg')
                @endphp

                <div class="table-responsive">
                    <table id="dataTable" name="dataTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Dealer</th>
                                <th class="text-center">Invoice No</th>
                                <th class="text-center">Invoice Date</th>
                                <th>Items</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">DP Amount</th>
                                <th class="text-right">Dealer Price</th>
                                <th class="text-right">Dealer Commission</th>
                                <th class="text-right">Point</th>
                                <th>Payment Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @php $sl = 0; @endphp

                            @foreach ($cashSales as $cashSale)
                            @php $sl++; @endphp
                            <tr class="text-right">
                                <td class="text-center">{{ $sl }}</td>
                                <td class="text-left">{{ @$cashSale->dealer->username }}</td>
                                <td class="text-center">{{ $cashSale->invoice_no }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($cashSale->invoice_date)) }}</td>
                                <td class="text-left">
                                    <ul>
                                        @foreach ($cashSale->items as $item)
                                        <li>{{ $item->product->name }} - {{ $item->item_quantity }}Pcs - {{
                                            $item->item_price }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $cashSale->totalQuantity() }}</td>
                                <td>{{ number_format($cashSale->invoice_amount, 2, ".", "") }}</td>
                                <td>{{ number_format($cashSale->net_amount, 2, ".", "") }}</td>
                                <td>{{ number_format($cashSale->invoice_amount - $cashSale->net_amount, 2, ".", "") }}</td>
                                <td class="text-right">{{ number_format($cashSale->invoiceTotalPP(), 2, ".", "") }}</td>
                                <td class="text-left">{{ $cashSale->payment_type }}</td>
                                <td class="text-center">
                                    @php
                                    echo \App\Link::action($cashSale->id)
                                    @endphp
                                </td>
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

<script>
    $(document).ready(function() {
        var updateThis;

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        // var table = $('#dataTable').DataTable({
        //     "order": [
        //         [0, "asc"]
        //     ]
        // });

        // table.on('order.dt search.dt', function() {
        //     table.column(0, {
        //         search: 'applied'
        //         , order: 'applied'
        //     }).nodes().each(function(cell, i) {
        //         cell.innerHTML = i + 1;
        //     });
        // }).draw();

        //ajax

        //ajax delete code
        $('#dataTable tbody').on('click', 'i.fa-trash', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            cashSaleId = $(this).parent().data('id');
            var tableRow = this;
            swal({
                    title: "Are you sure?"
                    , text: "You will not be able to recover this imaginary file!"
                    , type: "warning"
                    , showCancelButton: true
                    , confirmButtonColor: "#DD6B55"
                    , confirmButtonText: "Yes, delete it!"
                    , cancelButtonText: "No, cancel plx!"
                    , closeOnConfirm: false
                    , closeOnCancel: false
                }
                , function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST"
                            , url: "{{ route('cashSale.destroy') }}"
                            , data: {
                                cashSaleId: cashSaleId
                            },

                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>"
                                    , type: "success"
                                    , text: "Cash Sale Deleted Successfully!"
                                    , timer: 1000
                                    , html: true
                                , });
                                table
                                    .row($(tableRow).parents('tr'))
                                    .remove()
                                    .draw();
                            }
                            , error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>"
                                    , type: "error"
                                    , text: error
                                    , timer: 1000
                                    , html: true
                                , });
                            }
                        });
                    } else {
                        swal({
                            title: "Cancelled"
                            , type: "error"
                            , text: "Your Cash Sale is safe :)"
                            , timer: 1000
                            , html: true
                        , });
                    }
                });
        });

    });

</script>
@endsection
