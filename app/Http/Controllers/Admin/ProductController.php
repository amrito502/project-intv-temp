<?php

namespace App\Http\Controllers\Admin;

use DB;
use PDF;
use URL;
use Session;
use App\User;
use App\Brand;
use App\Order;
use App\Slider;
use App\Product;
use App\Category;
use App\Customer;
use App\FlashSell;
use App\ProductImage;
use App\CustomerGroup;
use App\ProductSections;
use Illuminate\Http\Request;
use App\CustomerGroupSections;
use Illuminate\Support\Carbon;
use App\Helper\ProductDealerStock;

use App\Helper\ProductStatusReport;
use App\Http\Controllers\Controller;
use App\Helper\ProductStatementReport;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;

        $products = Product::select('products.*', 'categories.id as catId', 'categories.categoryName as catName', 'product_images.productId', 'product_images.images')
            ->leftjoin('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('product_images', 'product_images.productId', '=', 'products.id')
            ->groupBy('products.id')
            // ->orderBy('categories.categoryName', 'asc')
            // ->orderBy('products.name', 'asc')
            ->orderBy('products.id', 'desc')
            ->where('products.status', 1)
            ->get();

        return view('admin.product.index')->with(compact('title', 'products'));
    }

    public function runningProduct()
    {
        $title = "Running Product";
        $products = Product::where('status', 1)->get();
        return view('admin.product.runningProduct')->with(compact('title', 'products'));
    }

    public function addproduct()
    {
        $title = "Add product";

        $tab1 = "Basic Information";
        $tab1Link = "productSetupBasicInfo.save";

        $tab2 = "Advance Information";
        $tab2Link = "productSetupAdvanceInfo.update";

        $tab3 = "Image";
        $tab3Link = "productSetupImage.save";

        $tab4 = "SEO Information";
        $tab4Link = "productSetupSeoInfo.update";

        $buttonName = "Save";
        $productId = "";

        $categories = Category::where('categoryStatus', 1)
            ->orderBy('categoryName', 'asc')
            ->get();

        $brands = Brand::where('status', 1)->get();

        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', @$_GET['productId'])
            ->orderBy('name', 'asc')
            ->get();

        $upsell_product = Product::where('status', 1)
            ->where('id', '!=', $productId)
            ->orderBy('name', 'asc')
            ->get();

        $customer_groups = CustomerGroup::where('groupStatus', 1)->get();

        return view('admin.product.add')->with(compact('upsell_product', 'title', 'tab1', 'tab1Link', 'tab2', 'tab2Link', 'tab3', 'tab3Link', 'tab4', 'tab4Link', 'buttonName', 'categories', 'brands', 'relatedProducts', 'customer_groups', 'productId'));
    }

    public function editProduct($productId)
    {
        $title = "Edit product";

        $tab1 = "Basic Information";
        $tab1Link = "productSetupBasicInfo.update";

        $tab2 = "Advance Information";
        $tab2Link = "productSetupAdvanceInfo.update";

        $tab3 = "Image";
        $tab3Link = "productSetupImage.save";

        $tab4 = "SEO Information";
        $tab4Link = "productSetupSeoInfo.update";

        $buttonName = "Update";

        $categories = Category::where('categoryStatus', 1)
            ->orderBy('categoryName', 'asc')
            ->get();

        $brands = Brand::where('status', 1)->get();

        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', $productId)
            ->orderBy('name', 'asc')
            ->get();

        $upsell_product = Product::where('status', 1)
            ->where('id', '!=', $productId)
            ->orderBy('name', 'asc')
            ->get();

        $customer_groups = CustomerGroup::where('groupStatus', 1)->get();
        $customerGroup = CustomerGroupSections::where('productId', $productId)->get();

        $product = Product::where('id', $productId)->first();
        $productAdvance = ProductSections::where('productId', $productId)->first();
        $productImages = ProductImage::where('productId', $productId)->get();

        return view('admin.product.edit')->with(compact('title', 'tab1', 'tab1Link', 'tab2', 'tab2Link', 'tab3', 'tab3Link', 'tab4', 'tab4Link', 'buttonName', 'brands', 'categories', 'relatedProducts', 'upsell_product', 'product', 'productAdvance', 'productImages', 'customer_groups', 'customerGroup', 'productId'));
    }

    public function saveProduct(Request $request)
    {
        $this->validate(request(), [
            'category_id' => 'required',
            'name' => 'required|string',
            // 'deal_code' => 'required|unique:products',
            'price' => 'required|numeric|not_in:0',
            'discount' => 'nullable|numeric',
            'status' => 'required',

        ]);

        if ($request->category_id) {
            $category_id = implode(',', $request->category_id);
        }


        $allCategory = Category::where('id', @$category_id)->first();
        if ($allCategory->parent) {
            $root_category = @$allCategory->parent;
        } else {
            $root_category = @$category_id;
        }

        $slug = preg_replace('/\s+/u', '-', trim($request->name));

        $discountPercent = 0;
        if ($request->price > 0 && $request->discount > 0) {
            $discountPercent = (($request->price - $request->discount) * 100) / $request->price;
        }

        $product = Product::create([
            'category_id' => @$category_id,
            // 'brand_id' => $request->brand_id,
            'root_category' => @$root_category,
            'name' => $request->name,
            'slug' => $slug,
            'deal_code' => $request->deal_code,
            'pp' => $request->purchase_point,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_percent' => $discountPercent,
            'product_details' => $request->product_details,
            'description1' => $request->description1,
            'description2' => $request->description2,
            'orderBy' => $request->orderBy,
            'status' => $request->status,
            'stockUnit' => $request->stockUnit,
            'youtubeLink' => $request->youtubeLink,
            'tag' => $request->tag
        ]);

        $productId = $product->id;
        if ($productId) {
            $productAdvance = ProductSections::create([
                'productId' => $productId
            ]);
        }



        return redirect(route('product.edit', $productId))->with('msg', 'Product Added Successfully')->withInput();
    }

    public function updateProduct(Request $request)
    {
        $this->validate(request(), [
            'category_id' => 'required',
            'name' => 'required|string',
            // 'deal_code' => 'required',
            'price' => 'required|not_in:0',
            'discount' => 'nullable|numeric',
            'status' => 'required',

        ]);

        $productId = $request->productId;

        $slug = preg_replace('/\s+/u', '-', trim($request->name));

        $product = Product::find($productId);
        if ($request->category_id) {
            $category_id = implode(',', @$request->category_id);
        }


        $allCategory = Category::where('id', @$category_id)->first();
        if ($allCategory->parent) {
            $root_category = $allCategory->parent;
        } else {
            $root_category = @$category_id;
        }

        $discountPercent = 0;
        if ($request->price > 0 && $request->discount > 0) {
            $discountPercent = (($request->price - $request->discount) * 100) / $request->price;
        }

        $product->update([
            'category_id' => @$category_id,
            'brand_id' => $request->brand_id,
            'root_category' => $root_category,
            'name' => $request->name,
            'slug' => $slug,
            'deal_code' => $request->deal_code,
            'pp' => $request->purchase_point,
            'price' => $request->price,
            'discount' => $request->discount,
            'discount_percent' => $discountPercent,
            'product_details' => $request->product_details,
            'description1' => $request->description1,
            'description2' => $request->description2,
            'orderBy' => $request->orderBy,
            'status' => $request->status,
            'stockUnit' => $request->stockUnit,
            'youtubeLink' => $request->youtubeLink,
            'tag' => $request->tag
        ]);

        $productId = $product->id;

        if ($request->submit == 'update_golist') {

            return redirect(route('products.index'));
        }

        return redirect(route('product.edit', $productId))->with('msg', 'Product Basic Information Updated Successfully')->withInput();
    }

    public function updateProductAdvanceInfo(Request $request)
    {
        $msg = "";
        $type = $request->type;

        $productId = $request->productId;
        $productAdvance = ProductSections::where('productId', $productId)->first();

        if ($request->related_product) {
            $related_product = implode(',', $request->related_product);
        }

        if ($request->upsell_product) {
            $upsell_product = implode(',', $request->upsell_product);
        }

        $product = Product::find($productId);
        if ($request->sections) {
            $request->sections = implode(',', $request->sections);
        }

        $product->update([
            'productSection' => $request->sections
        ]);

        if (@$productAdvance != '') {
            $productAdvance->update([
                'related_product' => @$related_product,
                'upsell_product' => @$upsell_product,
                'pre_orderDuration' => $request->pre_orderDuration,
                'free_shipping' => $request->free_shipping,
                'vat_amount' => $request->vat_amount,
                'hotDiscount' => $request->hotDiscount,
                'hotDate' => $request->hotDate,
                'specialDiscount' => $request->specialDiscount,
                'specialDate' => $request->specialDate
            ]);
        } else {
            $productAdvance = ProductSections::create([
                'related_product' => @$related_product,
                'upsell_product' => @$upsell_product,
                'pre_orderDuration' => $request->pre_orderDuration,
                'free_shipping' => $request->free_shipping,
                'vat_amount' => $request->vat_amount,
                'hotDiscount' => $request->hotDiscount,
                'hotDate' => $request->hotDate,
                'specialDiscount' => $request->specialDiscount,
                'specialDate' => $request->specialDate
            ]);
        }

        $countGroup = count($request->customerGroupPrice);
        DB::table('customer_group_sections')->where('productId', $productId)->delete();
        if ($request->customerGroupPrice) {
            $postData = [];
            for ($i = 0; $i < $countGroup; $i++) {
                $postData[] = [
                    'productId' => $productId,
                    'customerGroupId' => $request->customerGroupId[$i],
                    'customerGroupPrice' => $request->customerGroupPrice[$i]
                ];
            }

            CustomerGroupSections::insert($postData);
        }

        if ($type == "add") {
            $msg = "Product Advance Information Added Successfully";
            return redirect(route('productadd.page', ['productId' => $productId, 'productAdvance' => $productAdvance]))->with('msg', $msg)->withInput();
        }

        if ($type == "update") {
            $msg = "Product Advance Information Updated Successfully";

            if ($request->submit == 'update_golist') {
                return redirect(route('products.index'));
            }

            return redirect(route('product.edit', [$productId, 'productAdvance' => $productAdvance]))->with('msg', $msg)->withInput();
        }
    }

    public function updateProductSeoInfo(Request $request)
    {
        $msg = "";
        $type = $request->type;
        $productId = $request->productId;
        $productSeo = Product::find($productId);

        $productSeo->update([
            'metaTitle' => $request->metaTitle,
            'metaKeyword' => $request->metaKeyword,
            'metaDescription' => $request->metaDescription,
        ]);

        if ($type == "add") {
            $msg = "Product SEO Information Added Successfully";
            return redirect(route('productadd.page', ['productId' => $productId, 'productSeo' => $productSeo]))->with('msg', $msg)->withInput();
        }

        if ($type == "update") {
            $msg = "Product SEO Information Updated Successfully";

            if ($request->submit == 'update_golist') {
                return redirect(route('products.index'));
            }

            return redirect(route('product.edit', [$productId, 'productSeo' => $productSeo]))->with('msg', $msg)->withInput();
        }
    }

    public function saveProductImage(Request $request)
    {

        if (!$request->productImage) {
            return false;
        }

        $productId = $request->productId;
        $product = Product::where('id', $productId)->first();
        $productSection = explode(',', $product->productSection);
        /*if(in_array('1', $productSection) OR in_array('2', $productSection)){
            $width = '245';
            $height = '245';
        }elseif(in_array('3', $productSection) OR $product->specialDiscount != ''){
            $width = '100';
            $height = '118';
        }elseif(in_array('4', $productSection)){
            $width = '200';
            $height = '400';
        }elseif($product->hotDiscount != ''){
            $width = '318';
            $height = '380';
        }*/

        $width = '800';
        $height = '800';
        if (isset($request->productImage)) {
            $productImage = \App\helperClass::UploadImage($request->productImage, 'product_images', 'uploads/product_image/', @$width, @$height);
        } else {
            $productImage = "";
        }

        $image = ProductImage::create([
            'productId' => $productId,
            'images' => $productImage,
        ]);

        $productImages = ProductImage::where('productId', $productId)->get();
        $product_image = "";

        foreach ($productImages as $productImage) {
            $product_image .=
                '
            <div class="card card_image_' . $productImage->id . '" style="width: 200px; display: inline-block;" align="center">
                <img class="card-img-top" src="' . url('/') . '/' . $productImage->images . '" alt="Card image" style="width:150px; height: 150px;">
                <div class="card-body">
                    <a href="javascript:void(0)" data-id="' . $productImage->id . '" data-token="' . csrf_token() . '" class="btn btn-outline-danger" onclick="removeImage(' . $productImage->id . ')" style="width: 100%;">Delete</a>
                </div>
            </div>
            ';
        }

        if ($request->ajax()) {
            return response()->json([
                'images' => $product_image
            ]);
        }
    }


    public function deleteProductImage(Request $request)
    {
        $image = ProductImage::find($request->imageId);

        if ($image->delete()) {
            @unlink($image->images);
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }

    public function destroy(Request $request)
    {
        $imageSction = ProductImage::where('productId', $request->product_id)->get();
        if ($request->product_id) {
            foreach ($imageSction as $singleImage) {
                @unlink($singleImage->images);
            }
            ProductImage::where('productId', $request->product_id)->delete();
            ProductSections::where('productId', $request->product_id)->delete();
            Product::where('id', $request->product_id)->delete();
            CustomerGroupSections::where('productId', $request->product_id)->delete();
        }
    }

    public function changeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::find($request->product_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);

            $sliders = Slider::where('productId', $request->product_id)->first();
            $slider = Slider::find($sliders->id);
            $slider->status = $slider->status ^ 1;
            $slider->update();
            print_r(2);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        return redirect(route('products.index'))->with('msg', 'Product Deleted Successfully');
    }

    public function FlashSell()
    {
        $title = "Flash Sell";
        $productsAll = Product::all();
        $flashProducts = FlashSell::where('id', 1)->first();
        return view('admin.products.flashSell')->with(compact('productsAll', 'flashProducts', 'title'));
    }

    public function FlashSellUpdate(Request $request)
    {
        if ($request->flashProduct) {
            $allproduct = implode(',', $request->flashProduct);
            $flashSell = FlashSell::find(1);
            $flashSell->update([
                'flashPrice' => @$request->flashPrice,
                'flashDate' => @$request->flashDate,
                'flashProduct' => @$allproduct,
            ]);
        }
        return redirect(route('flashSell'))->with('msg', 'Flash Product Updated Successfully');
    }

    public function ProductQuickUpdateList()
    {
        $title = $this->title;

        $categoryList = Category::where('categoryStatus', 1)
            ->orderBy('categoryName', 'asc')
            ->get();

        $categoryParam = @$_GET['category'];

        $products = Product::with(['category'])
            ->whereRaw("find_in_set('" . $categoryParam . "', products.category_id)")
            ->where('status', 1)
            ->get();

        return view('admin.product.product_quick_update_list')->with(compact('title', 'products', 'categoryList', 'categoryParam'));
    }


    public function ProductQuickDiscountList()
    {

        $title = $this->title;

        $categoryList = Category::where('categoryStatus', 1)
            ->orderBy('categoryName', 'asc')
            ->get();

        $categoryParam = @$_GET['category'];

        $products = Product::select('products.*', 'categories.id as catId', 'categories.categoryName as catName')
            ->leftjoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', $categoryParam)
            ->where('products.status', '1')
            ->orderBy('categories.categoryName', 'asc')
            ->orderBy('products.name', 'asc')
            ->get();

        return view('admin.product.product_quick_update_discount_list')->with(compact('title', 'products', 'categoryList', 'categoryParam'));
    }

    public function ProductQuickDiscount(Request $request)
    {

        $product = Product::findOrFail($request->productId);

        $discountAmount = ($product->price / 100) * $request->discountPercentage;
        $discountPrice = $product->price - $discountAmount;

        $product->update([
            'discount' => $discountPrice,
            'discount_percent' => $request->discountPercentage,
        ]);
    }


    public function ProductQuickUpdate(Request $request)
    {
        $this->validate(request(), [
            'category_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|not_in:0'
        ]);

        $productId = $request->productId;
        $product = Product::find($productId);

        $allCategory = Category::where('id', @$request->category_id)->first();
        if ($allCategory->parent) {
            $root_category = $allCategory->parent;
        } else {
            $root_category = @$request->category_id;
        }

        if ($request->discount >= 1) {
            $request->discount = $request->discount;
        } else {
            $request->discount = NULL;
        }

        $product->update([
            'root_category' => @$root_category,
            'root_id' => @$request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'discount' => $request->discount,
            'pp' => $request->pp,
            'orderBy' => $request->orderBy,
        ]);
    }

    public function getProductPrice()
    {
        $product = Product::find(request()->product_id);
        $product_info = ProductSections::where('productId', $product->id)->first();
        $product_image = ProductImage::where('productId', $product->id)->first();

        if ($product_image) {
            $image = $product_image->images;
        } else {
            $image = $this->noImage;
        }

        return response()->json([
            'product' => $product,
            'product_price' => $product->price,
            'product_info' => $product_info,
            'product_image' => $image
        ]);
    }


    public function getProductPriceMemberSale()
    {
        $product = Product::find(request()->product_id);
        $product_info = ProductSections::where('productId', $product->id)->first();
        $product_image = ProductImage::where('productId', $product->id)->first();

        if ($product_image) {
            $image = $product_image->images;
        } else {
            $image = $this->noImage;
        }

        $customer = Customer::find(request()->customer_id);
        $user = User::find($customer->user_id);

        // $price = $user->member_type == 'Customer' ? $product->price : $product->discount;
        $price = $product->discount;

        return response()->json([
            'product' => $product,
            'product_price' => $price,
            'product_info' => $product_info,
            'product_image' => $image
        ]);
    }


    public function productStatementReport(Request $request)
    {

        $title = "Product Statement Report";

        $reports = [];

        $dateRangeUi = [
            'start_date' => $request->start_date ? $request->start_date : date('01-m-Y'),
            'end_date' => $request->end_date ? $request->end_date : date('t-m-Y'),
        ];

        $dateRange = [
            'start_date' => date('Y-m-d', strtotime($request->start_date)),
            'end_date' => date('Y-m-d', strtotime($request->end_date)),
        ];

        $previousBalance = 0;

        // if search form is submitted
        if ($request->searched) {

            $carbon = Carbon::createFromFormat('d-m-Y', $request->start_date)->subDay();

            $previousParams = [
                'dateRange' => [
                    'start_date' => "0000-00-00",
                    'end_date' => $carbon->format('Y-m-d'),
                ],
                'productId' => $request->product,
            ];


            $previousProductStatementReport = new ProductStatementReport($previousParams, 0);
            $previousReports = $previousProductStatementReport->getAllDetails();

            if (count($previousReports)) {
                $lastRow = count($previousReports) - 1;
                $previousBalance = $previousReports[$lastRow]['balance'];
            }

            $params = [
                'dateRange' => $dateRange,
                'productId' => $request->product,
            ];


            $productStatementReport = new ProductStatementReport($params, $previousBalance);

            $reports = $productStatementReport->getAllDetails();
        }

        $data = (object)[
            'reports' => $reports,
            'previousBalance' => $previousBalance,
            'products' => Product::where('status', 1)->get(),
            'dateRangeUi' => $dateRangeUi,
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.dealerReports.product_statement_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('product_statement.pdf');
        }

        return view('admin.dealerReports.product_statement_report', compact('title', 'data'));
    }

    public function productStatusReport(Request $request)
    {

        $title = "Product Status Report";

        $reports = ProductStatusReport::report();

        $data = (object)[
            'reports' => $reports,
        ];

        if ($request->print == true) {

            $pdf = PDF::loadView('admin.dealerReports.product_status_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('product_status.pdf');
        }

        return view('admin.dealerReports.product_status_report', compact('title', 'data'));
    }


    public function dealerWiseProductDealerStock($productId)
    {

        $title = "Product Dealer Stock";

        $product = Product::find($productId);
        $reports = ProductDealerStock::report($productId);

        $data = (object)[
            'product' => $product,
            'reports' => $reports,
        ];

        return view('admin.dealerReports.dealerwise_product_dealerStock', compact('title', 'data'));
    }


}
