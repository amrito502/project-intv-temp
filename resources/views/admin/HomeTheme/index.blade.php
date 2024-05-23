@extends('admin.layouts.master')

@section('content')

<style>
    .red-border {
        border: 1px solid red;
    }
</style>



<div class="row mt-5">
    <div class="col-2 bg-light" style="height: 70vh">
        <div class="nav flex-column nav-pills mt-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            {{-- menu start --}}

            @include('admin.HomeTheme.partials.menu.theme_menu')

            {{-- menu end --}}
        </div>
    </div>
    <div class="col-10">

        <div class="tab-content" id="v-pills-tabContent">

            {{-- <div class="tab-pane fade show active" id="popular-1" role="tabpanel" aria-labelledby="popular-1-tab">
                @include('admin.HomeTheme.partials.sections.popular_one')
            </div> --}}

            <!--<div class="tab-pane fade show active" id="category-1" role="tabpanel" aria-labelledby="category-1-tab">-->
            <!--    @include('admin.HomeTheme.partials.sections.category_one')-->
            <!--</div>-->

            <div class="tab-pane fade show active" id="4-banner" role="tabpanel" aria-labelledby="4-banner-tab">
                @include('admin.HomeTheme.partials.sections.four_banner')
            </div>


            <div class="tab-pane fade" id="3-category" role="tabpanel" aria-labelledby="3-category-tab">
                @include('admin.HomeTheme.partials.sections.three_category')
            </div>

            {{-- <div class="tab-pane fade" id="popular-2" role="tabpanel" aria-labelledby="popular-2-tab">
                @include('admin.HomeTheme.partials.sections.popular_two')
            </div> --}}

            <div class="tab-pane fade" id="1-banner" role="tabpanel" aria-labelledby="1-banner-tab">
                @include('admin.HomeTheme.partials.sections.one_banner')
            </div>

            {{-- <div class="tab-pane fade" id="2-banner" role="tabpanel" aria-labelledby="2-banner-tab">
                @include('admin.HomeTheme.partials.sections.two_banner')
            </div>

            <div class="tab-pane fade" id="services-item" role="tabpanel" aria-labelledby="services-item-tab">
                @include('admin.HomeTheme.partials.sections.services')
            </div> --}}

        </div>

    </div>
</div>

@endsection

@section('custom-js')


@endsection