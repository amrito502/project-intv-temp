<?php

namespace App\Helper;

use App\Product;
use App\Category;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HomeCategoryProducts
{

    public static function getProducts($homeCategories)
    {

        $data = [];

        foreach ($homeCategories as $category) {

            // category image or no image
            $cat_img = file_exists($category->categoryImage) ? $category->categoryImage : '/frontend/no-image-icon.png';

            //Subcategories
            $childs = Category::Enabled()->where('parent', $category->id)->select('id')->get()->pluck('id')->toArray();

            $cats = array_merge($childs, [ $category->id]);
            $cats = array_unique($cats);


                $productIds = [];
                if(!empty($cats) && count($cats) > 0){
                    foreach($cats as $key => $cat){
                       $catPIds = Product::select('id')
                                ->whereRaw('FIND_IN_SET(?,category_id)', [$cat])
                                ->where('status', 1)
                                ->orderBy('id', 'desc')
                                ->get();
                        if(!empty($catPIds) && count($catPIds) > 0){
                            foreach($catPIds as $catPId){
                                $productIds[] = $catPId->id;
                            }
                        }
                    }
                }

               if(!empty($productIds) && count($productIds) > 0){
                   $productIds = array_unique($productIds);
               }


            // add category Info
            $data[] = [

                'category' => [
                    'category_id' => $category->id,
                    'category_name' => $category->categoryName,
                    'category_image' => $cat_img,
                    'color' => $category->color,
                ],

                'child_category' => Category::Enabled()->where('parent', $category->id)->select(['id', 'categoryName', 'parent'])->get(),

                // 'products' => Product::whereRaw('FIND_IN_SET(?,category_id)', [$category->id])
                //     ->where('status', 1)
                //     ->orderBy('orderBy', 'ASC')
                //     // ->limit(8)
                //     // ->get(),
                //     ->paginate(8),




                'products' => Product::whereIn('id', $productIds)
                    ->where('status', 1)
                    ->orderBy('id', 'desc')
                    // ->limit(8)
                    // ->get(),
                    ->paginate(12),

            ];
        }


        return $data;
    }
}
