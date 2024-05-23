<?php

namespace App\Http\Middleware;

use Closure;
use App\Blog;
use App\Brand;
use App\Theme;
use App\Social;
use App\Category;
use App\Settings;
use Illuminate\Support\Facades\Session;

class HomeThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $home_themes = Theme::all();
        $metaInfo = Settings::first();
        $socials = Social::where('id', 1)->first();
        $brands = Brand::where('status', 1)->get();

        $ht = [];


        foreach ($home_themes as $value) {
            $ht[$value->section] = json_decode($value->value, true);
        }

        $catLink = Category::where('categoryStatus', 1)->where('showInHomepage', 'yes')->where('parent', null)->limit(8)->orderBy('orderBy', 'ASC')->get();

        $categories = Category::where('categoryStatus', 1)->orderBy('orderBy', 'ASC')->get();

        $data = [
            'home_theme' => $ht,
            'catLink' => $catLink,
            'categories' => $categories,
            'meta_info' => $metaInfo,
            'social_icons' => $socials,
            'brands' => $brands,
        ];


        Session::put('home_theme', $data);

        return $next($request);
    }
}
