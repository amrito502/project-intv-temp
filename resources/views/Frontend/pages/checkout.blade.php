@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">
        <nav data-depth="1" class="breadcrumb hidden-sm-down">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">

                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="#">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
            </ol>
        </nav>


        <div id="content-wrapper">
            <section id="main">
                <div class="cart-grid row" style="margin-top:20px;padding: 0 14px;">

                    <!-- Left Block: cart product informations & shpping -->
                    <div class="cart-grid-body col-xs-12 col-lg-8">

                        <section id="checkout-personal-information-step"
                            class="checkout-step -current -reachable js-current-step"
                            style="border: 1px solid #ddd; padding: 25px;">

                            <div class="content">
                                <ul class="nav nav-inline my-2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#checkout-guest-form"
                                            role="tab" aria-controls="checkout-guest-form" aria-selected="true">
                                            Order as a guest
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <span href="nav-separator"> | </span>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link " data-link-action="show-login-form" data-toggle="tab"
                                            href="#checkout-login-form" role="tab" aria-controls="checkout-login-form">
                                            Sign in
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="checkout-guest-form" role="tabpanel">
                                        <form action="{{route('order.save')}}" id="customer-form"
                                            class="js-customer-form" method="post">
                                            {{ csrf_field() }}

                                            <section>

                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Full name
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" name="fullName" type="text" value=""
                                                            required="">
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>


                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Email
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" name="email" type="email" value=""
                                                            required="">
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>


                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Phone
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" name="phone" type="text" value=""
                                                            required="">
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>


                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Shipping Address
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" name="address" type="text" value=""
                                                            required="">
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>

                                            </section>


                                            <footer class="form-footer clearfix">
                                                <input type="hidden" name="submitCreate" value="1">
                                                <button class="continue btn btn-primary float-xs-right" name="continue"
                                                    data-link-action="register-new-customer" type="submit" value="1">
                                                    Continue
                                                </button>
                                            </footer>
                                        </form>
                                    </div>

                                    <div class="tab-pane " id="checkout-login-form" role="tabpanel" aria-hidden="true">
                                        <form id="login-form" action="{{ route('customer.dologin') }}" method="post">
                                            {{ csrf_field() }}

                                            <section>
                                                <input type="hidden" name="back" value="">
                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Email
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input class="form-control" name="custemail" type="email" value=""
                                                            required="">
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>


                                                <div class="form-group row ">
                                                    <label class="col-md-3 form-control-label required">
                                                        Password
                                                    </label>
                                                    <div class="col-md-6">
                                                        <div class="input-group js-parent-focus">
                                                            <input
                                                                class="form-control js-child-focus js-visible-password"
                                                                name="password" type="password" value="" pattern=".{5,}"
                                                                required="">
                                                            <span class="input-group-btn">
                                                                <button class="btn" type="button"
                                                                    data-action="show-password" data-text-show="Show"
                                                                    data-text-hide="Hide">
                                                                    Show
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3 form-control-comment">

                                                    </div>
                                                </div>

                                                <div class="forgot-password">
                                                    <a href="{{ route('password.forget') }}" rel="nofollow">
                                                        Forgot your password?
                                                    </a>
                                                </div>

                                            </section>

                                            <footer class="form-footer text-sm-center clearfix">
                                                <input type="hidden" name="submitLogin" value="1">
                                                <button class="continue btn btn-primary float-xs-right" name="continue"
                                                    data-link-action="sign-in" type="submit" value="1">
                                                    Continue
                                                </button>
                                            </footer>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                    <!-- Right Block: cart subtotal & cart total -->
                    <div class="cart-grid-right col-xs-12 col-lg-4">
                        <div class="card cart-summary">
                            <div class="cart-detailed-totals">
                                <div class="card-block">
                                    <div class="cart-summary-line" id="cart-subtotal-products">
                                        <span class="label js-subtotal">1 item</span>
                                        <span class="value" id="subtotal">$22.71</span>
                                    </div>
                                    {{-- <div class="cart-summary-line" id="cart-subtotal-shipping">
                                        <span class="label">Shipping</span>
                                        <span class="value">$7.00</span>
                                        <div><small class="value"></small></div>
                                    </div> --}}
                                </div>

                                <hr class="separator">

                                <div class="card-block">
                                    <div class="cart-summary-line cart-total">
                                        <span class="label">Total</span>
                                        <span class="value" id="grandTotal">$29.71</span>
                                    </div>

                                    {{-- <div class="cart-summary-line">
                                        <small class="label">Taxes</small>
                                        <small class="value">$0.00</small>
                                    </div> --}}
                                </div>

                                <hr class="separator">
                            </div>

                            <div class="checkout cart-detailed-actions card-block">
                                <div class="text-sm-center">
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-primary">Proceed to
                                        checkout</a>
                                </div>
                            </div>
                        </div>

                        <div id="block-reassurance">
                            <ul>
                                <li>
                                    <div class="block-reassurance-item">
                                        <img src="http://laberpresta.com/v17/laber_supershop_v17/modules/blockreassurance/img/ic_verified_user_black_36dp_1x.png"
                                            alt="Security policy (edit with Customer reassurance module)">
                                        <span class="h6">Security policy (edit with Customer reassurance module)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="block-reassurance-item">
                                        <img src="http://laberpresta.com/v17/laber_supershop_v17/modules/blockreassurance/img/ic_local_shipping_black_36dp_1x.png"
                                            alt="Delivery policy (edit with Customer reassurance module)">
                                        <span class="h6">Delivery policy (edit with Customer reassurance module)</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="block-reassurance-item">
                                        <img src="http://laberpresta.com/v17/laber_supershop_v17/modules/blockreassurance/img/ic_swap_horiz_black_36dp_1x.png"
                                            alt="Return policy (edit with Customer reassurance module)">
                                        <span class="h6">Return policy (edit with Customer reassurance module)</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
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
