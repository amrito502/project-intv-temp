<?php

namespace App\Http\Controllers\Admin;

use App\Admin;

use App\Customer;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Users";
        $users = Admin::with(['user_role'])->get();
        return view('admin.users.index')->with(compact('title', 'users'));
    }

    public function changeuserStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::find($request->user_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);
            return;
        }
        return redirect(route('users.index'))->with('message', 'Wrong move!');
    }

    public function adduser()
    {
        $title = "Add New User";
        $userRoles = UserRoles::orderBy('id', 'ASC')->get();
        return view('admin.users.adduser')->with(compact('title', 'userRoles'));
    }

    public function saveuser(Request $request)
    {

        $this->validation($request);

        $image = "";

        $users = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'username' => $request->username,
            'role' => $request->role,
            'password' => bcrypt($request->password),
            'profile_img' => $image,
            'status' => '1',

        ]);

        if ($request->file('profile_image')) {
            $img = \App\ImageHelper::UploadImage($request->profile_image, 'admins', 'uploads/profile_images/');

            $users->update([
                'profile_img' => $img,
            ]);
        }

        return redirect(route('useradd.page'))->with('msg', 'User Added Successfully');
    }

    public function edituser($id)
    {

        // check if user is admin or super user
        $isUserAdminLevel = in_array(Auth::user()->role, [1, 2, 6, 7]) ? true : false;

        if ($isUserAdminLevel == false && $id != Auth::user()->id) {
            // redirect back to dashboard
            return redirect(route('users.index'));
        }

        $title = "Edit User";
        $userRoles = UserRoles::orderBy('id', 'ASC')->get();
        $users = Admin::where('id', $id)->first();

        // if user not found return to user index
        if (!$users) {
            return redirect(route('users.index'));
        }

        return view('admin.users.updateuser')->with(compact('title', 'users', 'userRoles'));
    }

    public function userProfile()
    {
        $title = "My Profile";
        $users = Admin::where('id', Auth::user()->id)->first();
        $userRoles = UserRoles::where('id', $users->role)->first();
        return view('admin.users.profile')->with(compact('title', 'users', 'userRoles'));
    }


    public function updateuser(Request $request)
    {

        $this->validate(request(), [
            'role' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'username' => 'required',

        ]);



        $investor = $request->investor ? 1 : 0;
        $operator = $request->operator ? 1 : 0;

        $userId = $request->userId;

        $users = Admin::find($userId);

        if ($request->file('profile_image')) {
            $logo = \App\ImageHelper::UploadImage($request->profile_image, 'admins', 'uploads/profile_images/');
            $users->update([
                'profile_img' => $logo,
            ]);
        } else {
            $image = $request->old_image;
        }


        $updateData = [
            'email' => $request->email,
            'mobile' => $request->mobile,
            'investor' => $investor,
            'operator' => $operator,
            'role' => $request->role,
        ];

        if (auth()->user()->role == 1) {
            $updateData['name'] = $request->name;
            // $updateData['username'] = $request->username;
        }

        // dd($users, $updateData);

        $users->update($updateData);


        // update user customer
        $customer = Customer::where('user_id', $userId)->first();

        if ($customer) {

            $customer->update([
                // 'username' => $request->username,
                // 'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
            ]);
        }


        if ($request->dealerEdit) {
            return redirect(route('dealer.list'))->with('msg', 'User Updated Successfully');
        }

        return redirect(route('users.index'))->with('msg', 'User Updated Successfully');
    }


    public function password($id)
    {
        if (Auth::user()->role != 1) {
            if ($id != Auth::user()->id) {
                return redirect(route('users.index'));
            }
        }

        $title = "Change Password";
        $users = Admin::where('id', $id)->first();
        return view('admin.users.changePassword')->with(compact('title', 'users'));
    }

    public function passwordChange(Request $request)
    {

        $validateArr = [
            'password' => 'required|min:6',
        ];

        if (Auth::user()->role != 1) {
            $validateArr['old_password'] = 'required';
        }

        $request->validate($validateArr);

        $userId = $request->userId;

        $users = Admin::find($userId);

        $customer_account = $users->CustomerAccount;

        // check if old password matches
        if (Auth::user()->role != 1) {
            if (!Hash::check($request->old_password, $users->password)) {
                return back()->with('msg', 'Old Password Not Matching');
            }
        }

        $users->update([
            'password' => bcrypt($request->password),
        ]);

        if ($customer_account) {
            $customer_account->update([
                'password' => bcrypt($request->password),
            ]);
        }

        // $product = Product::create($request->all());

        return redirect(route('users.index'))->with('msg', 'Password Changed Successfully');
    }


    public function destroy(Admin $user, Request $request)
    {
        if ($request->ajax()) {
            $user->delete();
            print_r(1);
            return;
        }

        $user->delete();
        return redirect(route('users.index'))->with('message', 'Deleted Successfully');
    }


    public function validation(Request $request)
    {
        $this->validate(request(), [
            'role' => 'required',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:admins',
            'password' => 'required',


        ]);
    }
}
