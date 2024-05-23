@php
$ProductImage = $noImage;

if ($product->images->first() != null){
if(file_exists($product->images->first()->images)){
$ProductImage = $product->images->first()->images;
}
}
@endphp

<div class="item-inner clearfix">
    <article class="product-miniature js-product-miniature">
        <div class="laberProduct-container item">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-4">
                    <div class="laberProduct-image">

                        <a href="{{ route('product.singles', [$product->slug]) }}" class="thumbnail product-thumbnail">

                            <span class="cover_image">
                                <img src="{{ asset($ProductImage) }}" alt="{{ $product->name }}" data-full-size-image-url="{{ asset($ProductImage) }}">
                            </span>
                        </a>


                        <ul class="laberProduct-flags">
                            <li class="laber-flag laber-discount"><span>Reduced price</span></li>
                            {{-- <li class="laber-flag laber-new"><span>New</span></li>--}}
                        </ul>

                        {{-- @if ($product->discount > 0)
                        @php
                        $percentage = (($product->price - $product->discount) / $product->price) * 100;
                        @endphp
                        @if($percentage > 0)
                        <div class="laber-flag laber_reduction_percent_display">
                            <span>{{ round($percentage) }}%</span>
                        </div>
                        @endif
                        @endif --}}
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-8">

                    <div class="laber-product-description">


                        <h2 class="laber-product-title" itemprop="name">
                            <a href="{{ route('product.singles', [$product->slug]) }}" class="text-capitalize">
                                {{ Str::limit(strtolower($product->name), 30) }}
                            </a>
                        </h2>


                        <div class="laber-product-price-and-shipping">

                            <?php $netAMount = $product->price; ?>

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

                        <div class="comments_note">
                            <div class="star_content">
                                @if (gettype($product->AvgRating()) == "string")
                                @for ($i = 1; $i < 6; $i++) <div class="star">
                                    @if ($product->AvgRating() > (int)$i)
                                    <i class="fa fa-star active" aria-hidden="true"></i>
                                    @else
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    @endif
                            </div>
                            @endfor

                            @else
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>
                            <i class="fa fa-star-o" aria-hidden="true"></i>

                            @endif
                        </div>
                        <!-- <span class="laberCountReview pull-left">0 Review(s)&nbsp</span> -->
                    </div>

                    <div class="description_short">
                        <p><span style="font-size:10pt;font-family:Arial;font-style:normal;">{!!
                                $product->description1 !!}</span>
                        </p>
                        <p></p>
                    </div>

                    {{-- <div class="variant-links">
                        <a href="http://laberpresta.com/v17/laber_supershop_v17/en/men/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white"
                            class="color" title="White" style="background-color: #ffffff"><span
                                class="sr-only">White</span></a>
                        <a href="http://laberpresta.com/v17/laber_supershop_v17/en/men/1-2-hummingbird-printed-t-shirt.html#/1-size-s/11-color-black"
                            class="color" title="Black" style="background-color: #434A54"><span
                                class="sr-only">Black</span></a>
                        <span class="js-count count"></span>
                    </div> --}}


                </div>
                <div class="laberProductRight">


                    <div class="actions clearfix">
                        <div class="laberCart">
                            <form action="http://laberpresta.com/v17/laber_supershop_v17/en/cart" method="post">
                                <input type="hidden" name="token" value="2fdc10c6ea8864560b44ba4a0cbb19ff">
                                <input type="hidden" value="1" name="id_product">
                                <button data-button-action="add-to-cart" class="laberBottom" <?php $btnName = 'Add to cart'; ?> @if($product->stockUnit == 1)
                                    @if ($product->onStock())
                                    onclick="addCart('{{ $product->id}}')"
                                    @else
                                    <?php $btnName = 'OUT OF STOCK'; ?>
                                    disabled
                                    @endif
                                    @else
                                    onclick="addCart('{{ $product->id}}')"
                                    @endif
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span>{{$btnName}}</span>
                                </button>
                            </form>
                        </div>

                        <div class="laberItem-center">
                            <div class="laberItem pull-left">
                                <div class="laberQuick">
                                    <a href="#" class="quick-view" data-link-action="quickview" title="Quickview">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <span>Quick view</span>
                                    </a>
                                </div>
                            </div>
                            <div class="laberItem pull-left">
                                <div class="laberwishlist product-item-wishlist">
                                    <a class="addToWishlist wishlistProd_1" title="Add to wishlist" href="#" rel="1" onclick="WishlistCart('wishlist_block_list', 'add', '1', false, 1); return false;">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i> <span>wishlist</span>
                                    </a>
                                </div>

                            </div>


                            <div class="laberItem pull-left">
                                <a href="javascript:void(0)" class="button-action js-compare js-compare-add" data-id-product="1" data-url-product="http://laberpresta.com/v17/laber_supershop_v17/en/men/1-1-hummingbird-printed-t-shirt.html#/1-size-s/8-color-white" data-name-product="Hummingbird printed t-shirt" data-image-product="http://laberpresta.com/v17/laber_supershop_v17/28-small_default/hummingbird-printed-t-shirt.jpg" data-url="//laberpresta.com/v17/laber_supershop_v17/en/module/labercompare/actions" title="Add to compare">
                                    <i class="addCompare fa fa-toggle-on"></i>
                                    <i class="removeCompare fa fa-trash-o"></i><span>Add to compare</span>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</article>
</div>
