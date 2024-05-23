@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')


<form action="{{ route('gallerydateimages.update', [$data->gallerydate, $data->gallerydateimage->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="tile mb-3">
        <div class="tile-body">
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center text-uppercase">Edit Gallery Image</h3>
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
                            <input type="file" class="form-control" name="image" id="image">
                        </div>

                        <input type="hidden" name="old_image" value="{{ $data->gallerydateimage->image }}">


                        <img style="width: 100px; height:100px;" src="{{ asset("storage/gallery_image/" . $data->gallerydateimage->image) }}" alt="">
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="information">Information</label>
                            <textarea class="form-control" name="information" id="information" rows="7" required>{{
                                $data->gallerydateimage->information }}</textarea>
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

@endsection

@section('custom-script')
<script>
    $(document).ready(function () {


            let parentValue = $('#parent_id').val();

            if(parentValue != ''){
            $('#action_menu').show();
            }else{
            $('#action_menu').hide();
            }


            $('#parent_id').change(function (e) {
                e.preventDefault();

                let parentValue = $(this).val();

                if(parentValue != ''){
                    $('#action_menu').show();
                }else{
                    $('#action_menu').hide();
                }

            });

        });
</script>
@endsection
