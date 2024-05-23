<div class="header-top">
    <div class="container">
        <div class="row">
            <!--Website Logo-->
            <div class="top-logo col-md-3 hidden-sm-down" id="_desktop_logo">
                <!--<h1>-->
                    <a href="{{ route('home.index') }}">
                        <img class="logo img-responsive center"
                            src="{{ asset(Session('home_theme')['meta_info']->siteLogo) }}"
                            alt="">
                    </a>
                <!--</h1>-->
            </div>
            <!--End Website Logo-->

            <div class="col-md-9 position-static">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $hImage = DB::table('header_image')->where('id', 1)->first();
                        ?>
                        <img src="{{ asset($hImage->image) }}" style="margin-top: 2px">
                    </div>
                </div>
                <div class="laberIpad">
                    <div class="row searchBarNav">
                        <!-- block seach mobile -->
                        <!-- Block search module TOP -->


                        <!--Search Start-->
                        <div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 ">
                            <div class="lab-search">
                                <form method="get" action="{{route('product.search')}}" id="searchbox">
                                    <input type="hidden" name="controller" value="search" />
                                    <div class="input-group-btn search_filter hidden-sm-down">
                                        <div class="select">
                                            <select name="category_filter" id="category_filter" class="form-control"
                                                style="display:none;">
                                                <option value="0" selected="selected">&nbsp;&nbsp; All Categories</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">&nbsp;&nbsp; {{ $category->categoryName }} </option>
                                                @endforeach
                                            </select>
                                            <div class="select-styled">All Categories</div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="orderby" value="position" />
                                    <input type="hidden" name="orderway" value="desc" />
                                    <input class="search_query form-control" type="text" id="search_query_top"
                                        name="search_query" value="{{ request()->search_query }}" placeholder="i&rsquo;m shopping for..." />
                                    <button type="submit" name="submit_search" class="btn button-search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!--Search End-->
                        <!-- /Block search module TOP -->

                        <!--Cart Start-->
                        <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 hidden-sm-down">
                            <div id="_desktop_blockcart">
                                <div class="blockcart laber-cart dropdown js-dropdown " data-refresh-url="#">
                                    <div class="expand-more" data-toggle="dropdown">
                                        <a class="cart" rel="nofollow" href="#">
                                            <i class="icon_cart"></i>
                                            <p class="labercart">Cart</p>
                                            <p class="cart-products-count cart_count">{{Cart::getContent()->count()}} Item(s)
                                            </p>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        <div class="cart_block block exclusive">

                                            {{-- if product in cart start--}}

                                            <div class="cart_block block exclusive" id="miniCartDiv">
                                                <p class="products_count" id="products_count_minicart">Your Cart (0)</p>

                                                <div id="productsParentDiv">

                                                </div>

                                                <div class="cart-prices">
                                                    <span class="total pull-left">
                                                        Total:
                                                    </span>

                                                    <span class="amount pull-right" id="miniCartTotalAmount">
                                                        ৳ 0
                                                    </span>

                                                </div>
                                                <div class="cart-buttons">
                                                    <a rel="nofollow" href="{{ route('cart.index') }}">
                                                        Cart <i class="ion-chevron-right"></i>
                                                    </a>
                                                </div>

                                            </div>

                                            {{-- if product in cart start--}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Cart End-->

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>


            @include('frontend.partial.navbar.mobile')


        </div>
    </div>
</div>

<div class="container_lab_megamenu hidden-sm-down">
    <div class="laberMegamenu">
        <div class="displayMegamenu">
            <div class="container">
                <div class="row">
                    <!-- Module Megamenu-->
                    <div class="padding-mobile col-xs-12 col-sm-4 col-md-3">
                        <div class="container_lab_vegamenu">
                            <div class="lab-menu-vertical clearfix">

                                <div class="title-menu">
                                    <span>Categories</span>
                                    {{-- <i class="mdi mdi-menu"></i>--}}
                                    <i class="fa fa-bars" aria-hidden="true"></i>

                                </div>
                                <div class="menu-vertical">
                                    <a href="javascript:void(0);" class="close-menu-content">
                                        <span>
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                    <ul class="menu-content">

                                        @foreach($categories->where('showInHomepage', 'yes') as $category)

                                        @php
                                        $subCats = $categories->where('parent', $category->id);
                                        @endphp

                                        <li class="laberCart level-1  @if(count($subCats) > 0) parent @endif
                                                    ">
                                            <a href="{{ route('product.productByCategory', [$category->id, $category->categoryName]) }}"
                                                class="laberIcon">
                                                @if($category->leftMenuImage)
                                                <img class="img-icon" src="{{ asset($category->leftMenuImage) }}" alt="" />
                                                @else
                                                <img class="img-icon" src="" alt="" />
                                                @endif
                                                <span>{{ $category->categoryName }}</span>
                                            </a>

                                            @if(count($subCats))
                                            <span class="icon-drop-mobile"></span>
                                            <ul class="menu-dropdown cat-drop-menu ">
                                                @foreach($subCats as $subCat)
                                                <li class="laberCart level-2 ">
                                                    <a href="{{ route('product.productByCategory', [$subCat->id, $subCat->categoryName]) }}"
                                                        class="">
                                                        <span>{{ $subCat->categoryName }}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif

                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Module Megamenu -->
                    <!-- Module Megamenu-->


                    <!--Desktop Menu Start-->
                    <div class="lab-menu-horizontal">
                        <div class="title-menu-mobile">
                            <span>Navigation</span>
                        </div>
                        <ul class="menu-content">
                            {{-- <li class="level-1">
                                <a href="{{ route('home.index') }}">
                                    <span>Home</span>
                                </a>
                            </li> --}}

                            @foreach($categories->where('showInMegaMenu', 'yes') as $category)

                            @php
                            $subCats = $categories->where('parent', $category->id);
                            @endphp


                            <li class="level-1 @if(count($subCats)) parent @endif">

                                <a href="{{ route('product.productByCategory', [$category->id, $category->categoryName]) }}">
                                    <span class="name">{{ $category->categoryName }}</span>
                                </a>

                                @if(count($subCats))
                                <span class="icon-drop-mobile"></span>
                                <ul class="menu-dropdown cat-drop-menu lab-sub-auto">
                                    @foreach($subCats as $subCat)
                                    <li class="level-2">
                                        <a href="{{ route('product.productByCategory', [$subCat->id, $subCat->categoryName]) }}">
                                            <span class="name">{{ $subCat->categoryName }}</span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                @endif

                            </li>


                            @endforeach

                        </ul>
                        <script type="text/javascript">
                            function getHtmlHide(n,l){var t="";if(0==$("#more_menu").length)for(var e=n+1;e<l;e++)$(".lab-menu-horizontal ul.menu-content li.level-1:nth-child("+e+")").html()&&(t+="<li>"+$(".lab-menu-horizontal ul.menu-content li.level-1:nth-child("+e+")").html()+"</li>");return t}text_more="More",numLiItem=$(".lab-menu-horizontal .menu-content li.level-1").length,nIpadHorizontal=5,nIpadVertical=4,htmlLiH=getHtmlHide(nIpadHorizontal,numLiItem),htmlLiV=getHtmlHide(nIpadVertical,numLiItem),htmlMenu=$(".lab-menu-horizontal").html(),$(window).load(function(){addMoreResponsive(nIpadHorizontal,nIpadVertical,htmlLiH,htmlLiV,htmlMenu)}),$(window).resize(function(){addMoreResponsive(nIpadHorizontal,nIpadVertical,htmlLiH,htmlLiV,htmlMenu)});
                        </script>
                    </div>
                    <!--Desktop Menu End-->
                    <!-- /Module Megamenu -->
                </div>
            </div>
        </div>
    </div>
</div>
