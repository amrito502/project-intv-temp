<div class="clearfix laberOverflow">
    <div class="product_list labContent">
        <div class="row">

            @foreach ($products as $product)

            <div class="col-md-3">

                @php
                $ProductImage = $noImage;

                if (!empty($product->image->images)){
                if(file_exists($product->image->images)){
                $ProductImage = $product->image->images;
                }else{
                $ProductImage = $noImage;
                }
                }
                @endphp

                <div class="item-inner ajax_block_product">

                    <div class="item">
                        <article class="product-miniature" data-id-product="" data-id-product-attribute="0" itemscope itemtype="http://schema.org/Product">
                            <div class="laberProduct-container">
                                <div class="laberProduct-image">

                                    <a href="{{ route('product.singles', [$product->slug]) }}" class="thumbnail product-thumbnail">

                                        <span class="cover_image">
                                            <img src="{{ asset($ProductImage) }}" alt="{{ $product->name }}" data-full-size-image-url="{{ asset($ProductImage) }}" style="width: 186px; height: 223px" />
                                        </span>

                                    </a>


                                    <ul class="laberProduct-flags">
                                        <li class="laber-flag laber-new">
                                            <span>New</span>
                                        </li>
                                    </ul>


                                    <div class="laberActions">
                                        <div class="laberActions-i">
                                            <div class="laberActions-top">

                                                <div class="laberItem">
                                                    <div class="laberwishlist product-item-wishlist">
                                                        <a class="addToWishlist wishlistProd_6" title="Add to wishlist" href="#" rel="6">
                                                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                            <span>wishlist</span>
                                                        </a>
                                                    </div>

                                                </div>
                                                <div class="laberItem">
                                                    <a href="javascript:void(0)" class="button-action js-compare" data-id-product="6" data-url-product="#home-accessories/6-mug-the-best-is-yet-to-come.html" data-name-product="Mug The best is yet to come" data-image-product="http://laberpresta.com/v17/laber_supershop_v17/48-small_default/mug-the-best-is-yet-to-come.jpg" data-url="//laberpresta.com#module/labercompare/actions" title="">
                                                        <i class="addCompare fa fa-toggle-on"></i>
                                                        <i class="removeCompare fa fa-trash-o"></i><span>Compare</span>
                                                    </a>

                                                </div>
                                                <div class="laberItem">
                                                    <div class="laberQuick">
                                                        <a href="#" class="quick-view" data-link-action="quickview" title="Quickview">
                                                            <i class="fa fa-search" aria-hidden="true"></i>
                                                            <span>Quick
                                                                view</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="laberCart">
                                                <button <?php $btnName = 'Add to cart'; ?> @if($product->stockUnit == 1)
                                                    @if ($product->onStock())
                                                    onclick="addCart('{{ $product->id}}')"
                                                    @else
                                                    <?php $btnName = 'OUT OF STOCK'; ?>
                                                    disabled
                                                    @endif
                                                    @else
                                                    onclick="addCart('{{ $product->id}}')"
                                                    @endif
                                                    class="laberBottom">
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                                    <span>{{$btnName}}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @if ($product->discount > 0 && $product->discount_percent > 0)
                                <div class="laber-flag laber_reduction_percent_display">
                                    <span>{{$product->discount_percent}}%</span>
                                </div>
                                @endif

                                <div class="laber-product-description">

                                    <p class="dealPP"><span class="font-weight-bold">Code:</span> {{$product->deal_code}}</p>
                                    <h2 class="productName font-weight-bold">
                                        <a href="{{ route('product.singles', [$product->slug]) }}" class="text-capitalize">
                                            {{ Str::limit(strtolower($product->name), 30) }}</a>
                                    </h2>
                                    <p class="dealPP"><span class="font-weight-bold">PP:</span> {{$product->pp}}</p>


                                    <div class="laber-product-price-and-shipping">

                                        @if ($product->discount > 0)
                                        <?php $netAMount = $product->discount; ?>
                                        <!--<span itemprop="price" class="price">-->
                                        <!--    ৳{{ $product->discount }}-->
                                        <!--</span>-->

                                        <!--<span class="regular-price">-->
                                        <!--    ৳{{ $product->price }}-->
                                        <!--</span>-->

                                        @else
                                        <?php $netAMount = $product->price; ?>
                                        <!--<span itemprop="price" class="price">-->
                                        <!--    ৳{{ $product->price }}-->
                                        <!--</span>-->

                                        @endif

                                        @if($product->stockUnit == 1)
                                        @if ($product->onStock())
                                        <div class="pricetag jumbotron">
                                            <span class="productcart laberCart" title="Add to Cart" onclick="addCart('{{ $product->id}}')">
                                                <i class="fa fa-cart-plus fa-fw"></i>
                                            </span>
                                            <div class="price">
                                                <div class="oneprice">BDT : {{ number_format($netAMount, 2, ".", ",") }}</div>
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
                                            <span class="productcart laberCart" title="Add to Cart" onclick="addCart('{{ $product->id}}')">
                                                <i class="fa fa-cart-plus fa-fw"></i>
                                            </span>
                                            <div class="price">
                                                <div class="oneprice">BDT : {{ number_format($netAMount, 2, ".", ",") }}</div>
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
        </div>
    </div>
</div>

<div class="pagination">
    {{ $products->appends(['category' => $category])->links('vendor.pagination.bootstrap-4') }}
</div>
