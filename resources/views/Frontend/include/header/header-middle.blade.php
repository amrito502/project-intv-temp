@php
    use App\Product;
    use App\ProductSections;
    $customerId = Session::get('customerId');
    $referrer_url = URL::previous();
    $customerId = Session::get('customerId');

    if(!isset($customerId))
    {
        $orderHistory = url('/shipping-email');
    }
    else
    {
        $orderHistory = url('/customer/order');
    }

    use App\Customer;
    $customerId = Session::get('customerId');
    $customers =Customer::where('id',$customerId)->first();
@endphp

<style type="text/css">
    /* Top Social Icons */
    .top-social-icon{
        float: right;
    }
    .top-social-icon a i{
        padding-left: 5px;
        padding-right: 5px;
    }
    /* Set top contact On Right Side */
    .top-social-icon.top-social-icon-left{
        float: left;
    }

    .icons-hover-black i, i:hover, i{
        transition:all 350ms ease-in-out 0s;
        -moz-transition:all 350ms ease-in-out 0s;
        -webkit-transition:all 350ms ease-in-out 0s;
        -o-transition:all 350ms ease-in-out 0s;
        -ms-transition:all 350ms ease-in-out 0s;
    }
</style>

<div class="header-top hidden-lg-down">
    <div class="container">
        <div class="row">
            <div id="_desktop_shop-logo" class="shop-logo col-xl-3">
                <h1>
                    <a href="<?php echo  url('/') ?>">
                        @if(file_exists(@$information->siteLogo))
                            <img class="logo" src="{{asset('/').@$information->siteLogo}}">
                        @else
                            <img class="logo" src="{{$noImage}}" style="height: 100px;">
                        @endif
                    </a>
                </h1>
            </div>

            <div id="_desktop_tptnsearch"  class="tptnsearch col-xl-7">
                <div class="search-btn m-toggle">
                    <i class="material-icons">&#xE8B6;</i><span class="m-toggle-title hidden-xl-up">Search</span>
                </div>

                <div class="search-form">
                    <form method="GET" action="{{route('product.search')}}">
                        <input type="hidden" name="controller" value="search" />
                        <input type="text"  value="" size="50" autocomplete="off" id="input_search" name="search_query" placeholder="Search our catalog" class="ui-autocomplete-input" autocomplete="off" name="searchProduct" required />
                        <button type="submit" name="submit_search"><i class="material-icons search">&#xE8B6;</i></button>
                        <span class="search-close"><i class="material-icons">&#xE5CD;</i></span>
                    </form>
                </div>

                <div id="search_popup"></div>
            </div>

            <div class="top-social-icon icons-hover-black col-xl-2">
                <span><a target="_blank" href="https://www.facebook.com/technoparkbangladesh/"><i class="fa fa-facebook"></i></a></span>
                <span><a target="_blank" href="https://www.twitter.com"><i class="fa fa-twitter"></i></a></span>
                <span><a target="_blank" href="https://www.instagram.com"><i class="fa fa-instagram"></i></a></span>
                <span><a target="_blank" href="https://www.whatsapp.com"><i class="fa fa-whatsapp"></i></a></span>
            </div>

            {{-- <div id="_desktop_user-info" class="user-info col-xl-2">
                <div class="login-register">
                    <div class="m-toggle">
                        <i class="material-icons">&#xE8A6;</i>
                        <span class="m-toggle-title">Account</span>
                    </div>
                    <ul class="dropdown-content">
                        @if (!isset($customerId))
                            <li><a href="{{url('/customer/login')}}" title="Log in to your customer account" rel="nofollow">Sign in</a></li>
                            <li><a href="{{url('/customer/registration')}}" title="Register your new customer account" rel="nofollow">Register</a></li>
                        @else
                            <li><a href="{{route('customer.profile')}}" title="View my customer account" rel="nofollow">My Account</a></li>
                            <li><a href="{{url('/customer/order')}}" title="Order details" rel="nofollow">Order details</a></li>
                            <li><a class="log login" href="{{route('customer.logout')}}" title="Sign out" rel="nofollow">Sign out</a></li>
                        @endif
                    </ul>
                </div>

                @if(Session::get('customerName'))
                    <div class="login-register" style="margin-right: 25px;margin-top: 5px;">
                        <h6 style="text-align: center;"><b>Welcome</b></h6>
                        <h4 style="text-align: center;color: #f70617;">{{Session::get('customerName')}}</h4>
                    </div>
                @endif
            </div> --}}
        </div>
    </div>
</div>
