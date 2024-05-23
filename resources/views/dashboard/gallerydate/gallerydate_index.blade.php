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
                    <h2 class="h2 text-center text-uppercase">Gallery Dates ({{ $data->gallery->title }})</h2>
                </div>
                @can('create gallery')
                <div class="col-md-2 text-right">
                    <a href="{{ route('gallerydate.create', $data->gallery->id) }}" class="btn btn-info"><i
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
                @foreach ($data->galleryDates as $galleryDate)
                <div class="col-md-2 col-sm-4 col-6 text-center mt-4" id="gallery-{{ $galleryDate->id }}">
                    <a href="{{ route('gallerydate.show', $galleryDate->id) }}">
                        <div class="logoDiv">
                            <i class="fa fa-folder FolderIconCss" aria-hidden="true"></i>
                        </div>
                        <div class="nameDiv">{{ $galleryDate->date }}</div>
                    </a>
                    <div class="buttonsDiv">
                        {{-- <a href="{{ route('gallerydate.show', $galleryDate->id) }}">View</a> | --}}
                        <a href="{{ route('gallerydate.edit', [$data->gallery->id, $galleryDate->id]) }}">Edit</a> |
                        <a href="#" onclick='deleteRow({{ $galleryDate->id }})'>Delete</a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</div>

@endsection


@section('custom-script')
<script>
    function deleteRow(id) {
            let trEl = document.getElementById('gallery-' + id);

            let c = confirm("Are You Sure ?");

            if(c) {
                axios.delete(route('gallerydate.destroy', id))
                .then(function (response) {
                })
                .catch(function (error) {
                })

                trEl.remove();
            }
        }
</script>
@endsection
