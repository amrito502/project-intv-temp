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
                            Your personal information
                        </h1>
                    </header>


                    <section id="content" class="page-content">
                        <aside id="notifications">
                            <div class="container">

                            </div>
                        </aside>


                        <form action="{{route('customer.update')}}" id="customer-form" class="js-customer-form"
                              method="post">

                            {{ csrf_field() }}
                            <input type="hidden" name="customerId" value="{{$customers->id}}">

                            <section>
                                <input type="hidden" name="id_customer" value="98">
                                {{--                                <div class="form-group row ">--}}
                                {{--                                    <label class="col-md-3 form-control-label">--}}
                                {{--                                        Social title--}}
                                {{--                                    </label>--}}
                                {{--                                    <div class="col-md-6 form-control-valign">--}}
                                {{--                                        <label class="radio-inline">--}}
                                {{--                                                    <span class="custom-radio">--}}
                                {{--                                                        <input name="id_gender" type="radio" value="1">--}}
                                {{--                                                        <span></span>--}}
                                {{--                                                    </span>--}}
                                {{--                                            Mr.--}}
                                {{--                                        </label>--}}
                                {{--                                        <label class="radio-inline">--}}
                                {{--                                                    <span class="custom-radio">--}}
                                {{--                                                        <input name="id_gender" type="radio" value="2">--}}
                                {{--                                                        <span></span>--}}
                                {{--                                                    </span>--}}
                                {{--                                            Mrs.--}}
                                {{--                                        </label>--}}
                                {{--                                    </div>--}}

                                {{--                                    <div class="col-md-3 form-control-comment">--}}

                                {{--                                    </div>--}}
                                {{--                                </div>--}}


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Full name
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="name" type="text" value="{{$customers->name}}"
                                               required>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Email Address
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="email" type="email"
                                               value="{{$customers->email}}"
                                               required="">
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Phone Number
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="mobile" type="text"
                                               value="{{$customers->mobile}}" required>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Your Address
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="address" type="text"
                                               value="{{$customers->address}}" required>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>

                            </section>


                            <footer class="form-footer clearfix">
                                <input type="hidden" name="submitCreate" value="1">
                                <button class="btn btn-primary form-control-submit float-xs-right"
                                        data-link-action="save-customer" type="submit">
                                    Update
                                </button>
                            </footer>
                        </form>
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
