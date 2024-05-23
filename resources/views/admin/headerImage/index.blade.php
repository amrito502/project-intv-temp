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

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">Edit Header Image</h4>

                <div id="addNewProduct" class="">
                    <div class="">
                        <div class="">

                            <form class="form-horizontal" action="{{ route('homeImage.update') }}" method="POST"
                                enctype="multipart/form-data" id="editSlider" name="editSlider">
                                {{ csrf_field() }}

                                @if( count($errors) > 0 )

                                <div style="display:inline-block;width: auto;" class="alert alert-danger">
                                    {{ $errors->first() }}</div>

                                @endif
                                <div class="modal-body">

                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                                    </div>
                                    <br>

                                    <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Slider
                                            Title</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Home Image Title" name="title" value="{{ $image->title }}">
                                            @if ($errors->has('title'))
                                            @foreach($errors->get('title') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Header
                                            Image</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control form-control-danger"
                                                placeholder=" image" name="image">
                                            <!--<span style="color:red">/* Standard Image Size : 1110*450 */ <br></span>-->
                                            @if ($errors->has('image'))
                                            @foreach($errors->get('image') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif

                                            <img src="{{ asset('/').$image->image }}" style="height: 85px"
                                                alt="You Have No Image" width="100%">
                                        </div>
                                    </div>

                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-info waves-effect">Save</button>
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