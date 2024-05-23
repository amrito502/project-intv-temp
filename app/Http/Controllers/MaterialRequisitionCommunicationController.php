<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\MaterialRequisition;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialRequisitionCommunication;

class MaterialRequisitionCommunicationController extends Controller
{

    public function details($requisitionId)
    {

        $requisitioncommunications = MaterialRequisitionCommunication::where('material_requisition_id', $requisitionId)
            ->with(['user'])
            ->get();

        $cashrequisition = MaterialRequisition::where('id', $requisitionId)->with(['createdby', 'comments', 'project', 'tower', 'unitConfig', 'items', 'items.budgethead'])->first();


        $data = (object)[
            'requisitioncommunications' => $requisitioncommunications,
            'cashrequisition' => $cashrequisition,
            'backroute' => 'approveRequisitionStepOneList',
        ];

        return view('dashboard.material_requisition_communication.requisition_communication_details', compact('data'));

    }


    public function commentSave(Request $request, $requisition)
    {

        $request->validate([
            'comment' => 'required',
        ]);

        MaterialRequisitionCommunication::create([
            'material_requisition_id' => $requisition,
            'comment' => $request->comment,
            'created_by' => Auth::user()->id,
        ]);

        return back();
    }


    public function commentUpdate(Request $request, $commentId)
    {

        $comment = MaterialRequisitionCommunication::findOrFail($commentId);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return true;
    }

    public function commentDelete($commentId)
    {

        MaterialRequisitionCommunication::findOrFail($commentId)->delete();

        return back();
    }
}
