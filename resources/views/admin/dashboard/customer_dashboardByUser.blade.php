@php
use Illuminate\Support\Carbon;
@endphp
@extends('admin.layouts.master')


@section('custom_css')

<style type="text/css">
    .serial_no {
        width: 4%
    }

    .mobile {
        width: 15%
    }

    .status {
        width: 10%
    }

    .name {
        width: 23%
    }

    .action {
        width: 10%
    }

    .total {
        width: 5%
    }

    table thead {
        line-height: 20px;
        background-color: #10cb9c;
    }

    table thead th {
        font-weight: bold !important;
        text-transform: uppercase;
        font-size: 12px;
    }

    .card {
        padding-top: 5px;
    }

    .card-title {
        padding-left: 5px;
        padding-right: 10px;
    }


    .userImageParent {
        padding: 5px;
        border: 1px solid #000;
        width: 222px;
        height: 222px;
        display: inline-block;
    }

    .userImage {
        width: 100%;
        height: 100%;
    }

    .rankImage {
        width: 25%;
        height: 150px;
    }

    .userRankParent {
        width: 100%;
        height: 200px;
        border: 1px solid black;
        display: inline-block;
    }

    .userRankParent h2 {
        font-size: 36px;
    }

    .title_block {
        background: #08a9f5;
        padding: 4px;
        text-align: center;
        width: 95%;
        margin: 0 auto;
        margin-top: 61px;
    }

    .title_block h4 {
        margin: 5px 0px 8px 0px;
        font-weight: 900;
        font-size: 24px;
        font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
        color: #000;
    }
</style>

<style>
    .noticeBox {
        width: 100%;
        margin: 0 auto;
        border: 1px solid black;
        padding: 20px 0;
        height: 300px;
        /* overflow: hidden; */
        overflow: auto;
    }

    .noticeBox li p {
        font-size: 22px;
    }
</style>

@endsection

@section('content')


