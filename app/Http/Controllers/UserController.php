<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Project;
use App\Models\UserBranches;
use Illuminate\Http\Request;
use App\Models\user_projects;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Helper\Ui\FlashMessageGenerator;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\PermissionChecker\PermissionChecker;
use App\Models\UserUnit;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        if (!Auth::user()->can('User Setup')) {

            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return User::userDatatable();
        }

        return view('dashboard.user.user_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('create user')) {
            return redirect(route('home'));
        }

        $roles = Role::all();

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $roles = Role::whereNotIn('id', [1, 2])->orWhere('company_id', Auth::user()->id)->get();
        }


        $branches  = Branch::GetRoleWiseAll()->get();
        $projects = Project::GetRoleWiseAll()->get();


        $data = (object)[
            'title' => 'Create User',
            'roles' => $roles,
            'companies' => Company::all(),
            'branches' => $branches,
            'projects' => $projects,
        ];

        return view('dashboard.user.create_user', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create user')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name',
            'username' => 'required|unique:users,email',
            'roles' => 'required',
            'password' => 'min:6|required|confirmed',
        ]);


        $companyId = $request->company;

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $companyId = Auth::user()->company_id;
        }

        $photo = "";

        if ($request->has('photo')) {
            // upload new file
            $photo = $request->file('photo')->store('public/user');
            $photo = explode('/', $photo);
            $photo = end($photo);
        }

        // save user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->username,
            'password' => Hash::make($request->password),
            'company_id' => $companyId,
            'photo' => $photo,
        ]);


        if ($request->has('branch')) {

            $branchData = [];

            // save branches
            foreach ($request->branch as $branch) {
                $branchData[] = [
                    'user_id' => $user->id,
                    'branch_id' => $branch,
                ];
            }

            UserBranches::insert($branchData);
        }

        if ($request->has('project')) {

            $projectData = [];

            // save branches
            foreach ($request->project as $project) {
                $projectData[] = [
                    'user_id' => $user->id,
                    'project_id' => $project,
                ];
            }

            user_projects::insert($projectData);
        }

        // if ($request->has('unit')) {

        //     $unitData = [];

        //     // save branches
        //     foreach ($request->unit as $unit) {
        //         $unitData[] = [
        //             'user_id' => $user->id,
        //             'unit_id' => $unit,
        //         ];
        //     }

        //     UserUnit::insert($unitData);
        // }


        // sync role
        $user->syncRoles($request->roles);

        FlashMessageGenerator::generate('primary', 'User Successfully Added');

        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        if (!Auth::user()->can('view user')) {
            return redirect(route('home'));
        }

        if (!Auth::user()->hasRole(['Software Admin'])) {
            if ($user->company_id != Auth::user()->company_id) {
                return back();
            }
        }

        $data = (object)[
            'user' => $user,
        ];

        return view('dashboard.user.profile', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {

        if (!Auth::user()->can('edit user')) {
            return redirect(route('home'));
        }

        $user = User::where('id', $user)->with(['userBranches', 'userProjects', 'usersUnit'])->first();

        if (!Auth::user()->hasRole(['Software Admin'])) {
            if ($user->company_id != Auth::user()->company_id) {
                return back();
            }
        }

        $roles = Role::all();

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $roles = Role::whereNotIn('id', [1, 2])->orWhere('company_id', Auth::user()->id)->get();
        }

        $branches  = Branch::GetRoleWiseAll()->get();
        $projects = Project::GetRoleWiseAll()->get();

        $data = (object)[
            'title' => 'Edit User',
            'user' => $user,
            'user_roles' => $user->roles()->get()->pluck(['name'])->toArray(),
            'roles' => $roles,
            'companies' => Company::all(),
            'branches' => $branches,
            'projects' => $projects,
        ];

        return view('dashboard.user.edit_user', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!Auth::user()->can('edit user')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'username' => 'required|unique:users,email,' . $id,
            'roles' => 'required',
        ]);

        // update user
        $user = User::findOrFail($id);
        $companyId = $request->company;

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $companyId = $user->company_id;
        }

        if ($request->has('photo')) {

            // delete old file
            Storage::delete($user->photo);

            // upload new file
            $photo = $request->file('photo')->store('public/user');
            $photo = explode('/', $photo);
            $photo = end($photo);
        } else {
            $photo = $request->old_photo;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->username,
            'company_id' => $companyId,
            'photo' => $photo,
        ]);


        // if (!Auth::user()->hasRole(['Software Admin'])) {

        UserBranches::where('user_id', $user->id)->delete();

        if ($request->has('branch')) {

            $branchData = [];

            // save branches
            foreach ($request->branch as $branch) {
                $branchData[] = [
                    'user_id' => $user->id,
                    'branch_id' => $branch,
                ];
            }

            UserBranches::insert($branchData);
        }

        user_projects::where('user_id', $user->id)->delete();

        if ($request->has('project')) {

            $projectData = [];

            // save branches
            foreach ($request->project as $project) {
                $projectData[] = [
                    'user_id' => $user->id,
                    'project_id' => $project,
                ];
            }

            user_projects::insert($projectData);
        }

        // UserUnit::where('user_id', $user->id)->delete();

        // if ($request->has('unit')) {

        //     $unitData = [];

        //     // save branches
        //     foreach ($request->unit as $unit) {
        //         $unitData[] = [
        //             'user_id' => $user->id,
        //             'unit_id' => $unit,
        //         ];
        //     }

        //     UserUnit::insert($unitData);
        // }

        // }

        // sync role
        $user->syncRoles($request->roles);

        FlashMessageGenerator::generate('primary', 'User Successfully Updated');

        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if (!Auth::user()->can('delete user')) {
            return redirect(route('home'));
        }

        UserBranches::where('user_id', $user->id)->delete();
        user_projects::where('user_id', $user->id)->delete();
        UserUnit::where('user_id', $user->id)->delete();


        $user->delete();
        FlashMessageGenerator::generate('primary', 'User Deleted Successfully');
        return back();
    }

    public function toggleStatus(User $user)
    {

        if (!Auth::user()->can('status user')) {
            return redirect(route('home'));
        }

        $user->toggleStatus();

        return true;
    }

    public function ChangePassView(User $user)
    {
        if (!Auth::user()->can('change_password user')) {
            return redirect(route('home'));
        }

        if (!Auth::user()->hasRole(['Software Admin'])) {
            if ($user->company_id != Auth::user()->company_id) {
                return back();
            }
        }

        return view('dashboard.user.password_change', compact('user'));
    }

    public function ChangePass(Request $request, User $user)
    {
        if (!Auth::user()->can('change_password user')) {
            return redirect(route('home'));
        }

        $validationArr = [
            'password' => 'required|confirmed',
        ];

        if (!Auth::user()->hasRole(['Software Admin'])) {
            $validationArr['old_password'] = 'required';
        }

        $request->validate($validationArr);

        // check old password

        if (!Auth::user()->hasRole(['Software Admin'])) {
            if (!Hash::check($request->old_password, Auth::user()->password)) {
                FlashMessageGenerator::generate('danger', 'Old Password Does Not Match');
                return redirect(route('home'));
            }
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        FlashMessageGenerator::generate('primary', 'Password Updated Successfully');

        return redirect(route('home'));
    }

    public function ChangeOwnPassView()
    {
        $user = Auth::user();
        return view('dashboard.user.password_change', compact('user'));
    }
}
