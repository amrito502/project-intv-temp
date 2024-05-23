@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">

        <div id="left-column" class="col-xs-12 col-sm-4 col-md-3" style="margin-top: 30px;">

            @include('frontend.partial.sidebar.category')

            <div id="search_filters_wrapper" class="hidden-sm-down">
                <div id="search_filter_controls" class="hidden-md-up">
                    <span id="_mobile_search_filters_clear_all"></span>
                    <button class="btn btn-secondary ok">
                        <i class="material-icons rtl-no-flip"></i>
                        OK
                    </button>
                </div>
                <div id="search_filters">
                    <p class="text-uppercase h6 hidden-sm-down">Filter By</p>
                    <div id="_desktop_search_filters_clear_all" class="hidden-sm-down clear-all-wrapper">
                        <button data-search-url="#" class="btn btn-tertiary js-search-filters-clear-all">
                            <i class="fa fa-times" aria-hidden="true"></i>

                            Clear all
                        </button>
                    </div>


                    <section class="facet clearfix">
                        <p class="h6 facet-title hidden-sm-down">Price</p>
                        <div class="title hidden-md-up" data-target="#facet_17103" data-toggle="collapse">
                            <p class="h6 facet-title">Price</p>
                            <span class="float-xs-right">
                                <span class="navbar-toggler collapse-icons">
                                    <i class="material-icons add"></i>
                                    <i class="material-icons remove"></i>
                                </span>
                            </span>
                        </div>
                        <ul id="facet_17103" class="collapse">
                            <li>
                                <label class="facet-label" for="facet_input_17103_0">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_0" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&maxPrice=200';"
                                            name="filter Price">
                                        <span class="ps-shown-by-js"></span>
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&maxPrice=200" class="_gray-darker search-link" rel="nofollow">
                                        Below ৳200.00
                                        {{-- <span class="magnitude">(2)</span> --}}
                                    </a>
                                </label>
                            </li>
                            <li>
                                <label class="facet-label" for="facet_input_17103_1">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_1" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=201&maxPrice=500';"
                                            name="filter Price">
                                        <span class="ps-shown-by-js"></span>
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=201&maxPrice=500" class="_gray-darker search-link " rel="nofollow">
                                        ৳201.00 - ৳500.00
                                        {{-- <span class="magnitude">(20)</span> --}}
                                    </a>
                                </label>
                            </li>
                            <li>
                                <label class="facet-label" for="facet_input_17103_2">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_2" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=5018&maxPrice=1000';"
                                            name="filter Price">
                                        <span class="ps-shown-by-js"></span>
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=5018&maxPrice=1000" class="_gray-darker search-link " rel="nofollow">
                                        ৳501.00 - ৳1000.00
                                        {{-- <span class="magnitude">(3)</span> --}}
                                    </a>
                                </label>
                            </li>
                            <li>
                                <label class="facet-label" for="facet_input_17103_3">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_3" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=1001&maxPrice=2000';"
                                            name="filter Price">
                                        <span class="ps-shown-by-js"></span>
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=1001&maxPrice=2000" class="_gray-darker search-link " rel="nofollow">
                                        ৳1001.00 - ৳2000.00
                                        {{-- <span class="magnitude">(2)</span> --}}
                                    </a>
                                </label>
                            </li>
                            <li>
                                <label class="facet-label" for="facet_input_17103_4">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_4" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=2001&maxPrice=4000';"
                                            name="filter Price">
                                        <span class="ps-shown-by-js"></span>
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=2001&maxPrice=4000" class="_gray-darker search-link " rel="nofollow">
                                        ৳2001.00 - ৳4000.00
                                        {{-- <span class="magnitude">(2)</span> --}}
                                    </a>
                                </label>
                            </li>
                            <li>
                                <label class="facet-label" for="facet_input_17103_5">
                                    <span class="custom-radio">
                                        <input id="facet_input_17103_5" data-search-url="#" type="radio" onclick="window.location='{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=4000';"
                                            name="filter Price">
                                        {{-- <span class="ps-shown-by-js"></span> --}}
                                    </span>

                                    <a href="{{ route('product.productByCategory', $category->id) }}?price=1&minPrice=4000" class="_gray-darker search-link " rel="nofollow">
                                        Above ৳4000.00
                                        {{-- <span class="magnitude">(2)</span> --}}
                                    </a>
                                </label>
                            </li>
                        </ul>


                    </section>

                </div>
            </div>

            @include('frontend.partial.left_sidebar_bottom_banner')
        </div>

        <div id="content-wrapper" class="left-column col-xs-12 col-sm-8 col-md-9" style="margin-top: 30px;">
            <section id="main">
                <div class="block-category card card-block">

                    @if (file_exists($category->categoryCoverImage))

                    <div class="category-cover">
                        <img src="{{ asset($category->categoryCoverImage) }}" style="height: 254px" alt="Men">
                    </div>

                    @endif
                    <h1 class="h1">{{ $category->categoryName }}</h1>
                    <div id="category-description" class="text-muted">
                        <p>
                            <span style="font-size:10pt;font-family:Arial;font-style:normal;">{{
                                $category->metaDescription }}</span>
                        </p>
                    </div>

                    <!-- Subcategories -->
                    <div id="subcategories">
                        <ul class="clearfix">
                        </ul>
                    </div>
                </div>


                <section id="products" class="active_grid">
                    <div id="laber-products-top">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <ul class="laberGridList pull-left hidden-sm-down">
                                    <li id="grid" class="pull-left"><a rel="nofollow" href="javascript:void(0)"
                                            title="Grid"><i class="fa fa-th"></i><span>Grid</span></a>
                                    </li>
                                    <li id="list" class="pull-left"><a rel="nofollow" href="javascript:void(0)"
                                            title="List"><i class="fa  fa-bars"></i><span>List</span></a></li>
                                </ul>
                                <div class="pull-left hidden-sm-down total-products">
                                    <p>There are {{ $products->total() }} products.</p>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div id="js-product-list-top" class="products-selection">
                                    <div class="pull-right ">
                                        <span class="pull-left sort-by">Sort by:</span>
                                        <div class="pull-left products-sort-order dropdown">
                                            <button class="btn-unstyle select-title" rel="nofollow"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @php
                                                $selectedSortText = '';

                                                switch ($sortBy){
                                                case 'nameAsc':
                                                $selectedSortText = 'Name, A to Z';
                                                break;
                                                case 'nameDesc':
                                                $selectedSortText = ' Name, Z to A';
                                                break;
                                                case 'priceAsc':
                                                $selectedSortText = 'Price, low to high';
                                                break;
                                                case 'priceDesc':
                                                $selectedSortText = 'Price, high to low';
                                                break;
                                                default:
                                                $selectedSortText = 'Relevance';
                                                break;
                                                }

                                                @endphp

                                                {{ $selectedSortText }}
                                                <i class="fa fa-caret-down float-xs-right" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('product.productByCategory', $category->id) }}"
                                                    class="select-list ">
                                                    Relevance
                                                </a>
                                                <a href="{{ route('product.productByCategory', $category->id).'?sort=nameAsc' }}"
                                                    class="select-list ">
                                                    Name, A to Z
                                                </a>
                                                <a href="{{ route('product.productByCategory', $category->id).'?sort=nameDesc' }}"
                                                    class="select-list ">
                                                    Name, Z to A
                                                </a>
                                                <a href="{{ route('product.productByCategory', $category->id).'?sort=priceAsc' }}"
                                                    class="select-list ">
                                                    Price, low to high
                                                </a>
                                                <a href="{{ route('product.productByCategory', $category->id).'?sort=priceDesc' }}"
                                                    class="select-list ">
                                                    Price, high to low
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="hidden-md-up filter-button">
                                    <button id="search_filter_toggler" class="btn btn-secondary">
                                        Filter
                                    </button>
                                </div>
                                <div class="hidden-md-up text-sm-center showing">
                                    Showing 1-12 of 31 item(s)
                                </div>
                            </div>

                        </div>
                    </div>


                    <div id="" class="hidden-sm-down">
                        <section id="js-active-search-filters" class="hide">
                            <h1 class="h6 hidden-xs-up">Active filters</h1>
                        </section>

                    </div>


                    <div id="" class="clearfix">

                        <div id="js-product-list">
                            <div class="laberProductGrid laberProducts">
                                <div class="row">

                                    @foreach($products as $product)
                                    @include('frontend.partial.product_cards.product_card1', ['product' =>
                                    $product])
                                    @endforeach

                                </div>
                            </div>
                            <div class="laberProductList laberProducts">
                                <div class="row">

                                    @foreach($products as $product)
                                    @include('frontend.partial.product_cards.product_card2', ['product' =>
                                    $product])
                                    @endforeach

                                </div>
                            </div>

                            <nav class="pagination">
                                <div class="row">
                                    <div class="col-md-6">

                                        Showing {{ ($products->currentPage()-1)*$products->perPage() }}
                                        -
                                        @if($products->currentPage() == $products->lastPage())
                                        {{ $products->total() }}
                                        @else
                                        {{ ($products->currentPage())*$products->perPage() }}
                                        @endif

                                        of {{ $products->total() }} item(s)

                                    </div>

                                    <div class="col-md-6">


                                        <ul class="page-list clearfix text-sm-center">

                                            @for($i = 1; $i <= $products->lastPage(); $i++)
                                                <li class="current">
                                                    <a
                                                        href="{{ route('product.productByCategory', $category->id) }}?page={{ $i }}">{{
                                                        $i }}</a>
                                                </li>
                                                @endfor

                                                <li>
                                                    <a rel="next"
                                                        href="{{ route('product.productByCategory', $category->id) }}?page={{ $products->currentPage()+1 }}"
                                                        class="next">
                                                        Next
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    </a>
                                                </li>

                                        </ul>

                                    </div>
                                </div>

                            </nav>


                            <div class="hidden-md-up text-xs-right up">
                                <a href="#header" class="btn btn-secondary">
                                    Back to top
                                    <i class="material-icons"></i>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div id="js-product-list-bottom">

                        <div id="js-product-list-bottom"></div>

                    </div>

                </section>

            </section>


        </div>


    </div>
</div>

@endsection

@section('custom-css')

<style>
    .lab-menu-vertical .menu-vertical,
    .laberMenu-top .menu-vertical {
        display: none !important;
    }

    .lab-menu-vertical .menu-vertical.lab-active,
    .laberMenu-top .menu-vertical.lab-active {
        display: block !important;
    }
</style>

@endsection
