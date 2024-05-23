@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('project.update', $data->project->id) }}" method="POST">
    @csrf
    @method('patch')

    <div class="tile mb-3">
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
                            <select name="project_type" id="project_type" class="select2" disabled>
                                <option value="">Select Project Type</option>
                                <option value="tower" @if ($data->project->project_type == 'tower')
                                    selected
                                    @endif>Tower</option>
                                <option value="factory_shade" @if ($data->project->project_type == 'factory_shade')
                                    selected
                                    @endif>Factory Shade</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_code">Project Code</label>
                            <input class="form-control" name="project_code" id="project_code" type="text"
                                value="{{ $data->project->project_code }}" placeholder="Enter code">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="project_name">Project Name</label>
                            <input class="form-control" name="project_name" id="project_name"
                                value="{{ $data->project->project_name }}" type="text" placeholder="Enter name">
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
                                        <option value="{{ $branch->id }}" @if ($branch->id == $data->project->branch_id)
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
                                        value="{{ $data->project->contact_person_phone }}" type="text"
                                        placeholder="Enter Contact Person Phone">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Project Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="6" required>{{
                                        $data->project->address }}</textarea>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-4">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="contact_person_name">Contact Name</label>
                                    <input class="form-control" name="contact_person_name" id="contact_person_name"
                                        value="{{ $data->project->contact_person_name }}" type="text"
                                        placeholder="Enter Contact Person Name">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="units">Unit</label>
                                    <select name="units[]" id="units" class="select2" multiple>
                                        @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}" @if (in_array($unit->id,
                                            $data->projectUnits->pluck('unit_id')->toArray()))
                                            selected
                                            @endif
                                            >{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass'=> 'col-md-12',
                            'company_id' => $data->project->company_id,
                            ])

                            <div class="col-md-8 tower_only d-none">
                                <div class="form-group">
                                    <label for="number_of_tower">Tower Qty</label>
                                    <input class="form-control" name="number_of_tower" id="number_of_tower" type="text"
                                        placeholder="Tower Qty" value="{{ $data->project_towers->count() }}">
                                </div>
                            </div>

                            <div class="col-md-4 tower_only d-none">
                                <button type="button" class="btn btn-primary" id="generate_tower_btn"
                                    style="margin-top: 29px;">More</button>
                            </div>

                        </div>

                    </div>

                </div>

                <div id="tower_name_parent" class="row">
                    @foreach ($data->project_towers as $tower)
                    <div class="col-md-3 mt-3 tower_{{ $tower->id }}">
                        <label for="">Tower Name</label>
                        <input type="text" name="tower_name[{{ $tower->id }}]" class="form-control" id="tower_name"
                            value="{{ $tower->name }}">
                    </div>

                    <div class="col-md-4 mt-3 tower_{{ $tower->id }}">
                        <label for="">Tower Type</label>
                        <input type="text" name="tower_type[{{ $tower->id }}]" class="form-control" id="tower_type"
                            value="{{ $tower->type }}">
                    </div>

                    <div class="col-md-4 mt-3 tower_{{ $tower->id }}">
                        <label for="">Soil Category</label>
                        <input type="text" name="soil_category[{{ $tower->id }}]" class="form-control"
                            id="soil_category" value="{{ $tower->soil_category }}">
                    </div>

                    <div class="col-md-1 mt-3 tower_{{ $tower->id }}" onclick="removeTower('{{ $tower->id }}')">
                        <button type="button" class="btn btn-danger" style="margin-top: 29px;margin-left: 10px;">
                            <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                        </button>
                    </div>
                    @endforeach
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
    function toggleTowerInput() {
        let tower_only_els = $('.tower_only');

        let project_type = $('#project_type').val();

        if(project_type == 'tower'){
            tower_only_els.removeClass('d-none');
        }else{
            tower_only_els.addClass('d-none');
            $('#tower_name_parent').html('');
        }
    }


    function removeTower(id) {

        $('.tower_'+id).remove();

    }

    $(document).ready(function () {

        toggleTowerInput();

        // toggle tower generator inputs
        $('#project_type').change(function (e) {
            e.preventDefault();

            toggleTowerInput();

        });

        // generate number of towers
        $('#generate_tower_btn').click(function (e) {
            e.preventDefault();
            const tower_name_parent = $('#tower_name_parent');
            const number_of_towers = $('#number_of_tower').val();

            let input = "";

            for (let index = 0; index < number_of_towers; index++) {

                let random = Math.round(Math.random() * 100000 + 100);

                input += `
                        <div class="col-md-3 mt-3">
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
                        <div class="col-md-1 mt-3 tower_${random}"  onclick="removeTower(${random})">
                            <button type="button" class="btn btn-danger" style="margin-top: 29px;margin-left: 10px;">
                            <i class="fa fa-trash" aria-hidden="true" style="font-size: 20px"></i>
                        </button>
                        </div>
                        `;

            }

            tower_name_parent.append(input);

        });

    });
</script>
@endsection
