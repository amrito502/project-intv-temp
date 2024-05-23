@extends('frontend.master')
<?php
use App\Category;
$imageCat1 = Category::where('id', @$banners['category_one'])->first();
$imageCat2 = Category::where('id', @$banners['category_two'])->first();
$imageCat3 = Category::where('id', @$banners['category_three'])->first();
$imageCat4 = Category::where('id', @$banners['category_four'])->first();
$imageCat5 = Category::where('id', @$banners['category_five'])->first();
$imageCat6 = Category::where('id', @$banners['category_six'])->first();

?>
@section('mainContent')
<div class="se-pre-con"></div>
<main>

    <section id="wrapper">

        @include('frontend.partial.home_slider')

        @include('frontend.partial.featured_product_home')

        <div class="displayPosition displayPosition2 pt-0">

            @include('frontend.partial.home_category_block', ['categoryChunk' => 0])

        </div>

        <div class="displayPosition displayPosition2 pt-0">

            @include('frontend.partial.home_category_block', ['categoryChunk' => 1])

        </div>

        <div class="displayPosition displayPosition2 pt-0" style="padding-bottom: 20px">

            @include('frontend.partial.home_category_block', ['categoryChunk' => 2])

        </div>

    </section>

</main>

@endsection


@section('custom-js')
<script>
    $(document).ready(function() {

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var category = $(this).attr('href').split('category=')[1];

            var pageText = '&page=' + page;
            category = category.replace(pageText, "");
            fetch_data(page, category);
            // console.log(category);
        });

        function fetch_data(page, category) {
            $.ajax({
                url: "{{route('pagination.data')}}?page=" + page + "&category=" + category
                , success: function(data) {
                    $('#category_' + category).html(data);
                }
            });
        }

    });

</script>
@endsection
