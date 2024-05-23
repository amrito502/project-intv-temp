<div class="block-categories hidden-sm-down">
    <ul class="category-top-menu">
        <li>
            <a class="text-uppercase h6" href="#">
                <span>Categories</span>
            </a>
        </li>
        <li>
            <ul class="category-sub-menu">
                @foreach(session('home_theme')['categories']->where('parent', Null) as $category)

                @php
                $subCats = session('home_theme')['categories']->where('parent', $category->id);
                @endphp

                <li data-depth="0">
                    <a href="{{ route('product.productByCategory', [$category->id, $category->categoryName]) }}">{{ $category->categoryName }}</a>

                    @if(count($subCats))

                    <div class="navbar-toggler collapse-icons" data-toggle="collapse"
                        data-target="#exCollapsingNavbar{{ $category->id }}">
                        <i class="fa fa-plus add" aria-hidden="true"></i>
                        <i class="fa fa-minus remove" aria-hidden="true"></i>

                    </div>
                    <div class="collapse" id="exCollapsingNavbar{{ $category->id }}">
                        <ul class="category-sub-menu">
                            @foreach($subCats as $subCat)
                            <li data-depth="1"><a class="category-sub-link" href="{{ route('product.productByCategory', [$subCat->id, $subCat->categoryName]) }}">{{ $subCat->categoryName }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    @endif


                </li>

                @endforeach

            </ul>
        </li>
    </ul>
</div>