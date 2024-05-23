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

<div class="item">
    <article class="product-miniature js-product-miniature">
        <div class="laberProduct-container">
            <div class="laberProduct-image">

                <a href="{{ route('product.singles', [$product->slug]) }}" {{ Str::limit($product->name,
                    30) }}" class="thumbnail product-thumbnail">

                    <span class="cover_image">
                        <img src="{{ asset($ProductImage) }}" alt="{{ $product->name }}" data-full-size-image-url="{{ asset($ProductImage) }}">
                    </span>

                </a>


                <ul class="laberProduct-flags">
                    {{-- <li class="laber-flag laber-discount"><span>Reduced price</span></li> --}}
                    {{-- <li class="laber-flag laber-new"><span>New</span></li>--}}
                </ul>


                <div class="laberActions">
                    <div class="laberActions-i">
                        <div class="laberActions-top">
                            <div class="laberItem">
                                <div class="laberwishlist product-item-wishlist">
                                    <a class="addToWishlist wishlistProd_1" title="Add to wishlist" href="#" rel="1" onclick="WishlistCart('wishlist_block_list', 'add', '1', false, 1); return false;">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i> <span>wishlist</span>
                                    </a>
                                </div>
                            </div>
                            <div class="laberItem">

                                @if (!empty($product->image->images))

                                <a href="javascript:void(0)" class="button-action js-compare js-compare-add" data-id-product="1" data-url-product="#" data-name-product="{{ $product->name }}" data-image-product="{{ asset($ProductImage) }}" data-url="#" title="Add to compare">
                                    <i class="addCompare fa fa-toggle-on"></i>
                                    <i class="removeCompare fa fa-trash-o"></i><span>Add to compare</span>
                                </a>

                                @else

                                <a href="javascript:void(0)" class="button-action js-compare js-compare-add" data-id-product="1" data-url-product="#" data-name-product="{{ $product->name }}" data-image-product="{{ $noImage }}" data-url="#" title="Add to compare">
                                    <i class="addCompare fa fa-toggle-on"></i>
                                    <i class="removeCompare fa fa-trash-o"></i><span>Add to compare</span>
                                </a>

                                @endif

                            </div>
                            <div class="laberItem">
                                <div class="laberQuick">
                                    <a href="#" class="quick-view" data-link-action="quickview" title="Quickview">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <span>Quick view</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="laberCart">
                            <button class="laberBottom" <?php $btnName = 'Add to cart'; ?> @if($product->stockUnit == 1)
                                @if ($product->onStock())
                                onclick="addCart('{{ $product->id}}')"
                                @else
                                <?php $btnName = 'OUT OF STOCK'; ?>
                                disabled
                                @endif
                                @else
                                onclick="addCart('{{ $product->id}}')"
                                @endif
                                >
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span>{{$btnName}}</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            {{-- @if ($product->discount > 0)
            @php
            $percentage = (($product->price - $product->discount) / $product->price) * 100;
            @endphp
            @if($percentage>0)
            <div class="laber-flag laber_reduction_percent_display">
                <span>{{ round($percentage) }}%</span>
            </div>
            @endif
            @endif --}}
            <div class="laber-product-description">
                <p class="dealPP"><span class="font-weight-bold">Code:</span> {{$product->deal_code}}</p>
                <h2 class="productName font-weight-bold">
                    <a href="{{ route('product.singles', [$product->slug]) }}" class="text-capitalize">
                        {{Str::limit(strtolower($product->name), 30) }}</a>
                </h2>
                <p class="dealPP"><span class="font-weight-bold">PP:</span> {{$product->pp}}</p>

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
            </div>
        </div>
    </article>
</div>
