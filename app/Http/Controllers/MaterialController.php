<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\BudgetHead;
use App\Models\MaterialUnit;
use Illuminate\Http\Request;
use App\Models\MaterialGroup;
use App\Models\MaterialIssueItem;
use App\Models\MaterialLiftingMaterial;
use App\Models\MaterialsGroup;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Material::datatable();
        }

        return view('dashboard.material.material_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create material')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'title' => 'Create Material',
            'units' => MaterialUnit::all(),
            'materialgroups' => MaterialGroup::where('company_id', Auth::user()->company_id)->get(),
        ];

        return view('dashboard.material.create_material', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create material')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'unit' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['transportation_charge'] =  $request->transportation_charge ? 1 : 0;
        $validatedData['show_dashboard'] =  $request->show_dashboard ? 1 : 0;

        $material = Material::create($validatedData);

        if ($request->has('materialgroup')) {

            $materialGroups = [];

            foreach ($request->materialgroup as $materialgroup) {
                $materialGroups[] = [
                    'material_id' => $material->id,
                    'materialgroup_id' => $materialgroup,
                ];
            }

            MaterialsGroup::insert($materialGroups);
        }

        // insert in budgethead
        if ($request->budgetHead == 'on') {

            $budgethead = BudgetHead::create([
                'type' => 'Material',
                'name' => $validatedData['name'],
                'company_id' => $validatedData['company_id'],
            ]);

            if ($request->ajax()) {
                return [
                    'material' => $material,
                    'budgetHeadMaterialUnit' => $material->materialUnit,
                    'budgetHead' => $material->budgetheadInfo(),
                ];
            }
        }

        if ($request->ajax()) {
            return [
                'material' => $material,
                'budgetHeadMaterialUnit' => $material->materialUnit,
                'budgetHead' => $material->budgetheadInfo(),
            ];
        }

        return redirect(route('material.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        if (!Auth::user()->can('edit material')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'title' => 'Edit Material',
            'material' => $material,
            'units' => MaterialUnit::all(),
            'materialgroups' => MaterialGroup::where('company_id', Auth::user()->company_id)->get(),
            'materialsgroups' => MaterialsGroup::where('material_id', $material->id)->get(),
        ];

        return view('dashboard.material.edit_material', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        if (!Auth::user()->can('edit material')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
            'unit' => 'required',
        ]);

        // update budgethead
        $budgethead = $material->budgetheadInfo();
        if ($budgethead) {
            $budgethead->update([
                'name' => $validatedData['name'],
            ]);
        }

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['transportation_charge'] =  $request->transportation_charge ? 1 : 0;
        $validatedData['show_dashboard'] =  $request->show_dashboard ? 1 : 0;

        // update material
        $material->update($validatedData);

        MaterialsGroup::where('material_id', $material->id)->delete();

        if ($request->has('materialgroup')) {

            $materialGroups = [];

            foreach ($request->materialgroup as $materialgroup) {
                $materialGroups[] = [
                    'material_id' => $material->id,
                    'materialgroup_id' => $materialgroup,
                ];
            }

            MaterialsGroup::insert($materialGroups);
        }

        if ($request->budgetHead == 'on') {

            // check if budgethead already exists
            $budgethead = BudgetHead::where('name', $validatedData['name'])->first();

            if (!$budgethead) {
                $budgethead = BudgetHead::create([
                    'type' => 'Material',
                    'name' => $validatedData['name'],
                    'company_id' => $validatedData['company_id'],
                ]);
            }

        }

        return redirect(route('material.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {

        $liftingQty = MaterialLiftingMaterial::where('material_id', $material->id)->count();
        $issueQty = MaterialIssueItem::where('material_id', $material->id)->count();

        if($liftingQty || $issueQty){
            return false;
        }

        MaterialsGroup::where('material_id', $material->id)->delete();

        if($material->budgetheadInfo()){
            $material->budgetheadInfo()->delete();
        }

        $material->delete();



        return true;
    }
}
