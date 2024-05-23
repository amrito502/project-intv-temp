@extends('frontend.master')

@section('mainContent')

<div class="container">
    <div class="row">

        <nav data-depth="3" class="breadcrumb hidden-sm-down">
            <ol itemscope="" itemtype="http://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="#">
                        <span itemprop="name">Home</span>
                    </a>
                    <meta itemprop="position" content="1">
                </li>
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="#">
                        <span itemprop="name">{{ request()->search_query }}</span>
                    </a>
                    <meta itemprop="position" content="2">
                </li>
            </ol>
        </nav>

        <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">

            @include('frontend.partial.sidebar.category')

            @include('frontend.partial.left_sidebar_bottom_banner')
        </div>

        <div id="content-wrapper" class="left-column col-xs-12 col-sm-8 col-md-9">
            <section id="main">
                {{-- <div class="block-category card card-block">

                    <div class="category-cover">
                        <img src="{{ asset($category->categoryCoverImage) }}" style="height: 254px" alt="Men">
                    </div>
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
                </div> --}}


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
                                {{-- {{ dd($products) }}--}}
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
                                                <a href="{{ route('product.search').'?search_query='. $search }}"
                                                    class="select-list ">
                                                    Relevance
                                                </a>
                                                <a href="{{ route('product.search').'?search_query='. $search.'&sort=nameAsc' }}"
                                                    class="select-list ">
                                                    Name, A to Z
                                                </a>
                                                <a href="{{ route('product.search').'?search_query='. $search.'&sort=nameDesc' }}"
                                                    class="select-list ">
                                                    Name, Z to A
                                                </a>
                                                <a href="{{ route('product.search').'?search_query='. $search.'&sort=priceAsc' }}"
                                                    class="select-list ">
                                                    Price, low to high
                                                </a>
                                                <a href="{{ route('product.search').'?search_query='. $search.'&sort=priceDesc' }}"
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
                                                        href="{{ route('product.search') }}?search_query={{ request()->search_query }}&page={{ $i }}">{{
                                                        $i }}</a>
                                                </li>
                                                @endfor

                                                <li>
                                                    <a rel="next"
                                                        href="{{ route('product.search') }}?search_query={{ request()->search_query }}&page={{ $products->currentPage()+1 }}"
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
