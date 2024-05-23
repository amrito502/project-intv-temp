<?php
use App\About;
use App\Settings;

$about = About::find(1);
$setting = Settings::find(1);

$customerId = session()->get('customerId');
?>


<div class="py-2 w-100" style="background: #111; color: rgba(255, 255, 255, 0.8) !important;">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-5 col-xl-4 text-center text-md-left mb-2">
                    <div class="col">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            About Us
                        </h4>
                        <p align="justify" class="text-white">{!! $about->aboutDescription !!}</p>
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline" method="POST" action="{{ route('subscribe.save') }}" style="display: flex">
                                {{csrf_field()}}                              
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control" placeholder="Your Email Address" name="subscribeEmail" required="">
                                </div>
                                <input type="hidden" name="action" value="0">
                                <button type="submit" name="submitNewsletter" class="btn btn-primary btn-icon-left ml-1" style="border-radius: 5px; font-size: 12px;">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-xl-1 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            Contact Info
                        </h4>
                        <ul class="footer-links contact-widget">
                            <li>
                               <span class="d-block opacity-5">Address: {{ $setting->siteAddress1 }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">Phone: {{ $setting->mobile1 }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">Email: {{ $setting->siteEmail1 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            Useful Link
                        </h4>
                        <ul class="footer-links">
                            <li>
                                <a href="{{ route('aboutpage') }}" title="">
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('termsandCondition') }}" title="">
                                    Terms And Conditions
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('paymentPolicy') }}" title="">
                                    Privacy Policy
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('refundPolicy') }}" title="">
                                    Refund Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="col text-center text-md-left">
                       <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                          My Account
                       </h4>

                        <ul class="footer-links">
                            @if (Auth::guard('customer')->user())
                            <li>
                                <a href="{{ route('customer.profile.home') }}" title="My Profile">
                                    My Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{route('customer.order')}}" title="Order History">
                                    Order History
                                </a>
                            </li>
                            <!--<li>-->
                            <!--    <a href="https://unimart.online/wishlists" title="My Wishlist">-->
                            <!--        My Wishlist-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li>
                                <a href="{{route('customer.order')}}" title="Track Order">
                                    Track Order
                                </a>
                            </li>
                            @else
                            <li>
                                 <a href="{{ route('customer.login') }}" title="Login">
                                    Login
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.login') }}" title="Order History">
                                    Order History
                                </a>
                            </li>
                            <!--<li>-->
                            <!--    <a href="{{ route('customer.login') }}" title="My Wishlist">-->
                            <!--        My Wishlist-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li>
                                <a href="{{ route('customer.login') }}" title="Track Order">
                                    Track Order
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    
                        
                    <div class="social-links" style="margin-top: 100px;">
                        <?php
                        $socialLinks = DB::table('social_links')->where('status', 1)->get();
                        ?>
                        
                        @foreach($socialLinks as $socialLink)
                            <a href="{{$socialLink->link}}" style="font-size: 25px; margin-right: 5px">{!! $socialLink->icon !!}</a>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>