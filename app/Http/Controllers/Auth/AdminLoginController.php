<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }
    /**
     * Show the admin's login form.
     *
     * @return \Illuminate\Http\Response
     */


    public function showLoginForm()
    {
        $title = "Admin Login";
        return view('auth.admin-login')->with(compact('title'));
    }

    /**
     * Functionalities for login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $user = Admin::where('mobile', $request->username)->first();
        $userCheck = Admin::where('mobile', $request->username)->orWhere('username', $request->username)->where('status', 1)->first();

        if (!$userCheck) {
            $message = "<span class='help-block' style='color:#a94442;'><strong>User Not Found</strong></span>";
            return redirect(route('login'))->with('msg', $message)->withInput();
        }

        if (strlen($request->username) > 10 && $user) {

            //validate data
            $this->validate($request, [
                'username' => 'required|exists:admins,mobile',
                'password' => 'required|min:6',
            ]);

            //attemt to log the admin in
            if (Auth::guard('admin')->attempt(['mobile' => $request->username, 'password' => $request->password], $request->remember)) {
                return redirect()->intended(route('admin.index'));
            }
        } else {
            //validate data
            $this->validate($request, [
                'username' => 'required|exists:admins,username',
                'password' => 'required|min:6',
            ]);

            //attemt to log the admin in
            if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
                return redirect()->intended(route('admin.index'));
            }
        }

        $message = "<span class='help-block' style='color:#a94442;'><strong>password not matched.</strong></span>";
        return redirect(route('login'))->with('passwordMessage', $message)->withInput();
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('customer')->logout();

        return redirect(route('admin.index'));
    }
}
