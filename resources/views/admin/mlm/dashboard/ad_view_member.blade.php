@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

@php
$todayAds = json_decode($_COOKIE['TodayAds_' . Auth::user()->id], true);
@endphp


<div class="tile mb-3">
    <div class="tile-body">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- <button onclick="window.history.back()" type="button" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button> --}}
                    <h3 class="text-center">Today ADS</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container">
            <div class="row ">

                @if (Auth::user()->status == 1)
                @foreach ($todayAds as $todayAd)

                <div class="col-md-4">
                    <div class="card">
                        <img data-toggle="modal" onclick="openModal(event)" adId={{ $todayAd['id'] }}
                            data-target="#adModal-{{ $todayAd['id'] }}"
                            src="{{ asset('storage/ad/'. $todayAd['img']) }}" alt="">
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="adModal-{{ $todayAd['id'] }}" tabindex="-1" role="dialog"
                    aria-labelledby="adModal-{{ $todayAd['id'] }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{ route('MemberGetAdBonus', $todayAd['id']) }}" method="POST">
                            @csrf

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">View AD</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img data-toggle="modal"
                                        data-target="#adModal-{{ $todayAd['id'] }}"
                                        src="{{ asset('storage/ad/'. $todayAd['img']) }}" style="height:300px;width:100%" alt="">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit <span
                                            id="adCounter-{{ $todayAd['id'] }}"></span></button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                @endforeach

                @else

                <h1 class="text-danger text-center">Please Activate Your Account.</h1>

                @endif



            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-script')

<script>
    function removeCookie(adID) {

        axios.post(route('removeAdvFromCookie', adID))
        .then(function (response) {
            location.reload();
        })
        .catch(function (error) {
        })

    }


    function startCount(adID, adCounter) {

        // console.log(adID);
        // console.log(adCounter);

        let i = 5;

        let refreshId = setInterval(function(){

            if(i <= 0){

                removeCookie(adID);

                clearInterval(refreshId);
            }


            adCounter.innerHTML = `(${i})`;
            i--;


        }, 1000);

    }


    function openModal(e) {

            let adID = e.target.getAttribute('adId');

            let adCounter = document.getElementById('adCounter-' + adID);

            startCount(adID, adCounter);

        }

        // setInterval(function(){
        //     console.log('hello from log');
        // }, 1000);
</script>

@endsection
