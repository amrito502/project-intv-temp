<nav class="header-nav ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="_desktop_contact_link">
                    <div id="contact-link">
                        <ul>
                            <li class="item">
                                <span><i class="fa fa-envelope" aria-hidden="true"></i>
                                     {{ session('home_theme')['meta_info']->siteEmail1 }}</span>
                            </li>
                            <li class="item">
                                <span><i class="fa fa-phone" aria-hidden="true"></i>
                                    {{ session('home_theme')['meta_info']->mobile1 }}</span>
                            </li>

                            <li class="item">
                                <a href="{{ route('contactpage') }}">
                                <i class="fa fa-map-marker" aria-hidden="true"></i> Contact us
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div id="aa" class="pull-right">
                    <div class="laberUserInfo">
                        <div class="laber-user-info">
                            <div class="user-info">
                                <div class="signin">
                                    @if (Auth::guard('customer')->user())

                                        <a href="{{route('customer.order')}}">
                                            Track Order
                                        </a>  /

                                        <a href="{{ route('customer.profile.home') }}">
                                            {{ Auth::guard('customer')->user()->name }}
                                        </a>

                                    @endif
                                    @guest('customer')
                                        <a href="{{ route('customer.login') }}" title="Log in to your customer account"
                                           rel="nofollow">
                                            Sign in
                                        </a> /
                                        <a class="" href="{{ route('customer.registration') }}">
                                            Register
                                        </a>
                                    @endguest

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    var wishlistProductsIds = '';
                    var baseDir = 'http://laberpresta.com/v17/laber_supershop_v17/';
                    var static_token = '2fdc10c6ea8864560b44ba4a0cbb19ff';
                    var isLogged = '0';
                    var loggin_required = 'You must be logged in to manage your wishlist.';
                    var added_to_wishlist = 'The product was successfully added to your wishlist.';
                    var mywishlist_url = '#module/blockwishlist/mywishlist';
                    var isLoggedWishlist = false;
                </script>
                <div id="_desktop_wishtlistTop" class="pull-right">
                    <div class="laberwishtlistTop">
                        <a class="wishtlist_top icon" href="#module/blockwishlist/mywishlist">
                            <i class="icon_wishtlist"></i>
                            <span>Wishlist</span>
                            <span class="cart-wishlist-number">(0)</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="hidden-md-up text-sm-center mobile">
                <div class="float-xs-left" id="menu-icon">
                    <i class="fa fa-align-justify"></i>
                </div>
                <div class="top-logo" id="_mobile_logo"></div>
                <div class="top-cart" id="_mobile_blockcart"></div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</nav>

