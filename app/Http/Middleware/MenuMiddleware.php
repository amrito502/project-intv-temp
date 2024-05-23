<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // get all menus
        session(['menus' => Permission::where('status', 1)->get()]);

        return $next($request);

    }
}
