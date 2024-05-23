@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('/admin-elite/assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
<!-- page css -->
<link href="{{ asset('/admin-elite/dist/css/pages/user-card.css') }}" rel="stylesheet">
<style type="text/css">

.slider-photo-custom-overly{
    margin-bottom: -2px;
    margin-left: -88px;
    will-change: transform;
    max-height: 203px;
    overflow-y: scroll;
    position: absolute;
    top: -1px;
    left: 0px;
    border-radius: 0;
    border:none;
}

.slider-card{
    min-height: 12rem;
    max-height: 12rem;
    margin: 0rem;
    border: .05rem solid #c3c3c3;
}

.slider-card .el-card-item{
    overflow: hidden;
    padding-bottom: 0rem;
}
.slider-card .el-overlay-1{
    margin-bottom: 0px;
}
.card-body-slider{
    padding: 0rem;
    position: absolute;
    z-index: 1;
    width: 100%;
}
.slider-card-title{
    background-color: white;
    margin: 0rem;
}
.slider-card .el-element-overlay .el-card-item .el-overlay-1 img {
    height: 12rem;
}
</style>
@endsection

@section('page-name')
Product
@endsection

@section('content')

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Category</h4>
                <select class="form-control" name="master_category_id" onchange="changeFunction(this)">
                    <option value="">--- Select Category Name---</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Featured Image</h4>
                <div class="row">
                    <div class="col-sm-8">                        
                        <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="featuredImage">
                        {{ csrf_field() }}
                        <input type="hidden" name="category_id">
                        <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Featured image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" aria-describedby="fileHelp" name="image" value="{{ old('image') }}">
                                @if ($errors->has('image'))
                                @foreach($errors->get('image') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 m-b-20 text-right">    
                            <button type="submit" class="btn btn-info waves-effect">Update Featured Image</button> 
                        </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <img src="not available" alt="not available" name="featured_image" style="width: 100%; height: 10rem">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Banner</h4>
                <div class="row">
                    <div class="col-sm-8"> 
                        <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="banner">
                        {{ csrf_field() }}
                        <input type="hidden" name="category_id">
                        <div class="form-group row {{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Sub category name</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="sub_category_id">
                                    <option value="">--- Select Sub Category Name---</option>
                                    @foreach($subCategories as $subCategory)
                                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sub_category_id'))
                                @foreach($errors->get('sub_category_id') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>                       
                        <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product image</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="image" aria-describedby="fileHelp" name="image" value="{{ old('image') }}">
                                @if ($errors->has('image'))
                                @foreach($errors->get('image') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 m-b-20 text-right">    
                            <button type="submit" class="btn btn-info waves-effect">Update Banner Image</button> 
                        </div>
                        </form>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <h5>The category is: </h5> <p name="banner_category" class=" text-success" style="font-weight: bold">  category</p>
                        </div>
                        <div class="row">
                            <img src="not available" alt="not available" name="banner_image"  style="width: 100%; height: 10rem">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $categoriesList = $products?>

<div style="border: 1px solid black; margin-bottom: 1.5rem;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Slider Products</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row el-element-overlay" id="sliderProducts">
        
    
    </div> 
</div>


<div tabindex="-1" class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" aria-labelledby="myLargeModalLabel" style="display: none;" id="create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="card-body">
                <h4 class="card-title">Products</h4>
                <select class="form-control select2" name="category_product" onchange="changeProduct(this)">
                    <option value="">--- Select Product---</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <hr>

                <div class="row">
                    <div class="col-sm-3">
                        <img src="no image selected" alt="no image found" name="categoriesProductImage" style="width: 100%">
                    </div>
                    <div class="col-sm-9">
                        <div class="container" id="showCategoriesContent"  style="max-height: 80vh; overflow-y: scroll;">
                            
                        </div>
                        <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="featuredSlider">
                        {{ csrf_field() }}
                            <input type="hidden" name="category_id">
                            <input type="hidden" name="product_id">
                            <div class="col-md-12 m-b-20 text-right">    
                                <button type="submit" class="btn btn-info waves-effect">Add to categoried slider</button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage products</h4>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addNewProduct" aria-hidden="true" style="float: right;" onclick="summernote()">Add new</button>
                <div class="table-responsive" style="margin-top: 5rem;">
                    <table id="productsTable" class="table table-bordered table-striped"  name="productsTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                        	@foreach($products as $product)                        	
                        	<tr>
                                <td>{{ $product->name }}</td>
                                <td><img src="{{ asset('/').$product->image }}" style="height: 75px"></td>
                                <td>{{ $product->qty }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>
                                    <span class="switchery-demo m-b-30" onclick="statusChange({{ $product->id }})">
                                    <input type="checkbox" {{ $product->status ? 'checked':'' }} class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="{{ $product->id }}"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="{{ $product->id }}"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="{{$product->id}}"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                                </td>
                            </tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<!-- sample modal content for add new product-->
<div id="addNewProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">        
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Add New Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="newProduct">
            {{ csrf_field() }}
            <div class="modal-body" style="max-height: 80vh; overflow-y: scroll;">
                <div class="form-group row {{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Sub category name</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="sub_category_id">
                            <option value="">--- Select Sub Category Name---</option>
                            @foreach($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('sub_category_id'))
                        @foreach($errors->get('sub_category_id') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                        @foreach($errors->get('name') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('deal_code') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product deal code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product deal code" name="deal_code" value="{{ old('deal_code') }}">
                        @if ($errors->has('deal_code'))
                        @foreach($errors->get('deal_code') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product marchent phone no</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product marchent phone no" name="phone_no" value="{{ old('phone_no') }}">
                        @if ($errors->has('phone_no'))
                        @foreach($errors->get('phone_no') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product description</label>
                    <div class="col-sm-9">
                        <textarea class="summernote form-control form-control-danger" name="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                        @foreach($errors->get('description') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product image</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="image" aria-describedby="fileHelp" name="image" value="{{ old('image') }}">
                        @if ($errors->has('image'))
                        @foreach($errors->get('image') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('image2') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product back image</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="image2" aria-describedby="fileHelp" name="image2" value="{{ old('image2') }}">
                        @if ($errors->has('image2'))
                        @foreach($errors->get('image2') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('qty') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product quantity</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product quantity" name="qty" value="{{ old('qty') }}">
                        @if ($errors->has('qty'))
                        @foreach($errors->get('qty') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('weight') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product weight</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger"  placeholder="add Product weight"  data-role="tagsinput" name="weight">
                        @if ($errors->has('weight'))
                        @foreach($errors->get('weight') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product price</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product price" name="price" value="{{ old('price') }}">
                        @if ($errors->has('price'))
                        @foreach($errors->get('price') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('discount') ? ' has-danger' : '' }}">
                    <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product discount</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-danger" placeholder="Product discount" name="discount" value="{{ old('discount') }}">
                        @if ($errors->has('discount'))
                        @foreach($errors->get('discount') as $error)
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
                                <input type="radio" id="published" name="status" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="published">Published</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="unpublished" name="status" class="custom-control-input" checked="" value="0">
                                <label class="custom-control-label" for="unpublished">Unpublished</label>
                            </div>
                        </div>                            
                    </div>
                </div>
                <div class="col-md-12 m-b-20 text-right">    
                    <button type="submit" class="btn btn-info waves-effect">Save prduct</button> 
                </div>
            </div>                
            </form>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content for edit and update product-->
<div id="editProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">   
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Edit Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form class="form-horizontal" action="javascript:void(0)" method="POST" enctype="multipart/form-data" name="updateProduct">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <div class="modal-body" id="editContent"  style="max-height: 80vh; overflow-y: scroll;">                
            </div>
            </form>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- sample modal content for show product-->
<div id="showProduct" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel1">Show Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="container" id="showContent"  style="max-height: 80vh; overflow-y: scroll;">
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



@endsection

@section('custom-js')

    <!-- This is data table -->
    <script src="{{ asset('/admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}"></script>
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

            table = $('#productsTable').DataTable( {
                "order": [[ 0, "asc" ]]
            } );

            table.on('order.dt search.dt', function () {
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            } ).draw();

            //ajax            

            //ajax insert code
            $( "form[name='newProduct']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('products.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var product = response.product;
                        var subCategory = response.subCategory;
                        $('#addNewProduct').modal('hide');

                        status = '';
                        if(product.status==1) status = 'checked';
                        var rowNode = table.row.add([ 
                            product.name ,
                            `<img src="{{ asset('/')}}`+product.image+`" style="height: 75px">`,
                            product.qty ,
                            product.price ,
                            product.discount ,
                            `<span class="switchery-demo m-b-30" onclick="statusChange(`+product.id+`)">
                            <input type="checkbox" `+status+` class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                            </span>`,
                            `<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="`+product.id+`"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="`+product.id+`"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="`+product.id+`"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                            `] ).draw().node();
                            new Switchery($(rowNode).find('.js-switch')[0], $(rowNode).find('.js-switch').data());
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Product successfully added!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.sub_category_id){
                            $( "select[name='sub_category_id']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.sub_category_id +"</li>";
                        }
                        if(data.errors.name) {
                            $( "input[name='name']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.name +"</li>";
                        }
                        if(data.errors.description) {
                            $( "textarea[name='description']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.description +"</li>";
                        }
                        if(data.errors.image) {
                            $( "input[name='image']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.image +"</li>";
                        }
                        if(data.errors.image2) {
                            $( "input[name='image2']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.image2 +"</li>";
                        }
                        if(data.errors.price) {
                            $( "input[name='price']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.price +"</li>";
                        }
                        if(data.errors.status) {
                            $( "input[name='status']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.status +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });

            //ajax show code
            $('#productsTable tbody').on( 'click', 'i.fa-eye', function () { 
                updateThis = this;
                product_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('products.index') }}" + "/" + product_id + "/edit",
                    data: "product_id=" + product_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {                        
                        product = response.product;
                        subCategory = response.subCategory;
                        category = response.category;
                        showFunction(product, subCategory, category);
                    },
                    error: function(response) {
                        error = "Something wrong.";
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

            //seperate the show function to understand
            function showFunction(product, subCategory, category){
                weightArray = [];
                if(product.weight)
                    weightArray = product.weight.split(",");
                weight = '';
                weightArray.forEach(function(element) {
                    weight = weight + `<span class="tag label label-info">`+element+`</span> `;
                });

                if(product.status == 1) 
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-success">Active</span>
                                </div>`;
                else
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-danger">In-active</span>
                                </div>`
                var content =   `<div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Product name</b></label>
                                    <div class="col-sm-8 form-control">`+product.name+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Category name</b></label>
                                    <div class="col-sm-3 form-control">`+category.name+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Sub category name</b></label>
                                    <div class="col-sm-3 form-control">`+subCategory.name+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Deal code</b></label>
                                    <div class="col-sm-3 form-control">`+product.deal_code+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Mobile no</b></label>
                                    <div class="col-sm-3 form-control">`+product.phone_no+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Quantity</b></label>
                                    <div class="col-sm-3 form-control">`+product.qty+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Weight</b></label>
                                    <div class="col-sm-3 form-control">`+weight+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Price</b></label>
                                    <div class="col-sm-3 form-control">`+product.price+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Discount</b></label>
                                    <div class="col-sm-3 form-control">`+product.discount+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Category</b></label>
                                    <div class="col-sm-8 form-control">`+product.name+`</div>
                                </div>`+status;

                $('#showContent').html(content);
                $("#showProduct").modal(); 
            }

            //ajax edit code
            $('#productsTable tbody').on( 'click', 'i.fa-pencil', function () { 
                $('.has-danger').removeClass('has-danger');
                updateThis = this;
                product_id = $(this).parent().data('id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('products.index') }}" + "/" + product_id + "/edit",
                    data: "product_id=" + product_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {                        
                        product = response.product;
                        subCategory = response.subCategory;
                        editFunction(product, subCategory);
                    },
                    error: function(response) {
                        error = "Something wrong.";
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
            
            
            //seperate the edit function to understand
            function editFunction(product, subCategory){
                $.get(  "{{ asset('/') }}"+product.description, function( data ) {
                    description = data;
                    $('#editedPublished').prop('checked', false);
                    $('#editedUnpublished').prop('checked', false);

                    var content = `
                    <input type="hidden" id="product_id" name="product_id" value="`+product.id+`">
                    <div class="form-group row {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Category name</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="category_id" onchange="changeCategory()">
                                <option value="">--- Select Category Name---</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                            @foreach($errors->get('category_id') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('sub_category_id') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Sub Category name</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="sub_category_id">
                                <option value="">--- Select Sub Category Name---</option>
                                @foreach($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('sub_category_id'))
                            @foreach($errors->get('sub_category_id') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product name" id="name" name="name" value="{{ old('name') }} `+product.name+`">
                            @if ($errors->has('name'))
                            @foreach($errors->get('name') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>                
                    <div class="form-group row {{ $errors->has('deal_code') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product deal code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product deal code" name="deal_code" value="{{ old('deal_code') }} `+product.deal_code+` ">
                            @if ($errors->has('deal_code'))
                            @foreach($errors->get('deal_code') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>              
                    <div class="form-group row {{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product phone number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product phone number" name="phone_no" value="{{ old('phone_no') }} `+product.phone_no+` ">
                            @if ($errors->has('phone_no'))
                            @foreach($errors->get('phone_no') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>                
                    <div class="form-group row {{ $errors->has('description') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product description</label>
                        <div class="col-sm-9">
                            <textarea class="summernote form-control form-control-danger" name="description">{{ old('description') }}`+description+`</textarea>
                            @if ($errors->has('description'))
                            @foreach($errors->get('description') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>  

                    <div class="form-group row {{ $errors->has('image') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product image</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="image" aria-describedby="fileHelp" name="image" value="{{ old('image') }}">
                            <img src="{{ asset('/') }}/`+product.image+`" style="width:75px;">
                            @if ($errors->has('image'))
                            @foreach($errors->get('image') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('image2') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product back image</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="image2" aria-describedby="fileHelp" name="image2" value="{{ old('image2') }}">

                            <img src="{{ asset('/') }}/`+product.image2+`" style="width:75px;">
                            @if ($errors->has('image2'))
                            @foreach($errors->get('image2') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('qty') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product quantity</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product quantity" name="qty" value="{{ old('qty') }}`+product.qty+`">
                            @if ($errors->has('qty'))
                            @foreach($errors->get('qty') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('weight') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product weight</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger"  placeholder="add Product weight"  data-role="tagsinput" name="weight" value="{{ old('weight') }} `+product.weight+`">
                            @if ($errors->has('weight'))
                            @foreach($errors->get('weight') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>            
                    <div class="form-group row {{ $errors->has('price') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product price</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product price" name="price" value="{{ old('price') }} `+product.price+`">
                            @if ($errors->has('price'))
                            @foreach($errors->get('price') as $error)
                            <div class="form-control-feedback">{{ $error }}</div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('discount') ? ' has-danger' : '' }}">
                        <label for="inputHorizontalDnger" class="col-sm-3 col-form-label">Product discount</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-danger" placeholder="Product discount" name="discount" value="{{ old('discount') }} `+product.discount+`">
                            @if ($errors->has('discount'))
                            @foreach($errors->get('discount') as $error)
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
                                    <input type="radio" id="editedPublished" name="status" class="custom-control-input" value="1">
                                    <label class="custom-control-label" for="editedPublished">Published</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="editedUnpublished" name="status" class="custom-control-input" value="0">
                                    <label class="custom-control-label" for="editedUnpublished">Unpublished</label>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-12 m-b-20 text-right">    
                        <button type="submit" class="btn btn-info waves-effect">Update product</button> 
                    </div>`;

                    $('#editContent').html(content);
                    $("#editProduct").modal();

                    if(subCategory.status == '1')
                        $('#editedPublished').prop('checked', true);
                    else
                        $('#editedUnpublished').prop('checked', true);

                    document.forms['updateProduct'].elements['category_id'].value = subCategory.category_id;
                    document.forms['updateProduct'].elements['sub_category_id'].value = product.sub_category_id;
                    $('.summernote').summernote({
                        height: 200, // set editor height
                        minHeight: null, // set minimum height of editor
                        maxHeight: null, // set maximum height of editor
                        focus: false // set focus to editable area after initializing summernote
                    });
                });
                
            } 
            //ajax update code
            $( "form[name='updateProduct']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('products.index') }}" + "/" + $('#product_id').val(),
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var product = response.product;
                        var subCategory = response.subCategory;
                        $('#editProduct').modal('hide');  
                        //hide the row.                      
                        table
                            .row( $(updateThis).parents('tr'))
                            .remove()
                            .draw();

                        status = '';
                        if(product.status==1) status = 'checked';

                        //insert new row.
                        var rowNode = table.row.add([ 
                            product.name,
                            `<img src="{{ asset('/') }}/`+product.image+`" style="width:75px;">`,
                            product.qty,
                            product.price,
                            product.discount,
                            `<span class="switchery-demo m-b-30" onclick="statusChange(`+subCategory.id+`)">
                            <input type="checkbox" `+status+` class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                            </span>`,
                            `<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="`+product.id+`"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="`+product.id+`"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="`+product.id+`"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                            `] ).draw().node();
                            new Switchery($(rowNode).find('.js-switch')[0], $(rowNode).find('.js-switch').data());

                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Product updated successfully!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.category_id){
                            $( "select[name='category_id']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.position +"</li>";
                        }
                        if(data.errors.name) {
                            $( "input[name='name']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.name +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });

            //ajax delete from slider code
            $('#productsTable tbody').on( 'click', 'i.fa-trash', function () {
                $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
                });

                product_id = $(this).parent().data('id');
                var product = this;
                swal({   
                    title: "Are you sure?",   
                    text: "You will not be able to recover this imaginary file!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    cancelButtonText: "No, cancel plx!",   
                    closeOnConfirm: false,   
                    closeOnCancel: false 
                }, function(isConfirm){   
                    if (isConfirm) {     
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('products.index') }}" + "/" + product_id,
                            dataType: "JSON",
                            data: {
                                id:product_id
                            },
                            cache:false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                swal({
                                    title: "<small class='text-success'>Success!</small>", 
                                    type: "success",
                                    text: "Product deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                table
                                    .row( $(product).parents('tr'))
                                    .remove()
                                    .draw();
                            },
                            error: function(response) {
                                error = "Failed.";
                                swal({
                                    title: "<small class='text-danger'>Error!</small>", 
                                    type: "error",
                                    text: error,
                                    timer: 1000,
                                    html: true,
                                });
                            }
                        });   
                    } else { 
                        swal({
                            title: "Cancelled", 
                            type: "error",
                            text: "Your product is safe :)",
                            timer: 1000,
                            html: true,
                        });    
                    } 
                });
            }); 


        });
                
        //ajax status change code
        function statusChange(product_id) {
            $.ajax({
                    type: "GET",
                    url: "{{ route('products.changeStatus', 0) }}",
                    data: "product_id=" + product_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "Status successfully updated!",
                            timer: 1000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        error = "Failed.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 2000,
                            html: true,
                        });
                    }
                });
            }

            function summernote(){
                $('.summernote').summernote({
                    height: 200, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: false // set focus to editable area after initializing summernote
                });
            }
    </script>


    <script type="text/javascript">

        $(document).ready(function() {
            $( "form[name='featuredImage']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('featuredImages.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var featuredImage = response.featuredImage;
                        $('img[name=featured_image]').attr('src', "{{ asset('/') }}"+featuredImage.image);
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "This item successfully updated!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.image) {
                            $( "input[name='image']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.image +"</li>";
                        }
                        if(data.errors.sub_category_id) {
                            $( "input[name='sub_category_id']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.sub_category_id +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            }); 
            $( "form[name='featuredSlider']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('featuredSliders.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var sliderProduct = response.sliderProduct;
                        if(sliderProduct != 1) {

                        // $('img[name=featured_image]').attr('src', "{{ asset('/') }}"+featuredImage.image);
                        content = 
                            `<div class="col-lg-3 col-md-3 col-sm-6" style=" padding: 1rem; ">
                                <div class="card slider-card">
                                    <div class="el-card-item" >
                                        <div class="el-card-avatar el-overlay-1" > 
                                            <div class="card-body-slider" style="overflow: hidden;">
                                                <h4 class="card-title bg-light w-100">`+sliderProduct.name+`</h4>
                                            </div>
                                            <img class="card-img-top img-responsive" src="{{ asset('/') }}/`+sliderProduct.image+`" alt="Not found">
                                            <div class="el-overlay" style="height: 200px;">
                                                <ul class="el-info">
                                                    <li>
                                                        <a class="btn default btn-outline" href="javascript:void(0)" data-id="`+sliderProduct.id+`" onclick="removeSliderProduct(this)"><i class="icon-trash"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        $('#sliderProducts').append(content);
                        }
                        $('#create').modal('hide');

                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "This item successfully updated!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.category_id) {
                            $( "input[name='category_id']").addClass('has-danger');
                            error = error+ "<li>" + data.errors.category_id +"</li>";
                        }
                        if(data.errors.product_id) {
                            $( "input[name='sub_category_id']").addClass('has-danger');
                            error = error+ "<li>" + data.errors.product_id +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            }); 

            $( "form[name='banner']" ).on( "submit", function( event ) {
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('banners.store') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var bannerImage = response.bannerImage;
                        $('img[name=banner_image]').attr('src', "{{ asset('/') }}"+bannerImage.image);
                        $('p[name=banner_category]').html(bannerImage.sub_category.name);
                        swal({
                            title: "<small class='text-success'>Success!</small>", 
                            type: "success",
                            text: "This item successfully updated!",
                            timer: 2000,
                            html: true,
                        });
                    },
                    error: function(response) {
                        data = JSON.parse(response.responseText);
                        error = "<div class='container'><ol class='text-center' style='padding:2rem;'>";
                        i=1;
                        if(data.errors.image) {
                            $( "input[name='image']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.image +"</li>";
                        }
                        if(data.errors.sub_category_id) {
                            $( "input[name='sub_category_id']").parent().parent().addClass('has-danger');
                            error = error+ "<li>" + data.errors.sub_category_id +"</li>";
                        }
                        error = error + "</ol></div>";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 5000,
                            html: true,
                        });
                    }
                });
            });
    });
function removeSliderProduct(th) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    slider_id = $(th).data('id');
    swal({   
        title: "Are you sure?",   
        text: "You will not be able to recover this imaginary file!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#DD6B55",   
        confirmButtonText: "Yes, delete it!",   
        cancelButtonText: "No, cancel plx!",   
        closeOnConfirm: false,   
        closeOnCancel: false 
    }, function(isConfirm){   
        if (isConfirm) {     
            $.ajax({
                type: "DELETE",
                url: "{{ route('featuredSliders.index') }}" + "/" + slider_id,
                dataType: "JSON",
                data: {
                    slider_id:slider_id,
                },
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $(th).parent().parent().parent().parent().parent().parent().parent().remove();
                    swal({
                        title: "<small class='text-success'>Success!</small>", 
                        type: "success",
                        text: "Product deleted Successfully!",
                        timer: 1000,
                        html: true,
                    });
                },
                error: function(response) {
                    error = "Failed.";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        timer: 1000,
                        html: true,
                    });
                }
            });   
        } else { 
            swal({
                title: "Cancelled", 
                type: "error",
                text: "Your product is safe :)",
                timer: 1000,
                html: true,
            });    
        } 
    });
}
        function changeFunction(th){
            category_id = $(th).val();
            $('input[name=category_id]').val( category_id);

            $.ajax({
                    type: "GET",
                    url: "{{ route('manages.index') }}",
                    data: "category_id=" + category_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        //featuredImage
                        var featuredImage = response.featuredImage;  

                        //bannerImage with category
                        var bannerImage = response.bannerImage;     
                        if(featuredImage == null) 
                            $('img[name=featured_image]').attr('src', '');
                        else
                            $('img[name=featured_image]').attr('src', "{{ asset('/') }}"+featuredImage.image);  
                        if(bannerImage == null) {
                            $('img[name=banner_image]').attr('src', '');
                            $('p[name=banner_category]').html('');
                        }
                        else {
                            $('img[name=banner_image]').attr('src', "{{ asset('/') }}"+bannerImage.image);
                            $('p[name=banner_category]').html(bannerImage.sub_category.name);
                        }

                        $( "form[name='banner'] select[name='sub_category_id']" ).html('');
                        $( "form[name='newProduct'] select[name='sub_category_id']" ).html('');
                        subCategories = response.subCategories;
                        subCategories.forEach(function(element) {
                            $( "form[name='banner'] select[name='sub_category_id']" ).append(new Option(element.name, element.id));
                            $( "form[name='newProduct'] select[name='sub_category_id']" ).append(new Option(element.name, element.id));
                        });

                        document.forms['banner'].elements['sub_category_id'].value = bannerImage.sub_category.id;

                        //slider products
                        $('#sliderProducts').html('');
                        var sliderProducts = response.sliderProducts;
                        var content = 
                        `<div class="col-lg-3 col-md-3 col-sm-6" style=" padding: 1rem; ">
                            <div class="card slider-card" >
                                <div class="el-card-item">
                                    <div class="el-card-avatar el-overlay-1 text-center"> 
                                        <div class="card-body-slider">
                                            <h4 class="slider-card-title">Add new</h4>
                                        </div>
                                        <img class="card-img-top img-responsive" src="{{ asset('/images/default/add_new.png') }}" alt="Not found" style="height: 8rem; width: 8rem; display: inline-block;    margin-top: 3rem;">
                                        <div class="el-overlay">
                                            <ul class="el-info">
                                                <li>
                                                    <h1>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#create"><i class="icon-plus" ></i></a>
                                                </h1>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        sliderProducts.forEach(function(element) {
                            content = content + 
                            `<div class="col-lg-3 col-md-3 col-sm-6" style=" padding: 1rem; ">
                                <div class="card slider-card">
                                    <div class="el-card-item" >
                                        <div class="el-card-avatar el-overlay-1" > 
                                            <div class="card-body-slider" style="overflow: hidden;">
                                                <h4 class="card-title bg-light w-100">`+element.name+`</h4>
                                            </div>
                                            <img class="card-img-top img-responsive" src="{{ asset('/') }}/`+element.image+`" alt="Not found">
                                            <div class="el-overlay" style="height: 200px;">
                                                <ul class="el-info">
                                                    <li>
                                                        <a class="btn default btn-outline" href="javascript:void(0)" data-id="`+element.id+`" onclick="removeSliderProduct(this)"><i class="icon-trash"></i></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        });

                        $('#sliderProducts').append(content);


                        //products
                        table
                            .clear()
                            .draw();
                        var products = response.products; 
                        products.forEach(function(product) {
                            status = '';
                            if(product.status==1) status = 'checked';
                            var rowNode = table.row.add([ 
                                product.name ,
                                `<img src="{{ asset('/')}}`+product.image+`" style="height: 75px">`,
                                product.qty ,
                                product.price ,
                                product.discount ,
                                `<span class="switchery-demo m-b-30" onclick="statusChange(`+product.id+`)">
                                <input type="checkbox" `+status+` class="js-switch" data-color="#00c292" data-switchery="true" style="display: none;" >
                                </span>`,
                                `<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Show" data-id="`+product.id+`"> <i class="fa fa-eye text-success m-r-10"></i> </a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Edit" data-id="`+product.id+`"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete" data-id="`+product.id+`"  data-token="{{ csrf_token() }}"> <i class="fa fa-trash text-danger"></i> </a>
                                `] ).draw().node();
                                new Switchery($(rowNode).find('.js-switch')[0], $(rowNode).find('.js-switch').data());
                        }); 

                        


                        
                    },
                    error: function(response) {
                        error = "Something wrong.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });
            
        }
        function changeProduct(th){
            product_id = $(th).val();
            // $('input[name=category_id]').val( category_id);

            $.ajax({
                type: "GET",
                url: "{{ route('products.index') }}" + "/" + product_id + "/edit",
                data: "product_id=" + product_id,
                cache:false,
                contentType: false,
                processData: false,
                success: function(response) {                        
                    product = response.product;
                    subCategory = response.subCategory;
                    category = response.category;
                    productShowFunction(product, subCategory, category);
                },
                error: function(response) {
                    error = "Something wrong.";
                    swal({
                        title: "<small class='text-danger'>Error!</small>", 
                        type: "error",
                        text: error,
                        timer: 1000,
                        html: true,
                    });
                }

            });
        }
        function productShowFunction(product, subCategory, category){
                weightArray = [];
                if(product.weight)
                    weightArray = product.weight.split(",");
                weight = '';
                weightArray.forEach(function(element) {
                    weight = weight + `<span class="tag label label-info">`+element+`</span> `;
                });

                if(product.status == 1) 
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-success">Active</span>
                                </div>`;
                else
                    status =    `<div class="form-group row">
                                    <span class="badge badge-pill badge-danger">In-active</span>
                                </div>`
                var content =   `<div class="form-group row">
                                    <label class="col-sm-4 col-form-label form-control"><b>Product name</b></label>
                                    <div class="col-sm-8 form-control">`+product.name+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Category name</b></label>
                                    <div class="col-sm-3 form-control">`+category.name+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Sub category name</b></label>
                                    <div class="col-sm-3 form-control">`+subCategory.name+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Deal code</b></label>
                                    <div class="col-sm-3 form-control">`+product.deal_code+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Mobile no</b></label>
                                    <div class="col-sm-3 form-control">`+product.phone_no+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Quantity</b></label>
                                    <div class="col-sm-3 form-control">`+product.qty+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Weight</b></label>
                                    <div class="col-sm-3 form-control">`+weight+`</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label form-control"><b>Price</b></label>
                                    <div class="col-sm-3 form-control">`+product.price+`</div>
                                    <label class="col-sm-3 col-form-label form-control"><b>Discount</b></label>
                                    <div class="col-sm-3 form-control">`+product.discount+`</div>
                                </div>`+status;
                source = "{{asset('/')}}"+product.image;
                $('img[name="categoriesProductImage"]').attr('src',source);
                $('#showCategoriesContent').html('');
                $('#showCategoriesContent').html(content);
                $('form[name="featuredSlider"]').find('input[name="product_id"]').val(product.id);
            }

            function changeCategory() {
                $( "form[name='updateProduct'] select[name='sub_category_id']" ).html('');
                $( "form[name='updateProduct'] select[name='sub_category_id']" ).append(new Option("--- Select Sub Category Name---", ""));
                category_id = $( "form[name='updateProduct'] select[name='category_id']" ).val();
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
                            $( "form[name='updateProduct'] select[name='sub_category_id']" ).append(new Option(element.name, element.id));
                        });
                    },
                    error: function(response) {
                        error = "Something wrong.";
                        swal({
                            title: "<small class='text-danger'>Error!</small>", 
                            type: "error",
                            text: error,
                            timer: 1000,
                            html: true,
                        });
                    }
                });           
            }
    </script>
@endsection