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
                                href="{{ route('dealerMemberSale.add')}}">
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
                                {{-- <th>Customer</th> --}}
                                <th>Requisition No</th>
                                <th>Requisition Date</th>
                                <th>Requisition Amount</th>
                                <th>Product Point</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="tbody">
                            @php $sl = 0; @endphp

                            @foreach ($memberSales as $memberSale)
                            @php $sl++; @endphp
                            <tr class="text-right">
                                <td class="text-center">{{ $sl }}</td>
                                {{-- <td class="text-left">{{ @$memberSale->customer->name }}</td> --}}
                                <td class="text-center">{{ $memberSale->invoice_no }}</td>
                                <td class="text-center">{{ date('d-m-Y', strtotime($memberSale->invoice_date)) }}</td>
                                <td>{{ $memberSale->invoice_amount }}</td>
                                <td>{{ $memberSale->invoiceTotalPP() }}</td>
                                <td>
                                    {{ $memberSale->status ? "Approved" : "Pending" }}
                                </td>
                                <td class="text-center">
                                    @php

                                    $status = in_array(auth()->user()->role, [1, 2, 6, 7]) ? true : false;

                                    if ($status && $memberSale->status == 0) {
                                    echo "<a href='" . route('memberSale.approve', $memberSale->id) . "' class='btn
                                        btn-success btn-block'>Approve</a>";
                                    }

                                    echo \App\Link::action($memberSale->id)
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

            memberSaleId = $(this).parent().data('id');
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
                            , url: "{{ route('memberSale.destroy') }}"
                            , data: {
                                memberSaleId: memberSaleId
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