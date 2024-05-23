<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Project;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\UnitConfiguration;
use App\Models\UnitConfigMaterials;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UnitConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Unit Estimation')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return UnitConfiguration::datatable();
        }

        $projects = Project::GetRoleWiseAll()->get();

        return view('dashboard.unitconfiguration.unitconfiguration_index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('create unitconfiguration')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();

        $data = (object)[
            'title' => 'Create Unit Estimation',
            'projects' => $projects,
        ];

        return view('dashboard.unitconfiguration.create_unitconfiguration', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create unitconfiguration')) {
            return redirect(route('home'));
        }

        $unitNameCheck = UnitConfiguration::where('unit_name', $request->unit_name)->count();

        if($unitNameCheck){
            return back();
        }

        // validation block start
        $validationArr = [
            'project_id' => 'required',
            'unit_id' => 'required',
            'unit_name' => 'required',
            'cement' => 'required',
            'sand' => 'required',
            'stone' => 'required',
            'cement_qty' => 'required',
            'sand_qty' => 'required',
            'stone_qty' => 'required',
        ];

        if($request->unit_id == 8){
            $validationArr['dia'] = 'required';
            $validationArr['pile_length'] = 'required';
        }

        if($request->unit_id == 9){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 10){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 11){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 12){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 13){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 14){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 15){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }

        if($request->unit_id == 16){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 17){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 18){
            $validationArr['length'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 19){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = 'required';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 20){
            $validationArr['length'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }



        $request->validate($validationArr);



        // validation block end
        $data = [
            'project_id' => $request->project_id,
            'unit_id' => $request->unit_id,
            'unit_name' => $request->unit_name,
            'pile_length' => $request->pile_length,
            'dia' => $request->dia,
            'length' => $request->length,
            'height' => $request->height,
            'width' => $request->width,
            'cement' => $request->cement,
            'sand' => $request->sand,
            'stone' => $request->stone,
            'cement_qty' => $request->cement_qty,
            'sand_qty' => $request->sand_qty,
            'stone_qty' => $request->stone_qty,
            'brick_qty' => $request->brick_qty,
            'tiles_sft' => $request->tiles_qty,
            'soil_qty' => $request->soil_qty,
        ];

        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        $unitconfig = UnitConfiguration::create($data);

        return redirect(route('unitconfiguration.index'));
    }

    public function edit(UnitConfiguration $unitconfiguration)
    {

        if (!Auth::user()->can('edit unitconfiguration')) {
            return redirect(route('home'));
        }

        $projects = Project::GetRoleWiseAll()->get();
        $units = Unit::where('company_id',  Auth::user()->company_id)->orWhere('company_id',  0)->get();

        $data = (object)[
            'title' => 'Edit Unit Estimation',
            'unitconfiguration' => $unitconfiguration,
            'unitconfigmaterials' => UnitConfigMaterials::where('unitconfig_id', $unitconfiguration->id)->get(),
            'projects' => $projects,
            'units' => $units,
            // 'materials' => $materials,
        ];

        return view('dashboard.unitconfiguration.edit_unitconfiguration', compact('data'));
    }

    public function update(Request $request, UnitConfiguration $unitconfiguration)
    {
        if (!Auth::user()->can('edit unitconfiguration')) {
            return redirect(route('home'));
        }

         // validation block start
         $validationArr = [
            // 'cement' => 'required',
            // 'sand' => 'required',
            // 'stone' => 'required',
            // 'cement_qty' => 'required',
            // 'sand_qty' => 'required',
            // 'stone_qty' => 'required',
        ];

        if($request->unit_id == 8){
            $validationArr['dia'] = 'required';
            $validationArr['pile_length'] = 'required';
        }

        if($request->unit_id == 9){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 10){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }


        if($request->unit_id == 11){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 12){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 13){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 14){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 15){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
        }


        if($request->unit_id == 16){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';
            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }


        if($request->unit_id == 17){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        if($request->unit_id == 18){
            $validationArr['length'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }


        if($request->unit_id == 19){
            $validationArr['length'] = 'required';
            $validationArr['height'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = 'required';
            $validationArr['stone_qty'] = '';
        }



        if($request->unit_id == 20){
            $validationArr['length'] = 'required';
            $validationArr['width'] = 'required';

            $validationArr['cement'] = '';
            $validationArr['sand'] = '';
            $validationArr['stone'] = '';
            $validationArr['cement_qty'] = '';
            $validationArr['sand_qty'] = '';
            $validationArr['stone_qty'] = '';
        }

        $request->validate($validationArr);


        // validation block end
        $data = [
            'pile_length' => $request->pile_length,
            'dia' => $request->dia,
            'length' => $request->length,
            'height' => $request->height,
            'width' => $request->width,
            'cement' => $request->cement,
            'sand' => $request->sand,
            'stone' => $request->stone,
            'cement_qty' => $request->cement_qty,
            'sand_qty' => $request->sand_qty,
            'stone_qty' => $request->stone_qty,
            'brick_qty' => $request->brick_qty,
            'tiles_sft' => $request->tiles_qty,
            'soil_qty' => $request->soil_qty,
        ];

        $data['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        $unitconfig = $unitconfiguration->update($data);


        UnitConfigMaterials::where('unitconfig_id', $unitconfiguration->id)->delete();


        return redirect(route('unitconfiguration.index'));
    }

    public function destroy(UnitConfiguration $unitconfiguration)
    {


        // UnitConfigMaterials::where('unitconfig_id', $unitconfiguration->id)->delete();

        $unitconfiguration->delete();

        return true;
    }


    public function createFormToggle(Request $request, $id)
    {
        $unitConfig = (object)[];
        if($request->has('unitConfig')){
            $unitConfig = json_decode($request->unitConfig);
        }

        if($id == 8){
            return view('dashboard.unitconfiguration.partials.forms.create.pile_ratio_form', compact('unitConfig'))->render();
        }

        if($id == 9){
            return view('dashboard.unitconfiguration.partials.forms.create.cap_ratio_form', compact('unitConfig'))->render();
        }

        if($id == 10){
            return view('dashboard.unitconfiguration.partials.forms.create.soil_excavation_form', compact('unitConfig'))->render();
        }

        if($id == 11){
            return view('dashboard.unitconfiguration.partials.forms.create.footing_work_form', compact('unitConfig'))->render();
        }

        if($id == 12){
            return view('dashboard.unitconfiguration.partials.forms.create.column_form', compact('unitConfig'))->render();
        }

        if($id == 13){
            return view('dashboard.unitconfiguration.partials.forms.create.beam_form', compact('unitConfig'))->render();
        }

        if($id == 14){
            return view('dashboard.unitconfiguration.partials.forms.create.slab_form', compact('unitConfig'))->render();
        }

        if($id == 15){
            return view('dashboard.unitconfiguration.partials.forms.create.guide_wall_form', compact('unitConfig'))->render();
        }

        if($id == 16){
            return view('dashboard.unitconfiguration.partials.forms.create.wall_form', compact('unitConfig'))->render();
        }

        if($id == 17){
            return view('dashboard.unitconfiguration.partials.forms.create.pluster_form', compact('unitConfig'))->render();
        }

        if($id == 18){
            return view('dashboard.unitconfiguration.partials.forms.create.brick_soiling_form', compact('unitConfig'))->render();
        }

        if($id == 19){
            return view('dashboard.unitconfiguration.partials.forms.create.sand_filling_form', compact('unitConfig'))->render();
        }

        if($id == 20){
            return view('dashboard.unitconfiguration.partials.forms.create.tiles_form', compact('unitConfig'))->render();
        }

    }
}
