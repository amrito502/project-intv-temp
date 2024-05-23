<div class="displayPosition displayPosition2">
    <div class="container">
        <div class="row">
            <!-- Module Product From Category -->
            <div class="laberthemes">
                <div class="laberProductGrid labProductList">
                    <?php
                        if($categoryChunk == 0){
                            $sl = 0;
                        }elseif($categoryChunk == 1){
                            $sl = 2;
                        }else{
                           $sl = 4;
                        }
                    ?>
                    @if ($categoryProducts)

                    @foreach ($categoryProducts[$categoryChunk] as $category)

                    @php
                    $sl++;

                    if(!$category){
                    continue;
                    }

                    if($category['products']->count() == 0){
                    continue;
                    }
                    @endphp

                    <div id="category_{{$category['category']['category_id']}}">

                        @include('frontend.partial.product_cards.homeCategory',
                        ['category' => $category, 'categoryId' => $category['category']['category_id']])

                    </div>

                    @endforeach

                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .pagination>ul {
        display: flex;
        justify-content: end;
    }

    .pagination a {
        line-height: 20px !important;
        height: 36px !important;
    }
</style>
