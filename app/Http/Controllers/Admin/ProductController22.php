<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\FlashSell;
use App\Order;
use App\ProductSections;
use App\Category;
use App\ProductImage;
use App\Slider;
use App\CustomerGroup;
use App\CustomerGroupSections;
use URL;
use DB;
use Session;

class ProductController22 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Products";

        $products = Product::select('products.*','categories.id as catId','categories.categoryName as catName')
            ->join('categories','categories.id','=','products.category_id')
            /*->join('product_images','product_images.productId','=','products.id')*/
            ->orderBy('categories.categoryName','asc')
            ->orderBy('products.name','asc')
            ->get();

        // $products = Product::orderBy('name','asc')->get();
        // $categories = Category::orderBy('categoryName','asc')->get();
        return view('admin.products.index')->with(compact('title','products'));
    }

    public function runningProduct(){
        $title = "Running Product";
        $products = Product::where('status',1)->get();
        return view('admin.products.runningProduct')->with(compact('title','products'));
    }

    public function addproduct(){
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

        $categories = Category::where('categoryStatus',1)
            ->orderBy('categoryName','asc')
            ->get();

        $relatedProducts = Product::where('status',1)
            ->orderBy('name','asc')
            ->get();

        $customer_groups = CustomerGroup::where('groupStatus',1)->get();

        return view('admin.product.add')->with(compact('title','tab1','tab1Link','tab2','tab2Link','tab3','tab3Link','tab4','tab4Link','buttonName','categories','relatedProducts','productId'));

        //return view('admin.products.addproduct')->with(compact('title','categories','relateProducts','customer_groups'));
    }

    public function destroy(Request $request)
    {   $imageSction = ProductImage::where('productId',$request->product_id)->get();
        if($request->product_id)
        {   foreach ($imageSction as $singleImage) {
           @unlink($singleImage->images);
        }
        ProductImage::where('productId',$request->product_id)->delete();
        ProductSections::where('productId',$request->product_id)->delete();
        Product::where('id',$request->product_id)->delete();
        Slider::where('productId',$request->product_id)->delete();
        }
    }

    public function changeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = Product::find($request->product_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);

            $sliders = Slider::where('productId',$request->product_id)->first();
            $slider = Slider::find($sliders->id);
            $slider->status = $slider->status ^ 1;
            $slider->update();
            print_r(2);
        }

    }

    public function saveProduct(Request $request){
        $this->validate(request(), [
            'category_id' => 'required',
            'name' => 'required|string',
            'deal_code' => 'required|unique:products',
            'phone_no' => 'nullable',
            'qty' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable|numeric',
            'status' => 'required',

        ]);

       $category_id = implode(',', $request->category_id);

        $allCategory = Category::where('id',$category_id)->first();
       if ($allCategory->parent) {
           $root_category = $allCategory->parent;
       }else{
            $root_category =  $category_id;
       }

        $product = Product::create( [
            'category_id' => $category_id,
            'root_category' => $root_category,
            'name' => $request->name,
            'deal_code' => $request->deal_code,
            'price' => $request->price,
            'discount' => $request->discount,
            'qty' => $request->qty,
            'stockUnit' => $request->stockUnit,
            'phone_no' => $request->phone_no,
            'description1' => $request->description1,
            'description2' => $request->description2,
            'orderBy' => $request->orderBy,
            'status' => $request->status,
            'youtubeLink' => $request->youtubeLink,
        ]);

            $productId = $product->id;

        return redirect(route('productadd.page',['productId'=>$productId]))->with('msg','Product Added Successfully')->withInput();
    }

    public function advnceProduct(Request $request){
         /*$this->validate(request(), [
            'section' => 'required',

        ]);*/
        $productId = $request->productId;
        if (isset($productId)) {
            $product = Product::find($productId);
            if ($request->section) {
                $section =  implode(',', $request->section);
                $product->update( [
                'productSection' => @$section,
                ]);
            }

             if ($request->related_product) {
                $allproduct = implode(',', $request->related_product);
            }

            if ($request->customerGroupId != '') {
                $customerGroupId = implode(',', @$request->customerGroupId);
            }

              $productSection = ProductSections::create( [
                 'productId' => $productId,
                 'hotDiscount' => $request->hotDiscount,
                 'hotDate' => $request->hotDate,
                 'specialDiscount' => $request->specialDiscount,
                 'specialDate' => $request->specialDate,
                 'free_shipping' => $request->free_shipping,
                 'pre_order' => $request->pre_order,
                 'pre_orderDuration' => $request->pre_orderDuration,
                 'related_product' => @$allproduct,

             ]);

            $countGroup = count($request->customerGroupPrice);
            if($request->customerGroupPrice){
                $postData = [];
                for ($i=0; $i <$countGroup ; $i++) {
                    $postData[] = [
                        'productId' => $productId,
                        'customerGroupId' => $request->customerGroupId[$i],
                        'customerGroupPrice' => $request->customerGroupPrice[$i]
                    ];
                }

                CustomerGroupSections::insert($postData);
            }

         return redirect(route('productadd.page',['productId'=>$productId]))->with('msg','Advance Information Save Successfully')->withInput();
        }else{
        return redirect(route('productadd.page'))->with('error_msg','Please Complete Basic Information ')->withInput();
        }
    }


    public function multiImageupload(Request $request){
        $this->validate(request(), [
            'multiImage' => 'required',

        ]);

        if($request->hasfile('multiImage'))
             {
                foreach($request->file('multiImage') as $multipleImages)
                {   $directory = "public/uploads/product_image";
                    $name=$multipleImages->getClientOriginalName();
                    $multipleImages->move(public_path().'/uploads/product_image', $name);
                    $data = $directory."/".$name;

                    $ProductImage = ProductImage::create( [
                        'images' =>$data,
                        'productId' =>$request->productId,
                     ]);
                }
             }

            $allImages = ProductImage::where('productId',$request->productId)->get();
            $images = [];
            foreach($allImages as $productImage){
                $eachImage ='<span>
                <input type="hidden" name="imageId" value="'.$productImage->id.'">
                <img src="'.url('/').'/'.$productImage->images.'"><a onclick="myFunction()" data-id="'.$productImage->id.'" class="btn btn-danger remove">x</a>
                </span>';
                array_push($images, $eachImage);
            }

            if($request->ajax())
            {
                return response()->json([
                    'images'=>$images
                ]);
            }


    }

     public function removeImage(Request $request)
    {
       $image = ProductImage::find($request->id);
            if($image->delete()){
                @unlink($image->images);
                return response()->json(true);
            }else{
                return response()->json(false);
            }
    }

    // Save SEO information for product

    public function productSeo(Request $request){
        $this->validate(request(), [
            'metaTitle' => 'required',
            'metaKeyword' => 'required',
            'metaDescription' => 'required'
        ]);
        $productId = $request->productId;

        if (isset($productId)) {
            $product = Product::find($productId);

            $product->update( [

                'metaTitle' => $request->metaTitle,
                'metaKeyword' => $request->metaKeyword,
                'metaDescription' => $request->metaDescription,
            ]);


             return redirect(route('productadd.page',['productId'=>$productId]))->with('msg','SEO Information Save Successfully')->withInput();

        }else{
            return redirect(route('productadd.page'))->with('error_msg','Please Complete Basic Information ')->withInput();
        }
    }

    //Save other information of product
    public function productOthers(Request $request){
        $this->validate(request(), [
            'tag' => 'required',
        ]);

        $productId = $request->productId;

        $existProduct = Slider::where('productId',@$productId)->first();

        if (@$existProduct) {
                $product = Product::find($productId);
                $productInfo = Product::where('id',$productId)->first();
                $sliderInfo = Slider::where('productId',$productId)->first();

                $slider = Slider::find($sliderInfo->id);

                $product->update( [

                    'tag' => $request->tag,
                ]);

                if ($request->sliderImage) {
                    @unlink($sliderInfo->source);
                     $sliderImage = \App\helperClass::_uploadImage($request->sliderImage);

                    $slider->update( [
                    'source' => $sliderImage,
                    'status' => $productInfo->status,
                    'metaTitle' => $productInfo->metaTitle,
                    'metaKeyword' => $productInfo->metaKeyword,
                    'metaDescription' => $productInfo->metaDescription,
                    'orderBy' => $productInfo->orderBy,
                ]);

                }

                return redirect(route('productadd.page',['productId'=>$productId]))->with('msg','Other Information Save Successfully')->withInput();

        }else{
           if (isset($productId)) {
            $product = Product::find($productId);

            $productInfo = Product::where('id',$productId)->first();

            $product->update( [

                'tag' => $request->tag,
            ]);

            if ($request->sliderImage) {
                 $sliderImage = \App\helperClass::_sliderImage($request->sliderImage);

                $slider = Slider::create( [
                'source' => $sliderImage,
                'productId' => $productId,
                'section' => 'product',
                'status' => $productInfo->status,
                'metaTitle' => $productInfo->metaTitle,
                'metaKeyword' => $productInfo->metaKeyword,
                'metaDescription' => $productInfo->metaDescription,
                'orderBy' => $productInfo->orderBy,
            ]);

            }

             return redirect(route('productadd.page',['productId'=>$productId]))->with('msg','Other Information Save Successfully')->withInput();

        }else{
            return redirect(route('productadd.page'))->with('error_msg','Please Complete Basic Information ')->withInput();
        }
        }

    }

    public function editProduct($id){
        $title = "Product";
        $products = Product::where('id',$id)->first();
        $meta = Product::where('id',$id)->first();
        $sliders = Slider::where('productId',$id)->first();
        $allProducts = Product::all();
        $categories = Category::all();
        $customer_groups = CustomerGroup::where('groupStatus',1)->get();
        $productSections = ProductSections::where('productId',$id)->first();
        $customerGroup = CustomerGroupSections::where('productId',$id)->get();

        return view('admin.products.updateproduct')->with(compact('title','products', 'categories','sliders','allProducts','meta','productSections','customer_groups','customerGroup'));
    }

    public function updateProduct(Request $request){
        $this->validate(request(), [
            'category_id' => 'required',
            'name' => 'required|string',
            'deal_code' => 'required',
            'phone_no' => 'nullable',
            'qty' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable|numeric',
            'status' => 'required',

        ]);

        $productId = $request->productId;

        $product = Product::find($productId);
        $category_id = implode(',', $request->category_id);

       $allCategory = Category::where('id',$category_id)->first();
       if ($allCategory->parent) {
           $root_category = $allCategory->parent;
       }else{
            $root_category =  $category_id;
       }

        $product->update( [
            'category_id' => $category_id,
            'root_category' => $root_category,
            'name' => $request->name,
            'description1' => $request->description1,
            'description2' => $request->description2,
            'deal_code' => $request->deal_code,
            'phone_no' => $request->phone_no,
            'qty' => $request->qty,
            'stockUnit' => $request->stockUnit,
            'price' => $request->price,
            'discount' => $request->discount,
            'status' => $request->status,
            'youtubeLink' => $request->youtubeLink,
            'orderBy' => $request->orderBy,
        ]);

       /* $slider->update( [
                'status' => $request->status,
            ]);
*/
        // $product = Product::create($request->all());

        return redirect(route('product.edit',$productId))->with('msg','Product Updated Successfully');
    }

    // update advance information for product

    public function updateProductAdvance(Request $request){
        $productId = $request->productId;
        if (isset($productId)) {
            $product = Product::find($productId);
            $proSection = ProductSections::where('productId',$productId)->first();

            if ($request->section) {
                $section =  implode(',', $request->section);
                $product->update( [
                'productSection' => @$section,

                ]);
            }

            if (@$proSection->productId) {
                $productSection = ProductSections::find($proSection->id);

             if ($request->related_product) {
                $allproduct = implode(',', $request->related_product);
                 $productSection->update( [
                     'related_product' => $allproduct,
                 ]);
                }

                if ($request->customerGroupId != '') {
                $customerGroupId = implode(',', @$request->customerGroupId);
                }
                $productSection->update( [
                 'free_shipping' => $request->free_shipping,
                 'pre_order' => $request->pre_order,
                 'pre_orderDuration' => $request->pre_orderDuration,
                 'customerGroupId' => @$customerGroupId,
                 'customerGroupPrice' => @$request->customerGroupPrice,
                ]);

            if ($request->hotDeal && $request->hotDiscount && $request->hotDate) {
              $productSection->update( [
                 'hotDiscount' => $request->hotDiscount,
                 'hotDate' => $request->hotDate,
                /* 'specialDiscount' => '',
                 'specialDate' => '',*/
             ]);
            }else{
                 $productSection->update( [
                     'hotDiscount' => '',
                     'hotDate' => '',

                 ]);
            }

        if ($request->specialDeal && $request->specialDiscount && $request->specialDate) {
              $productSection->update( [
                /* 'hotDiscount' => '',
                 'hotDate' => '',*/
                 'specialDiscount' => $request->specialDiscount,
                 'specialDate' => $request->specialDate,

             ]);

        }else{
            $productSection->update( [
                 'specialDiscount' => '',
                 'specialDate' => '',

             ]);
        }

        $countGroup = count($request->customerGroupPrice);
         DB::table('customer_group_sections')->where('productId', $productId)->delete();
        if($request->customerGroupPrice){
            $postData = [];
            for ($i=0; $i <$countGroup ; $i++) {
                $postData[] = [
                    'productId' => $productId,
                    'customerGroupId' => $request->customerGroupId[$i],
                    'customerGroupPrice' => $request->customerGroupPrice[$i]
                ];
            }

            CustomerGroupSections::insert($postData);
        }

         return redirect(route('product.edit',$productId))->with('msg','Advance Information Save Successfully')->withInput();
     }else{
             if ($request->related_product) {
                $allproduct = implode(',', $request->related_product);
                }
                $productSections = ProductSections::create( [
                 'productId' => $productId,
                 'hotDiscount' => $request->hotDiscount,
                 'hotDate' => $request->hotDate,
                 'specialDiscount' => $request->specialDiscount,
                 'specialDate' => $request->specialDate,
                 'related_product' => @$allproduct,
             ]);

          return redirect(route('product.edit',$productId))->with('msg','Advance Information Save Successfully')->withInput();
     }
        }else{
        return redirect(route('product.edit',$productId))->with('error_msg','Please Complete Basic Information ')->withInput();
        }
    }


    //update seo info
    public function updateProductSeo(Request $request){
        $this->validate(request(), [
            'metaTitle' => 'required',
            'metaKeyword' => 'required',
            'metaDescription' => 'required'
        ]);
        $productId = $request->productId;

        if (isset($productId)) {
            $product = Product::find($productId);

            $product->update( [

                'metaTitle' => $request->metaTitle,
                'metaKeyword' => $request->metaKeyword,
                'metaDescription' => $request->metaDescription,
            ]);


             return redirect(route('product.edit',$productId))->with('msg','SEO Information Save Successfully')->withInput();

        }else{
            return redirect(route('product.edit',$productId))->with('error_msg','Please Complete Basic Information ')->withInput();
        }
    }

     //update other information of product
    public function updateProductOthers(Request $request){
        $productId = $request->productId;
        $existProduct = Slider::where('productId',@$productId)->first();
        if (@$existProduct) {
            $product = Product::find($productId);
            $productInfo = Product::where('id',$productId)->first();
            $sliderInfo = Slider::where('productId',$productId)->first();

            $slider = Slider::find($sliderInfo->id);

            $product->update( [

                'tag' => $request->tag,
            ]);

            if ($request->sliderImage) {
                @unlink($sliderInfo->source);
                 $sliderImage = \App\helperClass::_uploadImage($request->sliderImage);

                $slider->update( [
                'source' => $sliderImage,
                'status' => $productInfo->status,
                'metaTitle' => $productInfo->metaTitle,
                'metaKeyword' => $productInfo->metaKeyword,
                'metaDescription' => $productInfo->metaDescription,
                'orderBy' => $productInfo->orderBy,
            ]);

            }

             return redirect(route('product.edit',$productId))->with('msg','Other Information Save Successfully')->withInput();

        }else{
           $product = Product::find($productId);

            $productInfo = Product::where('id',$productId)->first();

            $product->update( [

                'tag' => $request->tag,
            ]);

            if ($request->sliderImage) {
                 $sliderImage = \App\helperClass::_sliderImage($request->sliderImage);

                $slider = Slider::create( [
                'source' => $sliderImage,
                'productId' => $productId,
                'section' => 'product',
                'status' => $productInfo->status,
                'metaTitle' => $productInfo->metaTitle,
                'metaKeyword' => $productInfo->metaKeyword,
                'metaDescription' => $productInfo->metaDescription,
                'orderBy' => $productInfo->orderBy,
            ]);

            }

             return redirect(route('product.edit',$productId))->with('msg','Other Information Save Successfully')->withInput();
        }

    }

    //View Product

    public function edit(Product $product, Request $request)
    {
        $product = Product::find($request->product_id);
        $category = Category::where('id',$product->category_id)->first();
        if($request->ajax())
            {
                return response()->json([
                    'product'=>$product,
                    'category'=>$category
                ]);
            }
        return view('admin.products.edit')->with(compact('product'));
    }
    public function deleteProduct($id){
        Product::where('id',$id)->delete();
        return redirect(route('products.index'))->with('msg','Product Deleted Successfully');
    }

     public function FlashSell(){
        $title = "Flash Sell";
        $productsAll = Product::all();
        $flashProducts = FlashSell::where('id',1)->first();
        return view('admin.products.flashSell')->with(compact('productsAll','flashProducts','title'));
    }

    public function FlashSellUpdate(Request $request){
        if ($request->flashProduct) {
                $allproduct = implode(',', $request->flashProduct);
                $flashSell = FlashSell::find(1);
                 $flashSell->update( [
                    'flashPrice' => @$request->flashPrice,
                    'flashDate' => @$request->flashDate,
                    'flashProduct' => @$allproduct,
                 ]);
                }
        return redirect(route('flashSell'))->with('msg','Flash Product Updated Successfully');
    }


    /**
     * Internal function for validation.
     *
     * @param  $request
     * @return \validation
     */


}
