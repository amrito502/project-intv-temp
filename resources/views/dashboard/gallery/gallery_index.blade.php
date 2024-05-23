@extends('dashboard.layouts.app')

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
                    <h2 class="h2 text-center text-uppercase">Gallery List</h2>
                </div>
                {{-- @can('create gallery')
                <div class="col-md-2 text-right">
                    <a href="{{ route('gallery.create') }}" class="btn btn-info"><i class="fa fa-plus"
                            aria-hidden="true"></i>
                        Create</a>
                </div>
                @endcan --}}
            </div>
        </div>
    </div>
</div>

<div class="tile">
    <div class="tile-body">
        <div class="">
            <div class="row">

                @foreach ($data->galleries as $gallery)
                <div class="col-md-2 col-sm-4 col-6 text-center mt-4" id="gallery-{{ $gallery->id }}">
                    <a href="{{ route('galleryDates.index', $gallery->id) }}">
                        <div class="logoDiv">
                            <i class="fa fa-folder FolderIconCss" aria-hidden="true"></i>
                        </div>
                        <div class="nameDiv">{{ $gallery->title }}</div>
                    </a>
                    {{-- <div class="buttonsDiv">
                        <a href="{{ route('galleryDates.index', $gallery->id) }}">View</a>
                    </div> --}}
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>


<script>
    function deleteRow(id) {
        let folder = document.getElementById('gallery-' + id);

        let c = confirm("Are You Sure ?");

        if(c) {
            axios.delete(route('gallery.destroy', id))
            .then(function (response) {
            })
            .catch(function (error) {
            })

            folder.remove();
        }
    }
</script>

@endsection
