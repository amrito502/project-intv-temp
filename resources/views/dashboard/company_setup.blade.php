@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 text-left">
                    <button onclick="window.history.back()" type="button" type="button"
                        class="btn btn-info mb-1">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>

                </div>

                <div class="col-md-8">
                    <h3 class="text-center text-uppercase">Company Setup</h3>
                </div>

                <div class="col-md-2 text-right">
                    <a href="{{ route('company.edit', $data->company->id) }}" class="btn btn-info float-right">
                        <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="row">
                        <table class="table table-borderless table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="6">Company Information</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <th width="200px">Name</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->name }}</td>
                                </tr>
                                <tr>
                                    <th width="200px">Prefix</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->prefix }}</td>
                                </tr>
                                <tr>
                                    <th width="200px">Contact Person Name</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->contact_person_name }}</td>
                                </tr>
                                <tr>
                                    <th width="200px">Phone</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->phone }}</td>
                                </tr>
                                <tr>
                                    <th width="200px">Email</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->name }}</td>
                                </tr>
                                <tr>
                                    <th width="200px">Address</th>
                                    <td width="20px">:</td>
                                    <td>{{ $data->company->address }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
