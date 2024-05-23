<style>
    .nivo-slice>img,
    .nivo-box>img,
    .nivo-main-image,
    .nivo-slice,
    .nivo-box{
        height: 400px !important;
        height: 100% !important;
    }
</style>

<div class="container ImageSlider clearfix">
    <div class="laberImageSlider">
        <!-- Module labslideshow -->

        <div class="lab-nivoSlideshow">
            <!--<div class="lab-loading"></div>-->
            <div id="lab-slideshow" class="slides">

                @foreach ($sliders as $slider)
                <img data-thumb="{{ $slider->source }}" src="{{ $slider->source }}" alt="{{ $slider->metaTitle }}"
                    title="#{{ $slider->id }}"/>

                @endforeach

            </div>

            @foreach ($sliders as $slider)
            <div id="{{ $slider->id }}" class=" nivo-html-caption nivo-caption">
                <div class="lab_description style1 left">
                    <div class="container">
                        <div class="lab_description-ii">
                            <div class="title">
                                {{ $slider->title }}
                            </div>

                            <div class="legend">
                                {{ $slider->metaTitle }}
                            </div>
                            <div class="description">
                                <h4>{{ $slider->metaKeyword }}</h4>
                            </div>
                            @if($slider->category_id)
                            <?php
                                $catS = DB::table('categories')->where('id', $slider->category_id)->first();
                            ?>
                            <div class="readmore">
                                <a href="{{ route('product.productByCategory', [$slider->category_id, $catS->categoryName]) }}">Shop Now</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>

        <script>
            $(document).ready(function() {
                $('#lab-slideshow').nivoSlider({
                    effect: 'random',
                    slices: 15,
                    boxCols: 8,
                    boxRows: 4,
                    animSpeed: '500',
                    pauseTime: '5000',
                    startSlide: 0,
                    controlNav: true,
                    directionNav: true,
                    controlNavThumbs: false,
                    pauseOnHover: true,
                    manualAdvance: false,
                    prevText: '<i class="fa fa-angle-left"></i>',
                    nextText: '<i class="fa fa-angle-right"></i>',
                    // afterLoad: function() {
                    //     $('.lab-loading').css("display", "none");
                    // },
                    beforeChange: function() {
                        $('.nivo-caption .lab_description').removeClass("active").css("opacity", "0");
                    },
                    afterChange: function() {
                        $('.nivo-caption .lab_description').addClass("active").css("opacity", "1");
                    }
                });
            });
        </script>
        <!-- /Module labslideshow -->

    </div>
</div>
