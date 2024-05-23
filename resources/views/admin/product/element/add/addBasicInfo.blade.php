<form class="form-horizontal" action="{{ route($tab1Link) }}" method="POST" enctype="multipart/form-data" id="newProduct" name="newProduct">
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
                    <button type="submit" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> {{ $buttonName }}</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <input type="hidden" name="type" value="add">
            <div class="row">
                <div class="col-md-3">
                    <label for="category"> Chose Category</label>
                    <div class="form-group {{ $errors->has('category_id') ? ' has-danger' : '' }}">
                        <select name="category_id[]" data-placeholder="Choose Category" class="chosen-select" multiple tabindex="4">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('category_id'))
                        @foreach($errors->get('category_id') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>

                {{-- <div class="col-md-3">
                    <label for="category">Chose Brand</label>
                    <div class="form-group {{ $errors->has('brand_id') ? ' has-danger' : '' }}">
                <select name="brand_id" data-placeholder="Choose Brand" class="chosen-select">
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('category_id'))
                @foreach($errors->get('category_id') as $error)
                <div class="form-control-feedback">{{ $error }}</div>
                @endforeach
                @endif
            </div>
        </div> --}}
        <div class="col-md-3">
            <label for="product-deal-code">Deal Code</label>
            <div class="form-group {{ $errors->has('deal_code') ? ' has-danger' : '' }}">
                <input type="text" class="form-control form-control-danger" placeholder="Write new product code" name="deal_code" value="{{ old('deal_code') }}">
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
                <input type="text" class="form-control form-control-danger" name="name" value="{{ old('name') }}" required>
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
                        <input type="number" class="form-control form-control-danger" placeholder="Product price" name="price" value="{{ old('price') }}" required>
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
                        <input type="number" class="form-control form-control-danger" placeholder="Trade Price" name="discount" value="{{ old('discount') }}">
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
                        <input type="number" class="form-control form-control-danger" placeholder="PP" name="purchase_point" value="{{ !empty(old('purchase_point')) ? old('purchase_point') : 0 }}" step="any">
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
                        <input type="number" class="form-control form-control-danger" name="orderBy" value="{{ old('orderBy') }}" required>
                        @if ($errors->has('orderBy'))
                        @foreach($errors->get('orderBy') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="stock-status">Stock Status Check</label>
                    <div class="form-group {{ $errors->has('stockstatus') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" value="1" name="stockUnit" id="stockstatusActive"> Yes
                            </label>
                        </div>

                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="radio" value="0" name="stockUnit" id="stockstatusInactive" checked>
                                No
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-none">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <label for="tag-line">Tag Line</label>
                    <div class="form-group {{ $errors->has('tag') ? ' has-danger' : '' }}">
                        <input type="text" class="form-control form-control-danger" name="tag" value="{{ old('tag') }}">
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
                        <input type="text" class="form-control form-control-danger" placeholder="write your youtube link" name="youtubeLink" value="{{  old('youtubeLink') }}">
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
                <textarea class="summernote form-control form-control-danger" name="product_details" value="{{ old('product_details') }}">{{ old('product_details') }}</textarea>
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
                <textarea class="summernote form-control form-control-danger" name="description1" value="{{ old('description') }}">{{ old('description1') }}</textarea>
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
                <textarea class="summernote form-control form-control-danger" name="description2" value="{{ old('description2') }}">{{ old('description2') }}</textarea>
                @if ($errors->has('description2'))
                @foreach($errors->get('description2') as $error)
                <div class="form-control-feedback">{{ $error }}</div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="d-none">
            <label for="publication-status">Status</label>
            <div class="form-group {{ $errors->has('status') ? ' has-danger' : '' }}" style="height: 40px; line-height: 40px;">
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" value="1" name="status" id="published" required checked="">
                        Published
                    </label>
                </div>

                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" value="0" name="status" id="unpublished"> Unpublished
                    </label>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-outline-info btn-lg waves-effect"><i class="fa fa-save"></i> {{ $buttonName }}</button>
            </div>
        </div>
    </div>
    </div>
</form>
