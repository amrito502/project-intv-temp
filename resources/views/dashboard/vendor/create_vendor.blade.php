@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('vendor.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-3">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center my-3 d-md-none d-block text-uppercase">{{ $data->title }}</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">{{ $data->title }}</h3>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success float-right">
                            <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    @include('dashboard.layouts.partials.company_dropdown', [
                    'columnClass'=> 'col-md-4',
                    'company_id' => 0,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="code">Vendor Code</label>
                            <input class="form-control" name="code" id="code" type="text" value="{{ old('code') }}" placeholder="Enter Vendor Code">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Vendor Name</label>
                            <input class="form-control" name="name" id="name" type="text" value="{{ old('name') }}" placeholder="Enter name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="vendor_type">Vendor Type</label>
                            <select name="vendor_type" id="vendor_type" class="form-control" required>
                                <option value="">Select Option</option>
                                <option value="Material Supplier">Material Supplier</option>
                                <option value="Working Associate">Working Associate</option>
                                <option value="Logistics Associate">Logistics Associate</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_name">Contact Name</label>
                            <input class="form-control" name="contact_person_name" id="contact_person_name" value="{{ old('contact_person_name') }}" type="text" placeholder="Enter Contact Person Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_phone">Contact Phone</label>
                            <input class="form-control" name="contact_person_phone" id="contact_person_phone" value="{{ old('contact_person_phone') }}" type="text" placeholder="Enter Contact Person Phone">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_person_email">Contact Email</label>
                            <input class="form-control" name="contact_person_email" id="contact_person_email" value="{{ old('contact_person_email') }}" type="text" placeholder="Enter Contact Person Email">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input class="form-control" name="address" id="address" value="{{ old('address') }}" type="text" placeholder="Enter Address">
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
