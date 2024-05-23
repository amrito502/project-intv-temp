@extends('frontend.master')

@section('mainContent')
    <div class="container" style="padding-bottom: 20px">
        <div id="content">

            <div class="row" style="margin-top:30px;">
                <div class="col-md-4">
                    <div class="block-contact links wrapper" style="margin-top:60px;">

                        <p class="h3 text-uppercase hidden-sm-down block-contact-title">Contact information</p>
                        <div class="title clearfix hidden-md-up" data-target="#footer_sub_menu_contactFooter"
                             data-toggle="collapse">
                            <span class="h3">Contact information</span>
                            <span class="float-xs-right">
                                                <span class="navbar-toggler collapse-icons">
                                                    <i class="material-icons add">&#xE313;</i>
                                                    <i class="material-icons remove">&#xE316;</i>
                                                </span>
                                        </span>
                        </div>
                        <div id="footer_sub_menu_contactFooter" class="collapse">
                            <div class="laberContact">
                                <i class="fa fa-home"></i>
                                <p class="address address1">
                                    Address:
                                    <br>
                                     {!! session('home_theme')['meta_info']->siteAddress1 !!}
                                </p>

                                <p class="address address1">
                                </p>
                            </div>

                            <div class="laberContact">
                                <i class="fa fa-phone-square"></i>
                                <p class="phone">
                                    Phone:
                                    <br>
                                    <span>{{  session('home_theme')['meta_info']->mobile1  }},
                                    <br>
                                    {{ session('home_theme')['meta_info']->mobile2 }}</span>
                                </p>
                            </div>

                            <div class="laberContact">
                                <p class="email">
                                    <i class="fa fa-envelope"></i> Email us:
                                    <br>
                                    <a href="mailto:{{ session('home_theme')['meta_info']->siteEmail1 }}"
                                            class="dropdown">{!! session('home_theme')['meta_info']->siteEmail1 !!}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <iframe src="{{ $setting->map_url }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 contact-form">
                    <?php
                    $message = Session::get('msg');
                    if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                    }

                    Session::forget('msg')

                    ?>




                    <div class="col-md-12 contact-title">
                        <h4>Message to {{ @$information->siteName }}</h4>
                    </div>
                    <form action="{{route('contact.save')}}" method="post" class="register-form">
                        {{ csrf_field() }}

                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputName">Your Name <span>*</span></label>
                                <input type="text" name="contactName" value="{{ old('contactName') }}"
                                       class="form-control unicase-form-control text-input" id="exampleInputName"
                                       placeholder="Write your full name" required>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Phone Number <span>*</span></label>
                                <input type="number" name="contactPhone" value="{{ old('contactPhone') }}"
                                       class="form-control unicase-form-control text-input" id="exampleInputEmail1"
                                       placeholder="Write your phone number" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                                <input type="email" name="contactEmail" value="{{ old('contactEmail') }}"
                                       class="form-control unicase-form-control text-input" id="exampleInputEmail1"
                                       placeholder="Write your email address" required>
                                @if ($errors->has('contactEmail'))
                                    @foreach($errors->get('contactEmail') as $error)
                                        <p class="alert alert-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputTitle">Subject <span>*</span></label>
                                <input type="text" name="contactTitle" value="{{ old('contactTitle') }}"
                                       class="form-control unicase-form-control text-input" id="exampleInputTitle"
                                       placeholder="Write your subject" required>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="info-title" for="exampleInputComments">Your Message <span>*</span></label>
                                <textarea name="contactMessage" class="form-control unicase-form-control"
                                          id="exampleInputComments">{{ old('contactMessage') }}</textarea>
                            </div>

                        </div>

                        <div class="col-md-12" style="margin-bottom: 10px;">
                            {!! NoCaptcha::display() !!}
                        </div>

                        <div class="col-md-12 outer-bottom-small m-t-20">
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Send
                                Message</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.contact-page -->
        </div><!-- /.row -->
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
