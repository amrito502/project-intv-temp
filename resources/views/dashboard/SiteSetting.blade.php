@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')


<form action="{{ route('site.setting') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" type="button"
                            class="btn btn-info float-left mb-1">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center text-uppercase">Site Setting</h3>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_name">WebSite Name</label>
                                    <input class="form-control" name="website_name" id="site_name" type="text"
                                        placeholder="Enter Site Name" value="{{ $data->settings->website_name }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="site_logo">Site Logo</label>
                                    <input class="form-control" name="site_logo" id="site_logo" type="file" name="logo">

                                    <input type="hidden" name="old_image" value="{{ $data->settings->website_logo }}">

                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="favicon_img">Favicon</label>
                                    <input class="form-control" name="favicon_img" id="favicon_img" type="file"
                                        name="favicon_img">

                                    <input type="hidden" name="old_favicon_img" value="{{ $data->settings->favicon_img }}">

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
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection
