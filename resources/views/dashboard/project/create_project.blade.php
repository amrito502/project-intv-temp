@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('project.store') }}">
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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_type">Project Type</label>
                            <select name="project_type" id="project_type" class="select2" required>
                                <option value="">Select Project Type</option>
                                <option value="tower">Tower</option>
                                <option value="factory_shade">Factory Shade</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_code">Project Code</label>
                            <input class="form-control" name="project_code" id="project_code" type="text"
                                placeholder="Enter code" value="{{ old('project_code') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_name">Project Name</label>
                            <input class="form-control" name="project_name" id="project_name" type="text"
                                placeholder="Enter name" value="{{ old('project_name') }}">
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-8">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch">Branch</label>
                                    <select name="branch" id="branch" class="select2" required>
                                        <option value="">Select Branch</option>
                                        @foreach ($data->branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            @if (old('branch') == $branch->id)
                                                selected
                                            @endif
                                            >{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_person_phone">Contact Phone</label>
                                    <input class="form-control" name="contact_person_phone" id="contact_person_phone"
                                        type="text" placeholder="Enter Contact Person Phone" value="{{ old('contact_person_phone') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Project Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="6" required>{{ old('projectaddress_code') }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact_person_name">Contact Name</label>
                                    <input class="form-control" name="contact_person_name" id="contact_person_name" type="text"
                                        placeholder="Enter Contact Person Name" value="{{ old('contact_person_name') }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="units">Unit</label>
                                    <select name="units[]" id="units" class="select2" multiple>
                                        @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @include('dashboard.layouts.partials.company_dropdown', [
                                'columnClass'=> 'col-md-12',
                                'company_id' => 0,
                                ])

                            <div class="col-md-6 tower_only d-none">
                                <div class="form-group">
                                    <label for="number_of_tower">Tower Qty</label>
                                    <input class="form-control" name="number_of_tower" id="number_of_tower" type="text"
                                        placeholder="Tower Qty">
                                </div>
                            </div>

                            <div class="col-md-6 tower_only d-none">
                               <button type="button" class="btn btn-primary" id="generate_tower_btn" style="margin-top: 29px;">Generate</button>
                            </div>

                        </div>
                    </div>

                </div>

                <div id="tower_name_parent" class="row">

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

        // toggle tower generator inputs
        $('#project_type').change(function (e) {
            e.preventDefault();

            let tower_only_els = $('.tower_only');

            let project_type = $(this).val();

            if(project_type == 'tower'){
                tower_only_els.removeClass('d-none');
            }else{
                tower_only_els.addClass('d-none');
                $('#tower_name_parent').html('');
            }

        });

        // generate number of towers
        $('#generate_tower_btn').click(function (e) {
            e.preventDefault();
            const tower_name_parent = $('#tower_name_parent');
            const number_of_towers = $('#number_of_tower').val();

            let input = "";

            for (let index = 0; index < number_of_towers; index++) {

                input += `
                        <div class="col-md-4 mt-3">
                            <label for="">Tower Name</label>
                            <input type="text" name="tower_name[]" class="form-control" id="tower_name">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="">Tower Type</label>
                            <input type="text" name="tower_type[]" class="form-control" id="tower_type">
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="">Soil Category</label>
                            <input type="text" name="soil_category[]" class="form-control" id="soil_category">
                        </div>

                        `;

            }

            tower_name_parent.html(input);

        });

    });
</script>
@endsection
