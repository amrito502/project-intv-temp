@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page-name')
Add Category
@endsection

@section('content')

    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <style type="text/css">
        .chosen-single{
            height: 35px !important;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><h4 class="card-title">{{ $title }}</h4></div>
                        <div class="col-md-6">
                            <span class="shortlink">
                             <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                             </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @php
                        $message = Session::get('msg');
                          if (isset($message)) {
                            echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                          }

                          Session::forget('msg')
                    @endphp

                    <div id="addNewProduct" class="">
                        <div class="modal-body">
                            <form class="form-horizontal" action="{{ route('category.save') }}" method="POST" enctype="multipart/form-data" id="newProduct" name="newProduct">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>

                                @if( count($errors) > 0 )
                                    <div style="display:inline-block;width: auto;" class="alert alert-danger">{{ $errors->first() }}</div>
                                @endif

                                <div class="form-group row {{ $errors->has('parent') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Select Parent</label>
                                    <div class="col-sm-9">
                                        <select class="form-control chosen-select" name="parent">
                                            <option value="">--- Select Parent---</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('parent'))
                                            @foreach($errors->get('parent') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row {{ $errors->has('categoryName') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Category name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger" placeholder="Category name" name="categoryName" value="{{ old('categoryName') }}" required>
                                        @if ($errors->has('categoryName'))
                                            @foreach($errors->get('categoryName') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('color') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Text Background</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-danger" placeholder="Text Background" name="color" value="{{ old('color') }}">
                                        @if ($errors->has('color'))
                                            @foreach($errors->get('color') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('categoryCoverImage') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Cover Image (848x254)</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control form-control-danger" name="categoryCoverImage" style="margin-bottom: 10px;">
                                        @if ($errors->has('categoryCoverImage'))
                                            @foreach($errors->get('categoryCoverImage') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                        {{-- <span style="color: red;">/* Height : 200px, Witdht: 1180px */</span> --}}
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('categoryImage') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Category Image (276x350)</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control form-control-danger" placeholder="Category Image" name="categoryImage" value="{{ old('categoryImage') }}">
                                        @if ($errors->has('categoryImage'))
                                            @foreach($errors->get('categoryImage') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('leftMenuImage') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Left Menu Image (20x13)</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control form-control-danger" placeholder="left Menu Image" name="leftMenuImage" value="{{ old('leftMenuImage') }}">
                                        @if ($errors->has('leftMenuImage'))
                                            @foreach($errors->get('leftMenuImage') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in Sidebar</label>
                                    <div class="col-sm-9">
                                        <input type="radio" name="showInHomepage" value="yes" checked="1"> Yes
                                        <input type="radio" name="showInHomepage" value="no" style="margin-left: 10px;" checked> No
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('showInMegaMenu') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in MegaMenu</label>
                                    <div class="col-sm-9">
                                        <input type="radio" name="showInMegaMenu" value="yes" checked="1"> Yes
                                        <input type="radio" name="showInMegaMenu" value="no" style="margin-left: 10px;" checked> No
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('showInFooter') ? ' has-danger' : '' }}">
                                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in Footer</label>
                                    <div class="col-sm-9">
                                        <input type="radio" name="showInFooter" value="yes" checked="1"> Yes
                                        <input type="radio" name="showInFooter" value="no" style="margin-left: 10px;" checked> No
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
                                        <input type="number" class="form-control form-control-danger" name="orderBy" value="{{ old('orderBy') }}" required>
                                        @if ($errors->has('orderBy'))
                                            @foreach($errors->get('orderBy') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row {{ $errors->has('categoryStatus') ? ' has-danger' : '' }}">
                                    <label class="col-sm-3 col-form-label">Publication status</label>
                                    <div class="col-sm-9 row">
                                        <div class="form-control">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="published" name="categoryStatus" checked="" class="custom-control-input" value="1" required>
                                                <label class="custom-control-label" for="published">Published</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="unpublished" name="categoryStatus" class="custom-control-input" value="0">
                                                <label class="custom-control-label" for="unpublished">Unpublished</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 m-b-20 text-right">
                                        <button type="submit" class="btn btn-outline-info btn-lg">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- /.modal-dialog --}}
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
