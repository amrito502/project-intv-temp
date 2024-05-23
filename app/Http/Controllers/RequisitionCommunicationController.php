<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\CashRequisition;
use Illuminate\Support\Facades\Auth;
use App\Models\RequisitionCommunication;

class RequisitionCommunicationController extends Controller
{

    public function index()
    {
        if (!Auth::user()->can('Requisition Communication')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'cashRequisitions' => CashRequisition::where('company_id', Auth::user()->company_id)
                ->orderBy('id', 'desc')
                ->with(['createdby', 'budgethead', 'comments'])
                ->simplePaginate(12),
        ];

        return view('dashboard.requisition_communication.requisition_communication_index', compact('data'));
    }


    public function details($requisitionId)
    {
        $requisitioncommunications = RequisitionCommunication::where('cash_requisition_id', $requisitionId)
            ->with(['user'])
            ->get();

        $cashrequisition = CashRequisition::where('id', $requisitionId)->with(['createdby', 'comments', 'project', 'tower', 'unitConfig', 'items', 'items.budgethead', 'items.vendor'])->first();

        $budgetheads = BudgetHead::where(function ($query) {
            $query->where('company_id', Auth::user()->company_id)
                ->orWhere('company_id', 0);
        })->where('type', 'Cash')
            ->get();

        $data = (object)[
            'requisitioncommunications' => $requisitioncommunications,
            'budgetHeads' => $budgetheads,
            'cashrequisition' => $cashrequisition,
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
            'vendors' => Vendor::where('company_id', Auth::user()->company_id)->where('vendor_type', 'Working Associate')->get(),
        ];

        return view('dashboard.requisition_communication.requisition_communication_details', compact('data'));
    }


    public function commentSave(Request $request, $requisition)
    {

        $request->validate([
            'comment' => 'required',
        ]);

        RequisitionCommunication::create([
            'cash_requisition_id' => $requisition,
            'comment' => $request->comment,
            'created_by' => Auth::user()->id,
        ]);

        return back();
    }


    public function commentUpdate(Request $request, $commentId)
    {

        $comment = RequisitionCommunication::findOrFail($commentId);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return true;
    }

    public function commentDelete($commentId)
    {

        RequisitionCommunication::findOrFail($commentId)->delete();

        return back();
    }
}
