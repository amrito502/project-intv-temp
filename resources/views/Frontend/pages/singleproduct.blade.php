@extends('frontend.master')

@section('mainContent')

<?php
    use App\Product;
    use App\ProductImage;
    use App\ProductSections;
    use App\Review;
    $image = ProductImage::where('productId', $products->id)->first();

    $allImage = ProductImage::where('productId', $products->id)->get();

    // $customerId = Session::get('customerId');
    $customerId = @Auth::guard('customer')->user()->id;

    $allReview = Review::where('productId', $products->id)->count();

    $totalStar = $allReview * 5;

    $totalRating = Review::where('productId', $products->id)->sum('star');

    $rating = 0;
    if($totalRating > 0){
        @$rating = @$totalRating * 100 / $totalStar;
    }
    $setReview = @$_GET['setReview'];
    if (@$setReview == $products->id) {
        $activeReview = 'active';
        $activeTab = 'active in';
    } else {
        $activeReview = '';
    }

    if (!@$setReview) {
        $active = 'active';
    }


    $stockCheck = \App\Helper\StockStatus::StockCheck($products->id);
    if ($stockCheck->id != NULL && $stockCheck->remainingQty == 0 || $stockCheck->remainingQty < 0) {
        $disabled = "disabled";
        $availability = "Out of Stock";
        $availabilityColor = "red";
    } else {
        $disabled = "";
        $availability = "In Stock";
        $availabilityColor = "green";
    }


    ?>



