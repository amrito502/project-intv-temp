<?php
 use App\ShippingCharges;
 use App\Product;
 use App\ProductSections;
 ?>
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

<div class="header-bottom hidden-lg-down">
  <div class="container">
    <div class="row">
      <div id="tptndesktopmenu" class="col-xl-3 hidden-lg-down">
        <div class="desktopmenu-title">Categories<i class="material-icons">&#xE5D2;</i></div>
        <div class="desktopmenu">
          <ul id="megamenu" class="menu right">
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
            <li data-depth="0">
              <a href="{{$firstMenuLink}}" class="clearfix">
               <span>{{$category->categoryName}}</span>
               <?php
                $subcategory = Category::where('categoryStatus',1)->get();

                foreach ($subcategory as $subcat) {
                  if ($subcat->parent == $category->id) { 
                ?>  
                <?php } } ?>
              </a>

                <?php
                  $subcategory = Category::where('categoryStatus',1)->get();
                  foreach ($subcategory as $subcat) {
                    if ($subcat->parent == $category->id) { 
                ?> 
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

                    <li data-depth="1">
                      <a href="{{$secondMenuLink}}" >
                        <?php echo $subcat->categoryName; ?>
                      </a>
                      <ul>     
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
                           <li data-depth="2">
                            <a href="{{$thirdMenuLink}}" >
                              <?php echo $childcat->categoryName; ?>
                            </a>
                          </li>
                        <?php } } ?>
                      </ul>
                    </li> 
                  <?php } } ?>                                                             
                  </ul>
                  <?php } } ?>
                </li>
              <?php } ?>
            @endforeach
          </ul>
        </div>
      </div>

      <div id="_desktop_tptnmobilemenu" class="hidden-xl-up">
        <div class="m-toggle">
          <i class="material-icons">&#xE5D2;</i>
          <span class="m-toggle-title">Categories</span>
        </div>
        <div class="mobilemenu">
          <div class="mobilemenu-title">Categories<i class="material-icons">&#xE5CD;</i></div>


        </div>
      </div>

      <div id="_desktop_tptnheaderlinks" class="tptnheaderlinks col-xl-7">
        <div class="m-toggle">
          <i class="material-icons">more_horiz</i>
          <span class="m-toggle-title hidden-xl-up">Links</span>
        </div>
        <ul>
          <li><a href="<?php echo url('/') ?>">Home</a></li>
          <li><a href="new-products.html">New Products</a></li>
          <li><a href="content/4-about-us.html">About us</a></li>
          <li><a href="blog.html">Blog</a></li>
          <li><a href="#">Custom Link</a></li>
          <li><a href="#">Link-2</a></li>
          <li><a href="#">Link-3</a></li>
        </ul>
      </div>

      <div id="_desktop_blockcart-wrapper" class="tptncart col-xs-2">
        <div class="blockcart cart-preview">
          <div class="m-toggle">
            <span>
              <i class="material-icons">shopping_cart</i>
              <span class="items_cart cart_count">{{Cart::count()}}</span>
            </span>
            <span class="m-toggle-title hidden-xl-up">Cart</span>
          </div>
          <div class="minicart-body">
            <div class="minicart-title">Cart
              <i class="material-icons"></i>
            </div>
            <div id="minicartProduct">
              
            </div>
          </div>
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