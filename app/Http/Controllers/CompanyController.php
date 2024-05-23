<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::user()->can('Company Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Company::datatable();
        }

        return view('dashboard.company.company_index');
    }

    public function create()
    {
        if (!Auth::user()->can('create company')) {
            return redirect(route('home'));
        }

        $data = (object)[];

        return view('dashboard.company.create_company', compact('data'));
    }

    public function store(Request $request)
    {

        if (!Auth::user()->can('create company')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'prefix' => 'required',
            'username' => 'required|unique:users,email',
            'contact_person_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'website' => 'required',
        ]);

        $logo = "";

        if ($request->has('logo')) {
            // upload new file
            $logo = $request->file('logo')->store('public/company');
            $logo = explode('/', $logo);
            $logo = end($logo);
        }


        $validatedData['logo'] = $logo;
        unset($validatedData['username']);


        $company = Company::create($validatedData);


        // save user
        $user = User::create([
            'name' => $company->name,
            'email' => $request->username,
            'password' => Hash::make('123456789'),
            'company_id' => $company->id,
        ]);

        // sync role
        $user->syncRoles(['Company Admin']);


        // save branch
        Branch::create([
            'branch_name' => 'Head Office',
            'contact_person_name' => 'Head Office',
            'contact_person_phone' => '00000',
            'address' => 'Head Office',
            'company_id' => $user->company_id,
        ]);

        return redirect(route('company.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if (!Auth::user()->can('edit company')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'company' => $company,
        ];

        return view('dashboard.company.edit_company', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if (!Auth::user()->can('edit company')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'name' => 'required',
            'prefix' => 'required',
            'contact_person_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required',
            'website' => 'required',
        ]);

        if ($request->has('photo')) {

            // delete old file
            Storage::delete($request->old_logo);

            // upload new file
            $logo = $request->file('logo')->store('public/user');
            $logo = explode('/', $logo);
            $logo = end($logo);
        } else {
            $logo = $request->old_photo;
        }

        $validatedData['logo'] = $logo;
        unset($validatedData['username']);

        $company->update($validatedData);

        return redirect(route('company.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return 1;
    }
}
