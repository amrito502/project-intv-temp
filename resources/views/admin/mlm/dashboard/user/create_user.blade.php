@extends('admin.mlm.dashboard.layouts.app')

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Create New User</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username">UserName</label>
                                    <input class="form-control" name="username" id="username" type="text"
                                        placeholder="Username" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter name" autocomplete="off">
                                </div>
                            </div>

                            <input name="email" id="email" type="hidden" placeholder="Enter email" autocomplete="off">

                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input class="form-control" name="email" id="email" type="email"
                                        placeholder="Enter email" autocomplete="off">
                                </div>
                            </div> --}}


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Roles</label>
                                    <select class="form-control select2" name="roles[]" id="roles" multiple>
                                        @foreach ($data->roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <input type="hidden" name="referral">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="password" id="password" type="password"
                                        placeholder="Enter password" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" id="password_confirmation"
                                        type="password" placeholder="Enter password again" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profile_img">Profile Image</label>
                                    <input class="form-control" name="profile_img" id="profile_img" type="file"
                                        autocomplete="off">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>

@csrf
@endsection
