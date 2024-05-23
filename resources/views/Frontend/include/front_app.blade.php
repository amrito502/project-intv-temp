<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend_Adarsha.partial.header')
    @yield('custom-css')
</head>

<body>
    <div class="website-wrapper">

        <!-- NAVBAR(HEADER) -->
        @include('frontend_Adarsha.partial.navbar.navbar')
        <!--END MAIN NAVBAR(HEADER)-->

        <!-- MAIN CONTENT AREA -->

        <div class="main-page-wrapper">

            <div class="container">
                <div class="row content-layout-wrapper align-items-start">
                    <div class="site-content col-lg-12 col-12 col-md-12" role="main">
                        <article id="post-2124" class="post-2124 page type-page status-publish hentry">
                            <div class="entry-content">

                                <div class="main-page-wrapper">
                                    <div class="col-md-9 offset-md-3 pl-0">
                                        @yield('mainContent')
                                    </div>
                                </div>

                            </div>
                        </article>
                        <!-- #post -->
                    </div>
                    <!-- .site-content -->
                </div>
                <!-- .main-page-wrapper -->
            </div>

            <!-- end row -->
        </div>


        <!-- end container -->

        <!-- FOOTER -->
        @include('frontend_Adarsha.partial.footer')
    </div>
    <!-- end wrapper -->

    <!-- Start shopping_cart_side -->
    @include('frontend_Adarsha.partial.shopping_cart_side')
    <!-- End shopping_cart_side -->

    <!-- Start footer_scripte -->
    @include('frontend_Adarsha.partial.footer_script')
    @yield('custom-js')
    <!-- End footer_script -->

    <!--START MOBILE-NAV-->
    @include('frontend_Adarsha.partial.mobile_view')
    <!--END MOBILE-NAV-->

    <!--START Login Form Side-->
    @include('frontend_Adarsha.partial.login_form_side')
    <!--END Login Form Side-->

    <a href="#" class="scrollToTop">Scroll To Top</a>

    <!--START woodmart_promo_popup-->
    @include('frontend_Adarsha.partial.woodmart_promo_popup')
    <!--END woodmart_promo_popup-->

    <!-- Root element of PhotoSwipe. Must have class pswp. -->
    @include('frontend_Adarsha.partial.photo_swipe')
    <!--END Root element of PhotoSwipe. Must have class pswp.-->
</body>

</html>