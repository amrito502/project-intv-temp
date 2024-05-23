<?php

namespace App\Http\Controllers\Admin;

use App\Theme;
use App\Category;
use App\helperClass;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class HomeThemeController extends Controller
{
    public function index()
    {

        $theme = Theme::all();
        $popular_one = $theme->where('section', 'popular_one')->first();
        $category_one = $theme->where('section', 'category_one')->first();
        $four_banner = $theme->where('section', 'four_banner')->first();
        $popular_two = $theme->where('section', 'popular_two')->first();
        $one_banner = $theme->where('section', 'one_banner')->first();
        $two_banner = $theme->where('section', 'two_banner')->first();
        $three_category = $theme->where('section', 'three_category')->first();
        $promotional = $theme->where('section', 'promotional')->first();

        $categories = Category::get();
        
        // dd($categories);

        $data = (object)[
            'theme_data' => $theme,
            'categories' => Category::enabled()->get(),
            'products' => Product::enabled()->get(),
            'popular_one' => json_decode($popular_one->value),
            'category_one' => json_decode($category_one->value),
            'four_banner' => json_decode($four_banner->value),
            'popular_two' => json_decode($popular_two->value),
            'one_banner' => json_decode($one_banner->value),
            'two_banner' => json_decode($two_banner->value),
            'three_category' => json_decode($three_category->value),
            'promotional' => json_decode($promotional->value),
        ];

        return view('admin.HomeTheme.index', compact(['data', 'categories']));
    }


    public function CategoryOne(Request $request)
    {
        $section = 'category_one';

        $r = $request->except('_token');

        // if show exists
        if (array_key_exists('show', $r[$section])) {
            $r[$section]['show'] = true;
        } else {
            $r[$section]['show'] = false;
        }

        Theme::updateOrCreate(
            [
                'section' => $section,
            ],
            [
                'value' => json_encode($r[$section]),
            ]
        );

        return back();
    }


    // public function popularOne(Request $request)
    // {

    //     $section = 'popular_one';

    //     $theme = Theme::where('section', $section)->first();
    //     $themeVal = json_decode($theme->value);

    //     $r = $request->except('_token');

    //     // if show exists
    //     if (array_key_exists('show', $r[$section])) {
    //         $r[$section]['show'] = true;
    //     } else {
    //         $r[$section]['show'] = false;
    //     }

    //     if (array_key_exists('banner_image', $r[$section])) {

    //         foreach ($r[$section] as $key => $value) {

    //             if (gettype($value) == 'object') {
    //                 $file = helperClass::_themeImages($value);
    //                 $r[$section][$key] = $file;
    //             }
    //         }
    //     } else {
    //         $r[$section]['banner_image'] = $themeVal->banner_image;
    //     }

    //     Theme::updateOrCreate(
    //         [
    //             'section' => $section,
    //         ],
    //         [
    //             'value' => json_encode($r[$section]),
    //         ]
    //     );

    //     return back();
    // }

    public function FourBanner(Request $request)
    {
        
        // dd($request->all());
        $section = 'four_banner';

        $theme = Theme::where('section', $section)->first()->toArray();
        $themeVal = json_decode($theme['value'], true);

        $r = $request->except('_token');


        // if show exists
        if (array_key_exists('show', $r[$section])) {
            $r[$section]['show'] = true;
        } else {
            $r[$section]['show'] = false;
        }

        $image_fields = ['image_one', 'image_two', 'image_three', 'image_four', 'image_five','image_six'];
        $categoryFields = ['category_one', 'category_two', 'category_three', 'category_four', 'category_five','category_six'];

        foreach ($image_fields as $image_field) {
            if (!isset($r[$section][$image_field])) {
                $r[$section][$image_field] = $themeVal[$image_field];
            }
        }
        
        // dd($r[$section]);

        foreach ($r[$section] as $key => $value) {

            if (gettype($value) == 'object') {
                $file = helperClass::_themeImages($value);
                $r[$section][$key] = $file;
            }
            
            
        }
        
        // dd($r);

        Theme::updateOrCreate(
            [
                'section' => $section,
            ],
            [
                'value' => json_encode($r[$section]),
            ]
        );


        return back();
    }

    // public function PopularTwo(Request $request)
    // {
    //     $section = 'popular_two';

    //     $theme = Theme::where('section', $section)->first()->toArray();
    //     $themeVal = json_decode($theme['value'], true);

    //     $r = $request->except('_token');

    //     // if show exists
    //     if (array_key_exists('show', $r[$section])) {
    //         $r[$section]['show'] = true;
    //     } else {
    //         $r[$section]['show'] = false;
    //     }

    //     $image_fields = ['banner_image'];

    //     foreach ($image_fields as $image_field) {
    //         if (!isset($r[$section][$image_field])) {
    //             $r[$section][$image_field] = $themeVal[$image_field];
    //         }
    //     }

    //     foreach ($r[$section] as $key => $value) {

    //         if (gettype($value) == 'object') {
    //             $file = helperClass::_themeImages($value);
    //             $r[$section][$key] = $file;
    //         }
    //     }

    //     Theme::updateOrCreate(
    //         [
    //             'section' => $section,
    //         ],
    //         [
    //             'value' => json_encode($r[$section]),
    //         ]
    //     );

    //     return back();
    // }

    public function OneBanner(Request $request)
    {
        $section = 'one_banner';

        $theme = Theme::where('section', $section)->first()->toArray();
        $themeVal = json_decode($theme['value'], true);

        $r = $request->except('_token');

        // if show exists
        if (array_key_exists('show', $r[$section])) {
            $r[$section]['show'] = true;
        } else {
            $r[$section]['show'] = false;
        }

        $image_fields = ['image_one'];

        foreach ($image_fields as $image_field) {
            if (!isset($r[$section][$image_field])) {
                $r[$section][$image_field] = $themeVal[$image_field];
            }
        }

        foreach ($r[$section] as $key => $value) {

            if (gettype($value) == 'object') {
                $file = helperClass::_themeImages($value);
                $r[$section][$key] = $file;
            }
        }

        Theme::updateOrCreate(
            [
                'section' => $section,
            ],
            [
                'value' => json_encode($r[$section]),
            ]
        );

        return back();
    }

    // public function TwoBanner(Request $request)
    // {
    //     $section = 'two_banner';

    //     $theme = Theme::where('section', $section)->first()->toArray();
    //     $themeVal = json_decode($theme['value'], true);

    //     $r = $request->except('_token');

    //     // if show exists
    //     if (array_key_exists('show', $r[$section])) {
    //         $r[$section]['show'] = true;
    //     } else {
    //         $r[$section]['show'] = false;
    //     }

    //     $image_fields = ['image_one', 'image_two'];

    //     foreach ($image_fields as $image_field) {
    //         if (!isset($r[$section][$image_field])) {
    //             $r[$section][$image_field] = $themeVal[$image_field];
    //         }
    //     }

    //     foreach ($r[$section] as $key => $value) {

    //         if (gettype($value) == 'object') {
    //             $file = helperClass::_themeImages($value);
    //             $r[$section][$key] = $file;
    //         }
    //     }

    //     Theme::updateOrCreate(
    //         [
    //             'section' => $section,
    //         ],
    //         [
    //             'value' => json_encode($r[$section]),
    //         ]
    //     );

    //     return back();
    // }

    public function ThreeCategory(Request $request)
    {
        $section = 'three_category';

        $theme = Theme::where('section', $section)->first()->toArray();
        $themeVal = json_decode($theme['value'], true);

        $r = $request->except('_token');

        // if show exists
        if (array_key_exists('show', $r[$section])) {
            $r[$section]['show'] = true;
        } else {
            $r[$section]['show'] = false;
        }

        $image_fields = ['banner_image'];

        foreach ($image_fields as $image_field) {
            if (!isset($r[$section][$image_field])) {
                $r[$section][$image_field] = $themeVal[$image_field];
            }
        }

        foreach ($r[$section] as $key => $value) {

            if (gettype($value) == 'object') {
                $file = helperClass::_themeImages($value);
                $r[$section][$key] = $file;
            }
        }

        Theme::updateOrCreate(
            [
                'section' => $section,
            ],
            [
                'value' => json_encode($r[$section]),
            ]
        );

        return back();
    }

    // public function Services(Request $request)
    // {
    //     $section = 'promotional';

    //     // $theme = Theme::where('section', $section)->first()->toArray();
    //     // $themeVal = json_decode($theme['value'], true);

    //     $r = $request->except('_token');

    //     // if show exists
    //     if (array_key_exists('show', $r[$section])) {
    //         $r[$section]['show'] = true;
    //     } else {
    //         $r[$section]['show'] = false;
    //     }

    //     foreach ($r[$section] as $key => $value) {

    //         if (gettype($value) == 'object') {
    //             $file = helperClass::_themeImages($value);
    //             $r[$section][$key] = $file;
    //         }
    //     }

    //     Theme::updateOrCreate(
    //         [
    //             'section' => $section,
    //         ],
    //         [
    //             'value' => json_encode($r[$section]),
    //         ]
    //     );

    //     return back();
    // }


}
