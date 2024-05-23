<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Material;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueItem;
use Illuminate\Support\Facades\Auth;

class MaterialReceiveController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Receive')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialIssue::receiveDatatable();
        }

        return view('dashboard.materialreceive.materialreceive_index');
    }


    public function receiveMaterialDetails(MaterialIssue $issue)
    {

        if (!Auth::user()->can('Material Receive')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'materialissue' => $issue,
            'materialIssueItems' => MaterialIssueItem::where('material_issue_id', $issue->id)->with(['material', 'material.materialUnit'])->get(),
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materialissue.materialissue_receive_details', compact('data'));
    }


    public function receiveMaterial(MaterialIssue $issue, Request $request)
    {

        // $issue->update([
        //     'received_by_name' => $request->receive_by,
        // ]);

        foreach ($request->item_id as $item_id) {
            MaterialIssueItem::find($item_id)->update([
                'receive_qty' => $request->receive_qty[$item_id],
            ]);
        }

        $issue->update([
            'received_by' => Auth::user()->id,
            'status' => "Received",
        ]);

        return redirect(route('materialreceive.index'));
    }

}
