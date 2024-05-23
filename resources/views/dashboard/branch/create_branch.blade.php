@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('branch.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Create Branch</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Create Branch</h3>
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
                            <label for="branch_name">Branch Name</label>
                            <input class="form-control" name="branch_name" id="branch_name" type="text" value="{{ old('branch_name') }}" placeholder="Enter name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_name">Contact Person Name</label>
                            <input class="form-control" name="contact_person_name" id="contact_person_name" value="{{ old('contact_person_name') }}" type="text" placeholder="Enter Contact Person Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_phone">Contact Person Phone</label>
                            <input class="form-control" name="contact_person_phone" id="contact_person_phone" value="{{ old('contact_person_phone') }}" type="text" placeholder="Enter Contact Person Phone">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" rows="7">{{ old('address') }}</textarea>
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
