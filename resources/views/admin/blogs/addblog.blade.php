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
                 <a class="btn btn-info"  href="{{ route('blogs.index') }}">Go Back</a>

            </span>
            <div class="card-body">

                <?php
                    $message = Session::get('msg');
                      if (isset($message)) {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                      }

                      Session::forget('msg')

                ?>
                <h4 class="card-title">Add New Blog</h4>

                  <div id="addNewProduct" class="">
    <div class="">
        <div class="">

            <form class="form-horizontal" action="{{ route('blog.save') }}" method="POST" enctype="multipart/form-data" id="newProduct" name="newProduct">
            {{ csrf_field() }}

            <div class="col-md-12 m-b-20 text-right">
                    <button type="submit" class="btn btn-info waves-effect">Save</button>
                </div>
                <br>

            @if( count($errors) > 0 )

            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>

        @endif
            <div class="modal-body">

                <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Blog Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Blog title" name="title" value="{{ old('title') }}" required>
                        @if ($errors->has('title'))
                        @foreach($errors->get('title') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('blogImage') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Blog Image</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control form-control-danger" placeholder="Category Image" name="blogImage" value="{{ old('blogImage') }}">
                        @if ($errors->has('blogImage'))
                        @foreach($errors->get('blogImage') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('title') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Blog Description</label>
                    <div class="col-sm-9">
                       <textarea name="description" class="form-control" style="min-height: 400px;" required></textarea>
                    </div>
                </div>



                <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="{{ old('metaTitle') }}">
                        @if ($errors->has('metaTitle'))
                        @foreach($errors->get('metaTitle') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta keyword</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Meta Keyword" name="metaKeyword" value="{{ old('metaKeyword') }}">
                        @if ($errors->has('metaKeyword'))
                        @foreach($errors->get('metaKeyword') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta description</label>
                    <div class="col-sm-9">
                        <textarea style="min-height: 100px;" class="form-control" name="metaDescription">{{ old('metaDescription') }}</textarea>
                        @if ($errors->has('metaDescription'))
                        @foreach($errors->get('metaDescription') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                 <div class="form-group row {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Order By</label>
                    <div class="col-sm-9">
                        <input type="number"   name="orderBy" value="{{ old('orderBy') }}" required>
                        @if ($errors->has('orderBy'))
                        @foreach($errors->get('orderBy') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('status') ? ' has-danger' : '' }}">
                    <label class="col-sm-3 col-form-label">Publication status</label>
                    <div class="col-sm-9 row">
                        <div class="form-control">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="published" name="status" class="custom-control-input" value="1" required>
                                <label class="custom-control-label" for="published">Published</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="unpublished" name="status" class="custom-control-input" checked="" value="0">
                                <label class="custom-control-label" for="unpublished">Unpublished</label>
                            </div>
                        </div>
                    </div>
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


 <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false // set focus to editable area after initializing summernote
            });

            var updateThis ;

            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            var table = $('#productsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            //ajax
            //ajax category  wise subcategory
            $( "form[name='newProduct'] select[name='category_id']" ).on( "change", function( event ) {
            $( "form[name='newProduct'] select[name='sub_category_id']" ).html('');
            $( "form[name='newProduct'] select[name='sub_category_id']" ).append(new Option("--- Select Sub Category Name---", ""));
                category_id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('categories.index') }}" + "/" + category_id + "/subCategories",
                    data: "category_id=" + category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        subCategories = response.subCategories;
                        subCategories.forEach(function(element) {
                            $( "form[name='newProduct'] select[name='sub_category_id']" ).append(new Option(element.name, element.id));
                        });
                    },
                    error: function(response) {
                        error = "Select Category First.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>",
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            });

        });


            function summernote(){
                $('.summernote').summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false // set focus to editable area after initializing summernote
                });
            }
    </script>

@endsection
