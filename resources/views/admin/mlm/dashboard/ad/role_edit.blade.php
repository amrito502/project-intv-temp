@extends('admin.mlm.dashboard.layouts.app')

@section('custom-css')
<style>
    ul {
        list-style: none;
    }
</style>
@endsection

@section('content')
@include('admin.mlm.dashboard.layouts.partials.error')

<form action="{{ route('ad.update', $data->ad->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="tile">
        <div class="tile-body">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <button onclick="window.history.back()" type="button" class="btn btn-info float-left">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
                        </button>
                        <h3 class="text-center">Edit Role</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="tile">
        <div class="tile-body">
            <div class="container">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <img src="{{ asset('storage/ad/'. $data->ad->img) }}" class="img-fluid" alt="Ad Image">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input class="form-control" name="image" id="image" type="file">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="tile">
        <div class="tile-body">
            <div class="row">
                <div class="col-md-2 offset-md-10">
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
    function togglePermissions(e) {
                let thisEl = $(e.target);
                let isThisElChecked = thisEl.is(':checked');

                let isParent = $(thisEl).hasClass('parent');
                let isChild = $(thisEl).hasClass('child');

                let selectedInputs = '';


                if(isParent){
                    let thisElId = thisEl.attr('parent');
                    selectedInputs = $( "input[parent='"+thisElId+"']");
                }

                if(isChild){
                    let thisElId = thisEl.attr('child');
                    selectedInputs = $( "input[child='"+thisElId+"']");
                }

                if(typeof selectedInputs == 'object'){
                    selectedInputs.each(function(){
                        this.checked = isThisElChecked;
                    });
                }

            }
</script>
@endsection
