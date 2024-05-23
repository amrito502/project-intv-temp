@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                    <h3 class="text-center">Admin Income Statement</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <form action="">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <select name="type" class="form-control" id="type"
                                        onchange="$('#filterStatement').submit()">
                                        <option value="">All</option>
                                        <option value="Withdraw" @if ($data->type == 'Withdraw')
                                            selected
                                            @endif
                                            >Withdraw</option>
                                        <option value="Transfer" @if ($data->type == 'Transfer')
                                            selected
                                            @endif
                                            >Transfer</option>
                                        <option value="Account Purchase" @if ($data->type == 'Account Purchase')
                                            selected
                                            @endif
                                            >Account Purchase</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Username</label>
                                    <select name="username" class="form-control select2" id="username">
                                        <option value="">All</option>
                                        @foreach ($data->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input class="form-control datepicker" name="start_date" id="start_date" type="text"
                                        value="{{ $data->start_date_ui }}" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-2">
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

                    <table class="table table-hover table-bordered" id="dtb">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Income By</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1;
                            $totalAmount = 0;
                            @endphp
                            @foreach ($data->statements as $statement)
                            @php
                            $amount = $statement->charge;

                            if($statement->remarks == 'Account Purchase'){

                            $amount = $statement->amount;
                            }

                            $totalAmount += $amount;
                            @endphp
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $statement->from->username }}</td>
                                <td>{{ date('d-m-Y', strtotime($statement->created_at)) }}</td>
                                <td>{{ $amount }}</td>
                                <td>{{ $statement->remarks }}</td>
                                <td>
                                    {{ $statement->status == 1 ? 'Completed' : 'Processing' }}</td>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>{{ $totalAmount }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
