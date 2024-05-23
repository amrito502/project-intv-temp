@extends('layouts.login_app')

@section('content')
<div class="container" style="margin-top: 140px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card text-light" style="background: none">

            <div class="card-body py-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Username</label>

                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">

                            <div class="input-group mb-3">
                                <input type="password" id="password" class="form-control" placeholder="password"
                                    name="password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">
                                        <i onclick="toggleShowHide()" id="eyecon" class="fa fa-eye-slash"
                                            aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>


                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>



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
