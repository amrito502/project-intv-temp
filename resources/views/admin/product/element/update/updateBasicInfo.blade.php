<form class="form-horizontal" action="{{ route($tab1Link) }}" method="POST" enctype="multipart/form-data" id="basicInfo" name="basicInfo">
    {{ csrf_field() }}

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">Add {{ $tab1 }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-outline-info btn-lg" href="{{ route($goBackLink) }}">
                        <i class="fa fa-arrow-circle-left"></i> Go Back
                    </a>
                    <button type="submit" name="submit" value="update" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                    <button type="submit" name="submit" value="update_golist" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> Update & Go List</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <input type="hidden" name="productId" value="{{ $productId }}">
            <input type="hidden" name="type" value="update">
            <div class="row">
                <div class="col-md-3">
                    @php
                    $productCategory = explode(',', $product->category_id);
                    @endphp
                    <label for="category"> Chosse Category</label>
                    <div class="form-group {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                        <select name="category_id[]" data-placeholder="Choose Category" class="chosen-select" multiple tabindex="4">
                            @foreach($categories as $category)
                            @php
                            $select = "";
                            if (in_array($category->id, $productCategory))
                            {
                            $select = "selected";
                            }
                            else
                            {
                            $select = "";
                            }
                            @endphp
                            <option {{ $select }} value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('category_id'))
                        @foreach($errors->get('category_id') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="product-deal-code">Deal Code</label>
                    <div class="form-group {{ $errors->has('deal_code') ? ' has-danger' : '' }}">
                        <input type="text" class="form-control form-control-danger" placeholder="Write new product code" name="deal_code" value="{{ $product->deal_code }}">
                        @if ($errors->has('deal_code'))
                        @foreach($errors->get('deal_code') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                        <label for="product-name">Product Name</label>
                        <input type="text" class="form-control form-control-danger" name="name" value="{{ $product->name }}" required>
                        @if ($errors->has('name'))
                        @foreach($errors->get('productNname') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="regular-price">MRP price</label>
                            <div class="form-group {{ $errors->has('price') ? ' has-danger' : '' }}">
                                <input type="number" class="form-control form-control-danger" placeholder="Product price" name="price" value="{{ $product->price }}" required>
                                @if ($errors->has('price'))
                                @foreach($errors->get('price') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="product-discount">Trade Price</label>
                            <div class="form-group {{ $errors->has('discount') ? ' has-danger' : '' }}">
                                <input type="number" class="form-control form-control-danger" placeholder="Trade Price" name="discount" value="{{ $product->discount }}">
                                @if ($errors->has('discount'))
                                @foreach($errors->get('discount') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-4">
                            <label for="purchase-point">Purchase Point</label>
                            <div class="form-group {{ $errors->has('purchase_point') ? ' has-danger' : '' }}">
                                <input type="number" class="form-control form-control-danger" placeholder="PP" name="purchase_point" value="{{ $product->pp }}" step="any">
                                @if ($errors->has('purchase_point'))
                                @foreach($errors->get('purchase_point') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="order-by">Order By</label>
                            <div class="form-group {{ $errors->has('orderBy') ? ' has-danger' : '' }}">
                                <input type="number" class="form-control form-control-danger" name="orderBy" value="{{ $product->orderBy }}" required>
                                @if ($errors->has('orderBy'))
                                @foreach($errors->get('orderBy') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="stock-status">Stock Check</label>
                            <div class="form-group {{ $errors->has('stockUnit') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" value="1" name="stockUnit" id="stockstatusActive"> Yes
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" value="0" name="stockUnit" id="stockstatusInactive"> No
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!--<div class="row">-->

            <div class="d-none">
                <label for="publication-status">Status</label>
                <div class="form-group {{ $errors->has('status') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" value="1" name="status" id="published" required> Published
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" value="0" name="status" id="unpublished"> Unpublished
                        </label>
                    </div>
                </div>
            </div>
            <!--</div>-->

            <div class="d-none">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tag-line">Tag Line</label>
                            <div class="form-group {{ $errors->has('tag') ? ' has-danger' : '' }}">
                                <input type="text" class="form-control form-control-danger" data-role="tagsinput" name="tag" value="{{ $product->tag }}">
                                @if ($errors->has('tag'))
                                @foreach($errors->get('tag') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="d-none">
                            <label for="youtube-link">Youtube Link</label>
                            <div class="form-group {{ $errors->has('youtubeLink') ? ' has-danger' : '' }}">
                                <input type="text" class="form-control form-control-danger" placeholder="write your youtube link" name="youtubeLink" value="{{  $product->youtubeLink }}">
                                @if ($errors->has('youtubeLink'))
                                @foreach($errors->get('youtubeLink') as $error)
                                <div class="form-control-feedback">{{ $error }}</div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="short-descriotion">Product Details</label>
                    <div class="form-group {{ $errors->has('product_details') ? ' has-danger' : '' }}">
                        <textarea class="summernote form-control form-control-danger" name="product_details" value="{{ $product->product_details }}">{{ $product->product_details }}</textarea>
                        @if ($errors->has('product_details'))
                        @foreach($errors->get('product_details') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <label for="short-descriotion">Short description</label>
                    <div class="form-group {{ $errors->has('description1') ? ' has-danger' : '' }}">
                        <textarea class="summernote form-control form-control-danger" name="description1" value="{{ $product->description }}">{{ $product->description1 }}</textarea>
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
                        <textarea class="summernote form-control form-control-danger" name="description2" value="{{ $product->description2 }}">{{ $product->description2 }}</textarea>
                        @if ($errors->has('description2'))
                        @foreach($errors->get('description2') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" name="submit" value="update" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                <button type="submit" name="submit" value="update_golist" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> Update & Go List</button>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    document.forms['basicInfo'].elements['status'].value = "{{$product->status}}";
    document.forms['basicInfo'].elements['stockUnit'].value = "{{$product->stockUnit}}";

</script>
