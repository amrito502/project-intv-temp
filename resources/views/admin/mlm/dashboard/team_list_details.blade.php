@extends('admin.layouts.master')

@section('custom-css')

@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<div class="card" style="margin-bottom: 200px;">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">My Team</h4>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ route('team.list') }}" class="btn btn-primary">Summary</a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="tree">

            <div class="row justify-content-center" style="overflow-y: auto;">
                <div class="col-md-12">

                    <table class="table table-hover table-bordered dtb2">
                        <thead>
                            <th>#</th>
                            <th>Placement</th>
                            <th>Reference</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th style="width:150px;">Mobile No</th>
                            <th style="width:150px;">Rank</th>
                            <th style="width:150px;">My Team</th>
                            <th style="width:150px;">Rank Point</th>
                            {{-- <th>Account Status</th> --}}
                        </thead>
                        <tbody>

                            @include('admin.mlm.dashboard.layouts.tree.teamlist_table_detail_row', ['user'=> $data->user])

                            @php
                                $x = 1;
                            @endphp
                            @foreach ($data->downlevelUsers as $user)
                            @for ($i = 0; $i < 3; $i++)
                            @php
                            $hand=@$user->hands()[$i];

                            if(!@$user->hands()->count()){
                                continue;
                            }

                            $x++;
                            @endphp

                                <tr>
                                    <td>{{ $x }}</td>
                                    @if ($i == 0)
                                    <td rowspan="3">{{ @$user->username }}</td>
                                    @endif
                                    <td>{{ @$hand->refMember->username }}</td>
                                    <td>
                                        {{ @$hand->username }}
                                        &nbsp;
                                    </td>
                                    <td>{{ @$hand->name }}</td>
                                    <td>{{ @$hand->mobile }}</td>
                                    <td>{{ @$hand->rank }}</td>
                                    <td>
                                        @if ($hand)
                                        {{ @$hand->DownLevelMemberAllIdsWithHandCount(1) }} : {{
                                        @$hand->DownLevelMemberAllIdsWithHandCount(2) }}
                                        : {{ @$hand->DownLevelMemberAllIdsWithHandCount(3) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($hand)
                                        {{ @$hand->downLevelAllReferWhereRankIsMemberPoint(1) }} : {{ @$hand->downLevelAllReferWhereRankIsMemberPoint(2) }}
                                        : {{ @$hand->downLevelAllReferWhereRankIsMemberPoint(3) }}
                                        @endif

                                    </td>
                                    {{-- <td>
                                        @if ($hand)
                                        {{ @$hand->status == 1 ? "Active" : "InActive" }}
                                        @endif
                                    </td> --}}
                                </tr>

                                @endfor
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

<script>
    $(document).ready(function () {

        $('.dtb2').DataTable({
            "pageLength": 500
        });

    });
</script>

@endsection
