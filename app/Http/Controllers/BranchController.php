<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Business Wing')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Branch::datatable();
        }

        return view('dashboard.branch.branch_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create branch')) {
            return redirect(route('home'));
        }

        $data = (object)[];

        return view('dashboard.branch.create_branch', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create branch')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'branch_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'address' => 'required',
        ]);

        $validatedData['company_id'] = Auth::user()->company_id;

        Branch::create($validatedData);

        return redirect(route('branch.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        if (!Auth::user()->can('edit branch')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'branch' => $branch,
        ];

        return view('dashboard.branch.edit_branch', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        if (!Auth::user()->can('edit branch')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'branch_name' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            'address' => 'required',
        ]);

        $branch->update($validatedData);

        return redirect(route('branch.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {

        $branch->delete();
        return true;

    }
}
