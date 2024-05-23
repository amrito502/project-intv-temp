@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')



<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">

            <div class="row mb-4">

                <div class="col-md-4">
                    <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>

                <div class="col-md-4">
                    <h3 class="text-center">Fund History</h3>

                </div>

                <div class="col-md-4 text-right">
                    <span style="font-size: 26px" class="d-inline text-right">Fund Issue {{ $data->totalFunds }} </span> <span style="font-size: 30px">৳</span>
                </div>

            </div>

            <form action="">

                <div class="row">

                    <div class="col-md-4">
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


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12" style="overflow-y: auto;">

                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Deposit Date</th>
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Deposit Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $totalAmount = 0
                            @endphp
                            @foreach ($data->funds as $fund)
                            @php
                                $totalAmount += $fund->amount;
                            @endphp
                            <tr>
                                <td>{{ $fund->created_at->format('d-m-Y') }}</td>
                                <td>{{ $fund->from->username }}</td>
                                <td>{{ $fund->from->name }}</td>
                                <td>{{ $fund->amount }}</td>
                                <td>

                                    <button type='button' onclick='deleteRow("{{ $fund->id }}")'
                                        class='edit btn btn-danger btn-sm'><i class='fa fa-trash'
                                            aria-hidden='true'></i>Delete</button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total Fund Issue</th>
                                <th>{{ $totalAmount }}</th>
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

@section('custom-script')

<script>
    function deleteRow(id) {
        let c = confirm("Are You Sure ?");

        let url = route('fund.delete', id);

        if(c){
            axios.delete(url)
            .then(function (response) {
                window.location.reload(true);
            })
            .catch(function (error) {
            })
        }

    }
</script>

@endsection
