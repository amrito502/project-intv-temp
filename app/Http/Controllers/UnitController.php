<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Unit Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Unit::datatable();
        }

        return view('dashboard.unit.unit_index');
    }


    public function create()
    {
        if (!Auth::user()->can('create unit')) {
            return redirect(route('home'));
        }

        $data = (object)[];

        return view('dashboard.unit.create_unit', compact('data'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create unit')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;

        Unit::create($validatedData);

        return redirect(route('unit.index'));
    }

    public function edit(Unit $unit)
    {
        if (!Auth::user()->can('edit unit')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'unit' => $unit,
        ];

        return view('dashboard.unit.edit_unit', compact('data'));
    }


    public function update(Request $request, Unit $unit)
    {
        if (!Auth::user()->can('edit unit')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'code' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $unit->update($validatedData);

        return redirect(route('unit.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return true;
    }
}
