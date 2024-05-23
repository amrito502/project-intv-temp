<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Branch;
use App\Models\Gallery;
use App\Models\Project;
use App\Models\ProjectUnit;
use App\Models\ProjectTower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Project Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Project::datatable();
        }

        return view('dashboard.project.project_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create project')) {
            return redirect(route('home'));
        }


        $data = (object)[
            'title' => 'Create Project',
            'branches' => Branch::GetRoleWiseAll()->get(),
            'units' => Unit::GetRoleWiseAll()->get(),
        ];

        return view('dashboard.project.create_project', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create project')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'project_code' => 'required',
            'project_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'address' => 'required',
            'branch' => 'required',
            'project_type' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['branch_id'] = $request->branch;
        unset($validatedData['branch']);

        $project = Project::create($validatedData);

        if ($request->has('units')) {

            $projectUnits = [];

            foreach ($request->units as $unit) {
                $projectUnits[] = [
                    'project_id' => $project->id,
                    'unit_id' => $unit,
                ];
            }


            ProjectUnit::insert($projectUnits);
        }


        // create project gallery
        $data['company_id'] = $validatedData['company_id'];
        $data['title'] = $validatedData['project_name'];
        $data['created_by'] = Auth::user()->id;

        Gallery::create($data);


        // if tower type project add tower data
        if ($project->project_type == 'tower') {
            if ($request->tower_name) {
                foreach ($request->tower_name as $key => $tower) {
                    ProjectTower::create([
                        'project_id' => $project->id,
                        'name' => $tower,
                        'type' => $request->tower_type[$key],
                        'soil_category' => $request->soil_category[$key],
                    ]);
                }
            }
        }


        return redirect(route('project.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (!Auth::user()->can('edit project')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'title' => 'Edit Project',
            'project' => $project,
            'project_towers' => ProjectTower::where('project_id', $project->id)->get(),
            'projectUnits' => ProjectUnit::where('project_id', $project->id)->get(),
            'branches' => Branch::GetRoleWiseAll()->get(),
            'units' => Unit::GetRoleWiseAll()->get(),
        ];

        return view('dashboard.project.edit_project', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (!Auth::user()->can('edit project')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'project_code' => 'required',
            'project_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'address' => 'required',
            'branch' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['branch_id'] = $request->branch;
        unset($validatedData['branch']);


        ProjectUnit::where('project_id', $project->id)->delete();

        if ($request->has('units')) {

            $projectUnits = [];

            foreach ($request->units as $unit) {
                $projectUnits[] = [
                    'project_id' => $project->id,
                    'unit_id' => $unit,
                ];
            }

            ProjectUnit::insert($projectUnits);
        }

        $project->update($validatedData);


        // if tower type project add tower data
        if ($project->project_type == 'tower') {

            if ($request->tower_name) {
                $keys = [];
                foreach ($request->tower_name as  $key => $tower) {
                    if (!$tower) {
                        continue;
                    }


                    $projectTower = ProjectTower::findOrCreate($key);
                    $projectTower->project_id = $project->id;
                    $projectTower->name = $tower;
                    $projectTower->type = $request->tower_type[$key];
                    $projectTower->soil_category = $request->soil_category[$key];
                    $projectTower->save();

                    array_push($keys, $projectTower->id);

                }


                ProjectTower::where('project_id', $project->id)->whereNotIn('id', $keys)->delete();
            }
        }

        return redirect(route('project.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        ProjectUnit::where('project_id', $project->id)->delete();

        $project->delete();

        Gallery::findOrFail('name', 'like', "%$project->project_name%");

        return true;
    }

    public function toggleDashboardStatus($id)
    {
        Project::find($id)->toggleDashboardStatus();
    }
}
