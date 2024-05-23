@extends('dashboard.layouts.app')


@section('custom-css')
<link rel="stylesheet" href="{{ asset('css/plugin/magnific_popup/magnific_popup.css') }}">
@endsection

@section('content')
@include('dashboard.layouts.partials.error')

<div class="tile mb-3">
    <div class="tile-body">
        <div class="">
            <div class="row">
                <div class="col-md-2">
                    <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                    </button>
                </div>
                <div class="col-md-8">
                    <h2 class="h2 text-center text-uppercase">Gallery Images ({{ $data->gallerydate->date }})</h2>
                </div>
                @can('create gallery')
                <div class="col-md-2">
                    <a href="{{ route('gallerydateimages.create', $data->gallerydate->id) }}" class="btn btn-info"><i
                            class="fa fa-plus" aria-hidden="true"></i>
                        Create</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="">
            <div class="row">

                @foreach ($data->images as $image)
                <div class="col-md-2 col-sm-4 col-6 text-center mt-4" id="gallery-{{ $image->id }}">
                    <div class="logoDiv">
                        <a href="{{ asset('storage/gallery_image/' . $image->image) }}" class="popup_image">
                            <img src="{{ asset('storage/gallery_image/' . $image->image) }}"  style="height:170px;width:100%" alt="">
                        </a>
                    </div>
                    <div class="nameDiv">{{ $image->information }}</div>
                    <div class="buttonsDiv">
                        <a href="{{ route('gallerydate.edit', [$data->gallerydate->id, $image->id]) }}">Edit</a> |
                        <a href="#" onclick='deleteRow({{ $image->id }})'>Delete</a>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>

@endsection


@section('custom-script')

<script src="{{ asset('css/plugin/magnific_popup/magnific_popup.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.popup_image').magnificPopup({
            type:'image',
            gallery:{enabled:true}
    });
    });
</script>

<script>
    function deleteRow(id) {
        let trEl = document.getElementById(id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('gallerydateimages.destroy', id))
            .then(function (response) {
                location.reload();
            })
            .catch(function (error) {
            })

            trEl.remove();
        }
    }
</script>
@endsection
