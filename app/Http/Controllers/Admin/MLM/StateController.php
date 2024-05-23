<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\FlashMessageGenerator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('state')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            return State::dataTableAjax();
        }


        return view('dashboard.state.state_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create state')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'countries' => Country::Enabled()->get(),
        ];

        return view('dashboard.state.create_state', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create state')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        State::create([
            'name' => $request->name,
            'country_id' => $request->country
        ]);

        FlashMessageGenerator::generate('primary', 'State Added Successfully');

        return redirect(route('state.index'));

    }


    public function show(State $state)
    {
        //
    }


    public function edit(State $state)
    {
        if (!Auth::user()->can('edit state')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'state' => $state,
            'countries' => Country::Enabled()->get(),
        ];

        return view('dashboard.state.edit_state', compact('data'));

    }


    public function update(Request $request, State $state)
    {
        if (!Auth::user()->can('edit state')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required',
            'country' => 'required',
        ]);

        $state->update([
            'name' => $request->name,
            'country_id' => $request->country
        ]);

        FlashMessageGenerator::generate('primary', 'State Updated Successfully');

        return redirect(route('state.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();

        return True;
    }

    public function toggleStatus(State $state)
    {

        $state->toggleStatus();

        return True;
    }
}
