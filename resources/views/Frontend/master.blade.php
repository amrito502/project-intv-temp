@php
$categories = session('home_theme')['categories'];
@endphp

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<head>
    <?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Content-Type: application/xml; charset=utf-8");
    ?>
    <meta NAME="KEYWORDS" CONTENT="<?php echo @$metaTag['meta_keyword']; ?>">
    <meta NAME="TITLE" CONTENT="<?php echo @$metaTag['meta_title']; ?>">
    <meta NAME="DESCRIPTION" CONTENT="<?php echo @$metaTag['meta_description']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/').@$information->sitefavIcon }}">
    <title>{{$information->siteName}} @if(@$title) {{@$information->titlePrefix}} @endif {{ @$title }}</title>
    @include('frontend.partial.header.header-asset')

    <style>
        .lab-menu-vertical .menu-vertical,
        .laberMenu-top .menu-vertical {
            display: none !important;
        }

        .lab-menu-vertical .menu-vertical.lab-active,
        .laberMenu-top .menu-vertical.lab-active {
            display: block !important;
        }

        .laberProductGrid .laberProdCategory .item-inner {
            border: none !important;
        }
    </style>

    <style>
        @media only screen and (min-width: 768px) {
            .searchBarNav {
                margin-top: 10px;
            }
        }

        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 58%;
        }

        #header .header-top {
            padding: 5px 0 10px 0;
        }
    </style>

    <style>
        @media (min-width: 768px) {
            .d-md-none {
                display: none !important;
            }

        }
    </style>

    @yield('custom-css')

</head>

<body id="{{ @$bodyID }}"
    class="{{ @$bodyClass }} lang-en country-us currency-usd layout-full-width page-index tax-display-disabled">
    <!--<div class="se-pre-con"></div>-->
    <main>
        @include('frontend.partial.error')
        <header id="header">
            @include('frontend.partial.navbar.pre_navbar')
            <div class="container px-0">
                @include('frontend.partial.navbar.navbar')
            </div>

        </header>
        <section id="wrapper">
            <div class="">
                @yield('breadCombe')
                <div id="content-wrapper">
                    <section id="main">
                        @yield('mainContent')
                    </section>
                </div>
            </div>
        </section>

        @include('frontend.partial.add_to_cart_modal')

        <footer id="footer">
            {{-- @include('frontend.partial.footer.footer_slider') --}}
            {{-- @include('frontend.partial.footer.footer-top') --}}
            {{-- @include('frontend.partial.footer.footer-middle') --}}
            @include('frontend.partial.footer.footer_information')
            @include('frontend.partial.footer.footer-bottom')
        </footer>
        {{-- <div id="back-top"><i class="material-icons">arrow_upward</i></div>--}}
        <div class="tptn-overlay"></div>
    </main>
    @include('frontend.include.others.shopping_cart_javascript')
    @include('frontend.partial.footer.footer-asset')
    @yield('custom-js')

    <script>
        $(".lab-menu-vertical").hover(
      function () {
        $(".menu-vertical").addClass("lab-active");
      },
      function () {
        $(".menu-vertical").removeClass("lab-active");
      }
    );
    </script>
    <style>
        .displayPosition4,
        .displayPosition3,
        .displayPosition2 {
            background-color: #fff;
            padding-top: 30px;
        }

        .pricetag {
            margin: 8px 0 0px 0;
            position: relative;
            padding: 5px;
            height: 45px;
        }

        .jumbotron {
            /*padding-top: 30px;*/
            /*padding-bottom: 30px;*/
            /*margin-bottom: 30px;*/
            color: inherit;
            background-color: #eee;
        }

        span.productcart {
            background: #280074;
            color: #fff;
            float: right;
            padding: 0px 8px;
            font-size: 13px;
            text-transform: uppercase;
            position: relative;
            cursor: pointer;
        }

        .price .oneprice {
            line-height: 35px;
            vertical-align: middle;
            font-size: 13px;
            color: #fd0000;
            font-weight: bold;
        }

        #header .header-top .top-logo {
            top: -2px;
        }


        @media (max-width: 991px) {
            #header .logo {
                width: auto;
                height: 115px !important;
            }
        }
    </style>
</body>

</html>
