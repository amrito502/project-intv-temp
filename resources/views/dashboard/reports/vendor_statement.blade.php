@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')


<div class="tile mb-3">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- <button onclick="window.history.back()" type="button" type="button"
                        class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button> --}}
                    <h3 class="text-center text-uppercase">{{ $data->title }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">

            <form action="" method="get">

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vendor">Vendor</label>
                            <select name="vendor" id="vendor" class="select2" required>
                                <option value="">Select Vendor</option>
                                @foreach ($data->vendors as $vendor)
                                <option value="{{ $vendor->id }}" @if (request()->vendor == $vendor->id)
                                    selected
                                    @endif
                                    >{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="project">Project</label>
                            <select name="project" id="project" class="select2" required>
                                <option value="">Select Project</option>
                                @foreach ($data->projects as $project)
                                <option value="{{ $project->id }}" @if (request()->project == $project->id)
                                    selected
                                    @endif
                                    >{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="text" class="form-control datepicker" id="start_date" name="start_date"
                                autocomplete="off" value="{{ $data->filters['start_date'] }}" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="text" class="form-control datepicker" id="end_date" name="end_date"
                                autocomplete="off" value="{{ $data->filters['end_date'] }}" required>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary mb-2" name="search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            Search
                        </button>
                        <a target="_blank" href="{{ route('vendorStatement.print', request()->all()) }}"
                            class="btn btn-primary mb-2" name="search">
                            <i class="fa fa-print" aria-hidden="true"></i>
                            Print
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>


<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12" style="overflow-y: auto">

                   @include('dashboard.reports.partials.vendor_statement.vendor_statement_table')

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
