<?php

namespace App\Http\Controllers\Admin\MLM;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helper\MyTree\GenerateTreeData;

class MyTreeController extends Controller
{

    public function index(Request $request)
    {
        $title = 'My Tree';
        $user = Auth::user();

        // if user is admin or superadmin show all
        $isUserAdminLevel = in_array(Auth::user()->role, [1, 2, 6, 7]) ? true : false;

        if($isUserAdminLevel){
            $userBuffer = User::findOrFail(1);

            if ($userBuffer) {
                $user = $userBuffer;
            }
        }

        if ($request->has('uname')) {

            $uname = $request->uname;

            $userBuffer = User::where('username', $uname)->where('role', 3)->first();

            if ($userBuffer) {
                $user = $userBuffer;
            }
        }

        $hands = $user->hands();

        $user = User::findOrFail($user->id);

        $data = (object)[
            'user' => $user,
            'hands' => $hands,
            'downLevelMembers' => $user->DownLevelMembers(),
        ];

        return view('admin.mlm.dashboard.my_tree', compact('data', 'title'));
    }

    public function TeamList(Request $request)
    {
        $user = Auth::user();

        $isUserAdminLevel = in_array(Auth::user()->role, [1, 2, 6, 7]) ? true : false;

        if($isUserAdminLevel){
            $user = User::findOrFail(1);
        }

        // $hands = $user->hands();

        $data = (object)[
            'user' => $user,
            // 'hands' => $hands,
            'counter' => 1,
            'downLevelMembers' => $user->DownLevelMembers(),
            'title' => $this->title,
        ];

        return view('admin.mlm.dashboard.team_list', compact('data'));
    }

    public function TeamListDetails(Request $request)
    {

        $user = Auth::user();

        $isUserAdminLevel = in_array(Auth::user()->role, [1, 2, 6, 7]) ? true : false;

        if($isUserAdminLevel){
            $user = User::findOrFail(2);
        }

        $downlevelUsers = User::whereIn('id', $user->DownLevelMemberIds())->orWhere('id', Auth::user()->id)->get();

        $hands = $user->hands();

        $data = (object)[
            'user' => $user,
            'downlevelUsers' => $downlevelUsers,
        ];

        return view('admin.mlm.dashboard.team_list_details', compact('data'));
    }
}
