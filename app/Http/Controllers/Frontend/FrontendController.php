<?php

namespace App\Http\Controllers\Frontend;

use DB;
use App\Faq;
use Session;
use App\Blog;
use App\About;
use App\Brand;
use App\Terms;
use App\Review;
use App\Slider;
use App\Product;
use App\Category;
use App\Settings;
use App\HelpCenters;
use App\RefundPolicies;
use App\PaymentPolicies;
use App\ProductSections;
use App\DeliveryPolicies;
use Illuminate\Http\Request;
use App\CustomerRequestItemList;
use App\Helper\HomeCategoryProducts;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{

    public function index(Request $request)
    {

        $title = 'Home';

        $sliders = Slider::where('status', 1)->orderBy('orderBy', 'ASC')->get();

        $homeThemeCategories = session('home_theme')['home_theme']['three_category'];

        $categoryIds = [
            $homeThemeCategories['category_one'],
            $homeThemeCategories['category_two'],
            $homeThemeCategories['category_three'],
            $homeThemeCategories['category_four'],
            $homeThemeCategories['category_five'],
            $homeThemeCategories['banner_redirect_category'],
        ];

        $categories = Category::whereIn('id', $categoryIds)
            ->orderByRaw("FIELD(id ," . implode(',', $categoryIds) . ") ASC")
            ->get();

        $categoryProducts = HomeCategoryProducts::getProducts($categories);
        $categoryProducts = array_chunk($categoryProducts, 2);


        $featuredProductList = Product::where('status', '1')
            ->whereRaw('FIND_IN_SET(?,productSection)', ['2'])
            ->take(10)
            ->orderBy('id', 'desc')
            // ->orderBy('name', 'ASC')
            ->get();

        $newProductList = Product::where('status', '1')
            ->whereRaw('FIND_IN_SET(?,productSection)', ['1'])
            ->take(10)
            ->orderBy('id', 'desc')
            // ->orderBy('name', 'ASC')
            ->get();

        $bestSellProductList = Product::where('status', '1')
            ->whereRaw('FIND_IN_SET(?,productSection)', ['4'])
            ->take(10)
            ->orderBy('id', 'desc')
            // ->orderBy('name', 'ASC')
            ->get();


        $bodyID = 'index';
        $bodyClass = 'lang-en country-us currency-usd layout-full-width page-index tax-display-disabled';


        $banners = session('home_theme')['home_theme']['four_banner'];
        // dd($banners);

        return view('frontend.pages.home', compact('title', 'banners', 'categoryProducts', 'newProductList', 'featuredProductList', 'bestSellProductList', 'sliders', 'bodyID', 'bodyClass'));
    }

    public function paginationProducts(Request $request)
    {
        if ($request->ajax()) {
            $categoryId = $request->category;
            $categInfo = Category::where('id', $categoryId)->first();

            $cat_img = file_exists($categInfo->categoryImage) ? $categInfo->categoryImage : '/public/frontend/no-image-icon.png';

            //Subcategories
            $childs = Category::Enabled()->where('parent', $categInfo->id)->select('id')->get()->pluck('id')->toArray();

            $cats = array_merge($childs, [$categInfo->id]);
            $cats = array_unique($cats);

            $productIds = [];
            if (!empty($cats) && count($cats) > 0) {
                foreach ($cats as $key => $cat) {
                    $catPIds = Product::select('id')
                        ->whereRaw('FIND_IN_SET(?,category_id)', [$cat])
                        ->where('status', 1)
                        ->orderBy('id', 'desc')
                        ->get();
                    if (!empty($catPIds) && count($catPIds) > 0) {
                        foreach ($catPIds as $catPId) {
                            $productIds[] = $catPId->id;
                        }
                    }
                }
            }

            if (!empty($productIds) && count($productIds) > 0) {
                $productIds = array_unique($productIds);
            }

            // add category Info
            $category = [

                'category' => [
                    'category_id' => $categInfo->id,
                    'category_name' => $categInfo->categoryName,
                    'category_image' => $cat_img,
                    'color' => $categInfo->color,
                ],

                'child_category' => Category::Enabled()->where('parent', $categInfo->id)->select(['id', 'categoryName', 'parent'])->get(),


                'products' => Product::whereIn('id', $productIds)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    ->paginate(12),

            ];

            return view('frontend.partial.product_cards.homeCategory', compact('category', 'categoryId'))->render();
        }
    }

    public function searchProduct(Request $request)
    {
        $sortBy = $request->sort;
        $search = $_GET['search_query'];
        $categories = @$request->category_filter;

        // dd($request);

        $products = Product::where('status', 1)
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('deal_code', 'LIKE', '%' . $search . '%');

        if ($request->has('sort')) {

            if ($sortBy === 'nameAsc') {
                $products = $products->orderBy('name', 'asc');
            }

            if ($sortBy === 'nameDesc') {
                $products = $products->orderBy('name', 'desc');
            }


            if ($sortBy === 'priceAsc') {
                $products = $products->orderBy('price', 'asc');
            }


            if ($sortBy === 'priceDesc') {
                $products = $products->orderBy('price', 'desc');
            }
        } else {
            $products = $products->orderBy('orderBy', 'asc');
        }

        $products = $products->paginate(9);


        $products->appends(['searchProduct' => $search]);

        $categorySelect = Category::where('id', $categories)->first();

        // return view('frontend.search.searchProduct')->with(compact('products', 'search', 'categorySelect'));

        return view('frontend.pages.search_products')->with(compact('products', 'categorySelect', 'search', 'sortBy'));
    }

    public function categoryLanding($id)
    {

        $category = Category::where('id', $id)->first();

        $subCategory = Category::where('parent', $id)->where('categoryStatus', 1)->paginate(20);
        $allSubcat = Category::where('parent', $id)->where('categoryStatus', 1)->get();
        $homeCategories = Category::where('categoryStatus', 1)->where('showInHomepage', 'yes')->where('parent', null)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();

        $metaTag = [
            'meta_keyword' => $category->metaKeyword,
            'meta_title' => $category->metaTitle,
            'meta_description' => $category->metaDescription
        ];

        $title = $category->categoryName;

        return view('frontend_Adarsha.partial.navbar.side_menu2')->with(compact('subCategory', 'metaTag', 'title', 'category', 'allSubcat', 'homeCategories'));
    }

    public function productByCategory(Request $request, $id)
    {

        $sortBy = $request->sort;

        $catProducts = Product::whereRaw('FIND_IN_SET(?,category_id)', [$id])
            ->where('status', 1);

        if ($request->has('price')) {

            $minPrice  = 0;
            $maxPrice  = 0;

            if ($request->minPrice) {
                $minPrice  = $request->minPrice;
                $catProducts = $catProducts->where('price',  '>', $minPrice);
            }

            if ($request->maxPrice) {
                $maxPrice  = $request->maxPrice;
                $catProducts = $catProducts->where('price',  '<', $maxPrice);
            }
        }

        if ($request->has('brand')) {
            $catProducts = $catProducts->where('brand_id', $request->brand);
        }

        if ($request->has('sort')) {

            if ($sortBy === 'nameAsc') {
                $catProducts = $catProducts->orderBy('name', 'asc');
            }

            if ($sortBy === 'nameDesc') {
                $catProducts = $catProducts->orderBy('name', 'desc');
            }


            if ($sortBy === 'priceAsc') {
                $catProducts = $catProducts->orderBy('price', 'asc');
            }


            if ($sortBy === 'priceDesc') {
                $catProducts = $catProducts->orderBy('price', 'desc');
            }
        } else {
            $catProducts = $catProducts->orderBy('orderBy', 'asc');
        }

        $catProducts = $catProducts->paginate(9);


        $products = $catProducts;
        $category = Category::where('id', $id)->first();

        if (!$category) {
            return redirect(route('home.index'));
        }

        $metaTag = [
            'meta_keyword' => $category->metaKeyword,
            'meta_title' => $category->metaTitle,
            'meta_description' => $category->metaDescription
        ];

        $title = $category->categoryName;


        $catBrandIds = $products->pluck('brand_id')->toArray();

        $brands = Brand::wherein('id', $catBrandIds)->where('status', 1)->select(['id', 'name'])->limit(12)->get();

        return view('frontend.pages.category_wise_products')->with(compact('products', 'category', 'metaTag', 'title', 'sortBy', 'brands'));
    }

    public function productByBrand(Request $request, $id)
    {

        $products = Product::where('brand_id', $id)
            ->where('status', 1);


        $sortBy = $request->sort;

        if ($request->has('sort')) {

            if ($sortBy === 'nameAsc') {
                $products = $products->orderBy('name', 'asc');
            }

            if ($sortBy === 'nameDesc') {
                $products = $products->orderBy('name', 'desc');
            }


            if ($sortBy === 'priceAsc') {
                $products = $products->orderBy('price', 'asc');
            }


            if ($sortBy === 'priceDesc') {
                $products = $products->orderBy('price', 'desc');
            }
        } else {
            $products = $products->orderBy('orderBy', 'asc');
        }

        $products = $products->paginate(9);


        $brand = Brand::where('id', $id)->first();

        $title = $brand->name;


        return view('frontend.pages.brand_wise_products')->with(compact('products', 'brand', 'title', 'sortBy'));
    }

    public function productSort($id, $sortId)
    {
        if ($sortId == 1) {
            $orderBy = 'orderBy';
            $orders = "ASC";
        }
        if ($sortId == 2) {
            $orderBy = 'name';
            $orders = "ASC";
        }
        if ($sortId == 3) {
            $orderBy = 'name';
            $orders = "DESC";
        }
        if ($sortId == 4) {
            $orderBy = 'price';
            $orders = "ASC";
        }
        if ($sortId == 5) {
            $orderBy = 'price';
            $orders = "DESC";
        }
        $rootCategory = Product::where('root_category', $id)->first();

        if ($rootCategory) {
            @$products = Product::whereRaw('FIND_IN_SET(?,root_category)', [$rootCategory->root_category])->where('status', 1)->orderBy($orderBy, $orders)->paginate(40);
        } else {
            @$products = Product::whereRaw('FIND_IN_SET(?,category_id)', [$id])->where('status', 1)->orderBy($orderBy, $orders)->paginate(40);
        }

        $category = Category::where('id', $id)->first();

        $metaTag = [
            'meta_keyword' => $category->metaKeyword,
            'meta_title' => $category->metaTitle,
            'meta_description' => $category->metaDescription
        ];

        $title = $category->categoryName;

        // return view('frontend.category.productbycategory')->with(compact('products','category','metaTag','title','sortId'));

        return view('frontend_Adarsha.category.category')->with(compact('products', 'category', 'metaTag', 'title', 'sortId'));
    }

    public function singleProduct($slug)
    {
        $latestProducts = Product::with(['images'])->orderBy('id', 'desc')->where('status', 1)->limit(10)->get();
        $latestProducts = $latestProducts->chunk(5);
        $products = Product::where('slug', $slug)->with(['images'])->first();
        $reviews = Review::where('status', '1')->where('productId', $products->id)->get();
        $navbar = "no";


        $productInfo = ProductSections::where('productId', $products->id)->first();
        $allsection = explode(',', $productInfo->related_product);
        $relatedProducts = Product::whereIn('id', $allsection)->where('status', 1)->get();

        $metaTag = [
            'meta_keyword' => $products->metaKeyword,
            'meta_title' => $products->metaTitle,
            'meta_description' => $products->metaDescription
        ];

        $title = "Our Latest Product";
        $bodyClass = 'layout-left-column page-product tax-display-disabled
product-id-1 product-hummingbird-printed-t-shirt product-id-category-4 product-id-manufacturer-1 product-id-supplier-0
product-available-for-order';
        $bodyID = 'product';


        return view('frontend.pages.singleproduct')->with(compact('relatedProducts', 'products', 'latestProducts', 'metaTag', 'title', 'bodyClass', 'bodyID', 'reviews', 'navbar'));
    }

    public function viewProduct(Product $product, Request $request)
    {
        $products = Product::where('id', $request->product_id)->first();
        if ($request->ajax()) {
            return response()->json([
                'products' => $products
            ]);
        }
        return view('frontend.category.viewProduct')->with(compact('products'));
    }

    public function ViewAllProduct()
    {
        $section = @$_GET['section'];
        if ($section == 'flash_sell') {
            $title = "Deals of The Day";
            $products = FlashSell::where('id', 1)->where('flashDate', '!=', '')->first();
        } elseif ($section == 'best_sell') {
            $title = "Best Selling";
            $products = Product::whereRaw('FIND_IN_SET(?,productSection)', ['4'])->where('status', 1)->orderBy('id', 'ASC')->paginate(20);
        } elseif ($section == 'new_arrival') {
            $title = "New Arrival";
            $products = Product::whereRaw('FIND_IN_SET(?,productSection)', ['1'])->where('status', 1)->orderBy('id', 'ASC')->paginate(20);
        } elseif ($section == 'featured_product') {
            $title = "Featured Product";
            $products = Product::whereRaw('FIND_IN_SET(?,productSection)', ['2'])->where('status', 1)->orderBy('id', 'ASC')->paginate(20);
        } elseif ($section == 'trending') {
            $title = "Trending Product";
            $products = Product::whereRaw('FIND_IN_SET(?,productSection)', ['3'])->where('status', 1)->orderBy('id', 'ASC')->paginate(20);
        } else {
        }
        return view('frontend.product.viewAllProduct')->with(compact('section', 'products', 'title'));
    }

    public function customerOrder()
    {
        $packages = Package::all();
        $categories = Category::where('status', '1')->get();
        $products = Product::where('status', '1')->get();

        return view('frontend.package.package')->with(compact('packages', 'categories', 'products'));
    }


    public function productPage()
    {
        return view('frontend.pages.productPage');
    }

    public function productPage2()
    {
        return view('frontend.pages.productPage2');
    }

    public function career()
    {
        return view('frontend.pages.career');
    }

    public function contactUs()
    {
        $categories = Category::where('categoryStatus', 1)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $catLink = Category::where('categoryStatus', 1)->where('showInHomepage', 'yes')->where('parent', null)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $products = Product::where('status', 1)
            ->get();

        $setting = Settings::find(1);

        $title = "";
        //        return view('frontend_Adarsha.contact.contact')->with(compact('setting', 'title', 'categories', 'catLink', 'products'));
        return view('frontend.pages.contact_us')->with(compact('setting', 'title', 'categories', 'catLink', 'products'));
    }

    public function aboutUs()
    {
        $categories = Category::where('categoryStatus', 1)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $catLink = Category::where('categoryStatus', 1)->where('showInHomepage', 'yes')->where('parent', null)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $products = Product::where('status', 1)
            ->get();
        $title = "|| About Us";
        $about = About::where('status', '1')->first();

        //        return view('frontend_Adarsha.About.about')->with(compact('about', 'title', 'categories', 'catLink', 'products'));
        return view('frontend.pages.about_us')->with(compact('about', 'title', 'categories', 'catLink', 'products'));
    }

    public function faq()
    {
        $categories = Category::where('categoryStatus', 1)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $catLink = Category::where('categoryStatus', 1)->where('showInHomepage', 'yes')->where('parent', null)->orderBy('orderBy', 'ASC')->orderBy('categoryName', 'ASC')->get();
        $products = Product::where('status', 1)
            ->get();
        $faqs = Faq::where('status', '1')->orderBy('orderBy', "ASC")->get();
        return view('frontend_Adarsha.faq.faq')->with(compact('faqs', 'categories', 'catLink', 'products'));
    }

    public function deliveryPolicy()
    {
        $deliveryPolicy = DeliveryPolicies::where('status', '1')->first();

        return view('frontend.delivery.policy')->with(compact('deliveryPolicy'));
    }

    public function paymentPolicy()
    {
        $title = 'Privacy Policy';
        $paymentPolicy = PaymentPolicies::where('status', '1')->first();
        return view('frontend.pages.policy')->with(compact('paymentPolicy', 'title'));
    }

    public function refundPolicy()
    {
        $refundPolicy = RefundPolicies::where('status', '1')->first();
        return view('frontend.pages.refundPolicy')->with(compact('refundPolicy'));
    }

    public function helpCenter()
    {
        $helpCenter = HelpCenters::where('status', '1')->first();
        return view('frontend.help-center.help_center')->with(compact('helpCenter'));
    }

    public function termsCondition()
    {
        $title = 'Terms & Condition';
        $termsCondition = Terms::where('status', '1')->first();
        return view('frontend.pages.termsCondition')->with(compact('termsCondition', 'title'));
    }

    public function blog()
    {
        $blogs = Blog::where('status', '1')->get();
        return view('frontend.blog.blog')->with(compact('blogs'));
    }

    public function blogDetails($id)
    {
        $blogs = Blog::where('id', $id)->first();

        //        return view('frontend.blog.blogDetails')->with(compact('blogs'));

        return view('frontend.pages.blog_details')->with(compact('blogs'));
    }

    public function UploadItem(Request $request)
    {
        $title = "Upload Your Item List";
        if (count($request->all()) > 0) {
            if (isset($request->itemList)) {
                $itemList = \App\helperClass::UploadImage($request->itemList, 'customer_request_item_list', 'public/uploads/item_list/');
            }
            $customerRequestItem = CustomerRequestItemList::create([
                'name' => $request->fullName,
                'email' => $request->email,
                'mobile' => $request->phone,
                'address' => $request->address,
                'itemList' => $itemList,
            ]);

            $message = "<h3 style='display:inline-block;width:auto;' class='alert alert-success'>Your Item List Uploaded Successfully</h3>";
            return redirect(route('upload.itemList'))->with('msg', $message);
        }
        return view('frontend.order.upload_item')->with(compact('title'));
    }

    public function page404()
    {
        return view('frontend.pages.page404');
    }
}
