@extends('dashboard.layouts.app')

@section('content')
@include('dashboard.layouts.partials.error')

<form action="{{ route('materialgroup.update', $data->materialgroup->id) }}" method="POST">
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
                        <h3 class="text-center mt-5 mb-0 d-md-none d-block">Edit Material Group</h3>
                        <h3 class="text-center d-md-block d-none text-uppercase">Edit Material Group</h3>
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
                            <label for="name">Material Group Name</label>
                            <input class="form-control" name="name" id="name" type="text" value="{{ $data->materialgroup->name }}" placeholder="Enter name">
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
</script>
@endsection
