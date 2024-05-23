<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Vendor Setup')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {
            return Vendor::datatable();
        }

        return view('dashboard.vendor.vendor_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create vendor')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'title' => 'Create Vendor',
        ];

        return view('dashboard.vendor.create_vendor', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create vendor')) {
            return redirect(route('home'));
        }


        $validatedData = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'vendor_type' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            // 'contact_person_email' => 'required',
            'address' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['contact_person_email'] = $request->contact_person_email;

        $vendor = Vendor::create($validatedData);


        if ($vendor->vendor_type == 'Working Associate') {

            // save user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->name,
                'password' => Hash::make('123456'),
                'company_id' => Auth::user()->company_id,
                'photo' => '',
            ]);

            // save user role
            $user->syncRoles('Vendor');


            // assign user id in vendor table
            $vendor->update([
                'user_id' => $user->id,
            ]);


        }



        return redirect(route('vendor.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        if (!Auth::user()->can('edit vendor')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'title' => 'Edit Vendor',
            'vendor' => $vendor,
        ];

        return view('dashboard.vendor.edit_vendor', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        if (!Auth::user()->can('edit vendor')) {
            return redirect(route('home'));
        }

        $validatedData = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'vendor_type' => 'required',
            'contact_person_name' => 'required',
            'contact_person_phone' => 'required',
            // 'contact_person_email' => 'required',
            'address' => 'required',
        ]);

        $validatedData['company_id'] = $request->company ? $request->company : Auth::user()->company_id;
        $validatedData['contact_person_email'] = $request->contact_person_email;

        $vendor->update($validatedData);

        return redirect(route('vendor.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return true;
    }
}
