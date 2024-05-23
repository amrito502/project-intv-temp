<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;
use App\Models\NoticeRoles;
use App\UserRoles;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (object)[
            'notices' => Notice::all(),
            'title' => $this->title,
        ];

        return view('admin.mlm.dashboard.notice.notice_index', compact('data'));
    }

    public function NoticeList()
    {

        $data = (object)[
            'notices' => Notice::where('status', 1)->get(),
        ];

        return view('admin.mlm.dashboard.notice.notice_list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = (object) [
            'title' => 'Add Notice',
            'roles' => UserRoles::all(),
        ];

        return view('admin.mlm.dashboard.notice.create_notice', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $notice = Notice::create([
            'description' => $request->description,
        ]);

        if ($request->roles) {
            foreach ($request->roles as $role) {
                NoticeRoles::create([
                    'notice_id' => $notice->id,
                    'role_id' => $role,
                ]);
            }
        }

        FlashMessageGenerator::generate('primary', 'Notice Added');
        return redirect(route('notice.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        //
    }

    public function edit(Notice $notice)
    {

        $data = (object) [
            'title' => 'Edit Notice',
            'notice' => $notice,
            'notice_roles' => NoticeRoles::where('notice_id', $notice->id)->pluck('role_id')->toArray(),
            'roles' => UserRoles::all(),
        ];

        return view('admin.mlm.dashboard.notice.edit_notice', compact('data'));
    }


    public function update(Request $request, Notice $notice)
    {

        $notice->update([
            'description' => $request->description,
        ]);

        NoticeRoles::where('notice_id', $notice->id)->delete();

        if ($request->roles) {
            foreach ($request->roles as $role) {
                NoticeRoles::create([
                    'notice_id' => $notice->id,
                    'role_id' => $role,
                ]);
            }
        }

        FlashMessageGenerator::generate('primary', 'Notice Update');
        return redirect(route('notice.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        NoticeRoles::where('notice_id', $notice->id)->delete();
        $notice->delete();
        print_r(1);
        return;
    }

    public function status(Request $request)
    {
        if ($request->ajax()) {
            $data = Notice::find($request->id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);
            return;
        }
    }
}
