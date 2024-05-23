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
            <span class="shortlink">
                <a class="btn btn-info" href="{{ route('sliders.index') }}">Go Back</a>


            </span>
            <div class="card-body">

                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')
                  
                ?>
                <h4 class="card-title">Add New Slider</h4>

                <div id="addNewProduct" class="">
                    <div class="">
                        <div class="">

                            <form class="form-horizontal" action="{{ route('slider.save') }}" method="POST"
                                enctype="multipart/form-data" id="newProduct" name="newProduct">
                                {{ csrf_field() }}

                                @if( count($errors) > 0 )

                                <div style="display:inline-block;width: auto;" class="alert alert-danger">
                                    {{ $errors->first() }}</div>

                                @endif
                                <div class="modal-body">

                                    <div class="col-md-10 m-b-20 text-right">
                                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                                    </div>
                                    <br>

                                    <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Slider
                                            Title</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="slider title" name="title" value="{{ old('title') }}">
                                            @if ($errors->has('title'))
                                            @foreach($errors->get('title') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Slider
                                            Image</label>
                                        <div class="col-sm-7">
                                            <select class="form-control chosen-select" name="category">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('sliderImage') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Slider
                                            Image</label>
                                        <div class="col-sm-7">
                                            <input type="file" class="form-control form-control-danger"
                                                placeholder="Category Image" name="sliderImage"
                                                value="{{ old('sliderImage') }}" required>
                                            <span style="color:red">/* Standard Image Size : 1140*400px */ <br></span>
                                            @if ($errors->has('sliderImage'))
                                            @foreach($errors->get('sliderImage') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta
                                            Title</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Meta Title" name="metaTitle"
                                                value="{{ old('metaTitle') }}">
                                            @if ($errors->has('metaTitle'))
                                            @foreach($errors->get('metaTitle') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta
                                            keyword</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Meta Keyword" name="metaKeyword"
                                                value="{{ old('metaKeyword') }}">
                                            @if ($errors->has('metaKeyword'))
                                            @foreach($errors->get('metaKeyword') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta
                                            description</label>
                                        <div class="col-sm-7">
                                            <textarea style="min-height: 100px;" class="form-control"
                                                name="metaDescription">{{ old('metaDescription') }}</textarea>
                                            @if ($errors->has('metaDescription'))
                                            @foreach($errors->get('metaDescription') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Order
                                            By</label>
                                        <div class="col-sm-7">
                                            <input type="number" name="orderBy" value="{{ old('orderBy') }}" required>
                                            @if ($errors->has('orderBy'))
                                            @foreach($errors->get('orderBy') as $error)
                                            <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row {{ $errors->has('status') ? ' has-danger' : '' }}">
                                        <label class="col-sm-3 col-form-label">Publication status</label>
                                        <div class="col-sm-7 row">
                                            <div class="form-control">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="published" name="status"
                                                        class="custom-control-input" value="1" required>
                                                    <label class="custom-control-label"
                                                        for="published">Published</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="unpublished" name="status"
                                                        class="custom-control-input" checked="" value="0">
                                                    <label class="custom-control-label"
                                                        for="unpublished">Unpublished</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-10 m-b-20 text-right">
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