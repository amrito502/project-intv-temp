@extends('admin.layouts.master')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="row">
    <div class="col-md-12 form-group">
        <div class="card" style="margin-bottom: 0px;">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">My Income</h4>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12" style="overflow-y: auto;">

                        <form id="form-id" action="{{ route('statement.income') }}" method="get" id="filterStatement">

                            <div class="row mt-5">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" class="form-control" id="type">
                                            <option value="">All</option>

                                            <option value="SalesBonus" @if ($data->type == 'SalesBonus')
                                                selected
                                                @endif
                                                >Sales Commission</option>

                                            <option value="TeamBonus" @if ($data->type == 'TeamBonus')
                                                selected
                                                @endif
                                                >Generation</option>

                                            {{-- <option value="Level Bonus" @if ($data->type == 'Level Bonus')
                                                selected
                                                @endif
                                                >Level Bonus</option> --}}

                                            <option value="RankBonus" @if ($data->type == 'RankBonus')
                                                selected
                                                @endif
                                                >Rank Commission</option>


                                            <option value="Entertainment" @if ($data->type == 'Entertainment')
                                                selected
                                                @endif
                                                >Entertainment Bonus</option>


                                            <option value="RePurchaseBonus" @if ($data->type == 'RePurchaseBonus')
                                                selected
                                                @endif
                                                >Repurchase Bonus</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input class="form-control datepicker" name="start_date" id="start_date"
                                            type="text" value="{{ $data->start_date_ui }}" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input class="form-control datepicker" name="end_date" id="end_date" type="text"
                                            value="{{ $data->end_date_ui }}" autocomplete="off" required>
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
</div>


<div class="row">
    <div class="col-md-12 form-group">
        <div class="card" style="margin-bottom: 0px;">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">My Income</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button onclick="printThisPage()" type="button"
                            class="btn btn-outline-info btn-lg waves-effect">
                            <span style="font-size: 16px;">
                                <i class="fa fa-print"></i> Print
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12" style="overflow-y: auto;">

                        <table class="table table-hover table-bordered" id="dtb">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th class="text-right">Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                $totalAmount = 0;
                                @endphp
                                @foreach ($data->statements as $statement)
                                @php
                                $totalAmount += $statement->amount;
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ date('d-m-Y', strtotime($statement->created_at)) }}</td>
                                    <td class="text-right">{{ $statement->amount }}</td>
                                    <td>{{ $statement->remarks }}</td>
                                </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-right">Total</th>
                                    <th class="text-right">{{ $totalAmount }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

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
