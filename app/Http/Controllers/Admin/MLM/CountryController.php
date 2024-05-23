<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('country')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            return Country::dataTableAjax();
        }


        return view('dashboard.country.country_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create country')) {
            return redirect(route('home'));
        }

        return view('dashboard.country.create_country');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create country')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name',
        ]);

        Country::create([
            'name' => $request->name,
            'status' => 1
        ]);

        FlashMessageGenerator::generate('primary', 'Country Successfully Added');

        return redirect(route('country.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        if (!Auth::user()->can('edit country')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'country' => $country
        ];

        return view('dashboard.country.edit_country', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        if (!Auth::user()->can('edit country')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required|unique:users,name',
        ]);

        $country->update([
            'name' => $request->name,
        ]);

        FlashMessageGenerator::generate('primary', 'Country Updated Successfully');

        return redirect(route('country.index'));
    }


    public function toggleStatus(Country $country)
    {
        $country->toggleStatus();

        return True;
    }


    public function destroy(Country $country)
    {

        if (!Auth::user()->can('delete country')) {
            return redirect(route('home'));
        }

        $country->delete();

        return True;
    }
}
