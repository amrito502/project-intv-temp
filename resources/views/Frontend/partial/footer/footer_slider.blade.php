@php
    $brandChunks = session('home_theme')['brands']->chunk(2);
@endphp

<div class="displayPosition displayManufacture">
    <div class="container">
        <div class="row">
            <div class="laberthemes">
                <div class="laberLogo_manufacturer">
                    <!-- <div class="laberTitle">
                                        <h3>Brand</h3>
                        </div> -->
                    <div class="content-manufacturer">
                        <div class="row">
                            <div class="list_manufacturer">

                                @foreach ($brandChunks as $brandChunk)
                                    
                                <div class="item-inner">

                                    @foreach ($brandChunk as $brand)
                                        
                                    <div class="item">
                                        <a class="image_hoverwashe" href="{{ route('product.productByBrand', [$brand->id, $brand->name]) }}" title="manufacturer">
                                            <img src="{{ asset($brand->image) }}" alt="manufacturer"  style="width: 90px !important; height: 45px !important"/>
                                            <span class="hover_bkg_light"></span>
                                        </a>
                                    </div>

                                    @endforeach
                                  
                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="owl-buttons">
                        <div class="owl-prev prev-manufacturer"><i class="fa fa-angle-left"></i></div>
                        <div class="owl-next next-manufacturer"><i class="fa fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function() {
                    var owl = $(".list_manufacturer");
                    owl.owlCarousel({
                        items: 7,
                        itemsDesktop: [1199, 5],
                        itemsDesktopSmall: [991, 4],
                        itemsTablet: [767, 3],
                        itemsMobile: [480, 2],
                        navigation: false,
                        slideSpeed: 2000,
                        paginationSpeed: 2000,
                        rewindSpeed: 2000,
                        autoPlay: false,
                        stopOnHover: false,
                        pagination: false,
                        addClassActive: true,
                    });
                    $(".next-manufacturer").click(function() {
                        owl.trigger('owl.next');
                    })
                    $(".prev-manufacturer").click(function() {
                        owl.trigger('owl.prev');
                    })
                });
            </script>
        </div>
    </div>
</div>