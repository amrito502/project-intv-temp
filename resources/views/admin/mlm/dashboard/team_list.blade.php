@extends('admin.layouts.master')

@section('custom-css')

@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="card" style="margin-bottom: 200px;">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ $data->title }}</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('team.list.details') }}" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="tree">

            <div class="table-responsive">
                <table id="dataTable1" class="table table-hover table-bordered dtb2">
                    <thead>
                        <th>#</th>
                        <th>Reference</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Rank</th>
                        <th>Purchase Point</th>
                        <th>My Team</th>
                        <th>Rank Point</th>
                    </thead>
                    <tbody>

                        {{-- @php
                        $start_time = microtime(true);
                        @endphp --}}

                        @include('admin.mlm.dashboard.layouts.tree.teamlist_table_row', ['user'=> $data->user])

                        {{-- {{ dd($data->downLevelMembers->sortBy('rank')) }} --}}

                        @foreach ($data->downLevelMembers->sortBy('id') as $user)

                        @include('admin.mlm.dashboard.layouts.tree.teamlist_table_row', ['user'=> $user])

                        @endforeach

                        {{-- @php
                        $end_time = microtime(true);
                        $execution_time = $end_time - $start_time;

                        dd($execution_time);
                        @endphp --}}

                    </tbody>
                </table>
            </div>

        </div>

    </div>

</div>

@endsection


@section('custom-js')

<script>
    function showHandCount(userId) {

        $('#show_handcount_btn' + userId).hide();

        axios.get(route('getUserHandCount', userId))
        .then(function (response) {

            let data = response.data;

            let handCountString = `${data[0]} : ${data[1]} : ${data[2]}`;

            $('#handcount_' + userId).html(handCountString);
        })
        .catch(function (error) {
        })
    }

    function showRankPointCount(userId) {

        $('#show_rankpoint_btn' + userId).hide();

        axios.get(route('getUserRankPoint', userId))
        .then(function (response) {

            let data = response.data;

            let rankString = `${data[0]} : ${data[1]} : ${data[2]}`;

            $('#rankpoint_' + userId).html(rankString);
        })
        .catch(function (error) {
        })

    }

</script>

@endsection
