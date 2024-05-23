@extends('admin.layouts.master')


@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            
            <span class="shortlink">
                <a class="btn btn-info" href="{{ route('users.index') }}">Go Back</a>
                <a class="btn btn-success" href="{{ route('user.edit', $users->id) }}">Edit</a>
                <a class="btn btn-outline-danger" href="{{ route('withdraw.settings') }}">Withdraw Settings</a>
            </span>

            <div class="card-body">

                <h4 class="card-title">My Profile</h4>

                <div id="addNewProduct" class="">

                    <div class="modal-body">
                        <div class="form-group row {{ $errors->has('parent') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">User
                                Role</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-danger" placeholder="Name"
                                    name="name" value="{{ $userRoles->name }}" required readonly>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-danger" placeholder="Name"
                                    name="name" value="{{ $users->name }}" required readonly>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control form-control-danger" placeholder="Email"
                                    name="email" value="{{ $users->email }}" required readonly>
                            </div>
                        </div>

                        <div class="form-group row {{ $errors->has('username') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">User
                                Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-danger" placeholder="User Name"
                                    name="username" value="{{ $users->username }}" required readonly>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

@endsection
