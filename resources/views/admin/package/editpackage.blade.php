@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                ?>
                <h4 class="card-title">Edit Your Package</h4>

                  <div id="addNewProduct" class="">
    <div class="">
        <div class="">

            <form class="form-horizontal" action="{{route('package.update')}}" method="POST" enctype="multipart/form-data" name="packageForm">
            {{ csrf_field() }}

           <input type="hidden" name="packageId" value="{{$packages->id}}">
            <div class="modal-body">

                <div class="form-group row {{ $errors->has('packageName') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Package Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Write package name" name="packageName" value="{{ $packages->packageName }}" required>
                        @if ($errors->has('packageName'))
                        @foreach($errors->get('packageName') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('packagestatus') ? ' has-danger' : '' }}">
                    <label class="col-sm-3 col-form-label">Package status</label>
                    <div class="col-sm-9 row">
                        <div class="form-control">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="published" name="packageStatus" class="custom-control-input" value="1" required>
                                <label class="custom-control-label" for="published">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="unpublished" name="packageStatus" class="custom-control-input" checked="" value="0">
                                <label class="custom-control-label" for="unpublished">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 m-b-20 text-right">
                    <button type="submit" class="btn btn-info waves-effect">Update Package</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')

<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
        document.forms['packageForm'].elements['packageStatus'].value = "{{$packages->packageStatus}}";

</script>

@endsection
