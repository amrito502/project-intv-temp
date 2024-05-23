@extends('admin.layouts.master')

@section('content')
    <div style="padding-bottom: 10px;"></div>

    <form class="form-horizontal" id="search" action="{{ route($searchFormLink) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card">
            <div class="card-header">
                <input type="hidden" name="print" value="print">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-10 form-group">
                        <label for="date">Date</label>
                        <input  type="text" class="form-control datepicker" id="{{ $print == 'print' ? '' : 'to_date' }}" name="date" value="{{ date('d-m-Y',strtotime($date)) }}" placeholder="Select Date From">
                    </div>

                    <div class="col-md-2">
                        <label for=""></label>
                        <div class="form-group">
                            <button type="submit" id="search" name="searchButton" class="btn btn-outline-info btn-md waves-effect" style="width: 100%;"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"><h4 class="card-title">Searched Report</h4></div>
                <div class="col-md-6 text-right">
                    <form class="form-horizontal" id="print" action="{{ route($printFormLink) }}" target="_blank" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="date" value="{{ $date }}">

                        <input type="hidden" id="print_value" name="print" value="{{ $print }}">
                        <button type="submit" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-print"></i> Print</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table id="dataTable" name="productList" class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th width="20px">Sl</th>
                        <th>General Ledger Head</th>
                        <th width="80px">Debit</th>
                        <th width="80px">Credit</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $sl = 1;
                        $totalDebit = 0;
                        $totalCredit = 0;
                    @endphp
                    @foreach ($coaLists as $coaList)
                        @php
                            $amount = DB::table('tbl_account_transactions')
                                ->select(DB::raw('(SUM(debit_amount) - SUM(credit_amount)) as amount'))
                                ->where('coa_head_code','LIKE',$coaList->head_code.'%')
                                ->where('voucher_date',$date)
                                ->where('approve',1)
                                ->first();

                            if ($amount->amount > 0)
                            {
                                $debitAmount = $amount->amount;
                            }
                            else
                            {
                                $debitAmount = 0;
                            }

                            if ($amount->amount < 0)
                            {
                                $creditAmount = abs($amount->amount);
                            }
                            else
                            {
                                $creditAmount= 0;
                            }

                            $totalDebit = $totalDebit + $debitAmount;
                            $totalCredit = $totalCredit + $creditAmount;
                        @endphp

                        @if ($debitAmount != $creditAmount)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>{{ $coaList->head_name }}</td>
                                <td align="right">{{ $debitAmount }}</td>
                                <td align="right">{{ $creditAmount }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="2" align="right"><b>Total</b></td>
                        <td align="right">{{ $totalDebit }}</td>
                        <td align="right">{{ $totalCredit }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            // var table = $('#dataTable').DataTable( {
            //     "order": [[0, "asc"]]
            // } );

            // table.on('order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();

            // $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
