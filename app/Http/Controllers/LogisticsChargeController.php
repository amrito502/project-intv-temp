<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\LogisticsCharge;
use App\Models\LogisticsChargeItem;
use Illuminate\Support\Facades\Auth;

class LogisticsChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Logistics Charge')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return LogisticsCharge::datatable();
        }

        return view('dashboard.logistics_charge.logistics_charge_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create logistics charge')) {
            return redirect(route('home'));
        }


        $logistics_project_ids = LogisticsCharge::select('project_id')->get()->pluck('project_id')->toArray();

        $data = (object)[
            'title' => 'Create Logistics Charge',
            'projects' => Project::GetRoleWiseAll()->whereNotIn('id', $logistics_project_ids)->get(),

        ];

        return view('dashboard.logistics_charge.create_logistics_charge', compact('data'));
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('create logistics charge')) {
            return redirect(route('home'));
        }

        $request->validate([
            'project' => 'required',
            'general_transportation_charge' => 'required',
        ]);

        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $logisticsCharge = LogisticsCharge::create([
            'project_id' => $request->project,
            'company_id' => $company_id,
            'general_transportation_charge' => $request->general_transportation_charge,
            'created_by' => Auth::user()->id,
        ]);


        if ($request->materials) {

            foreach ($request->materials as $material_id => $material_rate) {
                LogisticsChargeItem::create([
                    'logistics_charge_id' => $logisticsCharge->id,
                    'material_id' => $material_id,
                    'material_rate' => $material_rate,
                ]);
            }
        }


        return redirect(route('logisticCharge.index'));
    }


    public function show(LogisticsCharge $logisticsCharge)
    {
        //
    }


    public function edit($id)
    {
        if (!Auth::user()->can('edit logistics charge')) {
            return redirect(route('home'));
        }

        $logisticsCharge = LogisticsCharge::with(['items'])->where('id', $id)->first();

        $logistics_project_ids = LogisticsCharge::select('project_id')->where('project_id', '!=', $logisticsCharge->project_id)->get()->pluck('project_id')->toArray();

        $data = (object)[
            'title' => 'Edit Logistics Charge',
            'logisticCharge' => $logisticsCharge,
            'projects' => Project::GetRoleWiseAll()->whereNotIn('id', $logistics_project_ids)->get(),
            'materials' => Material::GetRoleWiseAll()->with(['materialUnit'])
                ->where('transportation_charge', 1)
                ->get(),
        ];


        return view('dashboard.logistics_charge.edit_logistics_charge', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LogisticsCharge  $logisticsCharge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (!Auth::user()->can('edit logistics charge')) {
            return redirect(route('home'));
        }


        $request->validate([
            'project' => 'required',
            'general_transportation_charge' => 'required',
        ]);


        $lc = LogisticsCharge::find($id);
        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $logisticsCharge = $lc->update([
            'project_id' => $request->project,
            'general_transportation_charge' => $request->general_transportation_charge,
            'company_id' => $company_id,
        ]);


        if ($request->materials) {

            LogisticsChargeItem::where('logistics_charge_id', $lc->id)->delete();

            foreach ($request->materials as $material_id => $material_rate) {
                LogisticsChargeItem::create([
                    'logistics_charge_id' => $lc->id,
                    'material_id' => $material_id,
                    'material_rate' => $material_rate,
                ]);
            }
        }


        return redirect(route('logisticCharge.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LogisticsCharge  $logisticsCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogisticsChargeItem::where('logistics_charge_id', $id)->delete();
        LogisticsCharge::find($id)->delete();
    }
}
