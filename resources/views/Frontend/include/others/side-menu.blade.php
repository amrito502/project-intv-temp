 <?php
        use App\Category;
    ?>
<div class="side-menu animate-dropdown outer-bottom-xs">
          <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
          <nav class="yamm megamenu-horizontal">
            <ul class="nav">
      @foreach($publishedCategories as $category)
        <?php  if ($category->parent == '') { 
          $categoryName = str_slug($category->categoryName,'-');
        ?>
             

                 <li class="dropdown menu-item"> <a href="{{url('/categories/'.$category->id.'/'.$categoryName)}}" 
               <?php
                 $subcategory = Category::where('categoryStatus',1)->get();

                  foreach ($subcategory as $subcat) {
                    if ($subcat->parent == $category->id) { 

                ?>
                  class="dropdown-toggle" data-toggle="dropdown" <?php } } ?>>
                 <i class="icon fa fa-shopping-bag"></i>{{$category->categoryName}}</a> 
                <!-- ================================== MEGAMENU VERTICAL ================================== -->
                <ul class="dropdown-menu mega-menu">
                  <li class="yamm-content">
                    <div class="row">
                      <div class="">
                        <ul>
                   <?php
                    $subcategory = Category::where('categoryStatus',1)->get();

                    foreach ($subcategory as $subcat) {
                      if ($subcat->parent == $category->id) {
                      $categoryName = str_slug($subcat->categoryName,'-');     
                ?>
                          <li><a href="{{url('subcategories/'.@$subcat->id.'/'.@$categoryName)}}"><?php echo $subcat->categoryName; ?></a></li>
                <?php } } ?>
                        </ul>
                      </div>
                      
                    
                    </div>
                    <!-- /.row --> 
                  </li>
                  <!-- /.yamm-content -->
                </ul>
                <!-- /.dropdown-menu --> 
                <!-- ================================== MEGAMENU VERTICAL ================================== -->
                 </li>
          
                
              </li>
              <!-- /.menu-item -->
            <?php } ?>
      @endforeach
            
              
            </ul>
            <!-- /.nav --> 
          </nav>
          <!-- /.megamenu-horizontal --> 
        </div>