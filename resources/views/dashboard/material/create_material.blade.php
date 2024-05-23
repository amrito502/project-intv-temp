@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('material.store') }}">
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
                            <label for="code">Material Code</label>
                            <input class="form-control" name="code" id="code" value="{{ old('code') }}" type="text" placeholder="Enter Material Code">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Material Name</label>
                            <input class="form-control" name="name" id="name" value="{{ old('name') }}" type="text" placeholder="Enter Material Name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price">Material Unit</label>
                            <select name="unit" id="unit" class="select2" required>
                                <option value="">Select Unit</option>
                                @foreach($data->units as $unit)
                                <option value="{{ $unit->id }}"
                                    @if ($unit->id == old('unit'))
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
                                <option value="{{ $materialgroup->id }}">{{ $materialgroup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="budgetHead" @if (old('budgetHead'))
                                checked
                            @endif id="budgetHead">
                            <label class="form-check-label" for="budgetHead">In BudgetHead</label>
                          </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="transportation_charge" id="transportation_charge"
                            @if (old('transportation_charge'))
                                checked
                            @endif
                            >
                            <label class="form-check-label" for="transportation_charge">Transportation Charge</label>
                          </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-check" style="margin-top: 29px;">
                            <input type="checkbox" class="form-check-input" name="show_dashboard" id="show_dashboard"
                            @if (old('show_dashboard'))
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
</script>
@endsection
