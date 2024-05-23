@php
    use App\Category;
@endphp

<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>

    <nav class="yamm megamenu-horizontal">
        <ul class="nav">
            @foreach ($publishedCategories as $category)
                @if ($category->parent == '')
                    @php
                        $categoryName = str_slug($category->categoryName,'-');
                    @endphp

                    <li class="dropdown meni-item">
                        @php
                            $subcategory = Category::where('categoryStatus',1)->get();
                        @endphp

                        <a href="{{url('/categories/'.$category->id.'/'.$categoryName)}}"
                        @foreach ($subcategory as $subcat)
                            @if ($subcat->parent == $category->id)
                                class="dropdown-toggle" data-toggle="dropdown"
                            @endif
                        @endforeach
                        ><i class="icon fa fa-shopping-bag"></i>{{$category->categoryName}}
                                </a>

                        <!-- ================================== MEGAMENU VERTICAL ================================== -->
                        <ul class="dropdown-menu mega-menu">
                            <li class="yamm-content">
                                <div class="row">
                                    <div class="">
                                        <ul>
                                            @php
                                                $subcategory = Category::where('categoryStatus',1)->get();
                                            @endphp

                                            @foreach ($subcategory as $subcat)
                                                @if ($subcat->parent == $category->id)
                                                    @php
                                                        $categoryName = str_slug($subcat->categoryName,'-');
                                                    @endphp
                                                    <li>
                                                        <a href="{{url('categories/'.@$subcat->id.'/'.@$categoryName)}}"><?php echo $subcat->categoryName; ?></a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
        <!-- /.nav -->
    </nav>
    <!-- /.megamenu-horizontal -->
</div>