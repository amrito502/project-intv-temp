@extends('admin.layouts.master')

@section('custom-css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')


<?php
    use App\ProductImage;
    $allImages = ProductImage::where('productId',$products->id)->get();
?>

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<?php
    $productId = @$_GET["productId"];
?>

<style type="text/css">

 .uploadImage{
        color: red;
        margin-top: 5px;
    }

  .hotDeal input,.specialDeal input{
    /*padding: 7px;*/
  }
  .hotDeal{
    /*margin-left: 24px;*/
  }
  .modal-body{
  border: 2px solid #f3bfbf;
}
.allInfo{
    margin-bottom: 15px;
}

.gallery img{
    width: 168px;
    margin-left: 7px;
    margin-top: 7px;
    border: 3px solid #c7b8b8;
    border-radius: 4px;
    padding: 7px;
}
.chosen-container { width: 100% !important }
.search-choice{
    width: auto;
    display: inline-block;
}

.remove{
    margin-top: -125px;
    margin-left: -33px;
}

.bootstrap-tagsinput{
    width: 670px;
}

</style>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><h4 class="card-title">{{$title}}</h4> </div>
                    <div class="col-md-6">
                        <span class="shortlink">
                            <a style="font-size: 16px;" class="btn btn-outline-info btn-lg"  href="{{ route('products.index') }}">Go Back</a>
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @php
                    $message = Session::get('msg');
                    if (isset($message))
                    {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-success'><strong>" .$message."</strong></div>";
                    }

                    Session::forget('msg')
                @endphp

                @php
                    $message = Session::get('error_msg');
                    if (isset($message))
                    {
                        echo"<div style='display:inline-block;width: auto;' class='alert alert-danger'><strong>" .$message."</strong></div>";
                    }

                    Session::forget('msg')
                @endphp

                <div class="row allInfo">
                    <div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                        <button onclick="basic()" class="btn btn-default basic active" checked="checked">Basic Info</button>
                        <button onclick="advance()" class="btn btn-default advance">Advance Info</button>
                        <button onclick="seo()" class="btn btn-default seo">SEO Info</button>
                        <button onclick="others()" class="btn btn-default others">Others</button>
                    </div>
                </div>

                <div id="addNewProduct" class="">
                    <!-- Basic information of product -->
                    <form class="form-horizontal" action="{{ route('product.update') }}" method="POST" enctype="multipart/form-data" id="basicInfo" name="basicInfo">
                        {{ csrf_field() }}
                        @php
                            $allCategory = explode(',', $products->category_id);
                        @endphp

                        <div class="modal-body">
                            <input type="hidden" name="productId" value="{{$products->id}}">

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="category"> Chosse Category</label>
                                    <div class="form-group {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                                        <select name="category_id[]" data-placeholder="Choose Category" class="form-control chosen-select" multiple tabindex="4">
                                            @foreach($categories as $category)
                                                <option  <?php if (in_array($category->id, $allCategory)){echo "selected";} ?> value="{{ $category->id }}">{{ $category->categoryName }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category_id'))
                                            @foreach($errors->get('category_id') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="product-name">Product name</label>
                                    <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Product name" name="name" value="{{ $products->name }}" required>
                                        @if ($errors->has('name'))
                                            @foreach($errors->get('name') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-deal-code">Product Deal Code</label>
                                    <div class="form-group {{ $errors->has('deal_code') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Product deal code" name="deal_code" value="{{ $products->deal_code }}">
                                        @if ($errors->has('deal_code'))
                                            @foreach($errors->get('deal_code') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="product-discount">Product Discount</label>
                                    <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Product discount" name="discount" value="{{ $products->discount }}">
                                        @if ($errors->has('discount'))
                                            @foreach($errors->get('discount') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-quantity">Product quantity</label>
                                    <div class="form-group {{ $errors->has('qty') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Product quantity" name="qty" value="{{ $products->qty }}">
                                        @if ($errors->has('qty'))
                                            @foreach($errors->get('qty') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Product Price">Product Price</label>
                                            <div class="form-group {{ $errors->has('price') ? ' has-danger' : '' }}">
                                                <input type="text" class="form-control form-control-danger" placeholder="Product price" name="price" value="{{ $products->price }}" required>
                                                @if ($errors->has('price'))
                                                    @foreach($errors->get('price') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone-no">Product Marchent Phone No</label>
                                            <div class="form-group row {{ $errors->has('phone_no') ? ' has-danger' : '' }}">
                                                <input type="text" class="form-control form-control-danger" placeholder="Product marchent phone no" name="phone_no" value="{{ $products->phone_no }}">
                                                @if ($errors->has('phone_no'))
                                                    @foreach($errors->get('phone_no') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="publication-status">Publication status</label>
                                    <div class="form-group {{ $errors->has('status') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" value="1" name="status" id="published" required> Published
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" value="0" name="status" id="unpublished" checked=""> Unpublished
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock-unit">Stock Unit</label>
                                    <div class="form-group {{ $errors->has('stockUnit') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" value="1" name="stockUnit"> In Stock
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" value="2" name="stockUnit"> Sold Out
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="youtube-link">Youtube Link</label>
                                    <div class="form-group {{ $errors->has('youtubeLink') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="write your youtube link" name="youtubeLink" value="{{ $products->youtubeLink }}">
                                        @if ($errors->has('youtubeLink'))
                                            @foreach($errors->get('youtubeLink') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="order-by">Order By</label>
                                    <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                                        <input type="number" class="form-control form-control-danger" name="orderBy" value="{{ $products->orderBy }}" required>
                                        @if ($errors->has('orderBy'))
                                            @foreach($errors->get('orderBy') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="short-descriotion">Short description</label>
                                    <div class="form-group row {{ $errors->has('description1') ? ' has-danger' : '' }}">
                                        <textarea class="summernote form-control form-control-danger" name="description1" value="">{{$products->description1 }}</textarea>
                                        @if ($errors->has('description1'))
                                            @foreach($errors->get('description1') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="long-description">Long description</label>
                                    <div class="form-group {{ $errors->has('description2') ? ' has-danger' : '' }}">
                                        <textarea class="summernote form-control form-control-danger" name="description2" value="">{{$products->description2 }}</textarea>
                                        @if ($errors->has('description2'))
                                            @foreach($errors->get('description2') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Advance information of product -->

                    <form class="form-horizontal" action="javascript:void(0)" id="image-form" name="image-form" method="POST" enctype="multipart/form-data" style="display: none;">
                        {{ csrf_field() }}

                        <div class="modal-body" style="margin-bottom: 10px;">
                            <input type="hidden" name="productId" value="{{ $products->id }}">

                            <div class="row">
                                <div class="col-md-11">
                                    <label for="product-image">Product image</label>
                                    <div class="form-group">
                                        <input type="file" class="form-control" aria-describedby="fileHelp" name="multiImage[]" id="gallery-photo-add" multiple="multiple">
                                        @if ($errors->has('image'))
                                            @foreach($errors->get('image') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                        <p class="uploadImage">Standard Image Size: 700px * 700px</p>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label for=""></label>
                                    <div class="form-group">
                                        <button type="submit" id="addImage" class="btn btn-outline-info waves-effect">Upload</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for=""></label>
                                    <div  class="form-group gallery" id="div_image_reload">
                                        <div class="col-sm-4 col-md-6" id="images">
                                            @foreach($allImages as $productImage)
                                                <span>
                                                    <input type="hidden" name="imageId" value="{{ $productImage->id }}">
                                                    <img class="single-image" src="{{asset('/').$productImage->images}}">
                                                    <a href="javascript:void(0)" data-id="{{$productImage->id}}" class="btn btn-danger remove">x</a>
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form class="form-horizontal" action="{{ route('productadvance.update') }}" method="POST" enctype="multipart/form-data" id="advanceInfo" name="advanceInfo" style="display: none;">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" name="productId" value="{{$products->id}}">

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            @php
                                $allsection = explode(',', $products->productSection);
                            @endphp

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-section">Product Section</label>
                                    <div class="form-group {{ $errors->has('section') ? ' has-danger' : '' }}">
                                         <div class="form-check-inline">
                                            <label class="form-check-label" for="new-arrival">
                                                <input type="checkbox" class="form-check-input" id="section" name="section[]" value="1">New Arrival
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="featured-product">
                                                <input type="checkbox" class="form-check-input" id="section" name="section[]" value="2" <?php if (in_array("2", $allsection)) { echo "checked"; }  ?>>Featured Product
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="top-rated">
                                                <input type="checkbox" class="form-check-input" id="section" name="section[]" value="3" <?php if (in_array("3", $allsection)) { echo "checked"; }  ?>>Top Rated
                                            </label>
                                        </div>

                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="best-seller">
                                                <input type="checkbox" class="form-check-input" id="section" name="section[]" value="4" <?php if (in_array("4", $allsection)) { echo "checked"; }  ?>>Best Seller
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-check-inline">
                                            <label class="form-check-label" for="hot-deal">
                                                <input class="form-check-input" type="checkbox" name="free_shipping" value="free" <?php if(@$productSections->free_shipping){echo "checked";} ?>>Free Shipping
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hot Deal Section -->
                            <div class="row" style="height: 45px;">
                                <div class="col-md-6">
                                    <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="hot-deal">
                                                        <input class="form-check-input" type="checkbox" name="hotDeal" value="{{ old('hotDeal') }}" id="hotInput" <?php if(@$productSections->hotDiscount){echo "checked";} ?>>Hot Deal
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <span style="display: none;" id="hotDeal" class="hotDeal">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                 <input type="text" class="form-control form-control-danger" placeholder="Discount Price" name="hotDiscount" value="{{ @$productSections->hotDiscount }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control form-control-danger datepicker" placeholder="Date" name="hotDate" value="{{ @$productSections->hotDate }}">
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label" for="hot-deal">
                                                        <input class="form-check-input" type="checkbox" id="specialInput" name="specialDeal" value="{{ old('specialDeal') }}">
                                                        <label for="special-deal">Special Deal</label>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <span style="display: none;" id="specialDeal" class="specialDeal">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control form-control-danger" placeholder="Discount Price" name="specialDiscount" value="{{  @$productSections->specialDiscount }}">
                                                            </div>

                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control form-control-danger datepicker" placeholder="Date" name="specialDate" value="{{ @$productSections->specialDate }}">
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            @php
                                @$related_product = explode(',', $productSections->related_product);
                                @$customer_group = explode(',', $productSections->customerGroupId);
                            @endphp

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="related-product">Related Product</label>
                                    <div class="form-group">
                                        <select name="related_product[]" data-placeholder="Select Products" class="form-control chosen-select" multiple tabindex="4">
                                            @foreach($allProducts as $product)
                                                <option  <?php if (in_array($product->id, $related_product)){echo "selected";} ?> value="{{ $product->id }}">{{ $product->name }}({{ $product->deal_code }})</option>
                                             @endforeach
                                        </select>

                                        @if ($errors->has('related_product'))
                                            @foreach($errors->get('related_product') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="pre-order">Pre Order</label>
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control form-control-danger" placeholder="Order Duration" name="pre_orderDuration" value="{{ @$productSections->pre_orderDuration }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <style type="text/css">
                                            .chosen-single{
                                                padding: 5px 16px !important;
                                                height: 37px !important;
                                            }
                                        </style>
                                        <span class="customerGroupRow">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Customer Group Name</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Price</label>
                                                </div>
                                            </div>

                                        <?php if(count($customerGroup) < 1){  ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select name="customerGroupId[]" data-placeholder="Select Group" class="form-control chosen-select customerGroup">
                                                           <option value="">Select Any Group</option>
                                                            @foreach($customer_groups as $group)
                                                                <option value="{{ $group->id }}">{{ $group->groupName }}</option>
                                                             @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <input type="text" name="customerGroupPrice[]" class="form-control" placeholder="price for customer group" value="">
                                                    </div>
                                                </div>
                                                <?php }else{ ?>

                                                <?php
                                                    $i = 0;
                                                    foreach ($customerGroup as $custGroup) {
                                                    $i++;
                                                    if($i>1){
                                                        $break = "extraGroup";
                                                    }else{
                                                       $break = "";
                                                    }
                                                ?>
                                                <div class="row extra_group_{{$i}} {{$break}}">
                                                    <div class="col-md-6">
                                                        <select name="customerGroupId[]" data-placeholder="Select Group" class="form-control chosen-select customerGroup">
                                                           <option value="">Select Any Group</option>
                                                            @foreach($customer_groups as $group)
                                                                <?php
                                                                    if($group->id == $custGroup->customerGroupId){
                                                                        $selected = "selected";
                                                                    }else{
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                    <option {{$selected}} value="{{ $group->id }}">{{ $group->groupName }}</option>
                                                             @endforeach
                                                            </select>
                                                                @if ($errors->has('customerGroupId'))
                                                                @foreach($errors->get('customerGroupId') as $error)
                                                                <div class="form-control-feedback">{{ $error }}</div>
                                                                @endforeach
                                                                @endif

                                                    </div>

                                                    <div class="col-md-6">
                                                        <span class="cnt_remove"><i class="fa fa-times" onclick="mychar({{$i}})"></i>
                                                        <input type="text" name="customerGroupPrice[]" class="form-control" placeholder="price for customer group" value="{{$custGroup->customerGroupPrice}}">
                                                        @if ($errors->has('customerGroupPrice'))
                                                        @foreach($errors->get('customerGroupPrice') as $error)
                                                        <div class="form-control-feedback">{{ $error }}</div>
                                                        @endforeach
                                                        @endif
                                                        </span>
                                                    </div>
                                                </div>

                                        <?php } } ?>
                                        </span>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" class="group_count" value="{{count($customerGroup)}}">
                                                <p align="right"> <span class="btn btn-success add_customer_group"><i class="fa fa-plus"></i> Add Group</span></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- SEO information of product -->

                    <form class="form-horizontal" action="{{ route('productseo.update') }}" method="POST" enctype="multipart/form-data" id="seoInfo" name="seoInfo" style="display: none;">
                        {{ csrf_field() }}

                        <div class="modal-body">
                            <input type="hidden" name="productId" value="{{$products->id}}">

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect">Update</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="meta-title">Meta Title</label>
                                    <div class="form-group {{ $errors->has('metaTitle') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Meta Title" name="metaTitle" value="{{ $meta->metaTitle }}" required>
                                        @if ($errors->has('metaTitle'))
                                            @foreach($errors->get('metaTitle') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="meta-keyword">Meta keyword</label>
                                    <div class="form-group {{ $errors->has('metaKeyword') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Meta Keyword" name="metaKeyword" value="{{ $meta->metaKeyword }}" data-role="tagsinput" required>
                                        @if ($errors->has('metaKeyword'))
                                            @foreach($errors->get('metaKeyword') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label for="meta-description">Meta description</label>
                                    <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                                        <textarea style="min-height: 100px;" class="form-control" name="metaDescription" required>{{ $meta->metaDescription }}</textarea>
                                        @if ($errors->has('metaDescription'))
                                            @foreach($errors->get('metaDescription') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Others information of product -->

                    <form class="form-horizontal" action="{{ route('productOthers.update') }}" method="POST" enctype="multipart/form-data" id="othersInfo" name="othersInfo" style="display: none;">
                        {{ csrf_field() }}

                        <div class="modal-body">
                            <input type="hidden" name="productId" value="{{$products->id}}">

                            <div class="row">
                                <div class="col-md-12 m-b-20 text-right">
                                    <button type="submit" class="btn btn-outline-info btn-lg">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                        <label for="tag-line">Tag Line</label>
                                    <div class="form-group {{ $errors->has('tag') ? ' has-danger' : '' }}">
                                        <input type="text" class="form-control form-control-danger" placeholder="Tag line" name="tag" value="{{ $meta->tag }}" data-role="tagsinput">
                                        @if ($errors->has('tag'))
                                            @foreach($errors->get('tag') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="slider-image">Slider image</label>
                                     <div class="form-group {{ $errors->has('sliderImage') ? ' has-danger' : '' }}">
                                        <input type="file" class="form-control" id="sliderImage" aria-describedby="fileHelp" name="sliderImage" alt="You have no image">
                                        @if ($errors->has('sliderImage'))
                                            @foreach($errors->get('sliderImage') as $error)
                                                <div class="form-control-feedback">{{ $error }}</div>
                                            @endforeach
                                        @endif
                                        <img style="width: 200px;" src="{{asset('/').@$sliders->source}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>
</div>

<div id="customer_group" style="display:none">
    <div class="input select">
    <select>
        @foreach($customer_groups as $group)
                <option value="{{ $group->id }}">{{ $group->groupName }}</option>
        @endforeach
    </select>
    </div>
</div>


@endsection

@section('custom-js')

<script src="{{ asset('admin-elite/assets/node_modules/datatables/jquery.dataTables.min.js') }}">

</script>


<script type="text/javascript">
     $(document).ready(function() {

            var updateThis ;

        //ajax upload image
            $( "form[name='image-form']" ).on( "submit", function( event ) {
                console.log('asdfasf');
                $('.has-danger').removeClass('has-danger');
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('image.upload') }}",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        var product = response.product;
                        var images = response.images;
                        swal({
                            title: "<small class='text-success'>Success!</small>",
                            type: "success",
                            text: "Image Successfully Uploded!",
                            timer: 2000,
                            html: true,
                        });
                        $('#images').html(images);
                        /*$("#div_image_reload").load(location.href + " #div_image_reload");*/
                    },
                    error: function(response) {

                    }
                });

                $("#image-form")[0].reset();
            });

            //ajax remove image
            $('.remove').on('click', function(e){
                e.preventDefault();
                let id = $(this).attr('data-id');

                var image_row = $(this).parent().children();
                var close_button = $(this).parent().children('.single-image');

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
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type : 'DELETE',
                             url: "{{ route('image.remove') }}",
                            data : {
                                id : id,
                            },
                            success : function(response){
                                swal({
                                    title: "<small class='text-success'>Success!</small>",
                                    type: "success",
                                    text: "Image deleted Successfully!",
                                    timer: 1000,
                                    html: true,
                                });
                                if(response){
                                    image_row.remove();

                                }
                            }.bind(this)
                        })

             }else {
                        swal({
                            title: "Cancelled",
                            type: "error",
                            text: "Your Image is safe :)",
                            timer: 1000,
                            html: true,
                        });
                    }
         });

            });

        });
</script>


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

<script>


    function basic() {

        $(this).addClass('active');
        $('.advance').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').removeClass('active');
        $('.basic').addClass('active');
        $('#basicInfo').show();
        $('#image-form').hide();
        $('#advanceInfo').hide();
        $('#seoInfo').hide();
        $('#othersInfo').hide();

    }

    function advance() {
        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').removeClass('active');
        $('.advance').addClass('active');
        $('#image-form').show();
        $('#advanceInfo').show();
        $('#basicInfo').hide();
        $('#seoInfo').hide();
        $('#othersInfo').hide();


    }
    function seo() {

        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.advance').removeClass('active');
        $('.others').removeClass('active');
        $('.seo').addClass('active');
        $('#basicInfo').hide();
        $('#advanceInfo').hide();
        $('#image-form').hide();
        $('#seoInfo').show();
        $('#othersInfo').hide();


    }
    function others() {

        $(this).addClass('active');
        $('.basic').removeClass('active');
        $('.advance').removeClass('active');
        $('.seo').removeClass('active');
        $('.others').addClass('active');
        $('#basicInfo').hide();
        $('#advanceInfo').hide();
        $('#image-form').hide();
        $('#seoInfo').hide();
        $('#othersInfo').show();


    }



</script>

<script type="text/javascript">
    $(function () {
        $("#hotInput").click(function () {
            if ($(this).is(":checked")) {
                $("#hotDeal").show();
                $("#specialInput"). prop("checked", false);
                $("#specialDeal").hide();
            } else {
                $("#hotDeal").hide();
            }
        });
    });

    $(function () {
        $("#specialInput").click(function () {
            if ($(this).is(":checked")) {
                $("#specialDeal").show();
                $("#hotInput"). prop("checked", false);
                $("#hotDeal").hide();
            } else {
                $("#specialDeal").hide();
            }
        });
    });
</script>


<script type="text/javascript">
    var dateToday = new Date();
    $(function() {
        $( ".datepicker" ).datepicker({
            numberOfMonths: 2,
            showButtonPanel: true,
            minDate: dateToday,
            dateFormat: 'dd MM yy'
        });
    });
</script>

<script type="text/javascript">
    document.forms['basicInfo'].elements['status'].value ="{{$products->status}}";
    document.forms['basicInfo'].elements['stockUnit'].value ="{{$products->stockUnit}}";
</script>

<script type="text/javascript">
    $(".add_customer_group").click(function () {
        var group_count = $('.group_count').val();
        var total = parseInt(group_count) + 1;
        $(".customerGroupRow").append(
            '<div class="row extraGroup extra_group_'+total+'"><div class="col-md-6">'+
            '<select name="customerGroupId[]" data-placeholder="Select Group" class="form-control chosen-select customerGroupOption_'+total+'">'+
            '</select>'+
            '</div>'+
            '<div class="col-md-6">'+
           '<span class="cnt_remove"><i class="fa fa-times" onclick="mychar(' + total + ')"></i>'+
                '<input type="text" name="customerGroupPrice[]" class="form-control" placeholder="price for customer group" value=""></span>'+

            '</div></div>'
        );

        $('.group_count').val(total);
        var extra_group = $("#customer_group div select").html();
        $('.customerGroupOption_'+total).html(extra_group);
        $('.chosen-select').chosen();
        $('.chosen-select').trigger("chosen:updated");
    });

    function mychar(i) {
            $(".extra_group_" + i).remove();
        }

</script>

<style type="text/css">
    .extraGroup{
        margin-top: 5px !important;
    }
    .cnt_remove {
            width: 100%;
            position:  relative;
            top: 0;
            right: 0;
            display: inline-block;
        }
        .cnt_remove i {
            position:  absolute;
            top: -7px;
            right: -10px;
            z-index: 9;
            display: none;
            cursor: pointer;
            display: block;
        }

        .cnt_remove:hover i {
            display: block;
        }
</style>

@endsection


