@extends('admin.layouts.master')

@section('custom-css')
<style>
    ul {
        list-style: none;
    }

</style>
@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-title">{{ $data->title }}</h4>
            </div>
            <div class="col-md-6">
                <span class="shortlink">
                    <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg" href="{{ route($goBackLink) }}">
                        <i class="fa fa-arrow-circle-left"></i> Go Back
                    </a>
                </span>
            </div>
        </div>
    </div>


    <form action="{{ route('notice.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input class="form-control" name="description" id="description" type="text">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="roles">Roles</label>
                        <select class="chosen-select" name="roles[]" id="roles" multiple>
                            @foreach ($data->roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer">
            <div class="row">
                <div class="col-md-2 offset-md-10">
                    <button class="btn btn-success float-right">
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
