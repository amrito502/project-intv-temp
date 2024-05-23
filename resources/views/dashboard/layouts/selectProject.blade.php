@extends('dashboard.layouts.app')

@section('custom-css')

@if (!Auth::user()->hasrole('Software Admin'))
@if (!cache('user_project_' . Auth::user()->id))
<style>
    .app-content {
        margin-left: 0 !important;
    }
</style>
@endif
@endif


@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<div class="conatiner">
    <div class="row">
        <div class="col-md-6 offset-md-3" style="margin-top: 100px;">
            <div class="tile mt-5">
                <div class="tile-body">
                    <div class="container-fluid">

                        <form action="{{ route('select.project.save') }}" method="post">
                            @csrf

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Select Project</label>
                                        <select name="project" class="select2" id="select2" required>
                                            <option value="">Select Project</option>
                                            @foreach ($data->projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right mt-5">
                                    <button class="btn btn-primary" type="submit">Go To System</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
