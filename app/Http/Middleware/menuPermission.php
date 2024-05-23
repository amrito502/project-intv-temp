<?php

namespace App\Http\Middleware;

use Closure;
use App\UserRoles;
use App\UserMenu;
use App\UserMenuActions;
use Auth;

class menuPermission
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
        $routeName = \Request::route()->getName();
        $userMenus = UserMenu::where('menuLink', $routeName)->get();
        $userMenuActions = UserMenuActions::where('actionLink', $routeName)->get()->pluck('id')->toArray();

        $roleId =  Auth::user()->role;
        $userRoles = UserRoles::where('id', $roleId)->first();
        $rolePermission = explode(',', $userRoles->permission);
        $actionLinkPermission = explode(',', $userRoles->actionPermission);

        $match = false;

        if ($userMenus->count()) {
            foreach ($userMenus as $userMenu) {
                if (in_array($userMenu->id, $rolePermission)) {
                    $match = true;
                    break;
                }
            }
        }

        if ($match) {
            return $next($request);
        }

        if ($userMenuActions) {

            foreach ($userMenuActions as $userMenuAction) {

                if ($match) {
                    break;
                }

                $match = in_array($userMenuAction, @$actionLinkPermission) ? True : False;
            }
        }

        if ($match) {
            return $next($request);
        }

        if (!$userMenus->count() && !$userMenuActions) {
            return $next($request);
        }

        return redirect(route('admin.index'));
    }
}
