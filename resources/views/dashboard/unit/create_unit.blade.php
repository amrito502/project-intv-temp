@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('unit.store') }}">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Create Unit</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Create Unit</h3>
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
                        'columnClass'=> 'col-md-6',
                        'company_id' => 0,
                    ])

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="code">Unit Code</label>
                            <input class="form-control" name="code" id="code" type="text" placeholder="Enter code">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Unit Name</label>
                            <input class="form-control" name="name" id="name" type="text" placeholder="Enter name">
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

@endsection
