@extends('frontend.master')

@section('custom-css')
<style>
    #main {
        padding: 50px 0;
    }

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

@section('mainContent')
<div class="container">
    <div class="row">

        <nav data-depth="0" class="breadcrumb hidden-sm-down">
            <ol>
                <li itemprop="itemListElement" itemscope="">
                    <a itemprop="item" href="{{ route('home.index') }}">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                <li itemprop="itemListElement">
                    <a itemprop="item" href="{{ route('customer.profile.home') }}">
                        <span itemprop="name">Your account</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>


        <div id="content-wrapper">
            <section id="main">
                {{-- <header class="page-header">
                    <h1>
                        Your account
                    </h1>
                </header> --}}

                <section id="content" class="page-content">
                    <aside id="notifications">
                        <div class="container">

                        </div>
                    </aside>

                    <div class="row">
                        <div class="links">

                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link"
                                href="{{ route('customer.profile') }}">
                                <span class="link-item">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                                    Information
                                </span>
                            </a>

                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="addresses-link"
                                href="{{ route('customer.address') }}">
                                <span class="link-item">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    Addresses
                                </span>
                            </a>

                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="history-link"
                                href="{{ route('customer.order') }}">
                                <span class="link-item">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                    Order history and details
                                </span>
                            </a>


                        </div>
                    </div>
                    <div class="row">
                        <div class="links">

                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link">

                                <span class="link-item">

                                    <input id="refUrl" type="text" class="form-control font-weight-normal"
                                        value="{{ route('customer.registration', ['reference' => Auth::guard('customer')->user()->id]) }}"
                                        onclick="copyText()">

                                    <div style="margin-top: 18px;"></div>
                                    Reference Link
                                </span>
                            </a>


                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link"
                                href="{{ route('customer.businesspanel') }}">
                                <span class="link-item">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                    Go To Business Panel
                                </span>
                            </a>

                            <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="identity-link"
                                href="{{ route('customer.logout') }}">
                                <span class="link-item">
                                    <i class="fa fa-power-off" aria-hidden="true"></i>
                                    Sign out
                                </span>
                            </a>

                        </div>
                    </div>

                </section>

            </section>
        </div>
    </div>
</div>
@endsection

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
