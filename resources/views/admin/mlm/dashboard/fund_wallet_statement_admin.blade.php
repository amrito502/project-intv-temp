@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{--  <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>  --}}
                    <h3 class="text-center">Fund Statement</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <form action="">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Username</label>
                                    <select name="username" class="form-control select2" id="username" required>
                                        {{--  <option value="">All</option>  --}}
                                        @foreach ($data->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control datepicker" name="start_date" id="start_date" type="text"
                                        value="{{ $data->start_date_ui }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input class="form-control datepicker" name="end_date" id="end_date" type="text"
                                        value="{{ $data->end_date_ui }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-2 text-right">
                                <button type="submit" class="btn btn-block btn-primary" style="margin-top: 29px;"><i
                                        class="fa fa-search" aria-hidden="true"></i>Search</button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12" style="overflow-y: auto;">

                    <table class="table table-hover table-bordered" id="">
                        <thead>
                            <tr>
                                <th colspan="4" align="right">Previous Balance</th>
                                <th>
                                    @if ($data->statements)

                                    {{ $data->statements[0]['previous_balance'] }}

                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <th>Remarks</th>
                                <th>Income</th>
                                <th>Expense</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $skip = false;
                            $totalIncome = 0;
                            $totalExpense = 0;
                            @endphp
                            @foreach ($data->statements as $statement)
                            @php
                            if(!$skip) { //edited for accuracy
                            $skip = true;
                            continue;
                            }

                            $totalIncome += $statement['income'];
                            $totalExpense += $statement['expense'];
                            @endphp
                            <tr>
                                <td>{{ $statement['date'] }}</td>
                                <td>{{ $statement['remarks'] }}</td>
                                <td>{{ $statement['income'] }}</td>
                                <td>{{ $statement['expense'] }}</td>
                                <td>{{ $statement['balance'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th>{{ $totalIncome }}</th>
                                <th>{{ $totalExpense }}</th>
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
