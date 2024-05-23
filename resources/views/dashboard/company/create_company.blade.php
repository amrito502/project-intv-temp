@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('company.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class=" mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center text-uppercase">Create Company</h3>
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
                            <input class="form-control" name="name" id="name" type="text" placeholder="Enter name" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="prefix">Company Prefix</label>
                            <input class="form-control" name="prefix" id="prefix" type="text" placeholder="Enter Prefix" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_name">Contact Person Name</label>
                            <input class="form-control" name="contact_person_name" id="contact_person_name" type="text" placeholder="Enter Contact Person Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input class="form-control" name="phone" id="phone" type="text" placeholder="Enter Contact Person Phone">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="username">UserName</label>
                            <input class="form-control" name="username" id="username" type="text" placeholder="Enter username">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Company Logo</label>
                            <input class="form-control" name="logo" id="logo" type="file">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" name="email" id="email" type="text" placeholder="Enter email">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input class="form-control" name="website" id="website" type="text" placeholder="Enter website">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="7"></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-success mt-2 float-right">
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

        $('#action_menu').hide();

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
