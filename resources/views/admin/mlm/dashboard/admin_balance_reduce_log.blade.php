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
                    <h3 class="text-center">Admin Balance Reduce List</h3>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <form action="">

                        <div class="row">

                            {{--  <div class="col-md-3">
                                <div class="form-group">
                                    <label for="start_date">Username</label>
                                    <select name="username" class="form-control select2" id="username">
                                        <option value="">All</option>
                                        @foreach ($data->users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                            </select>
                        </div>
                </div> --}}

                {{--  <div class="col-md-2">
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
        </div> --}}

        {{--  <div class="col-md-2 text-right">
                                <button type="submit" class="btn btn-block btn-primary" style="margin-top: 29px;"><i
                                        class="fa fa-search" aria-hidden="true"></i>Search</button>
                            </div>  --}}

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
                                <th>Reduced From</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($data->logs as $log)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $log->from->username }}</td>
                                <td>{{ $log->amount }}</td>
                                <td>{{ $log->created_at->format('d-m-Y') }}</td>
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
