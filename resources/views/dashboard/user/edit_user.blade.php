@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('user.update', $data->user) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
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
                                        placeholder="Enter name" value="{{ $data->user->name }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">User Name</label>
                                    <input class="form-control" name="username" id="username" type="text"
                                        placeholder="Enter username" value="{{ $data->user->email }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Roles</label>
                                    <select class="form-control select2" name="roles[]" id="roles">
                                        @foreach ($data->roles as $role)
                                        <option value="{{ $role->name }}" @if (in_array($role->name, $data->user_roles))
                                            selected
                                            @endif
                                            >{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- @if (!Auth::user()->hasRole(['Software Admin'])) --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch">Business Wing</label>
                                    <select class="form-control select2" name="branch[]" id="branch" multiple>
                                        @foreach ($data->branches as $branch)
                                        <option value="{{ $branch->id }}" @if (in_array($branch->id,
                                            $data->user->userBranches->pluck('branch_id')->toArray()))
                                            selected
                                            @endif
                                            >{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project">Project</label>
                                    <select class="form-control select2" name="project[]" id="project" multiple>
                                        @foreach ($data->projects as $project)
                                        <option value="{{ $project->id }}"
                                            @if (in_array($project->id,
                                            $data->user->userProjects->pluck('project_id')->toArray()))
                                            selected
                                            @endif
                                            >{{ $project->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- @endif --}}

                            @if (Auth::user()->hasRole(['Software Admin']))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <select class="form-control select2" name="company" id="company">
                                        <option value="">Select Company</option>
                                        @foreach ($data->companies as $company)
                                        <option value="{{ $company->id }}" @if ($company->id == $data->user->company_id)
                                            selected
                                            @endif
                                            >{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <select class="form-control select2" name="unit[]" id="unit" multiple>
                                        @foreach ($data->units as $unit)
                                        <option value="{{ $unit->id }}"
                                            @if (in_array($unit->id,
                                            $data->user->usersUnit->pluck('unit_id')->toArray()))
                                            selected
                                            @endif
                                            >{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="photo">Photo</label>
                                    <input class="form-control" name="photo" id="photo" type="file">

                                    <input type="hidden" name="old_photo" value="{{ $data->user->photo }}">
                                </div>

                                <img style="width: 50%; height: 300px;" src="{{ asset('storage/user/'. $data->user->photo) }}" alt="">
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
                <div class="col-md-4 offset-md-8">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection
