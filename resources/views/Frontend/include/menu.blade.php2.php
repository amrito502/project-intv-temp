 <?php
      use App\Category;
    $customerId = Session::get('customerId');
    $referrer_url = URL::previous();
    $customerId = Session::get('customerId');
   if(!isset($customerId)){ 
      $orderHistory = url('/shipping-email');
   }else{
      $orderHistory = url('/customer/order');
   }

  ?>
 
<!-- Header Bottom -->
<div class="header-bottom hidden-compact">
    <div class="container">
        <div class="row">
            <div class="bottom1 menu-vertical col-lg-2 col-md-3 col-sm-3">
                <div class="responsive so-megamenu megamenu-style-dev ">
                    <div class="so-vertical-menu ">
                        <nav class="navbar-default">
                            <div class="container-megamenu vertical">
                                <div id="menuHeading">
                                    <div class="megamenuToogle-wrapper">
                                        <div class="megamenuToogle-pattern">
                                            <div class="container">
                                                <div>
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                                All Categories                          
                                            </div>
                                        </div>
                                    </div>
                                </div>

        <div class="navbar-header">
            <button type="button" id="show-verticalmenu" data-toggle="collapse" class="navbar-toggle">      
                <i class="fa fa-bars"></i>
                <span>  All Categories     </span>
            </button>
        </div>
        <div class="vertical-wrapper" >
            <span id="remove-verticalmenu" class="fa fa-times"></span>
            <div class="megamenu-pattern">
                <div class="container-mega">
                    <ul class="megamenu">
                @foreach($publishedCategories as $category)
                  <?php  if ($category->parent == '') { 
                    $categoryName = str_replace(' ', '-', $category->categoryName);
                        $submenu1 = Category::where('parent',$category->id)->where('categoryStatus',1)->first();
                        if($submenu1){
                            $firstMenuLink = url('/categories/'.@$category->id.'/'.@$categoryName); 
                        }else{
                           $firstMenuLink = url('/subcategories/'.@$category->id.'/'.@$categoryName);
                        }
                    ?>
                        <li class="item-vertical with-sub-menu hover">
                            <p class="close-menu"></p>
                            <a href="{{$firstMenuLink}}" class="clearfix">
                             <!--   <img src="{{ asset('public/frontend') }}/assets/image/catalog/menu/icons/ico7.png" alt="icon"> -->
                               <span>{{$category->categoryName}}</span>
                 <?php
                 $subcategory = Category::where('categoryStatus',1)->get();

                  foreach ($subcategory as $subcat) {
                    if ($subcat->parent == $category->id) { 

                ?>  <b class="fa-angle-right"></b>
                <?php } } ?>
                           </a>

                <?php
                 $subcategory = Category::where('categoryStatus',1)->get();

                  foreach ($subcategory as $subcat) {
                    if ($subcat->parent == $category->id) { 

                ?> 
                        <div class="sub-menu" style="width: 236.6px;" style="display: none !important;">
                            <div class="content" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 static-menu">
                                                <div class="category-menu">
                                                    <ul>
                                <?php
                                    $subcategory = Category::where('categoryStatus',1)->get();
                                    foreach ($subcategory as $subcat) {
                                      if ($subcat->parent == $category->id) {
                                     
                                      $subCategoryName = str_replace(' ', '-', $subcat->categoryName);
                                        $submenu2 = Category::where('parent',$subcat->id)->where('categoryStatus',1)->first();
                                        if($submenu2){
                                            $secondMenuLink = url('/categories/'.@$subcat->id.'/'.@$subCategoryName); 
                                        }else{
                                           $secondMenuLink = url('/subcategories/'.@$subcat->id.'/'.@$subCategoryName);
                                        }
                                ?>
                                                        <li class="item-vertical">
                                                            <a href="{{$secondMenuLink}}" class="main-menu submenu"><?php echo $subcat->categoryName; ?></a>
                                                       <ul class="category-mega-menu">
                                        <?php 
                                          $childCategory = Category::where('categoryStatus',1)->get();
                                          foreach ($childCategory as $childcat) {
                                          if ($childcat->parent == $subcat->id) {
                                           
                                            $childCategoryName = str_replace(' ', '-', $childcat->categoryName);
                                            $submenu3 = Category::where('parent',$childcat->id)->where('categoryStatus',1)->first();
                                            if($submenu3){
                                                $thirdMenuLink = url('/categories/'.@$childcat->id.'/'.@$childCategoryName); 
                                            }else{
                                               $thirdMenuLink = url('/subcategories/'.@$childcat->id.'/'.@$childCategoryName);
                                            }
                                        ?>
                                                        <li><a href="{{$thirdMenuLink}}"><?php echo $childcat->categoryName; ?></a></li>
                                                      
                                        <?php } } ?>
                                                        </ul>
                                                            
                                                        </li>
                                <?php } } ?>  
                                                    </ul>
                                                </div>
                                            </div>
                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <?php } } ?>
            </li>
                <?php } ?>
                @endforeach



       <!--  <li class="loadmore">
            <i class="fa fa-plus-square-o"></i>
            <span class="more-view">More Categories</span>
        </li> -->

            </ul>
                </div>
            </div>
        </div>
</div>
</nav>
</div>
</div>

</div>

<!-- Main menu -->
<!-- <div class="main-menu-w col-lg-10 col-md-9">
    <div class="responsive so-megamenu megamenu-style-dev">
        <nav class="navbar-default">
            <div class=" container-megamenu  horizontal open ">
                <div class="navbar-header">
                    <button type="button" id="show-megamenu" data-toggle="collapse" class="navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="megamenu-wrapper">
                    <span id="remove-megamenu" class="fa fa-times"></span>
                    <div class="megamenu-pattern">
                        <div class="container-mega">

                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div> -->
<!-- //end Main menu -->

            <div class="bottom3" style="width: 36em;">                        
                <div class="telephone hidden-xs hidden-sm hidden-md">
                    <ul class="blank"> 
                        <li></li>
                        <li><a href="#" style="color: #fff;font-size: 12px;"><i class="fa fa-phone-square"></i>Hotline <?php echo @$information->mobile1;  ?></a></li> 
                    </ul>
                </div>  
                <div class="signin-w hidden-md hidden-sm hidden-xs">
                    <ul class="signin-link blank">
                    <?php
                      if (!isset($customerId)) {
                    ?>                            
                        <li class="log login" style="padding-left: 96px;"><i class="fa fa-lock" style="color: #fff;"></i> <a class="link-lg" href="{{url('/customer/profile')}}">LOGIN </a> <span style="color: #fff;padding: 0px 3px;font-size: 12px;">or</span>  <a href="{{url('/customer/registration')}}">SIGNUP</a></li>
                    <?php }else{ ?>
                        <li class="log login" style="padding-left: 166px;"> <a class="link-lg" href="{{route('customer.logout')}}" style="color:fff;
                    font-size: 12px;">Logout </a></li>
                    <?php } ?>  

                     <!-- <li class="log login" style="margin-left: 3px;"><a class="link-lg" href="{{$orderHistory}}">
                        <i class="fa fa-history"></i> Order History</a></li> -->                              
                    </ul>                     
                </div>                  
            </div>

        </div>
    </div>

</div>
