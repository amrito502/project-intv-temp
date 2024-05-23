@extends('dashboard.layouts.app')

@section('content')

<form method="POST" action="{{ route('gallerydateimages.store', $data->gallerydate->id) }}" enctype="multipart/form-data">
    @csrf

    <div class="tile">
        <div class="tile-body">
            <div class=" mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center text-uppercase">Create Gallery Image</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="">

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="images[]" id="image" multiple required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="information">Information</label>
                            <textarea class="form-control" name="information" id="information" rows="7" required></textarea>
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
