@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


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
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">User Name</label>
                                    <input class="form-control" name="username" id="username" type="username"
                                        placeholder="Enter email">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input class="form-control" name="password" id="password" type="password"
                                        placeholder="Enter password">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input class="form-control" name="password_confirmation" id="password_confirmation"
                                        type="password" placeholder="Enter password again">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Roles</label>
                                    <select class="form-control select2" name="roles[]" id="roles">
                                        @foreach ($data->roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @if (Auth::user()->hasRole(['Software Admin']))

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <select class="form-control select2" name="company" id="company" disabled>
                                        <option value="">Select Company</option>
                                        @foreach ($data->companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch">Business Wing</label>
                                    <select class="form-control select2" name="branch[]" id="branch" multiple>
                                        @foreach ($data->branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project">Project</label>
                                    <select class="form-control select2" name="project[]" id="project" multiple>
                                        @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select class="form-control select2" name="unit[]" id="unit" multiple>
                                        @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input class="form-control" name="photo" id="photo" type="file">
                                </div>
                            </div>

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

@csrf
@endsection

@section('custom-script')
<script>
    $(function () {

            $('#roles').change(function (e) {
                e.preventDefault();

                const selectVal = $(this).val();

                if(selectVal == 'Software Admin'){
                    $('#company').attr('disabled', true);
                }else{
                    $('#company').attr('disabled', false);
                }

            });

        });
</script>
@endsection
