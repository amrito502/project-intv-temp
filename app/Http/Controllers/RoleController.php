<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Helper\Ui\FlashMessageGenerator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Auth::user()->can('Role Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            $roles = Role::query();

            if (!Auth::user()->hasRole(['Software Admin'])) {
                $roles = $roles->whereNotIn('id', [1, 2])->where(function ($query) {
                    $query->where('company_id', Auth::user()->company_id)->orWhereNull('company_id');
                });
            }

            return DataTables::eloquent($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = "";

                    if (Auth::user()->can('edit role')) {
                        $btn = $btn . '<a href="' . route('role.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a> &nbsp;';
                    }

                    if ($row->company_id != null) {

                        if (Auth::user()->can('delete role')) {
                            $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                        }
                    }

                    return $btn;
                })
                ->toJson();
        }

        return view('dashboard.role.role_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create role')) {
            return redirect(route('home'));
        }

        $permissions = Permission::orderBy('order_serial')
            ->where('status', 1);

        if (!Auth::user()->hasRole('Software Admin')) {
            $permissions = $permissions->where('software_admin_only', 0);
        }

        $permissions = $permissions->get();

        $data = (object) [
            'permissions' => $permissions,
        ];

        return view('dashboard.role.create_role', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);


        // save role
        $role = Role::create([
            'company_id' => Auth::user()->company_id,
            'name' => $request->name,
        ]);

        // assign role permission
        $role->syncPermissions($request->permissions);


        FlashMessageGenerator::generate('primary', 'Role Successfully Added');

        return redirect(route('role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!Auth::user()->can('edit role')) {
            return redirect(route('home'));
        }

        if ($role->company_id != null) {

            if (!Auth::user()->hasRole(['Software Admin'])) {
                if ($role->company_id != Auth::user()->company_id) {
                    return back();
                }
            }

        }


        if ($role->company_id == null) {
            if (!Auth::user()->hasRole(['Software Admin'])) {
                return back();
            }
        }


        $permissions = Permission::orderBy('order_serial')
            ->where('status', 1);

        if (!Auth::user()->hasRole('Software Admin')) {
            $permissions = $permissions->where('software_admin_only', 0);
        }

        $permissions = $permissions->get();

        $data = (object) [
            'permissions' => $permissions,
            'role' => $role,
            'role_permissions' => $role->permissions()->select(['id'])->get()->pluck(['id'])->toArray(),
        ];

        return view('dashboard.role.edit_role', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        if (!Auth::user()->can('edit role')) {
            return redirect(route('home'));
        }


        if ($role->company_id != null) {

            if (!Auth::user()->hasRole(['Software Admin'])) {
                if ($role->company_id != Auth::user()->company_id) {
                    return back();
                }
            }
        }


        // validate
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required',
        ]);


        // save role
        $role->update([
            'name' => $request->name
        ]);

        // assign role permission
        $role->syncPermissions($request->permissions);


        FlashMessageGenerator::generate('primary', 'Role Updated Successfully');

        return redirect(route('role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {

        if (!Auth::user()->can('delete role')) {
            return redirect(route('home'));
        }

        if (!Auth::user()->hasRole(['Software Admin'])) {
            if ($role->company_id != Auth::user()->company_id) {
                return back();
            }
        }

        $role->delete();

        FlashMessageGenerator::generate('primary', 'Role Deleted Successfully');

        return back();
    }
}
