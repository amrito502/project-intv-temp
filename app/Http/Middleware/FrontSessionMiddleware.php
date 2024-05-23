<?php

namespace App\Http\Middleware;

use Closure;
use App\Theme;
use App\Social;
use Illuminate\Support\Facades\Session;

class FrontSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $social_icons = Social::find(1);

        $data = [
            'social_icons' => $social_icons,
        ];

        Session::put('theme_data', $data);


        return $next($request);
    }
}
