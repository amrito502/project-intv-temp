@extends('frontend.master')

@section('mainContent')
    <div class="container">
        <h1 style="font-weight: bold;font-size: 20px;text-align: center;margin-top: 40px; margin-bottom: 40px;">{{@$about->title}}</h1>

        <p>{!! @$about->aboutDescription !!}</p>
    </div>
@endsection

@section('custom-css')

    <style>
        .lab-menu-vertical .menu-vertical,
        .laberMenu-top .menu-vertical {
            display: none !important;
        }

        .lab-menu-vertical .menu-vertical.lab-active,
        .laberMenu-top .menu-vertical.lab-active {
            display: block !important;
        }
    </style>

@endsection
