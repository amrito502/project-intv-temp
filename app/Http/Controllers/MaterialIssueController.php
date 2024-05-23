<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\Company;
use App\Models\Project;
use App\Models\Material;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use PDF;

class MaterialIssueController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Transfer')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialIssue::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.materialissue.materialissue_index', compact('projects'));
    }

    public function system_serial($company_id = null)
    {

        $companyId = $company_id ? $company_id : Auth::user()->company_id;

        $company = Company::findOrFail($companyId);

        $liftingQty = MaterialIssue::where('company_id', $companyId)->count();
        $liftingQty++;

        return $company->prefix . '/ts/' . $liftingQty;
    }

    public function create()
    {
        if (!Auth::user()->can('create materialissue')) {
            return redirect(route('home'));
        }

        if (Auth::user()->hasRole('Software Admin')) {
            $system_serial = "";
        } else {
            $system_serial = $this->system_serial();
        }

        $data = (object)[
            'title' => 'Create Material Transfer',
            'materials' => Material::with(['materialUnit'])->GetRoleWiseAll()->where('id', '!=', 1)->get(),
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
            'units' => MaterialUnit::all(),
            'system_serial' => $system_serial,
        ];

        return view('dashboard.materialissue.create_materialissue', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create materialissue')) {
            return redirect(route('home'));
        }

        $request->validate([
            'project' => 'required',
            'source_project' => 'required',
            'issue_date' => 'required',
        ]);

        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $data = [
            'company_id' => $company_id,
            'source_project_id' => $request->source_project,
            'source_unit_id' => $request->source_unit_id,
            'source_tower_id' => $request->source_tower,
            'project_id' => $request->project,
            'unit_id' => $request->issue_unit_id,
            'tower_id' => $request->issue_tower,
            'logistics_associate' => $request->logistics_associate,
            'issue_to' => $request->issue_to,
            'truck_no' => $request->truck_no,
            'issue_date' => date('Y-m-d', strtotime($request->issue_date)),
            'system_serial' => $this->system_serial(),
            'status' => 'Issued',
            'created_by' => Auth::user()->id,
        ];

        $materialissue = MaterialIssue::create($data);

        $countMaterial = count($request->material_id);

        if ($request->material_id) {
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {
                $postData[] = [
                    'material_issue_id' => $materialissue->id,
                    'material_id' => $request->material_id[$i],
                    // 'unit_id' => $request->unit_id[$i],
                    'material_qty' => $request->qty[$i],
                    // 'material_rate' => $request->rate[$i],
                    'material_rate' => 0,
                ];
            }

            MaterialIssueItem::insert($postData);
        }


        return redirect(route('materialissue.index'));
    }

    public function edit(MaterialIssue $materialissue)
    {

        if (!Auth::user()->can('edit materialissue')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'title' => 'Edit Material Transfer',
            'materialissue' => $materialissue,
            'materialIssueItems' => MaterialIssueItem::where('material_issue_id', $materialissue->id)->get(),
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'projects' => Project::GetRoleWiseAll()->orWhere('company_id', 0)->get(),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materialissue.edit_materialissue', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialIssue  $materialIssue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialIssue $materialissue)
    {
        if (!Auth::user()->can('edit materialissue')) {
            return redirect(route('home'));
        }


        $request->validate([
            'project' => 'required',
            'source_project' => 'required',
            'issue_date' => 'required',
            // 'unit_id.*' => 'required',
        ]);

        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $data = [
            'company_id' => $company_id,
            'source_project_id' => $request->source_project,
            'project_id' => $request->project,
            'issue_date' => date('Y-m-d', strtotime($request->issue_date)),
            'system_serial' => $this->system_serial(),
        ];


        $materialIssueId = $materialissue->id;

        $materialissue->update($data);


        MaterialIssueItem::where('material_issue_id', $materialIssueId)->delete();

        $countMaterial = count($request->material_id);
        if ($request->material_id) {
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {
                $postData[] = [
                    'material_issue_id' => $materialissue->id,
                    'material_id' => $request->material_id[$i],
                    // 'unit_id' => $request->unit_id[$i],
                    'material_qty' => $request->qty[$i],
                    // 'material_rate' => $request->rate[$i],
                    'material_rate' => 0,
                ];
            }

            MaterialIssueItem::insert($postData);
        }

        return redirect(route('materialissue.index'));
    }


    public function destroy(MaterialIssue $materialissue)
    {

        MaterialIssueItem::where('material_issue_id', $materialissue->id)->delete();

        $materialissue->delete();

        return true;
    }

    public function print($id)
    {
        $materialissue = MaterialIssue::where('id', $id)->with(['issuedMaterials.material', 'SourceProject'])->first();
        $company = Company::findOrFail($materialissue->company_id);

        $data = (object)[
            'materialIssue' => $materialissue,
            'company' => $company,
        ];


        $pdf = PDF::loadView('dashboard.materialissue.materialissue_print', compact('data'));
        return $pdf->stream('material_issue_invoice.pdf');
    }
}
