<div id="mobile_top_menu_wrapper" class="row hidden-md-up" style="display: none;">

    <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
    <div class="js-top-menu-bottom">
        <!-- Module Megamenu-->
        <div class="padding-mobile col-xs-12 col-sm-4 col-md-3">
            <div class="container_lab_vegamenu">
                <div class="lab-menu-vertical clearfix">

                    <div class="title-menu"><span>Categories</span><i class="mdi mdi-menu"></i></div>
                    <div class="menu-vertical">
                        <a href="javascript:void(0);" class="close-menu-content"><span><i class="fa fa-times" aria-hidden="true"></i></span></a>
                        <ul class="menu-content">
                            @foreach($categories->where('showInHomepage', 'yes') as $category)

                            @php
                            $subCats = $categories->where('parent', $category->id);
                            @endphp
                            <li class="laberCart level-1 @if(count($subCats) > 0) parent @endif ">
                                <a href="{{ route('product.productByCategory', [$category->id, $category->categoryName]) }}" class="laberIcon">
                                    @if($category->leftMenuImage)
                                    <img class="img-icon" src="{{ asset($category->leftMenuImage) }}" alt="" />
                                    @else
                                    <img class="img-icon" src="" alt="" />
                                    @endif
                                    <span>{{ $category->categoryName }}</span>
                                </a>
                                @if(count($subCats))
                                <span class="icon-drop-mobile"></span>
                                @foreach($subCats as $subCat)
                                <ul class="menu-dropdown cat-drop-menu " style="display: none;">
                                    <li class="laberCart level-2 "><a href="{{ route('product.productByCategory', [$subCat->id, $subCat->categoryName]) }}" class="">
                                        <span>{{ $subCat->categoryName }}</span></a>
                                    </li>
                                </ul>
                                @endforeach
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Module Megamenu -->
        <!-- Module Megamenu-->

        <div class="lab-menu-horizontal">
            <div class="title-menu-mobile"><span>Navigation</span></div>
            <ul class="menu-content">
                <li class="level-1  parent">

                    <a href="{{ route('home.index') }}">
                        <span>Home</span>
                    </a>
                </li>
                @foreach($categories->where('showInMegaMenu', 'yes') as $category)

                    @php
                    $subCats = $categories->where('parent', $category->id);
                    @endphp
                <li class="level-1 @if(count($subCats)) parent @endif ">
                    <a href="{{ route('product.productByCategory', [$category->id, $category->categoryName]) }}">
                        <span class="name">{{ $category->categoryName }}</span>
                    </a>
                    @if(count($subCats))
                    <span class="icon-drop-mobile"></span>
                    <ul class="menu-dropdown cat-drop-menu lab-sub-auto">
                        @foreach($subCats as $subCat)
                        <li class="level-2 ">
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
                text_more = "More";
                numLiItem = $(".lab-menu-horizontal .menu-content li.level-1").length;
                nIpadHorizontal = 5;
                nIpadVertical = 4;

                function getHtmlHide(nIpad, numLiItem) {
                    var htmlLiHide = "";
                    if ($("#more_menu").length == 0)
                        for (var i = nIpad + 1; i < numLiItem; i++) {
                            var tmp = $('.lab-menu-horizontal ul.menu-content li.level-1:nth-child(' + i + ')').html();
                            if (tmp) htmlLiHide += '<li>' + $('.lab-menu-horizontal ul.menu-content li.level-1:nth-child(' + i + ')').html() + '</li>';
                        }
                    return htmlLiHide;
                }

                htmlLiH = getHtmlHide(nIpadHorizontal, numLiItem);
                htmlLiV = getHtmlHide(nIpadVertical, numLiItem);
                htmlMenu = $(".lab-menu-horizontal").html();

                $(window).load(function() {
                    addMoreResponsive(nIpadHorizontal, nIpadVertical, htmlLiH, htmlLiV, htmlMenu);
                });
                $(window).resize(function() {
                    addMoreResponsive(nIpadHorizontal, nIpadVertical, htmlLiH, htmlLiV, htmlMenu);
                });

            </script>
        </div>

        <!-- /Module Megamenu -->

        <div id="_mobile_contact_link"></div>
        <div id="_mobile_language_selector"></div>
        <div id="_mobile_currency_selector"></div>
    </div>
</div>
