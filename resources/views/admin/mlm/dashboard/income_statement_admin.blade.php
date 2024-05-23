@extends('admin.layouts.master')

@section('content')

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
                <div class="row">
                    <div class="col-md-12">
                        @php
                        $message = Session::get('msg');
                        if (isset($message))
                        {
                        echo "<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                                .$message."</strong></div>";
                        }
                        Session::forget('msg')
                        @endphp
                    </div>
                </div>

                <div class="modal-body">
                    <form class="form-horizontal" action="">

                        <div class="row">
                            <div class="col-md-12">
                                @if (count($errors) > 0)
                                <div style="display:inline-block; width: auto;" class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                                @endif
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="type">Income Type</label>
                                    <select name="type" class="form-control" id="type">
                                        <option value="">All</option>
                                        <option value="Sales Commission" @if ($data->type == 'Sales Commission')
                                            selected
                                            @endif
                                            >Sales Commission</option>

                                        <option value="TeamBonus" @if ($data->type == 'Generation')
                                            selected
                                            @endif
                                            >TeamBonus</option>

                                        {{-- <option value="Level Bonus" @if ($data->type == 'Level Bonus')
                                            selected
                                            @endif
                                            >Level Bonus</option> --}}

                                        <option value="Rank Commission" @if ($data->type == 'Rank Commission')
                                            selected
                                            @endif
                                            >Rank Commission</option>


                                        {{-- <option value="Entertainment Bonus" @if ($data->type == 'Entertainment Bonus')
                                            selected
                                            @endif
                                            >Entertainment Bonus</option> --}}


                                        <option value="Repurchase Bonus" @if ($data->type == 'Repurchase Bonus')
                                            selected
                                            @endif
                                            >Repurchase Bonus</option>


                                    </select>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="start_date">Member</label>
                                    <select name="username" class="form-control chosen-select" id="username">
                                        <option value="">All</option>
                                        @foreach ($data->users as $user)
                                        <option value="{{ $user->id }}"
                                            @if (request()->username == $user->id)
                                            selected
                                            @endif
                                            >{{ $user->name }} ({{ $user->username }})</option>
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

                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right" style="padding-bottom: 10px;">

                                <button type="submit" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-search"></i> Search
                                    </span>
                                </button>

                                <button type="submit" name="submitType" value="print" class="btn btn-outline-info btn-lg waves-effect">
                                    <span style="font-size: 16px;">
                                        <i class="fa fa-print"></i> Print
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

                        @include('admin.mlm.dashboard.income_statement_table', ['id' => 'dtb'])

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