<div class="container">
    <div class="bg-white py-5 px-5">

        <div class="row">

            <div class="col-md-5">

                <div class="w-100 text-center">
                    <div class="userImageParent">
                        <img src="{{ $user->profile_image() }}" class="userImage" alt="">
                    </div>
                </div>

                <div class="pt-5 px-3"></div>

                <h4 class="pt-2 font-weight-bold mb-1">Achivement Statement</h4>

                <div style="border-bottom: 3px solid black" class="mb-1"></div>

                <div style="border-bottom: 3px solid black" class=" mb-4"></div>

                <table class="middle-table-fz text-dark w-100">

                    <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Sales Bonus Achieve
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['sales'] }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Generation Achieve
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['generation'] }} ৳
                        </td>
                    </tr>

                    {{-- <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Level Bonus Achieve
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['level'] }} ৳
                        </td>
                    </tr> --}}

                    <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Rank Bonus Achieve
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['rank'] }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Repurchase Achieve
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['rePurchase'] }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left ">
                            Transfer Receive
                        </td>
                        <td style="font-size: 16px;" class="text-right">
                            {{ $userData->achieve['transfer_receive'] }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="font-size: 16px;">
                            <div style="border-bottom: 3px solid black" class="mt-4 "></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="font-size: 16px;">
                            <div style="border-bottom: 3px solid black"></div>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left font-weight-bold">
                            Total Income
                        </td>
                        <td style="font-size: 16px;" class="text-right font-weight-bold">
                            {{ $userData->total_achieve }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left font-weight-bold">
                            Total Receive
                        </td>
                        <td style="font-size: 16px;" class="text-right font-weight-bold">
                            {{ $userData->total_receive }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px;" class="text-left font-weight-bold">
                            Total Balance
                        </td>
                        <td style="font-size: 16px;" class="text-right font-weight-bold">
                            {{ $userData->total_due }} ৳
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="font-size: 16px;">
                            <div style="border-bottom: 3px solid black"></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="font-size: 16px;">
                            <div style="border-bottom: 3px solid black" class=" mb-4"></div>
                        </td>
                    </tr>

                </table>



                <div class="row">
                    <div class="col-md-12">
                        <div class="title_block" style="width: 100%;margin-top: 0;">
                            <h4>Notice Board</h4>
                        </div>
                        <div class="d-flex" style="justify-content:center;">
                            <div class="noticeBox">

                                <ul class="noticeList">
                                    @foreach ($userData->notices as $notices)
                                    <li>
                                        <p>{{ $notices->description }}</p>
                                    </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-7">

                <div class="text-center mt-1">
                    <div class="userRankParent">
                        <img src="{{ asset('admin-elite/assets/images/leadmart_text.jpg') }}" class="img-fluid" alt="">
                        <h2 class="mt-4">{{ $user->currentRank() }}</h2>
                    </div>
                </div>

                <div class="title_block">
                    <h4>Basic Information</h4>
                </div>

                <table class="middle-table-fz text-dark mt-3" style="width: 93%;margin: 0 auto;">

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Username
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->username }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Full Name
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->name }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Email Address
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->email }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Mobile Number
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->mobile }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Joining Date
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">

                            @php
                            // get date diff between current date and join date
                            $now = Carbon::now();

                            $diff = $user->created_at->diffInDays($now);
                            @endphp

                            {{ $user->created_at->format('d-m-Y') }} ({{ $diff }} days ago)
                        </td>
                    </tr>

                    {{-- <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Designation
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->member_type }}
                        </td>
                    </tr> --}}

                    {{-- <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Last Designation
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            @if ($user->rank_date)
                            {{ date('d-m-Y', strtotime($user->rank_date)) }}
                            @else
                            {{ $user->created_at->format('d-m-Y') }} ({{ $diff }} days ago)
                            @endif
                        </td>
                    </tr> --}}

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Purchase Point
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->totalPointIncome() }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Refer ID
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ @$user->refMember->username }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Placer ID
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ @$user->placeMember->username }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Team Member
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->DownLevelMemberAllIdsWithHandCount(1) }} : {{
                            $user->DownLevelMemberAllIdsWithHandCount(2) }}
                            : {{ $user->DownLevelMemberAllIdsWithHandCount(3) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width:200px;font-size: 16px;" class="text-left">
                            Rank Points
                        </td>
                        <td style="width:60px;font-size: 16px;" class="text-center">
                            :
                        </td>
                        <td style="font-size: 16px;" class="text-left">
                            {{ $user->downLevelAllReferWhereRankIsMemberPoint(1) }} : {{
                            $user->downLevelAllReferWhereRankIsMemberPoint(2) }}
                            : {{ $user->downLevelAllReferWhereRankIsMemberPoint(3) }}
                        </td>
                    </tr>

                </table>


                <div class="title_block mt-4">
                    <h4>Reference Link</h4>
                </div>

                <div class="d-flex" style="justify-content:center;">
                    <div style="width: 95%;margin: 0 auto;">
                        <input id="refUrl" type="text" class="form-control font-weight-normal"
                            value="{{ route('customer.registration', ['reference' => $user->id]) }}"
                            onclick="copyText()">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">

                        <div class="title_block mt-4">
                            <h4>Club Status</h4>
                        </div>

                        <table class="middle-table-fz text-dark mt-3" style="width: 93%;margin: 0 auto;">

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    My Current Club
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $user->currentRank() }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    My UpComing Club
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->nextRank }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    Current Club Members
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->currentRankMemberCount }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    UpComing Club Members
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->nextRankMemberCount }}
                                </td>
                            </tr>


                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    Package Sell in This Month
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->thisMonthSoldPackages }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    Current Club Reserve
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->currentRankReserve }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width:200px;font-size: 16px;" class="text-left">
                                    UpComing Club Reserve
                                </td>
                                <td style="width:60px;font-size: 16px;" class="text-center">
                                    :
                                </td>
                                <td style="font-size: 16px;" class="text-left">
                                    {{ $rankData->nextRankReserve }}
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>


            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                {{-- active leader start --}}
                <div class="title_block" style="width: 100%;margin-top: 10px;">
                    <h4>Top 5 Earner</h4>
                </div>

                <div class="card">
                    <div class="card-body" style="height: 200px">
                        <div class="row">
                            <table class="middle-table-fz text-dark w-100">

                                @foreach ($userData->active_leaders as $active_leader)

                                <tr>
                                    <td style="font-size: 16px;" class="text-left">
                                        <span class="mb-0" data-toggle="tooltip" data-placement="right"
                                            title="{{ $active_leader['customer']->UserAccount->name }}">
                                            {{ $active_leader['customer']->UserAccount->username }}
                                        </span>
                                    </td>
                                    {{-- <td style="font-size: 16px;" class="text-right">
                                        {{ $active_leader['income'] }}
                                    </td> --}}
                                </tr>

                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
                {{-- active leader end --}}
            </div>

            <div class="col-md-6">
                {{-- Team leader start --}}
                <div class="title_block" style="width: 100%;margin-top: 10px;">
                    <h4>Top 5 Team Earner</h4>
                </div>

                <div class="card">
                    <div class="card-body" style="height: 200px">
                        <div class="row">
                            <table class="middle-table-fz text-dark w-100">

                                @foreach ($userData->top_team_earners as $top_team_earner)

                                <tr>
                                    <td style="font-size: 16px;" class="text-left">
                                        <span class="mb-0" data-toggle="tooltip" data-placement="right"
                                            title="{{ $top_team_earner['customer']->UserAccount->name }}">
                                            {{ $top_team_earner['customer']->UserAccount->username }}
                                        </span>
                                    </td>
                                </tr>

                                @endforeach

                            </table>
                        </div>
                    </div>
                </div>
                {{-- Team leader end --}}
            </div>

        </div>

    </div>

</div>







@endsection

{{-- file for javascript code --}}
{{-- @include('admin.dashboard.element.js_code') --}}


@section('custom-js')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    function copyText(){
    var text = document.getElementById('refUrl');
    text.select();
    document.execCommand("copy");

    swal("Text Copied", {
        button: "OK",
        timer: 5000,
        icon: 'success',
        ButtonColor: "#DD6B55",
    });

}
</script>
@endsection
