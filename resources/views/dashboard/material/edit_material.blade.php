@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('material.update', $data->material->id) }}" method="POST">
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

                    @include('dashboard.layouts.partials.company_dropdown', [
                        'columnClass'=> 'col-md-4',
                        'company_id' => $data->material->company_id,
                    ])

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="code">Material Code</label>
                            <input class="form-control" name="code" id="code" type="text"
                                placeholder="Enter Material Code" value="{{ $data->material->code }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Material Name</label>
                            <input class="form-control" name="name" id="name" type="text"
                                value="{{ $data->material->name }}" placeholder="Enter Material Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price">Material Unit</label>
                            <select name="unit" id="unit" class="select2" required>
                                <option value="">Select Unit</option>
                                @foreach ($data->units as $unit)
                                <option value="{{ $unit->id }}"
                                    @if ( $unit->id == $data->material->unit)
                                        selected
                                    @endif
                                    >{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 d-none">
                        <div class="form-group">
                            <label for="materialgroups">Material Groups</label>
                            <select name="materialgroup[]" id="materialgroup" class="select2" multiple>
                                @foreach ($data->materialgroups as $materialgroup)
                                <option value="{{ $materialgroup->id }}" @if (in_array($materialgroup->id,
                                    $data->materialsgroups->pluck('materialgroup_id')->toArray()))
                                    selected
                                    @endif
                                    >{{ $materialgroup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="budgetHead" @if ($data->material->budgetheadInfo())
                                checked
                            @endif id="budgetHead">
                            <label class="form-check-label" for="budgetHead">In BudgetHead</label>
                          </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="transportation_charge" id="transportation_charge" @if ($data->material->transportation_charge == 1)
                            checked
                            @endif>
                            <label class="form-check-label" for="transportation_charge">Transportation Charge</label>
                          </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="show_dashboard" id="show_dashboard"
                            @if ($data->material->show_dashboard == 1)
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="show_dashboard">Show Dashboard</label>
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
</script>
@endsection
