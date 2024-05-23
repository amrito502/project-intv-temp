@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')
<div class="container mb-3">
    <div class="row">
        <div class="col-md-12">
            <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
            </button>
            <h3 class="text-center text-uppercase">Change User Password - ({{ $user->name }})</h3>
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input class="form-control" name="old_password" id="old_password" type="password"
                                        placeholder="Enter Old password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="password" id="password" type="password"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" id="password_confirmation"
                                        type="password" placeholder="Enter password again">
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
