@extends('frontend.master')

@section('custom-css')

<style>
    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }

    .input-group>.custom-file,
    .input-group>.custom-select,
    .input-group>.form-control,
    .input-group>.form-control-plaintext {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
    }

    .input-group-append {
        margin-left: -2px;
    }

    .input-group-append,
    .input-group-prepend {
        display: flex;
    }

    .input-group>.input-group-append>.btn,
    .input-group>.input-group-append>.input-group-text,
    .input-group>.input-group-prepend:first-child>.btn:not(:first-child),
    .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child),
    .input-group>.input-group-prepend:not(:first-child)>.btn,
    .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: .875rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 2px solid #ced4da;
        border-radius: 4px;
    }
</style>

<style>
    .lab-menu-vertical .menu-vertical,
    .laberMenu-top .menu-vertical {
        display: none !important;
    }

    .lab-menu-vertical .menu-vertical.lab-active,
    .laberMenu-top .menu-vertical.lab-active {
        display: block !important;
    }

    #loginDiv {
        padding: 40px 0;
    }

    .forgot-password {
        text-align: center;
        margin-bottom: 10px;
    }

    .no-account {
        text-align: center;
    }
</style>

@endsection


@section('mainContent')


<div id="loginDiv">

    <div class="container ">
        <div class="row">

            <div id="content-wrapper">
                <section id="main">
                    <header class="page-header">
                        <h1>
                            Log in to your account
                        </h1>
                    </header>


                    <section id="content" class="page-content card card-block">
                        <section class="login-form">
                            <form id="login-form" action="{{route('customer.dologin')}}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="redirectTo" value="{{ request('redirectTo') }}">
                                <section>
                                    <input type="hidden" name="back" value="my-account">

                                    <div class="form-group row ">
                                        <label class="col-md-3 form-control-label required">
                                            Username / Phone
                                        </label>
                                        <div class="col-md-6">
                                            <input class="form-control" name="custemail" type="text"
                                                value="{{old('custemail')}}" required="">
                                        </div>

                                        <div class="col-md-3 form-control-comment">

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-3 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">

                                            <div class="input-group mb-3">
                                                <input type="password" id="password" class="form-control"
                                                    placeholder="password" name="password" required="">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">
                                                        <i onclick="toggleShowHide()" id="eyecon"
                                                            class="fa fa-eye-slash" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="form-group row ">
                                        <label class="col-md-3 form-control-label required">
                                            Password
                                        </label>
                                        <div class="col-md-6">
                                            <div class="input-group js-parent-focus">
                                                <input class="form-control js-child-focus js-visible-password"
                                                    name="password" type="password" value="" pattern=".{5,}"
                                                    required="">
                                                <span class="input-group-btn">
                                                    <button class="btn" type="button" data-action="show-password"
                                                        data-text-show="Show" data-text-hide="Hide">
                                                        Show
                                                    </button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-control-comment">

                                        </div>
                                    </div> --}}

                                    <div class="forgot-password">
                                        <a href="{{ route('password.forget') }}" rel="nofollow">
                                            Forgot your password?
                                        </a>
                                    </div>
                                </section>


                                <footer class="form-footer text-sm-center clearfix">
                                    <input type="hidden" name="submitLogin" value="1">
                                    <button id="submit-login" class="btn btn-primary" data-link-action="sign-in"
                                        type="submit">
                                        Sign in
                                    </button>
                                </footer>
                            </form>
                        </section>
                        <hr>

                        <div style="text-align: center; margin-bottom: 10px;">

                            <a href="{{ route('customer.register.facebook') }}"
                                class="btn btn-primary text-center">Continue with Facebook</a>

                        </div>

                        <div class="no-account">
                            <a href="{{ route('customer.registration') }}" data-link-action="display-register-form">
                                No account? Create one here
                            </a>
                        </div>
                    </section>

                    <footer class="page-footer">

                        <!-- Footer content -->

                    </footer>
                </section>
            </div>
        </div>
    </div>

</div>

@endsection


@section('custom-js')
<script>
    function toggleShowHide() {

        const EyeSlash = "fa fa-eye-slash";
        const Eye = "fa fa-eye";


        const passwordEl = document.getElementById('password');
        const eyeconEl = document.getElementById('eyecon');

        const passwordElInputType = passwordEl.getAttribute('type');

        if(passwordElInputType == 'password'){
            passwordEl.setAttribute('type', 'text');
            eyeconEl.setAttribute('class', Eye);
        }else{
            passwordEl.setAttribute('type', 'password');
            eyeconEl.setAttribute('class', EyeSlash);
        }

    }
</script>
@endsection
