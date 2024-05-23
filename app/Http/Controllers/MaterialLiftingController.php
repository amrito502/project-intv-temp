<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Unit;
use App\Models\Vendor;
use App\Models\Company;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\Material;
use App\Models\GalleryDate;
use App\Models\MaterialUnit;
use App\Models\ProjectTower;
use Illuminate\Http\Request;

use App\Models\MaterialLifting;
use App\Models\GalleryDateImage;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialLiftingMaterial;

class MaterialLiftingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Lifting')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialLifting::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.materiallifting.materiallifting_index', compact('projects'));
    }


    public function system_serial($company_id = null)
    {

        $companyId = $company_id ? $company_id : Auth::user()->company_id;

        $company = Company::findOrFail($companyId);

        $liftingQty = MaterialLifting::where('company_id', $companyId)->count();

        $liftingQty++;

        return $company->prefix . '/li/' . $liftingQty;
    }

    public function create()
    {
        if (!Auth::user()->can('create materiallifting')) {
            return redirect(route('home'));
        }

        if (Auth::user()->hasRole('Software Admin')) {
            $system_serial = "";
        } else {
            $system_serial = $this->system_serial();
        }

        $data = (object)[
            'title' => 'Create Material Lifting',
            'materials' => Material::with(['materialUnit'])->GetRoleWiseAll()->get(),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
            'logistics_vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Logistics Associate')->get(),
            'projects' => Project::GetRoleWiseAll()->get(),
            'system_serial' => $system_serial,
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materiallifting.create_materiallifting', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create materiallifting')) {
            return redirect(route('home'));
        }

        $validateArr = [
            'voucher' => 'required',
            'voucher_date' => 'required',
        ];

        // if (!in_array($request->lifting_type, ['Product Lifting To Central Store', 'Client Provide To Central Store'])) {
        //     $validateArr['unit'] = 'required';
        // }

        $request->validate($validateArr);

        $company_id = $request->company ? $request->company : Auth::user()->company_id;

        $projectId = $request->project;

        if (in_array($request->lifting_type, ['Product Lifting To Central Store', 'Client Provide To Central Store'])) {
            $projectId = 999999;
            // $company_id = 0;
        }

        $data = [
            'company_id' => $company_id,
            'system_serial' => $this->system_serial($company_id),
            'lifting_type' => $request->lifting_type,
            'vendor_id' => $request->vendor,
            'project_id' => $projectId,
            'unit_id' => $request->unit,
            'tower_id' => $request->tower,
            'voucher' => $request->voucher,
            'logistics_vendor' => $request->logistics_associate,
            'truck_no' => $request->truck_no,
            'vouchar_date' => date('Y-m-d', strtotime($request->voucher_date)),
        ];

        $materiallifting = MaterialLifting::create($data);

        $countMaterial = count($request->material_id);
        if ($request->material_id) {
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {
                $material = Material::find($request->material_id[$i]);
                $postData[] = [
                    'material_lifting_id' => $materiallifting->id,
                    'material_id' => $request->material_id[$i],
                    'unit_id' => $material->unit,
                    'material_qty' => $request->qty[$i],
                    'material_rate' => $request->rate[$i],
                    'remarks' => $request->remarks[$i],
                ];
            }

            MaterialLiftingMaterial::insert($postData);
        }



        if ($request->hasfile('lifting_files')) {

            $project = Project::find($request->project);
            $newDate = $request->voucher_date;

            // get project gallery
            $gallery = Gallery::where('company_id', Auth::user()->company_id)->where('title', $project->project_name)->first();

            // get project gallery date or create new gallery
            $galleryDate = GalleryDate::where('date', $newDate)->first();

            if (!$galleryDate) {
                $galleryDate = GalleryDate::create([
                    'gallery_id' => $gallery->id,
                    'date' => $newDate,
                ]);
            }

            // upload files
            foreach ($request->lifting_files as $image) {

                // upload new file
                $image = $image->store('public/gallery_image');
                $image = explode('/', $image);
                $image = end($image);

                GalleryDateImage::create([
                    'created_by' => Auth::user()->id,
                    'gallery_date_id' => $galleryDate->id,
                    'information' => 'lifting image',
                    'image' => $image,
                ]);

            }

        }

        return redirect(route('materiallifting.index'));
    }

    public function show(MaterialLifting $materialLifting)
    {
        //
    }

    public function edit(MaterialLifting $materiallifting)
    {
        if (!Auth::user()->can('edit materiallifting')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'title' => 'Edit Material Lifting',
            'materiallifting' => $materiallifting,
            'materialliftingMaterials' => MaterialLiftingMaterial::where('material_lifting_id', $materiallifting->id)->get(),
            'materials' => Material::where('company_id', Auth::user()->company_id)->orWhere('company_id', 0)->get(),
            'projects' => Project::find($materiallifting->project_id),
            'unit' => Unit::find($materiallifting->unit_id),
            'tower' => ProjectTower::find($materiallifting->tower_id),
            'vendors' => Vendor::GetRoleWiseAll()->where('vendor_type', 'Material Supplier')->get(),
            'logistics_vendor' => Vendor::find($materiallifting->logistics_vendor),
            'units' => MaterialUnit::all(),
        ];

        return view('dashboard.materiallifting.edit_materiallifting', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialLifting  $materialLifting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialLifting $materiallifting)
    {
        if (!Auth::user()->can('edit materiallifting')) {
            return redirect(route('home'));
        }

        $request->validate([
            'voucher' => 'required',
            'voucher_date' => 'required',
        ]);

        $data = [
            'vendor_id' => $request->vendor,
            'voucher' => $request->voucher,
            'truck_no' => $request->truck_no,
            // 'lifting_type' => $request->lifting_type,
            'vouchar_date' => date('Y-m-d', strtotime($request->voucher_date)),
        ];

        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        $materialLiftingId = $materiallifting->id;

        $materiallifting->update($data);

        MaterialLiftingMaterial::where('material_lifting_id', $materialLiftingId)->delete();

        if ($request->material_id) {
            $countMaterial = count($request->material_id);
            $postData = [];
            for ($i = 0; $i < $countMaterial; $i++) {

                $material = Material::find($request->material_id[$i]);

                $postData[] = [
                    'material_lifting_id' => $materialLiftingId,
                    'material_id' => $request->material_id[$i],
                    'unit_id' => $material->unit,
                    'material_qty' => $request->qty[$i],
                    'material_rate' => $request->rate[$i],
                ];
            }

            MaterialLiftingMaterial::insert($postData);
        }

        return redirect(route('materiallifting.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialLifting  $materialLifting
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialLifting $materiallifting)
    {

        MaterialLiftingMaterial::where('material_lifting_id', $materiallifting->id)->delete();
        $materiallifting->delete();

        return true;
    }

    public function print($id)
    {
        $materialLifting = MaterialLifting::where('id', $id)->with(['liftingMaterials.material.materialUnit', 'project', 'unit', 'tower', 'vendor'])->first();

        if ($materialLifting->company_id) {
            $company = Company::find($materialLifting->company_id);
        } else {
            $company = Company::find(Auth::user()->company_id);
        }

        $data = (object)[
            'materialLifting' => $materialLifting,
            'company' => $company,
        ];

        $pdf = PDF::loadView('dashboard.materiallifting.materiallifting_print', compact('data'));
        return $pdf->stream('material_lifting_invoice.pdf');
    }
}
