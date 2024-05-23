<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helper\Ui\FlashMessageGenerator;
use App\Models\Customer;

class FrontController extends Controller
{


    public function memberRegister(Request $request)
    {

        $user = User::find($request->uid);

        if (!$user) {
            return redirect()->route('admin.index');
        }

        $data = (object)[
            'refUser' => $user,
            'referrals' => User::where('role', 3)->where('status', 1)->get(),
            'businessSettings' => BusinessSetting::where('id', 1)->select(['person_per_level', 'hand_name'])->first(),
        ];

        return view('admin.mlm.Frontend.member_register', compact('data'));
    }


    public function memberRegisterSave(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:admins,username',
            // 'roles' => 'required',
            'password' => 'min:6|required|confirmed',
            'profile_img' => 'image|size:512'

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
            'rank' => "Customer",
            'status' => 0,
            'role' => 3,
        ];


        if ($request->has('profile_img')) {
            $data['profile_img'] = $file;
        }

        // save user
        $user = User::create($data);

        //Create Ecommerce Customer
        Customer::create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,
            'reference_by' => @$user->referrence,
        ]);


        $userWithFUllData = User::where('id', $user->id)->with(['refMember'])->first();

        Session::flash('user', $userWithFUllData);

        FlashMessageGenerator::generate('primary', 'Congratulation, Customer Successfully Added! Please Add fund to activate your account.');

        return back();
    }
}
