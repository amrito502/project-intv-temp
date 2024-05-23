<form class="form-horizontal" action="{{ route($tab2Link) }}" method="POST" enctype="multipart/form-data"
    id="newProduct" name="newProduct">
    {{ csrf_field() }}

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">Add {{ $tab2 }}</h4>
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
            <input type="hidden" name="productId" value="{{ $productId }}">
            <input type="hidden" name="type" value="add">

            <div class="row">
                <div class="col-md-6">
                    @php
                    $productSections = array('1'=>'New Arrival','2'=>'Featured Product','3'=>'Top Rated','4'=>'Best
                    Seller');
                    @endphp
                    <label for="product-section">Product Section</label>
                    <select class="form-control chosen-select" name="sections[]"
                        data-placeholder="Select Product Section" multiple>
                        @foreach ($productSections as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="related-product">Related Product</label>
                    <div class="form-group">
                        <select name="related_product[]" data-placeholder="Select Related Products"
                            class="form-control chosen-select-5" multiple>
                            @foreach($relatedProducts as $products)
                            <option value="{{ $products->id }}">{{ $products->name }}({{ $products->deal_code }})
                            </option>
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
                   
                    <div class="row d-none" style="margin-top: 21px;">
                        <div class="col-md-4">
                            <div class="form-check-inline" style="margin-top: 10px;">
                                <label class="form-check-label" for="preOrder">
                                    <input class="form-check-input" type="checkbox" name="pre_order" id="preOrder">
                                    <label for="preOrder">Preorder</label>
                                </label>
                            </div>
                        </div>
                    
                        <div class="col-md-8">
                            <div>
                                <span id="preOrderInput" class="hotDeal">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control form-control-danger" placeholder="Preorder Duration"
                                                name="pre_orderDuration" value="{{ old('pre_orderDuration') }}">
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-none">
                    <label for="related-product">Upsell Product</label>
                    <div class="form-group">
                        <select name="upsell_product[]" data-placeholder="Select Upsell Products"
                            class="form-control chosen-select-5" multiple>
                            @foreach($upsell_product as $products)
                            <option {{@$select}} value="{{ $products->id }}">
                                {{ $products->name }}({{ $products->deal_code }})</option>
                            @endforeach
                        </select>

                        @if ($errors->has('related_product'))
                        @foreach($errors->get('related_product') as $error)
                        <div class="form-control-feedback">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>
                </div>


            </div>

            <div class="row d-none">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check-inline" style="margin-top: 10px;">
                                <label class="form-check-label" for="hot-deal">
                                    <input class="form-check-input" type="checkbox" name="hotDeal" id="hotInput">
                                    <label for="hot-deal">Hot Deal</label>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div>
                                <span id="hotDeal" class="hotDeal">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Hot Deal Discount" name="hotDiscount"
                                                value="{{ old('hotDiscount') }}">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control form-control-danger datepicker"
                                                placeholder="Date" name="hotDate" value="{{ old('hotDate') }}"
                                                readonly="">
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
                            <div class="form-group">
                                <div class="form-check-inline" style="margin-top: 10px;">
                                    <label class="form-check-label" for="free_shipping">
                                        <input class="form-check-input" type="checkbox" name="free_shipping"
                                            value="free">
                                        <label for="vat-applicable">Free Shipping</label>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <br>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check-inline" style="margin-top: 10px;">
                                <label class="form-check-label" for="hot-deal">
                                    <input class="form-check-input" type="checkbox" id="specialInput"
                                        name="specialDeal">
                                    <label for="special-deal">Special Deal</label>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <span id="specialDeal" class="specialDeal">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-danger"
                                                placeholder="Special Deal Discount" name="specialDiscount"
                                                value="{{ old('specialDiscount') }}">
                                        </div>

                                        <div class="col-md-5">
                                            <input type="text" class="form-control form-control-danger datepicker"
                                                placeholder="Date" name="specialDate" value="{{ old('specialDate') }}"
                                                readonly="">
                                        </div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-check-inline" style="margin-top: 10px;">
                                <label class="form-check-label" for="hot-deal">
                                    <input class="form-check-input" type="checkbox" name="hotDeal" id="vat_applicable">
                                    <label for="vat-applicable">Vat Applicable (%)</label>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <input type="number" class="form-control form-control-danger" placeholder="VAT"
                                name="vat_amount" value="{{old('vat_amount')}}">
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <style type="text/css">
                            .chosen-single {
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

                            <div class="row">
                                <div class="col-md-6">
                                    <select name="customerGroupId[]" data-placeholder="Select Group"
                                        class="form-control chosen-select customerGroup">
                                        <option value="">Select Any Group</option>
                                        @foreach($customer_groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->groupName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" name="customerGroupPrice[]" class="form-control"
                                        placeholder="price for customer group" value="">
                                </div>
                            </div>
                        </span>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" class="group_count" value="1">
                                <p align="right"> <span class="btn btn-success add_customer_group"><i
                                            class="fa fa-plus"></i> Add Group</span></p>
                            </div>
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

<div id="customer_group" style="display:none">
    <div class="input select">
        <select>
            <option value="">Select Client Group</option>
            @foreach($customer_groups as $group)
            <option value="{{ $group->id }}">{{ $group->groupName }}</option>
            @endforeach
        </select>
    </div>
</div>