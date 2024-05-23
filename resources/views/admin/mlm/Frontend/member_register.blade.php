@extends('admin.mlm.Frontend.Layout.front_app')

@section('content')

<div class="bg-primary w-100" style="height: 100vh; background: url('{{ asset('refregister_bg.webp') }}')">

    <form action="{{ route('memberRegisterSave') }}" id="form" method="post" enctype="multipart/form-data">
        @csrf

        <div class="container" style="padding-top: 5%;">

            <div class="col-md-8 offset-md-2">

                @if( Session('user'))

                <div class="p-4 bg-light">
                    <h2 class="text-success">Congratulation!</h2>
                    <p>Please keep below infotmation for login</p>

                    <ul>
                        <li>Username: {{ Session('user')->username }}</li>
                        <li>Full Name: {{ Session('user')->name }}</li>
                        <li>Registration Date: {{ Session('user')->created_at->format('d-m-Y') }}</li>
                        <li>Mobile No: {{ Session('user')->mobile }}</li>
                        <li>Reference Id: {{ @Session('user')->refMember->username }}</li>
                    </ul>
                </div>

                @else
                <div class="card">

                    <div class="text-light bg-secondary text-center ch py-4 px-5">
                        <h2 class="mb-0">Health Heaven</h2>
                    </div>

                    <div class="cb bg-light px-3 py-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">UserName</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="username" id="username" type="text" placeholder="Username" autocomplete="off" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input class="form-control" name="name" id="name" type="text" placeholder="Enter name" autocomplete="off" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="profile_img">Profile Image</label>
                                    <input class="form-control" name="profile_img" id="profile_img" type="file" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="gender">Refference</label>
                                    <select class="form-control select2" name="referrence" id="referrence" required>
                                        <option value="">Select an Option</option>
                                        @foreach ($data->referrals as $referral)
                                        @if (request('uid') == $referral->id)
                                        <option value="{{ $referral->id }}" selected>{{ $referral->username }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Placement</label>
                                    <select class="form-control select2" name="referral" id="referral" required>
                                        <option value="">Select an Option</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
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


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="password" id="password" type="password" placeholder="Enter password" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label> <span class="text-danger">*</span>
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="Enter password again" autocomplete="off" required>
                                </div>
                            </div>

                        </div>



                    </div>

                    <div class="text-right cf py-4 px-3">
                        <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                    </div>

                </div>
                @endif


            </div>

        </div>

    </form>

</div>

@endsection

@section('custom-script')

<script>
    function referenceWiseReferral() {
        let ReferenceId = $('#referrence').val();

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
                });

            }
            , error: function(response) {

            }
        });

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
                    });

                }
                , error: function(response) {

                }
            });

        });
    });

</script>

@endsection