<div class="container">
    <div class="row" style="padding-top: 20px;">

        <div id="left-column" class="col-xs-12 col-sm-4 col-md-3 d-none d-md-block">
            <section class="laberNewProducts-box laberProductColumn laberColumn clearfix">
                <h3>New products</h3>
                <div class="product_list">

                    <div class="laberNewProducts owl-carousel owl-theme"
                        style="opacity: 1; display: block;padding: 20px 5px;">

                        <div class="outer-item">
                            <div class="row">

                                @foreach($latestProducts[0] as $latestProduct)

                                @php
                                $ProductImage = $noImage;

                                if ($latestProduct->images->first() != null){
                                if(file_exists($latestProduct->images->first()->images)){
                                $ProductImage = $latestProduct->images->first()->images;
                                }
                                }
                                @endphp

                                <div class="item col-lg-12 col-md-12 px-1" style="margin-bottom: 20px">
                                    <article class="product-miniature product-miniature_left js-product-miniature"
                                        data-id-product="32" data-id-product-attribute="59" itemscope=""
                                        itemtype="http://schema.org/Product">
                                        <div class="laberProduct-container">
                                            <div class="row m-0">
                                                <div class="laberProduct-image col-lg-5 col-md-12 col-xs-5 p-0">

                                                    <a href="{{ route('product.singles', [$latestProduct->slug]) }}">
                                                        <img class="latestPimg" src="{{ asset($ProductImage) }}"
                                                            alt="{{ $latestProduct->name }}"
                                                            data-full-size-image-url="{{ $ProductImage }}">
                                                    </a>
                                                </div>
                                                <div
                                                    class="laber-product-description col-lg-7 col-md-12 col-xs-7 latestP p-0">
                                                    <p class="dealPP"><span class="font-weight-bold">Code:</span>
                                                        {{$latestProduct->deal_code}}</p>
                                                    <h2 class="productName font-weight-bold" itemprop="name">
                                                        <a href="{{ route('product.singles', [$latestProduct->slug]) }}"
                                                            class="text-capitalize" title="Hummingbird notebook">
                                                            {{ Str::limit(strtolower($latestProduct->name), 15) }}
                                                        </a>
                                                    </h2>
                                                    <p class="dealPP"><span class="font-weight-bold">PP:</span>
                                                        {{$latestProduct->pp}}</p>
                                                    <div class="laber-product-price-and-shipping">

                                                        <?php $latestProductnetAMount = $latestProduct->price; ?>

                                                        @if($latestProduct->stockUnit == 1)
                                                        @if ($latestProduct->onStock())
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">OUT OF STOCK</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                @endforeach


                                @foreach($latestProducts[0] as $latestProduct)

                                @php
                                $ProductImage = $noImage;

                                if ($latestProduct->images->first() != null){
                                if(file_exists($latestProduct->images->first()->images)){
                                $ProductImage = $latestProduct->images->first()->images;
                                }
                                }
                                @endphp

                                <div class="item col-lg-12 col-md-12 px-1" style="margin-bottom: 20px">
                                    <article class="product-miniature product-miniature_left js-product-miniature"
                                        data-id-product="32" data-id-product-attribute="59" itemscope=""
                                        itemtype="http://schema.org/Product">
                                        <div class="laberProduct-container">
                                            <div class="row m-0">
                                                <div class="laberProduct-image col-lg-5 col-md-12 col-xs-5 p-0">

                                                    <a href="{{ route('product.singles', [$latestProduct->slug]) }}">
                                                        <img class="latestPimg" src="{{ asset($ProductImage) }}"
                                                            alt="{{ $latestProduct->name }}"
                                                            data-full-size-image-url="{{ $ProductImage }}">
                                                    </a>
                                                </div>
                                                <div
                                                    class="laber-product-description col-lg-7 col-md-12 col-xs-7 latestP p-0">

                                                    <p class="dealPP"><span class="font-weight-bold">Code:</span>
                                                        {{$latestProduct->deal_code}}</p>
                                                    <h2 class="productName font-weight-bold" itemprop="name">
                                                        <a href="{{ route('product.singles', [$latestProduct->slug]) }}"
                                                            class="text-capitalize" title="Hummingbird notebook">
                                                            {{ Str::limit(strtolower($latestProduct->name), 15) }}
                                                        </a>
                                                    </h2>
                                                    <p class="dealPP"><span class="font-weight-bold">PP:</span>
                                                        {{$latestProduct->pp}}</p>
                                                    <div class="laber-product-price-and-shipping">

                                                        <?php $latestProductnetAMount = $latestProduct->price; ?>

                                                        @if($latestProduct->stockUnit == 1)
                                                        @if ($latestProduct->onStock())
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">OUT OF STOCK</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div id="content-wrapper" class="left-column col-xs-12 col-sm-8 col-md-9">
            <section id="main" itemscope="" itemtype="https://schema.org/Product">
                <meta itemprop="url" content="">

                <div class="laberProduct">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <section class="page-content" id="content">
                                <div class="images-container">
                                    <div class="product-cover">
                                        @php
                                        $fImage = $noImage;
                                        if(count($products->images)){

                                        $fImage = $products->images->first()->images;
                                        if(!file_exists($fImage)){
                                        $fImage = $noImage;
                                        }
                                        }
                                        @endphp
                                        <img class="js-qv-product-cover" src="{{ asset($fImage) }}" alt="" title=""
                                            style="width:100%;" itemprop="image">

                                        <div class="layer hidden-sm-down" data-toggle="modal"
                                            data-target="#product-modal">
                                            <i class="fa fa-search-plus zoom-in" aria-hidden="true"></i>

                                        </div>
                                    </div>
                                    <div class="js-qv-mask mask scroll">
                                        <ul class="product-images js-qv-product-images">
                                            @foreach($products->images as $image)
                                            @php
                                            $fImage = $image->images;
                                            if(!file_exists($fImage)){
                                            $fImage = $noImage;
                                            }
                                            @endphp
                                            <li class="thumb-container">
                                                <img class="thumb js-thumb  selected"
                                                    data-image-medium-src="{{ asset($fImage) }}"
                                                    data-image-large-src="{{ asset($fImage) }}"
                                                    src="{{ asset($fImage) }}" alt="" title="" width="100"
                                                    itemprop="image">
                                            </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                                <div class="scroll-box-arrows scroll">
                                    <i class="fa fa-angle-left left" aria-hidden="true"></i>
                                    <i class="fa fa-angle-right right" aria-hidden="true"></i>
                                </div>
                            </section>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <h2 class="h2 text-capitalize" style="margin-bottom: 10px"><span
                                    class="font-weight-bold">Code:</span> {{ $products->deal_code }}</h2>
                            <h1 class="h1" itemprop="name">{{ $products->name }}</h1>
                            <h2 class="h2"><span class="font-weight-bold">PP:</span> {{ $products->pp }}</h2>


                            <div class="product-prices">
                                <div class="product-price h5 " itemprop="offers" itemscope=""
                                    itemtype="https://schema.org/Offer">
                                    <link itemprop="availability" href="https://schema.org/InStock">
                                    <meta itemprop="priceCurrency" content="TK">
                                    <div class="current-price">

                                        <?php $netSAMount = $products->price; ?>

                                    </div>

                                    <?php $btnName = 'Add to cart'; ?>
                                    @if($products->stockUnit == 1)
                                    @if ($products->onStock())
                                    <div class="pricetag jumbotron">
                                        <div class="price pr-1">
                                            <div class="oneprice singleAmount"> BDT {{ number_format($netSAMount, 2,
                                                ".", ",") }}</div>
                                        </div>
                                    </div>
                                    @else
                                    <?php $btnName = 'OUT OF STOCK'; ?>
                                    <div class="pricetag jumbotron">
                                        <div class="price pr-1">
                                            <div class="oneprice singleAmount">OUT OF STOCK</div>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <div class="pricetag jumbotron">
                                        <div class="price pr-1">
                                            <div class="oneprice singleAmount">
                                                BDT : {{ number_format($netSAMount, 2,".", ",") }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <style>
                                    .singleAmount {
                                        font-size: 17px;
                                    }

                                    .out_of_stock {
                                        padding: 10px;
                                        background-color: red;
                                        color: #fff;
                                        font-weight: 700;
                                        margin-top: 10px;
                                        border-radius: 5px;
                                    }
                                </style>

                                <div class="tax-shipping-delivery-label">


                                </div>
                            </div>
                            <div class="product-description-short" id="product-description-short-31"
                                itemprop="description">
                                <p>
                                    <span style="font-size:10pt;font-family:Arial;font-style:normal;">
                                        {!! $products->description1 !!}
                                    </span>
                                </p>
                            </div>

                            <div class="product-actions">

                                <input type="hidden" name="token" value="2fdc10c6ea8864560b44ba4a0cbb19ff">
                                <input type="hidden" name="id_product" value="5" id="product_page_product_id">
                                <input type="hidden" name="id_customization" value="0" id="product_customization_id">



                                <section class="product-discounts">
                                </section>


                                <div class="product-add-to-cart">
                                    <span class="control-label">Quantity</span>
                                    <div class="product-quantity">
                                        <div class="qty">
                                            <div class="input-group bootstrap-touchspin">
                                                <span class="input-group-addon bootstrap-touchspin-prefix"
                                                    style="display: none;"></span>
                                                <input type="text" name="qty" id="quantity_wanted" value="1"
                                                    class="input-group form-control" min="1" aria-label="Quantity"
                                                    style="display: block;">
                                                <span class="input-group-addon bootstrap-touchspin-postfix"
                                                    style="display: none;"></span>
                                                <span class="input-group-btn-vertical">
                                                    <button
                                                        class="btn btn-touchspin js-touchspin bootstrap-touchspin-up"
                                                        type="button">
                                                        <i class="material-icons touchspin-up"></i>
                                                    </button>
                                                    <button
                                                        class="btn btn-touchspin js-touchspin bootstrap-touchspin-down"
                                                        type="button">
                                                        <i class="material-icons touchspin-down"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="add laberBottom">
                                            <button class="btn btn-primary add-to-cart laberBottom" <?php
                                                $btnName='Add to cart' ; ?> @if($products->stockUnit == 1)
                                                @if($products->onStock())
                                                onclick="addCartFromSingleProduct('{{ $products->id}}')"
                                                @else
                                                <?php $btnName = 'OUT OF STOCK'; ?>
                                                disabled
                                                @endif
                                                @else
                                                onclick="addCartFromSingleProduct('{{ $products->id}}')"
                                                @endif
                                                data-button-action="add-to-cart" type="submit">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                {{$btnName}}
                                            </button>
                                        </div>
                                    </div>
                                    <p class="product-minimal-quantity"></p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tabs laberTabs">
                    <div class="nav nav-tabs">
                        <ul>
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#product-details">Product Details</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="tab-content">
                        <div class="tab-pane fade in active" id="description">
                            <div class="product-description">
                                <p>
                                    <span style="font-size:10pt;font-family:Arial;font-style:normal;">
                                        {!! $products->description2!!}
                                    </span>
                                </p>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="product-details">
                            {!! $products->product_details !!}
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    var productcomments_controller_url = 'http://laberpresta.com/v17/laber_supershop_v17/en/module/productcomments/default';
                    var confirm_report_message = 'Are you sure that you want to report this comment?';
                    var secure_key = 'c5e2ab6d1cc78102514f206d005b176f';
                    var productcomments_url_rewrite = '1';
                    var productcomment_added = 'Your comment has been added!';
                    var productcomment_added_moderation = 'Your comment has been submitted and will be available once approved by a moderator.';
                    var productcomment_title = 'New comment';
                    var productcomment_ok = 'OK';
                    var moderation_active = 1;

                </script>

                <div id="productCommentsBlock" class="">

                    @if(!isset( $customerId ))
                    <p style="color: red;">/*Please <a style="font-size: 15px;color: #0f7a9a;"
                            href="{{route('customer.login',['setReview'=>@$products->id])}}">Login</a>
                        First and complete
                        your review*\</p>
                    @else
                    <h3 class="h3 products-section-title text-uppercase "><span>Reviews</span></h3>
                    <div class="labertabs">
                        <div class="laberButtonReviews clearfix">
                            <a class="open-comment-form btn btn-primary mt-2" href="#new_comment_form">Write your
                                review</a>
                        </div>
                        <div id="new_comment_form_ok" class="alert alert-success"
                            style="display:none;padding:15px 25px"></div>
                        <div class="tab-pane fade in" id="reviews">
                            <div id="product_comments_block_tab">
                                @foreach($reviews as $review)
                                <?php
                                    $reviewDate = date('d-m-Y',strtotime($review->created_at));
                                    @$revewRating = 1*100/$review->star;
                                ?>

                                <div class="commentBox">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>{{$review->name}} ({{ $review->star }})</h4>
                                            <span>({{$reviewDate}})</span>
                                        </div>
                                        <div class="col-md-9">
                                            <h4>{{$review->summary}}</h4>
                                            <p style="color:#fff;">{{$review->review}}</p>
                                        </div>
                                    </div>
                                </div>

                                @endforeach

                            </div>

                            <!-- Fancybox -->
                            <div style="display:none">
                                <div id="new_comment_form">
                                    <form method="POST" action="{{route('customerReview.save')}}">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="productId" value="{{$products->id}}">
                                        <input type="hidden" name="productName" value="{{$products->name}}">
                                        <input type="hidden" name="name" class="form-control"
                                            value="{{ Auth::guard('customer')->user()->name }}" required>

                                        <h2 class="title">Write your review</h2>
                                        {{-- <div class="product">
                                            Galaxy Android Smartphone
                                        </div> --}}
                                        <div class="new_comment_form_content">
                                            <div id="new_comment_form_error" class="error" style="display:none">
                                                <ul></ul>
                                            </div>
                                            <ul id="criterions_list">
                                                <li>
                                                    <label>Quality</label>

                                                    <input type="radio" class="d-none" name="star" id="star-null"
                                                        checked />
                                                    <input type="radio" class="d-none" value="1" name="star"
                                                        id="star-1" />
                                                    <input type="radio" class="d-none" value="2" name="star"
                                                        id="star-2" />
                                                    <input type="radio" class="d-none" value="3" name="star"
                                                        id="star-3" />
                                                    <input type="radio" class="d-none" value="4" name="star"
                                                        id="star-4" />
                                                    <input type="radio" class="d-none" value="5" name="star"
                                                        id="star-5" />

                                                    <section>
                                                        <label class="size" for="star-1">
                                                            <svg width="255" height="240" viewBox="0 0 51 48">
                                                                <path
                                                                    d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z" />
                                                            </svg>
                                                        </label>
                                                        <label class="size" for="star-2">
                                                            <svg width="255" height="240" viewBox="0 0 51 48">
                                                                <path
                                                                    d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z" />
                                                            </svg>
                                                        </label>
                                                        <label class="size" for="star-3">
                                                            <svg width="255" height="240" viewBox="0 0 51 48">
                                                                <path
                                                                    d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z" />
                                                            </svg>
                                                        </label>
                                                        <label class="size" for="star-4">
                                                            <svg width="255" height="240" viewBox="0 0 51 48">
                                                                <path
                                                                    d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z" />
                                                            </svg>
                                                        </label>
                                                        <label class="size" for="star-5">
                                                            <svg width="255" height="240" viewBox="0 0 51 48">
                                                                <path
                                                                    d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z" />
                                                            </svg>
                                                        </label>
                                                        <label for="star-null">
                                                            Clear
                                                        </label>
                                                    </section>
                                                    <div class="clearfix"></div>
                                                </li>
                                            </ul>
                                            <label for="comment_title">Subject<sup class="required">*</sup></label>
                                            <input id="comment_title" name="summary" type="text" value="">

                                            <label for="content">Your review<sup class="required">*</sup></label>
                                            <textarea id="content" name="review"></textarea>


                                            <div id="new_comment_form_footer">
                                                <input id="id_product_comment_send" name="id_product" type="hidden"
                                                    value="5">
                                                <p class="f-left required"><sup>*</sup> Required fields</p>
                                                <p class="f-right">
                                                    <button class="btn btn-primary" name="submitMessage"
                                                        type="submit">Send</button>
                                                </p>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </form><!-- /end new_comment_form_content -->
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>


                <section>
                    <div class="laberthemes">
                        <div class="Categoryproducts laberProductGrid">
                            <!--<div class="title_block">-->
                            <!--    <h3>-->
                            <!--        <span>-->
                            <!--            {{ count($relatedProducts) }} other products in the same category:-->
                            <!--        </span>-->
                            <!--    </h3>-->
                            <!--</div>-->
                            <div class="laberCate product_list">
                                <div class="row">
                                    <div class="laberCategoryproducts" style="opacity: 1; display: block;">

                                        @if (count($relatedProducts))

                                        @foreach ($relatedProducts as $relatedProduct)

                                        @php
                                        $fImage = $noImage;
                                        if(count($relatedProduct->images)){

                                        $fImage = $relatedProduct->images->first()->images;
                                        if(!file_exists($fImage)){
                                        $fImage = $noImage;
                                        }
                                        }
                                        @endphp

                                        <div class="owl-item" style="width: 293px;">
                                            <div class="item-inner">
                                                <div class="item">
                                                    <article class="product-miniature js-product-miniature"
                                                        data-id-product="5" data-id-product-attribute="19" itemscope=""
                                                        itemtype="http://schema.org/Product">
                                                        <div class="laberProduct-container">
                                                            <div class="laberProduct-image">

                                                                <a href="{{ route('product.singles', [$relatedProduct->slug]) }}"
                                                                    class="thumbnail product-thumbnail">
                                                                    <span class="cover_image">
                                                                        <img src="{{ asset($fImage) }}"
                                                                            alt="{{ $relatedProduct->name }}"
                                                                            data-full-size-image-url="{{ asset($fImage) }}">
                                                                    </span>
                                                                </a>
                                                                {{-- <ul class="laberProduct-flags">
                                                                    <li class="laber-flag laber-new">
                                                                        <span>New</span>
                                                                    </li>
                                                                </ul> --}}
                                                                <div class="laberActions">
                                                                    <div class="laberActions-i">
                                                                        <div class="laberActions-top">


                                                                        </div>
                                                                        <div class="laberCart">
                                                                            <button
                                                                                onclick="addCart('{{ $relatedProduct->id}}')"
                                                                                class="laberBottom">
                                                                                <i class="fa fa-shopping-cart"
                                                                                    aria-hidden="true"></i>
                                                                                <span>Add to cart</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="laber-product-description">
                                                                <p class="dealPP"><span
                                                                        class="font-weight-bold">Code:</span>
                                                                    {{$relatedProduct->deal_code}}</p>
                                                                <h2 class="productName font-weight-bold">
                                                                    <a href="{{ route('product.singles', [$relatedProduct->slug]) }}"
                                                                        class="text-capitalize">
                                                                        {{ Str::limit(strtolower($relatedProduct->name),
                                                                        30) }}</a>
                                                                </h2>
                                                                <p class="dealPP"><span
                                                                        class="font-weight-bold">PP:</span>
                                                                    {{$relatedProduct->pp}}</p>
                                                                <div class="laber-product-price-and-shipping">
                                                                    @if ($relatedProduct->discount > 0)
                                                                    <?php $rnetAMount = $relatedProduct->discount; ?>
                                                                    <!--<span itemprop="price" class="price">৳{{ $relatedProduct->discount }}</span>-->
                                                                    <!--<span class="regular-price">৳{{ $relatedProduct->price }}</span>-->
                                                                    @else
                                                                    <?php $rnetAMount = $relatedProduct->price; ?>
                                                                    <!--<span itemprop="price" class="price">৳{{ $relatedProduct->price }}</span>-->
                                                                    @endif
                                                                    @if($relatedProduct->stockUnit == 1)
                                                                    @if ($relatedProduct->onStock())
                                                                    <div class="pricetag jumbotron">
                                                                        <span class="productcart laberCart"
                                                                            title="Add to Cart"
                                                                            onclick="addCart('{{ $relatedProduct->id}}')">
                                                                            <i class="fa fa-cart-plus fa-fw"></i>
                                                                        </span>
                                                                        <div class="price">
                                                                            <div class="oneprice">BDT : {{
                                                                                number_format($rnetAMount, 2, ".", ",")
                                                                                }}</div>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    <div class="pricetag jumbotron">
                                                                        <div class="price">
                                                                            <div class="oneprice">OUT OF STOCK</div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                    @else
                                                                    <div class="pricetag jumbotron">
                                                                        <span class="productcart laberCart"
                                                                            title="Add to Cart"
                                                                            onclick="addCart('{{ $relatedProduct->id}}')">
                                                                            <i class="fa fa-cart-plus fa-fw"></i>
                                                                        </span>
                                                                        <div class="price">
                                                                            <div class="oneprice">BDT : {{
                                                                                number_format($rnetAMount, 2, ".", ",")
                                                                                }}</div>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach

                                        @endif

                                    </div>

                                </div>
                            </div>
                            <div class="owl-buttons">
                                <p class="owl-prev prevCategoryproducts"><i class="fa fa-angle-left"></i></p>
                                <p class="owl-next nextCategoryproducts"><i class="fa fa-angle-right"></i></p>
                            </div>
                        </div>
                    </div>
                </section>
                <script type="text/javascript">
                    $(document).ready(function() {
                        var owl = $(".laberCategoryproducts");
                        owl.owlCarousel({
                            items: 3
                            , itemsDesktop: [1199, 3]
                            , itemsDesktopSmall: [991, 2]
                            , itemsTablet: [767, 2]
                            , itemsMobile: [480, 2]
                            , rewindNav: false
                            , autoPlay: false
                            , stopOnHover: false
                            , pagination: false
                        , });
                        $(".nextCategoryproducts").click(function() {
                            owl.trigger('owl.next');
                        })
                        $(".prevCategoryproducts").click(function() {
                            owl.trigger('owl.prev');
                        })
                    });

                </script>


                <div class="modal fade js-product-images-modal" id="product-modal" style="display: none;"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <figure>
                                    @php
                                    $fImage = $noImage;
                                    if(count($products->images)){

                                    $fImage = $products->images->first()->images;
                                    if(!file_exists($fImage)){
                                    $fImage = $noImage;
                                    }
                                    }
                                    @endphp
                                    <img class="js-modal-product-cover product-cover-modal" width="800"
                                        src="{{ asset($fImage) }}" alt="" title="" itemprop="image">
                                    <figcaption class="image-caption">

                                        <div id="product-description-short" itemprop="description">
                                            {{-- <p><span
                                                    style="font-size:10pt;font-family:Arial;font-style:normal;">120
                                                    sheets notebook with hard cover made of recycled cardboard.
                                                    16x22cm</span>
                                            </p> --}}
                                        </div>

                                    </figcaption>
                                </figure>
                                <aside id="thumbnails" class="thumbnails js-thumbnails text-sm-center">

                                    <div class="js-modal-mask mask  nomargin ">
                                        <ul class="product-images js-modal-product-images">
                                            @foreach($products->images as $image)
                                            @php
                                            $fImage = $image->images;
                                            if(!file_exists($fImage)){
                                            $fImage = $noImage;
                                            }
                                            @endphp
                                            <li class="thumb-container">
                                                <img data-image-large-src="{{ asset($fImage) }}"
                                                    class="thumb js-modal-thumb" src="{{ asset($fImage) }}" alt=""
                                                    title="" width="320" itemprop="image">
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                </aside>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <footer class="page-footer">

                    <!-- Footer content -->

                </footer>
            </section>
        </div>

        <div id="left-column" class="col-xs-12 col-sm-4 col-md-3 d-block d-md-none">
            <section class="laberNewProducts-box laberProductColumn laberColumn clearfix">
                <h3>New products</h3>
                <div class="product_list">

                    <div class="laberNewProducts owl-carousel owl-theme"
                        style="opacity: 1; display: block;padding: 20px 5px;">

                        <div class="outer-item">
                            <div class="row">

                                @foreach($latestProducts[0] as $latestProduct)

                                @php
                                $ProductImage = $noImage;

                                if ($latestProduct->images->first() != null){
                                if(file_exists($latestProduct->images->first()->images)){
                                $ProductImage = $latestProduct->images->first()->images;
                                }
                                }
                                @endphp

                                <div class="item col-lg-12 col-md-12 px-1" style="margin-bottom: 20px">
                                    <article class="product-miniature product-miniature_left js-product-miniature"
                                        data-id-product="32" data-id-product-attribute="59" itemscope=""
                                        itemtype="http://schema.org/Product">
                                        <div class="laberProduct-container">
                                            <div class="row m-0">
                                                <div class="laberProduct-image col-lg-5 col-md-12 col-xs-5 p-0">

                                                    <a href="{{ route('product.singles', [$latestProduct->slug]) }}">
                                                        <img class="latestPimg" src="{{ asset($ProductImage) }}"
                                                            alt="{{ $latestProduct->name }}"
                                                            data-full-size-image-url="{{ $ProductImage }}">
                                                    </a>
                                                </div>
                                                <div
                                                    class="laber-product-description col-lg-7 col-md-12 col-xs-7 latestP p-0">
                                                    <p class="dealPP"><span class="font-weight-bold">Code:</span>
                                                        {{$latestProduct->deal_code}}</p>
                                                    <h2 class="productName font-weight-bold" itemprop="name">
                                                        <a href="{{ route('product.singles', [$latestProduct->slug]) }}"
                                                            class="text-capitalize" title="Hummingbird notebook">
                                                            {{ Str::limit(strtolower($latestProduct->name), 15) }}
                                                        </a>
                                                    </h2>
                                                    <p class="dealPP"><span class="font-weight-bold">PP:</span>
                                                        {{$latestProduct->pp}}</p>
                                                    <div class="laber-product-price-and-shipping">

                                                        <?php $latestProductnetAMount = $latestProduct->price; ?>

                                                        @if($latestProduct->stockUnit == 1)
                                                        @if ($latestProduct->onStock())
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">OUT OF STOCK</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                @endforeach


                                @foreach($latestProducts[0] as $latestProduct)

                                @php
                                $ProductImage = $noImage;

                                if ($latestProduct->images->first() != null){
                                if(file_exists($latestProduct->images->first()->images)){
                                $ProductImage = $latestProduct->images->first()->images;
                                }
                                }
                                @endphp

                                <div class="item col-lg-12 col-md-12 px-1" style="margin-bottom: 20px">
                                    <article class="product-miniature product-miniature_left js-product-miniature"
                                        data-id-product="32" data-id-product-attribute="59" itemscope=""
                                        itemtype="http://schema.org/Product">
                                        <div class="laberProduct-container">
                                            <div class="row m-0">
                                                <div class="laberProduct-image col-lg-5 col-md-12 col-xs-5 p-0">

                                                    <a href="{{ route('product.singles', [$latestProduct->slug]) }}">
                                                        <img class="latestPimg" src="{{ asset($ProductImage) }}"
                                                            alt="{{ $latestProduct->name }}"
                                                            data-full-size-image-url="{{ $ProductImage }}">
                                                    </a>
                                                </div>
                                                <div
                                                    class="laber-product-description col-lg-7 col-md-12 col-xs-7 latestP p-0">

                                                    <p class="dealPP"><span class="font-weight-bold">Code:</span>
                                                        {{$latestProduct->deal_code}}</p>
                                                    <h2 class="productName font-weight-bold" itemprop="name">
                                                        <a href="{{ route('product.singles', [$latestProduct->slug]) }}"
                                                            class="text-capitalize" title="Hummingbird notebook">
                                                            {{ Str::limit(strtolower($latestProduct->name), 15) }}
                                                        </a>
                                                    </h2>
                                                    <p class="dealPP"><span class="font-weight-bold">PP:</span>
                                                        {{$latestProduct->pp}}</p>
                                                    <div class="laber-product-price-and-shipping">

                                                        <?php $latestProductnetAMount = $latestProduct->price; ?>

                                                        @if($latestProduct->stockUnit == 1)
                                                        @if ($latestProduct->onStock())
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">OUT OF STOCK</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @else
                                                        <div class="pricetag latestPpricetag jumbotron">
                                                            <div class="price">
                                                                <div class="oneprice latestPprice">BDT {{
                                                                    number_format($latestProductnetAMount, 2, ".", ",")
                                                                    }}</div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>
</div>



@endsection

@section('custom-js')



@endsection

@section('custom-css')

<style>
    #star-1:checked~section [for=star-1] svg,
    #star-2:checked~section [for=star-1] svg,
    #star-2:checked~section [for=star-2] svg,
    #star-3:checked~section [for=star-1] svg,
    #star-3:checked~section [for=star-2] svg,
    #star-3:checked~section [for=star-3] svg,
    #star-4:checked~section [for=star-1] svg,
    #star-4:checked~section [for=star-2] svg,
    #star-4:checked~section [for=star-3] svg,
    #star-4:checked~section [for=star-4] svg,
    #star-5:checked~section [for=star-1] svg,
    #star-5:checked~section [for=star-2] svg,
    #star-5:checked~section [for=star-3] svg,
    #star-5:checked~section [for=star-4] svg,
    #star-5:checked~section [for=star-5] svg {
        transform: scale(1);
    }

    #star-1:checked~section [for=star-1] svg path,
    #star-2:checked~section [for=star-1] svg path,
    #star-2:checked~section [for=star-2] svg path,
    #star-3:checked~section [for=star-1] svg path,
    #star-3:checked~section [for=star-2] svg path,
    #star-3:checked~section [for=star-3] svg path,
    #star-4:checked~section [for=star-1] svg path,
    #star-4:checked~section [for=star-2] svg path,
    #star-4:checked~section [for=star-3] svg path,
    #star-4:checked~section [for=star-4] svg path,
    #star-5:checked~section [for=star-1] svg path,
    #star-5:checked~section [for=star-2] svg path,
    #star-5:checked~section [for=star-3] svg path,
    #star-5:checked~section [for=star-4] svg path,
    #star-5:checked~section [for=star-5] svg path {
        fill: #ffbb00;
        stroke: #cc9600;
    }


    label.size {
        display: inline-block;
        width: 50px;
        text-align: center;
        cursor: pointer;
    }

    label.size svg {
        width: 100%;
        height: auto;
        fill: white;
        stroke: #ccc;
        transform: scale(0.8);
        transition: transform 200ms ease-in-out;
    }

    label.size svg path {
        transition: fill 200ms ease-in-out, stroke 100ms ease-in-out;
    }

    label[for=star-null] {
        display: block;
        margin: 0 auto;
        color: #999;
    }


    .lab-menu-vertical .menu-vertical,
    .laberMenu-top .menu-vertical {
        display: none !important;
    }

    .lab-menu-vertical .menu-vertical.lab-active,
    .laberMenu-top .menu-vertical.lab-active {
        display: block !important;
    }

    .commentBox {
        background: #f3a251;
        padding: 10px;
        color: #fff;
        margin-top: 20px;
    }

    .bootstrap-touchspin>span.input-group-btn {
        position: absolute;
    }

    .input-group-btn>.btn-touchspin.js-touchspin.bootstrap-touchspin-up {
        display: none;
    }

    .item>.product-miniature_left {
        box-shadow: 0px 0px 0px 1px rgb(0 0 0 / 10%) !important;
    }

    .item>.product-miniature {
        box-shadow: 0px 0px 0px 1px rgb(0 0 0 / 10%) !important;
    }

    .latestPprice {
        line-height: 20px !important;
        vertical-align: middle;
        font-size: 13px;
        color: #fd0000;
        font-weight: bold;
    }

    .latestPpricetag {
        height: 30px !important;
    }

    .latestP>.dealPP,
    .latestP>.productName {
        padding: 0 !important;
        padding-left: 5px !important;
    }

    @media only screen and (min-width: 994px) {
        .latestPimg {
            margin-top: 5% !important;
            width: 100% !important;
        }
    }
</style>

@endsection
