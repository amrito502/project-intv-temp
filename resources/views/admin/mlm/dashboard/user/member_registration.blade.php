@extends('admin.layouts.master')

@section('custom-css')
<style>
    ul {
        list-style: none;
    }

    /* .select2 {
        width: 100% !important;
    }

    .select2-container {
        width: 100% !important;
    }

    .select2-selection {
        overflow: hidden;
    }

    .select2-selection__rendered {
        white-space: normal;
        word-break: break-all;
    } */
</style>
@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
        </div>
    </div>

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter name" autocomplete="off" value="{{ old('name') }}">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-danger" placeholder="Email"
                                        name="email">
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Refference</label>
                                    <select class="form-control select2" name="referrence" id="referrence"
                                        required>
                                        <option value="">Select an Option</option>
                                        @foreach ($data->referrals as $referral)

                                        <option value="{{ $referral->id }}" @if ($referral->id == Auth::user()->id)
                                            selected
                                            @endif

                                            @if (old('referrence') == $referral->id)
                                            selected
                                            @endif
                                            >{{ $referral->username }}</option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Placement</label>
                                    <select class="form-control select2" name="referral" id="referral"
                                        required>
                                        <option value="">Select an Option</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Position</label>
                                    <select class="form-control select2" name="hand_id" id="hand_id" required>
                                        @for ($i = 1; $i <= $data->businessSettings->person_per_level; $i++)
                                            <option value="{{ $i }}">{{ $data->businessSettings->hand_name }} {{ $i }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username">UserName</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="username" id="username" type="text"
                                        placeholder="Username" autocomplete="off" value="{{ old('username') }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="password" id="password" type="password"
                                        placeholder="Enter password" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label> <span
                                        class="text-danger">*</span>
                                    <input class="form-control" name="password_confirmation" id="password_confirmation"
                                        type="password" placeholder="Enter password again" autocomplete="off" required>
                                </div>
                            </div>


                            <input type="hidden" name="roles[]" value="3">


                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profile_img">Profile Image</label>
                                    <input class="form-control" name="profile_img" id="profile_img" type="file"
                                        autocomplete="off">
                                </div>
                            </div>

                            @if (in_array(auth()->user()->role, [1, 2, 6, 7]))
                            <div class="col-md-4">
                                <div class="row mt-5">

                                    <div class="col-md-6">
                                        <div class="form-group mr-5">
                                            <input type="checkbox" class="investor" name="investor" value="investor">
                                            &nbsp;
                                            <label for="investor">Investor</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mr-5">
                                            <input type="checkbox" class="operator" name="operator" value="operator">
                                            &nbsp;
                                            <label for="operator">Operator</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Register
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('custom-js')

<script>
    $(document).ready(function () {
        $('.select2').select2({ width: '100%' });
    });
</script>

<script>
    function referenceWiseReferral() {
    let ReferenceId = $('#referrence').val();

    // in placement dropdown
    $.ajax({
        type: "get"
        , url: "{{route('getReferralReference')}}"
        , data: {
            ReferenceId: ReferenceId
        }
        , success: function(response) {
            $('#referral').html('');
            $('#referral').append(`<option value="">Select Option</option>`);

            response.forEach(function(item, index) {
                let option = `<option value="${item.id}">${item.username}</option>`;
                $('#referral').append(option);

                $('.select2').select2({ width: '100%' });

                // $('.select2').chosen();
                // $('.select2').trigger("chosen:updated");
            });

        }
        , error: function(response) {

        }
    });

    // in reference dropdown
}

    $(document).ready(function() {
        referenceWiseReferral();
        $('#referrence').change(function() {
            referenceWiseReferral();
        });

        $('#referral').change(function(e) {
            e.preventDefault();
            let ReferenceId = $(this).val();
            // regenarate options
            $('#hand_id').html('');
            for (let index = 1; index < 4; index++) {
                let option = `<option value="${index}">{{ $data->businessSettings->hand_name }} ${index} </option>`;
                $('#hand_id').append(option);

                $('.select2').select2({ width: '100%' });

                // $('.select2').chosen();
                // $('.select2').trigger("chosen:updated");
            }

            $.ajax({
                type: "get"
                , url: "{{route('getReferenceHands')}}"
                , data: {
                    ReferenceId: ReferenceId
                }
                , success: function(response) {
                    response.forEach(function(item, index) {
                        $('#hand_id option[value="' + item + '"]').remove();

                        $('.select2').select2({ width: '100%' });

                        // $('.select2').chosen();
                        // $('.select2').trigger("chosen:updated");
                    });

                }
                , error: function(response) {

                }
            });
        });
    });

</script>
@endsection
