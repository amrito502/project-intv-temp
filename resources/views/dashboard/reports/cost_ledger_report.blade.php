@extends('dashboard.layouts.app')

@section('custom-css')
    <style>
        .heading-color-two th,
        .heading-color-three td {
            background-color: #9ad5c5 !important;
        }

        .heading-color-four th,
        .heading-color-four td {
            background-color: #5ec7e7 !important;
        }

        .footer-heading th {
            background-color: #000 !important;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    @include('dashboard.layouts.partials.error')

    <div class="d-print-none tile mb-3">
        <div class="tile-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center text-uppercase">{{ $data->title }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-print-none tile">
        <div class="tile-body">
            <div class="container-fluid">
                <form action="" method="get">
                    <div class="row">
                        @include('dashboard.layouts.partials.company_dropdown', [
                            'columnClass' => 'col-md-4',
                            'company_id' => request()->company,
                        ])

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date"
                                    value="{{ request()->start_date ? request()->start_date : $data->defaultDates['start_date'] }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date"
                                    value="{{ request()->end_date ? request()->end_date : $data->defaultDates['end_date'] }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="vendor">Vendor</label>
                                <select name="vendor" id="vendor" class="select2">
                                    <option value="">Select Vendor</option>
                                    @foreach ($data->vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            @if (request()->vendor) @if ($vendor->id == request()->vendor)
                                    selected @endif
                                            @endif
                                            >{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="project">Project</label>
                                <select name="project" id="project" class="select2" required>
                                    <option value="">Select Project</option>
                                    @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}"
                                            @if (request()->project) @if ($project->id == request()->project)
                                    selected @endif
                                            @endif
                                            >{{ $project->project_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="budgetHeads">Budget Head</label>
                                <select name="budgetHeads[]" id="budgetHeads" class="select2" multiple>
                                    @foreach ($data->budgetHeads as $budgetHead)
                                        <option value="{{ $budgetHead->id }}"
                                            @if (request()->budgetHeads) @if (in_array($budgetHead->id, request()->budgetHeads))
                                    selected @endif
                                            @endif
                                            >{{ $budgetHead->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">

                            <button type="submit" class="btn btn-primary mb-2" name="search">
                                <i class="fa fa-search" aria-hidden="true"></i>
                                Search
                            </button>

                            <a target="_blank" href="{{ route('cost.ledger.report.print', request()->all()) }}"
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

                        @if (request()->has('search'))

                            @include('dashboard.reports.partials.cost_ledger.cost_ledger_table')

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('custom-script')
@endsection