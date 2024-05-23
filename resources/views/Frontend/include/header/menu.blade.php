@php
    use App\ShippingCharges;
    use App\Product;
    use App\ProductSections;
    use App\Category;

    $customerId = Session::get('customerId');
    $referrer_url = URL::previous();
    $customerId = Session::get('customerId');

    if(!isset($customerId))
    {
        $orderHistory = url('/shipping-email');
    }
    else
    {
        $orderHistory = url('/customer/order');
    }
@endphp

<style type="text/css">
    .uploadListButton{
        background: #2ac97a;
        color: #fff;
        font-size: 12px;
        display: inline-block;
        height: 50px;
        line-height: 50px;
        padding: 0 16px;
        text-transform: uppercase;
        font-weight: bold;
        margin-left: 26px;
    }

    #header .user-info .login-register .m-toggle {
        text-align: center;
        color: white;
        margin-top: 5px;
    }
</style>

<div class="header-bottom hidden-lg-down">
    <div class="container">
        <div class="row">
            <div id="_desktop_tptnheaderlinks" class="tptnheaderlinks col-xl-7">
                <div class="m-toggle">
                    <i class="material-icons">more_horiz</i>
                    <span class="m-toggle-title hidden-xl-up">Links</span>
                </div>
                <ul>
                    <li><a href="<?php echo url('/') ?>">Home</a></li>
                    <li><a href="{{url('/about-us')}}">About us</a></li>
                    <li><a href="{{url('/contact-us')}}">Contact Us</a></li>
                    <li><a href="{{$orderHistory}}">Order History</a></li>
                    <li><a href="{{route('faq')}}">FAQ</a></li>
                </ul>
            </div>

            <div id="_desktop_user-info" class="user-info col-xl-2">
                <div class="login-register">
                    <div class="m-toggle">
                        <i class="material-icons">&#xE8A6;</i>
                        @if (!isset($customerId))
                            <span class="m-toggle-title"><a href="{{url('/customer/login')}}" style="color: white;" title="Log in to your customer account" rel="nofollow">Login / Signup</a></span>
                        @else
                            <span><a href="{{route('customer.profile')}}" title="View my customer account" rel="nofollow">My Account</a></span>
                        @endif
                    </div>
  
                </div>
            </div>

            <div id="_desktop_blockcart-wrapper" class="tptncart col-xs-3">
                <div class="blockcart cart-preview">
                    <a href="{{ route('upload.itemList') }}" class="uploadListButton">
                        <i class="fa fa-camera"></i> Upload Item List
                    </a>
                    <div class="m-toggle">
                        <span>
                            <i class="material-icons">shopping_cart</i>
                            <span class="items_cart cart_count">{{Cart::count()}} items</span>
                        </span>

                        <span class="m-toggle-title hidden-xl-up">Cart</span>
                    </div>

                    <div class="minicart-body">
                        <div class="minicart-title">Cart<i class="material-icons"></i></div>
                        <div id="minicartProduct"></div>
                    </div>
                </div>
            </div>

             <div id="_desktop_tptnmobilemenu" class="hidden-xl-up">
                <div class="m-toggle">
                    <i class="material-icons">&#xE5D2;</i><span class="m-toggle-title">Categories</span>
                </div>

                <div class="mobilemenu">
                    <div class="mobilemenu-title">Categories<i class="material-icons">&#xE5CD;</i></div>
                    <ul data-depth="0">
                        @foreach($publishedCategories as $category)
                            @if ($category->parent == '')
                                @php
                                    $categoryName = str_replace(' ', '-', $category->categoryName);
                                    $firstMenuLink = url('/categories/'.@$category->id.'/'.@$categoryName);
                                    $subcategory = Category::where('parent',$category->id)->where('categoryStatus',1)->get();
                                @endphp

                                <li {{-- id="category-3" --}}>
                                    <a href="{{$firstMenuLink}}" data-depth="0">
                                        @if(count(@$subcategory) > 0)
                                            <span class="float-xs-right hidden-xl-up">
                                                <span data-target="#mobile_menu_{{$category->id}}" data-toggle="collapse" class="navbar-toggler collapse-icons">
                                                    <i class="material-icons add">&#xE145;</i>
                                                    <i class="material-icons remove">&#xE15B;</i>
                                                </span>
                                            </span>
                                        @endif

                                        {{$category->categoryName}}
                                    </a>

                                    @if(count(@$subcategory) > 0)
                                        <div class="collapse" id="mobile_menu_{{$category->id}}">
                                            <ul data-depth="0">
                                                @foreach ($subcategory as $subcat)
                                                    @if ($subcat->parent == $category->id)
                                                        @php
                                                            $subCategoryName = str_replace(' ', '-', $subcat->categoryName);
                                                            $secondMenuLink = url('/subcategories/'.@$subcat->id.'/'.@$subCategoryName);
                                                        @endphp
                                                        <li>
                                                            <a href="{{$secondMenuLink}}" data-depth="0">
                                                                <span class="float-xs-right hidden-xl-up">
                                                                    <span data-target="#mobile_menu_61066" data-toggle="collapse" class="navbar-toggler-icons">
                                                                        <i class="material-icons add">&#xE145;</i>
                                                                        <i class="material-icons remove">&#xE15B;</i>
                                                                    </span>
                                                                </span>
                                                                {{$subcat->categoryName}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="mobile-header hidden-xl-up">
    <div class="mobile-header-top">
        <div id="_mobile_shop-logo" class="shop-logo"></div>
    </div>

    <div class="mobile-header-bottom">
        <div id="_mobile_tptnmobilemenu" class="tptnmobilemenu"></div>
        <div id="_mobile_user-info" class="user-info"></div>
        <div id="_mobile_tptnsearch" class="tptnsearch"></div>
        <div id="_mobile_tptnheaderlinks" class="tptnheaderlinks"></div>
        <div id="_mobile_blockcart-wrapper" class="tptncart"></div>
    </div>
</div>