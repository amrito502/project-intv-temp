@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')
<div class="container mb-3">
    <div class="row">
        <div class="col-md-12">
            <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
            </button>
            <h3 class="text-center">Change User Password - ({{ $user->name }})</h3>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ route('changepassword', $user) }}" method="POST">
                        @csrf

                        {{-- <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input class="form-control" name="old_password" id="old_password" type="password"
                                        placeholder="Enter Old password">
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="input-group mb-3">
                                    <input type="password" id="password" class="form-control" placeholder="password"
                                        name="password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i onclick="toggleShowHide2()" id="eyecon" class="fa fa-eye-slash"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="input-group mb-3">
                                    <input type="password" id="password_confirmation" class="form-control" placeholder="Enter password again"
                                        name="password_confirmation" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">
                                            <i onclick="toggleShowHide()" id="eyecon2" class="fa fa-eye-slash"
                                                aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4 offset-md-8 mt-4">
                                <button class="btn btn-success mt-2 float-right">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@csrf
@endsection

@section('custom-script')

<script>
    function toggleShowHide() {

        const EyeSlash = "fa fa-eye-slash";
        const Eye = "fa fa-eye";


        const passwordEl = document.getElementById('password_confirmation');
        const eyeconEl = document.getElementById('eyecon2');

        const passwordElInputType = passwordEl.getAttribute('type');

        if(passwordElInputType == 'password'){
            passwordEl.setAttribute('type', 'text');
            eyeconEl.setAttribute('class', Eye);
        }else{
            passwordEl.setAttribute('type', 'password');
            eyeconEl.setAttribute('class', EyeSlash);
        }

    }

    function toggleShowHide2() {

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
