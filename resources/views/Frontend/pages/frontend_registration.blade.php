@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">
        <nav data-depth="1" class="breadcrumb hidden-sm-down">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="index.html">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
            </ol>
        </nav>

        <div id="content-wrapper">
            <section id="main">
                <header class="page-header">
                    <h1>
                        Create an account
                    </h1>
                </header>

                <section id="content" class="page-content card card-block">
                    <section class="register-form">
                        <p>Already have an account? <a href="{{ route('customer.login') }}">Log in instead!</a></p>

                        <form action="{{route('customer.register')}}" id="customer-form" class="js-customer-form" method="post">
                            {{ csrf_field() }}

                            <section>
                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="name" type="text" value="{{old('name')}}" required="">
                                    </div>

                                    <div class="col-md-3 form-control-comment"></div>
                                </div>


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Email
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="email" type="text" value="{{old('email')}}" >
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Username <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" oninput="checkUsername()" name="username" id="username" type="text" value="{{old('username')}}" required>
                                    </div>

                                    <div class="col-md-3 form-control-comment" style="margin-top: 10px">
                                        <span id="usercheck"></span>
                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Phone Number <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="mobile" type="text" value="{{old('mobile')}}">
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Reference
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="reference" value="{{ @$reference->username }}" placeholder="Reference" @if ($reference) readonly @endif>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>


                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group js-parent-focus" style="display: flex">
                                                    <input class="form-control js-child-focus js-visible-password" name="password" id="password1" type="password" value="" pattern=".{5,}" required="">
                                                    <span class="input-group-btn" style="width: auto">
                                                        <i id="eye1" onclick="showHide(1)" class="btn fa fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>

                                <div class="form-group row ">
                                    <label class="col-md-3 form-control-label required">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <div class="input-group js-parent-focus" style="display: flex">
                                            <input class="form-control js-child-focus js-visible-password" name="confirmPassword" type="password" id="password2" value="" pattern=".{5,}" required="">
                                            <span class="input-group-btn" style="width: auto">
                                                <i id="eye2" onclick="showHide(2)" class="btn fa fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 form-control-comment">

                                    </div>
                                </div>
                            </section>

                            <footer class="form-footer clearfix">
                                <input type="hidden" name="submitCreate" value="1">
                                <button class="btn btn-primary form-control-submit float-xs-right" data-link-action="save-customer" type="submit">
                                    Register
                                </button>
                            </footer>

                        </form>
                    </section>
                </section>

                <footer class="page-footer mb-3">
                    <!-- Footer content -->
                </footer>
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

    .fa-eye,
    .fa-eye-slash {
        padding: 13px;
    }

    .fa-eye:hover,
    .fa-eye-slash:hover {
        background-color: #502073;
        color: #fff !important;
    }

</style>

@endsection

@section('custom-js')
<script>
    function checkUsername() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var username = $('#username').val();
        if (username.length == 0) {
            $('#usercheck').html('<span style="color: black;">Enter Username.</span>');
            return;
        }

        $.ajax({
            type: 'get'
            , url: "{{ route('username.check') }}"
            , data: {
                username: username
            , }
            , success: function(response) {
                if (response == '') {
                    $('#usercheck').html('<span style="color: green;">Username Available.</span>');
                } else {
                    $('#usercheck').html('<span style="color: red;">Username Not Available.</span>');
                }
            }
            , error: function(response) {}
        });
    }


    function showHide(id) {

        const EyeSlash = "btn fa fa-eye-slash";
        const Eye = "btn fa fa-eye";


        const passwordEl = document.getElementById('password' + id);
        const eyeconEl = document.getElementById('eye' + id);

        const passwordElInputType = passwordEl.getAttribute('type');

        if (passwordElInputType == 'password') {
            passwordEl.setAttribute('type', 'text');
            eyeconEl.setAttribute('class', Eye);
        } else {
            passwordEl.setAttribute('type', 'password');
            eyeconEl.setAttribute('class', EyeSlash);
        }

    }

</script>
@endsection
