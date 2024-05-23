<?php

namespace App\Http\Controllers;

use App\Helper\Ui\FlashMessageGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Auth::user()->can('Module Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            $module = Permission::where('action_menu', 0);

            return DataTables::eloquent($module)
                ->addIndexColumn()
                ->addColumn('parent_menu_name', function ($row) {
                    $parentId = $row->parent_id;

                    $parentName = '';
                    if ($parentId) {

                        $permission = Permission::findOrFail($parentId);

                        $parentName = $permission->name;
                    }

                    return $parentName;
                })
                // ->addColumn('is_action_menu', function ($row) {
                //     return $row->action_menu == 1 ? true : false;
                // })
                ->addColumn('action', function ($row) {

                    $btn = "";

                    if (Auth::user()->can('edit module')) {
                        $btn = $btn . '<a href="' . route('module.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
 Edit</a> &nbsp;';
                    }


                    // if (Auth::user()->can('action menu')) {
                        $btn = $btn . '<a href="' . route('actionmenu.index', $row->id) . '" class="mx-1 edit btn btn-info btn-sm"><i class="fa fa-lock" aria-hidden="true"></i>Action Menu</a> &nbsp;';
                    // }

                    if (Auth::user()->can('delete module')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                    }


                    return $btn;
                })
                ->toJson();
        }

        return view('dashboard.module.module_index');
    }

    public function actionMenuIndex(Request $request, $menuId)
    {

        // if (!Auth::user()->can('action menu')) {
        //     return redirect(route('home'));
        // }

        if ($request->ajax()) {

            $module = Permission::where('action_menu', 1)->where('parent_id', $menuId);

            return DataTables::eloquent($module)
                ->addIndexColumn()
                ->addColumn('parent_menu_name', function ($row) {
                    $parentId = $row->parent_id;

                    $parentName = '';
                    if ($parentId) {

                        $permission = Permission::findOrFail($parentId);

                        $parentName = $permission->name;
                    }

                    return $parentName;
                })
                // ->addColumn('is_action_menu', function ($row) {

                //     return $row->action_menu == 1 ? true : false;
                // })
                ->addColumn('action', function ($row) {

                    $btn = "";

                    if (Auth::user()->can('edit module')) {
                        $btn = $btn . '<a href="' . route('module.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
 Edit</a> &nbsp;';
                    }

                    if (Auth::user()->can('delete module')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                    }

                    return $btn;
                })
                ->toJson();
        }

        return view('dashboard.module.action_module_index', compact('menuId'));
    }


    public function create()
    {
        if (!Auth::user()->can('create module')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'permissions' => Permission::select(['id', 'name'])->where('action_menu', 0)->orderBy('order_serial')->get(),
        ];

        return view('dashboard.module.create_module', compact('data'));
    }

    public function actionMenuCreate($menuId)
    {
        // if (!Auth::user()->can('action menu')) {
        //     return redirect(route('home'));
        // }

        $data = (object)[
            // 'permissions' => Permission::select(['id', 'name'])->where('action_menu', 0)->orderBy('order_serial')->get(),
            'menuId' => $menuId,
        ];

        return view('dashboard.module.create_action_module', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (!Auth::user()->can('create module')) {
            return redirect(route('home'));
        }

        // validate
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);


        $orderNo = $request->order_no;


        // generate order no
        if ($orderNo == null) {

            if ($request->parent_id == null) {
                $permissionCount = Permission::whereNull('parent_id')->orderBy('order_serial', 'desc')->count();
            } else {
                $permissionCount = Permission::where('parent_id', $request->parent_id)->orderBy('order_serial', 'desc')->count();
            }

            $orderNo = $permissionCount + 1;
        }


        // parent name checkered a

        $name = $request->name;


        $action = $request->action_menu ? 1 : 0;
        $software_admin_only = $request->software_admin_only ? 1 : 0;


        // save
        Permission::create([
            'name' => $name,
            'parent_id' => $request->parent_id,
            'order_serial' => $orderNo,
            'action_menu' => $action,
            'url' => $request->url,
            'icon' => $request->icon,
            'icon_color' => $request->icon_color,
            'software_admin_only' => $software_admin_only,
        ]);

        FlashMessageGenerator::generate('primary', 'Module Successfully Added');

        // return redirect(route('module.index'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->can('edit module')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'permission' => Permission::findOrFail($id),
            'permissions' => Permission::select(['id', 'name'])->where('action_menu', 0)->orderBy('order_serial')->get(),
        ];

        return view('dashboard.module.edit_module', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!Auth::user()->can('edit module')) {
            return redirect(route('home'));
        }

        // validate
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $orderNo = $request->order_no;

        // parent name checkered a

        $name = $request->name;

        $action = $request->action_menu ? 1 : 0;
        $software_admin_only = $request->software_admin_only ? 1 : 0;

        // save

        // Permission::where('id', $id)->first()->update([
        Permission::findOrFail($id)->update([
            'name' => $name,
            'parent_id' => $request->parent_id,
            'order_serial' => $orderNo,
            'action_menu' => $action,
            'url' => $request->url,
            'icon' => $request->icon,
            'icon_color' => $request->icon_color,
            'software_admin_only' => $software_admin_only,
        ]);


        FlashMessageGenerator::generate('primary', 'Module Successfully Added');

        return redirect(route('module.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('delete module')) {
            return redirect(route('home'));
        }

        Permission::findOrFail($id)->delete();
        // FlashMessageGenerator::generate('primary', 'Module Successfully Deleted');
        return back();
    }
}
