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
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 0px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route('users.index') }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @php
                $message = Session::get('msg');
                if (isset($message))
                {
                echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                        .$message."</strong></div>";
                }

                Session::forget('msg')
                @endphp

                <div id="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" action="{{ route('user.update', $users->id) }}" method="POST"
                            enctype="multipart/form-data" id="editUser" name="editUser">
                            {{ csrf_field() }}

                            @if( count($errors) > 0 )
                            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{
                                $errors->first() }}</div>
                            @endif

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>

                                <input type="hidden" name="userId" value="{{$users->id}}">

                                <div class="row">

                                    <div class="col-md-6 @if (auth()->user()->role == 3) d-none @endif">
                                        <div class="form-group {{ $errors->has('parent') ? ' has-danger' : '' }}">
                                            <label for="role">Role</label>
                                            <select class="form-control" name="role" required>
                                                <option value=""> Select Role</option>
                                                @foreach($userRoles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('parent'))
                                            @foreach($errors->get('parent') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Name" name="name" value="{{ $users->name }}" required>
                                            @if ($errors->has('name'))
                                            @foreach($errors->get('name') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control form-control-danger"
                                                placeholder="Email" name="email" value="{{ $users->email }}" required>
                                            @if ($errors->has('email'))
                                            @foreach($errors->get('email') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('username') ? ' has-danger' : '' }}">
                                            <label for="user-name">User Name</label>
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="User Name" name="username" value="{{ $users->username }}"
                                                required>
                                            @if ($errors->has('username'))
                                            @foreach($errors->get('username') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div
                                            class="form-group {{ $errors->has('profile_image') ? ' has-danger' : '' }}">
                                            <label for="profile_image">Profile Image</label>
                                            <input type="file" class="form-control form-control-danger"
                                                name="profile_image">
                                            @if ($errors->has('profile_image'))
                                            @foreach($errors->get('profile_image') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif

                                            <img src="{{ $users->profile_image() }}" class="img-fluid mt-5" alt="">

                                            <input type="hidden" name="old_image" value="{{ $users->profile_img }}">

                                        </div>
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type="text" class="form-control" name="mobile"
                                                value="{{ $users->mobile }}" autocomplete="off">
                                        </div>


                                        <div class="row mt-5">

                                            <div class="col-md-3">
                                                <div class="form-group mr-5">
                                                    <input type="checkbox" class="investor" name="investor"
                                                        value="investor" @if ($users->investor == 1) checked @endif> &nbsp;
                                                    <label for="investor">Investor</label>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group mr-5">
                                                    <input type="checkbox" class="operator" name="operator"
                                                        value="operator" @if ($users->operator == 1) checked @endif> &nbsp;
                                                    <label for="operator">Operator</label>
                                                </div>
                                            </div>

                                        </div>

                                    </div>




                                </div>
                            </div>
                        </form>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.forms['editUser'].elements['role'].value = "{{$users->role}}";
</script>

@endsection
