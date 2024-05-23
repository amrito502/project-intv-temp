<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helper\Ui\FlashMessageGenerator;

class FrontController extends Controller
{


    public function memberRegister(Request $request)
    {


    }


    public function memberRegisterSave(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users,username',
            'roles' => 'required',
            'password' => 'min:6|required|confirmed',
        ]);



        if ($request->has('profile_img')) {
            // upload new file
            $file = $request->file('profile_img')->store('public/profile_img');
            $file = explode('/', $file);
            $file = end($file);
        }


        $data = [
            'username' => $request->username,
            'is_founder' => $request->is_founder == 'on' ? 1 : 0,
            'is_agent' => $request->is_agent == 'on' ? 1 : 0,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'referrence' => $request->referrence,
            'referral' => $request->referral,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hand_id' => $request->hand_id,
            'district_id' => $request->district,
            'thana_id' => $request->thana,
            'status' => 0,
        ];


        if ($request->has('profile_img')) {
            $data['profile_img'] = $file;
        }

        $roles = $request->roles;

        if (in_array('Member', $roles)) {
            $data['rank'] = "Member";
        }

        // save user
        $user = User::create($data);

        // sync role
        $user->syncRoles($roles);


        $userWithFUllData = User::where('id', $user->id)->with(['refMember'])->first();

        Session::flash('user', $userWithFUllData);

        FlashMessageGenerator::generate('primary', 'Congratulation, Member Successfully Added! Please Add fund to activate your account.');

        return back();
    }
}
