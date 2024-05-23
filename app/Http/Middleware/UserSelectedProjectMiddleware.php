<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserSelectedProjectMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        // if (Auth::user()->hasRole(['Software Admin'])) {
        //     return $next($request);
        // }

        // if(Auth::user()->hasRole(['SuperAdmin'])){
        //     return $next($request);
        // }

        // if (!Cache::has('user_project_' . Auth::user()->id)) {
        //     return redirect(route('select.project'));
        // }

        return $next($request);
    }
}
