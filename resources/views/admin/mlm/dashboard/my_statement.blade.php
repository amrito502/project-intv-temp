@extends('admin.layouts.master')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="row">
    <div class="col-md-12 form-group">
        <div class="card" style="margin-bottom: 0px;">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">My Statement</h4>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <form id="form-id" action="{{ route('my.statement') }}" method="get">

                            <input type="hidden" name="search" value="1">

                            <div class="row mt-5">
                                @php
                                $role = auth()->user()->role;
                                $colClass='col-md-6';
                                if(in_array($role, [1, 2, 6, 7])){
                                $colClass='col-md-4';
                                }
                                @endphp

                                @if (in_array($role, [1, 2, 6, 7]))
                                <div class="{{ $colClass }}">
                                    <div class="form-group">
                                        <label for="member">Member</label>
                                        <select name="member" class="chosen-select" id="member">
                                            @foreach ($data->users as $user)
                                            <option value="{{ $user->id }}" @if (request()->member && request()->member
                                                == $user->id)
                                                selected
                                                @endif
                                                >{{ $user->name }} ({{ $user->username }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @else
                                <input type="hidden" name="member" value="{{ auth()->user()->id }}">
                                @endif


                                <div class="{{ $colClass }}">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input class="form-control datepicker" name="start_date" id="start_date"
                                            type="text" value="{{ $data->start_date_ui }}" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="{{ $colClass }}">
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
                        <h4 class="card-title">My Statement</h4>
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

                <div class="row mt-5 justify-content-center">
                    <div class="col-md-12" style="overflow-y: auto;">

                        @include('admin.mlm.dashboard.my_statement_table')

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
