<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialGroup;
use Illuminate\Support\Facades\Auth;

class MaterialGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Material Group Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return MaterialGroup::datatable();
        }

        return view('dashboard.materialgroup.materialgroup_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create material group')) {
            return redirect(route('home'));
        }

        $data = (object)[
        ];

        return view('dashboard.materialgroup.create_materialgroup', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create material group')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $validatedData['company_id'] = Auth::user()->company_id;

        MaterialGroup::create($validatedData);

        return redirect(route('materialgroup.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaterialGroup  $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function show(MaterialGroup $materialGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MaterialGroup  $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(MaterialGroup $materialgroup)
    {
        if (!Auth::user()->can('edit material group')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'materialgroup' => $materialgroup,
        ];

        return view('dashboard.materialgroup.edit_materialgroup', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaterialGroup  $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaterialGroup $materialgroup)
    {
        if (!Auth::user()->can('edit material group')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $materialgroup->update($validatedData);

        return redirect(route('materialgroup.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaterialGroup  $materialGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaterialGroup $materialgroup)
    {
        $materialgroup->delete();
        return true;
    }
}
