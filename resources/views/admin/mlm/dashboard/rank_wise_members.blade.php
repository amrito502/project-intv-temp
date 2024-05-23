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
                    <h3 class="text-center">{{ $data->rank->rank_name }} Members</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                @if(!empty($data->rankWMembers->members) && count($data->rankWMembers->members))
                @foreach ($data->rankWMembers->members as $member)
                <div class="col-md-3 my-1">
                    <div class="card">
                        <img class="card-img-top w-50 mx-auto my-0 mt-4" src="{{ $member->profile_image() }}"
                            alt="User Avatar">
                        <div class="card-body">
                            <p class="card-text text-center">{{ $member->name }}</p>
                            <p class="card-text text-center">{{ $member->username }}</p>
                            <p class="card-text text-center">{{ $member->urank() }}</p>
                            <p class="card-text text-center">
                                @php
                                $date = date('d-m-Y', strtotime($member->account_activation_date));

                                if($date == '01-01-1970'){
                                    $date = '';
                                }
                                @endphp

                                {{ $date }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
