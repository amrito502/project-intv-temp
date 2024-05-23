@extends('admin.layouts.master')

@section('custom-css')
<style>
    ul {
        list-style: none;
    }
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

    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <input type="hidden" name="dealerEdit" value="1">
        <input type="hidden" name="userId" value="{{ $data->member->id }}">

        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter name" autocomplete="off" value="{{ $data->member->name }}">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" value="{{ $data->member->mobile }}"
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <label for="email">Email</label>
                                    <input type="email" value="{{ $data->member->email }}" class="form-control form-control-danger" placeholder="Email"
                                        name="email">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="username">UserName</label> <span class="text-danger">*</span>
                                    <input value="{{ $data->member->username }}" class="form-control" name="username" id="username" type="text"
                                        placeholder="Username" autocomplete="off"
                                        required>
                                </div>
                            </div>


                            <div class="col-md-4 mt-5">

                                <div class="d-flex">
                                    <div class="form-group mr-5">
                                        <input type="radio" class="founder_or_agent" name="founder_or_agent"
                                            value="Founder"> &nbsp;
                                        <label for="mobile">Is Dealer</label>
                                    </div>


                                    <div class="form-group">
                                        <input type="radio" class="founder_or_agent" name="founder_or_agent"
                                            value="Agent"> &nbsp;
                                        <label for="mobile">Is Agent</label>
                                    </div>
                                </div>

                            </div>


                            <div class="col-md-4">

                                <div class="form-group agent_inputs dealer_input">
                                    <label for="district">District</label>
                                    <select class="form-control select2" name="district" id="district">
                                        <option value="">Select An District</option>
                                        @foreach ($data->districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group agent_inputs">
                                    <label for="thana">Thana</label>
                                    <select class="form-control select2" name="thana" id="thana">
                                        <option value="">Select District First</option>
                                    </select>
                                </div>

                            </div>

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

    $(document).ready(function() {
        // fetch district wise thana
        $('#district').change(function(e) {
            e.preventDefault();

            let districtId = $(this).val();
            $.ajax({
                type: "get"
                , url: "{{route('getDistrictWiseThanas')}}"
                , data: {
                    districtId: districtId
                }
                , success: function(response) {
                    $('#thana').html('');
                    response.forEach(function(item, index) {
                        let option = `<option value="${item.id}">${item.name}</option>`;
                        $('#thana').append(option);

                        $('.chosen-select').chosen();
                        $('.chosen-select').trigger("chosen:updated");
                    });

                }
                , error: function(response) {

                }
            });

        });


        $('.agent_inputs').hide();
        $('.dealer_input').hide();

        $('.founder_or_agent').click(function(e) {

            let val = $(this).val();

            if (val == 'Founder') {
                $('.agent_inputs').hide();
                $('.dealer_input').show();

            } else {
                $('.dealer_input').hide();
                $('.agent_inputs').show();
            }

        });
    });

</script>
@endsection
