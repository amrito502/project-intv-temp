@extends('admin.layouts.master')

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<style type="text/css">
    .chosen-single {
        height: 35px !important;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="margin-right: 20px; font-size: 16px;" class="btn btn-outline-info btn-lg"
                                href="{{ route($goBackLink) }}">
                                <i class="fa fa-arrow-circle-left"></i> Go Back
                            </a>
                        </span>
                    </div>
                </div>
            </div>

            {{-- <span class="shortlink">
                <a class="btn btn-info" href="{{ route('categories.index') }}">Go Back</a>
                <a class="btn btn-info" onclick="return confirm('Are you sure want to delete')"
                    href="{{ route('category.delete',$categories->id) }}">Delete</a>
                <a class="btn btn-info" href="{{ route('categoryadd.page') }}">Add New</a>
            </span> --}}

            <div class="card-body">
                @php
                $message = Session::get('msg');
                if (isset($message))
                {
                echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>"
                        .$message."</strong></div>";
                }
                Session::forget('msg');
                @endphp

                <div id="addNewProduct" class="">
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{ route('category.update') }}" method="POST"
                            enctype="multipart/form-data" id="editCategory" name="editCategory">
                            {{ csrf_field() }}

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit"
                                        class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            @if( count($errors) > 0 )
                            <div style="display:inline-block;width: auto;" class="alert alert-danger">{{
                                $errors->first() }}</div>
                            @endif

                            <div class="form-group row {{ $errors->has('parent') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Select Parent</label>
                                <div class="col-sm-9">
                                    <select class="form-control chosen-select" name="parent">
                                        <option value="">--- Select Parent---</option>
                                        @foreach($parentCategory as $category)
                                        <option value="{{ @$category->id }}">{{ $category->categoryName }}</option>
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
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Category Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-danger"
                                        placeholder="Category name" name="categoryName"
                                        value="{{ $categories->categoryName }}" required>
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
                                        <input type="text" class="form-control form-control-danger" placeholder="Text Background" name="color" value="{{ $categories->color }}">
                                        @if ($errors->has('color'))
                                            @foreach($errors->get('color') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            <input type="hidden" name="categoryId" value="{{$categories->id}}">

                            <div class="form-group row {{ $errors->has('categoryCoverImage') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Cover Image (848x254)</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control form-control-danger"
                                        name="categoryCoverImage" style="margin-bottom: 10px;">
                                    @if ($errors->has('categoryCoverImage'))
                                    @foreach($errors->get('categoryCoverImage') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif

                                    <br><br>
                                    @if(file_exists($categories->categoryCoverImage))
                                    <img src="{{ asset('/').$categories->categoryCoverImage }}" style="height: 85px">
                                    <button class="btn btn-danger" type="button" onclick="removeColumnData('categories', 'categoryCoverImage', '{{$categories->id}}')">Remove Image</button>
                                    @else
                                    <img src="{{ $noImage }}" style="height: 85px">
                                    @endif

                                </div>

                            </div>

                            <div class="form-group row {{ $errors->has('categoryImage') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Category Image  (276x350)</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control form-control-danger"
                                        placeholder="Category image" name="categoryImage">
                                    @if ($errors->has('categoryImage'))
                                    @foreach($errors->get('categoryImage') as $error)
                                    <div class="form-control-feedback">{{ $error }}</div>
                                    @endforeach
                                    @endif
                                    @if(file_exists($categories->categoryImage))
                                    <img src="{{ asset('/').$categories->categoryImage }}" style="height: 85px">
                                    <button class="btn btn-danger" type="button" onclick="removeColumnData('categories', 'categoryImage', '{{$categories->id}}')">Remove Image</button>

                                    @else
                                    <img src="{{ $noImage }}" style="height: 85px">
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
                                    @if(file_exists($categories->leftMenuImage))
                                    <img src="{{ asset('/').$categories->leftMenuImage }}" style="height: 85px">
                                    <button class="btn btn-danger" type="button" onclick="removeColumnData('categories', 'leftMenuImage', '{{$categories->id}}')">Remove Image</button>
                                    @else
                                    <img src="{{ $noImage }}" style="height: 85px">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in
                                    Sidebar</label>
                                <div class="col-sm-9">
                                    <input type="radio" name="showInHomepage" value="yes"
                                        @if($categories->showInHomepage == 'yes') checked @endif> Yes
                                    <input type="radio" name="showInHomepage" value="no" @if($categories->showInHomepage
                                    != 'yes') checked @endif style="margin-left: 10px;"> No
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in
                                    MegaMenu</label>
                                <div class="col-sm-9">
                                    <input type="radio" name="showInMegaMenu" value="yes" @if($categories->showInMegaMenu == 'yes') checked @endif> Yes
                                    <input type="radio" name="showInMegaMenu" value="no" style="margin-left: 10px;" @if($categories->showInMegaMenu != 'yes') checked @endif> No
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('showInFooter') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Show in Footer</label>
                                <div class="col-sm-9">
                                    <input type="radio" name="showInFooter" value="yes" @if($categories->showInFooter == 'yes') checked @endif> Yes
                                    <input type="radio" name="showInFooter" value="no" style="margin-left: 10px;" @if($categories->showInFooter != 'yes') checked @endif> No
                                </div>
                            </div>

                            <div class="form-group row {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Meta Title</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-danger" placeholder="Meta Title"
                                        name="metaTitle" value="{{ $categories->metaTitle }}">
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
                                    <input type="text" class="form-control form-control-danger"
                                        placeholder="Meta Keyword" name="metaKeyword"
                                        value="{{ $categories->metaKeyword }}">
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
                                <div class="col-sm-9">
                                    <textarea style="min-height: 100px;" class="form-control" name="metaDescription">{{
                                        $categories->metaDescription }}</textarea>
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
                                    <input type="number" name="orderBy" value="{{ $categories->orderBy }}" required>
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
                                            <input type="radio" id="published" name="categoryStatus"
                                                class="custom-control-input" value="1" required>
                                            <label class="custom-control-label" for="published">Published</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="unpublished" name="categoryStatus"
                                                class="custom-control-input" checked="" value="0">
                                            <label class="custom-control-label" for="unpublished">Unpublished</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit"
                                        class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.forms['editCategory'].elements['parent'].value = "{{$categories->parent}}";
        document.forms['editCategory'].elements['categoryStatus'].value = "{{$categories->categoryStatus}}";
        document.forms['editCategory'].elements['showInHomepage'].value = "{{$categories->showInHomepage}}";        
</script>
@endsection