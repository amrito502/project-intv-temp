<?php

namespace App\Http\Controllers\Admin;

use App\Courier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourierController extends Controller
{
    public function index()
    {
        $title = $this->title;
        $couriers = Courier::all();

        return view('admin.courier.index')->with(compact('title', 'couriers'));
    }

    public function add()
    {
        $title = "Add New Courier";
        return view('admin.courier.add')->with(compact('title'));
    }

    public function save(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required',
        ]);

        Courier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);


        return redirect(route('courier.index'))->with('msg', 'Courier Added Successfully');
    }

    public function edit($id)
    {
        $title = "Edit Courier";
        $courier = Courier::where('id', $id)->first();
        return view('admin.courier.edit')->with(compact('title', 'courier'));
    }

    public function Status(Request $request)
    {
        if ($request->ajax()) {
            $courier = Courier::findOrFail($request->charge_id);
            $currentStatus = $courier->status;

            if ($currentStatus == 1) {
                $courier->status = 0;
            } else {
                $courier->status = 1;
            }

            $courier->save();

        }
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
        ]);

        $courier = Courier::findOrFail($request->courier_id);

        $courier->update([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect(route('courier.index'))->with('msg', 'Courier Added Successfully');
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $courier = Courier::findOrFail($request->charge_id);
            $courier->delete();
        }
    }
}
