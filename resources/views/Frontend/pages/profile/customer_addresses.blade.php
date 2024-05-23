@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">

        <nav data-depth="2" class="breadcrumb hidden-sm-down">
            <ol>
                <li>
                    <a itemprop="item" href="{{ route('home.index') }}">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>

                <li>
                    <a itemprop="item" href="{{ route('customer.profile') }}">
                        <span itemprop="name">Account Information</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>

            </ol>
        </nav>


        <div id="content-wrapper">
            <section id="main">
                <header class="page-header">
                    <h1>
                        Your addresses
                    </h1>
                </header>


                <section id="content" class="page-content">

                    @php
                    $i = 0;
                    @endphp

                    @foreach ($customer->addresses as $address)

                    @php
                    $i++;
                    @endphp

                    @include('frontend.partial.customer_profile.customer_address_card', ['address' => $address,
                    'sl' => $i])

                    @endforeach


                    <div class="clearfix"></div>
                    @include('frontend.partial.customer_profile.address_add_btn')
                </section>

                @include('frontend.partial.customer_profile.footer_nav')
            </section>
        </div>
    </div>
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
