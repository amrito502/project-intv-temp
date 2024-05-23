<div class="displayPosition displayPosition1" style="padding-bottom: 20px;">
    <div class="container">
        <div class="row">
            <div class="laberthemes clearfix">
                <div class="type-tab laberProductFilter laberProductGrid clearfix">
                    <div class="lab_tab">
                        <ul class="laberTab nav nav-tabs clearfix">
                            <li class="nav-item">
                                <a data-toggle="tab" href="#Lab-new-prod_tab" class=" active nav-link">
                                    New products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#Lab-featured-prod_tab" class=" nav-link">
                                    Featured products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a data-toggle="tab" href="#Lab-bestseller-prod_tab" class=" nav-link">
                                    Best Seller
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content clearfix labContent">
                        <div id="Lab-new-prod_tab" class="Lab-new-prod tab-pane  active">
                            <div class="product_list">
                                <div class="row" style="margin: 0">
                                    <div class="owlProductFilter-Lab-new-prod-tab">

                                        @foreach ($newProductList as $product)
                                        @include('frontend.partial.product_cards.product_card3', ['product' =>
                                        $product])
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="owl-buttons">
                                <div class="owl-prev prev-Lab-new-prod-tab"><i class="fa fa-angle-left"></i>
                                </div>
                                <div class="owl-next next-Lab-new-prod-tab"><i class="fa fa-angle-right"></i></div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    var owl = $(".owlProductFilter-Lab-new-prod-tab");
                                    owl.owlCarousel({
                                        items: 4,
                                        itemsDesktop: [1199, 4],
                                        itemsDesktopSmall: [991, 3],
                                        itemsTablet: [767, 2],
                                        itemsMobile: [480, 2],
                                        rewindNav: false,
                                        autoPlay: false,
                                        stopOnHover: false,
                                        pagination: false,
                                    });
                                    $(".next-Lab-new-prod-tab").click(function () {
                                        owl.trigger('owl.next');
                                    })
                                    $(".prev-Lab-new-prod-tab").click(function () {
                                        owl.trigger('owl.prev');
                                    })
                                });
                            </script>
                        </div>

                        <div id="Lab-featured-prod_tab" class="Lab-featured-prod tab-pane ">
                            <div class="product_list">
                                <div class="row" style="margin: 0;">
                                    <div class="owlProductFilter-Lab-featured-prod-tab">

                                        @foreach ($featuredProductList as $product)
                                        @include('frontend.partial.product_cards.product_card3', ['product' =>
                                        $product])
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="owl-buttons">
                                <div class="owl-prev prev-Lab-featured-prod-tab"><i class="fa fa-angle-left"></i></div>
                                <div class="owl-next next-Lab-featured-prod-tab"><i class="fa fa-angle-right"></i></div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    var owl = $(".owlProductFilter-Lab-featured-prod-tab");
                                    owl.owlCarousel({
                                        items: 4,
                                        itemsDesktop: [1199, 4],
                                        itemsDesktopSmall: [991, 3],
                                        itemsTablet: [767, 2],
                                        itemsMobile: [480, 2],
                                        rewindNav: false,
                                        autoPlay: false,
                                        stopOnHover: false,
                                        pagination: false,
                                    });
                                    $(".next-Lab-featured-prod-tab").click(function () {
                                        owl.trigger('owl.next');
                                    })
                                    $(".prev-Lab-featured-prod-tab").click(function () {
                                        owl.trigger('owl.prev');
                                    })
                                });
                            </script>
                        </div>

                        <div id="Lab-bestseller-prod_tab" class="Lab-bestseller-prod tab-pane ">
                            <div class="product_list">
                                <div class="row" style="margin: 0;">
                                    <div class="owlProductFilter-Lab-bestseller-prod-tab">

                                        @foreach ($bestSellProductList as $product)
                                        @include('frontend.partial.product_cards.product_card3', ['product' =>
                                        $product])
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="owl-buttons">
                                <div class="owl-prev prev-Lab-bestseller-prod-tab"><i class="fa fa-angle-left"></i>
                                </div>
                                <div class="owl-next next-Lab-bestseller-prod-tab"><i class="fa fa-angle-right"></i>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function () {
                                    var owl = $(".owlProductFilter-Lab-bestseller-prod-tab");
                                    owl.owlCarousel({
                                        items: 4,
                                        itemsDesktop: [1199, 4],
                                        itemsDesktopSmall: [991, 3],
                                        itemsTablet: [767, 2],
                                        itemsMobile: [480, 2],
                                        rewindNav: false,
                                        autoPlay: false,
                                        stopOnHover: false,
                                        pagination: false,
                                    });
                                    $(".next-Lab-bestseller-prod-tab").click(function () {
                                        owl.trigger('owl.next');
                                    })
                                    $(".prev-Lab-bestseller-prod-tab").click(function () {
                                        owl.trigger('owl.prev');
                                    })
                                });
                            </script>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
