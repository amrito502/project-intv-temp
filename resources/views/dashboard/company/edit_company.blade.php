@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('company.update', $data->company->id) }}" method="POST">
    @csrf
    @method('patch')

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center text-uppercase">Edit Company</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input class="form-control" name="name" id="name" type="text" placeholder="Enter name"
                                value="{{ $data->company->name }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="prefix">Company Prefix</label>
                            <input class="form-control" name="prefix" id="prefix" type="text" placeholder="Enter Prefix" value="{{ $data->company->prefix }}" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_name">Contact Person Name</label>
                            <input class="form-control" name="contact_person_name" id="contact_person_name" type="text"
                                placeholder="Enter Contact Person Name" value="{{ $data->company->contact_person_name }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control" name="phone" id="phone" type="text"
                                placeholder="Enter Contact Person Phone" value="{{ $data->company->phone }}">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Company Logo</label>
                            <input class="form-control" name="logo" id="logo" type="file">

                            <input name="old_logo" id="old_logo" type="hidden" value="{{ $data->company->logo}}">

                        </div>


                        <img class="img-fluid" src="{{ asset('storage/company/' . $data->company->logo) }}" alt="">
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" name="email" id="email" type="text" placeholder="Enter email" value="{{ $data->company->email }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input class="form-control" name="website" id="website" type="text" placeholder="Enter website" value="{{ $data->company->website }}">
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="7">{{ $data->company->address }}</textarea>
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

@endsection

@section('custom-script')
<script>
    $(document).ready(function () {


            let parentValue = $('#parent_id').val();

            if(parentValue != ''){
            $('#action_menu').show();
            }else{
            $('#action_menu').hide();
            }


            $('#parent_id').change(function (e) {
                e.preventDefault();

                let parentValue = $(this).val();

                if(parentValue != ''){
                    $('#action_menu').show();
                }else{
                    $('#action_menu').hide();
                }

            });

        });
</script>
@endsection
