<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Customer;

use App\ClientEntry;
use App\CustomerGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ClientEntryController extends Controller
{
    public function index()
    {
        $title = "Customer";
        $customers = Customer::select('customers.*', 'customer_groups.groupName')
            ->leftjoin('customer_groups', 'customer_groups.id', '=', 'customers.clientGroup')
            ->orderBy('customer_groups.groupName', 'asc')
            ->orderBy('customers.name', 'asc')
            ->get();

        return view('admin.clientEntry.index')->with(compact('title', 'customers'));
    }

    public function add()
    {
        $title = 'Customer';
        $customerGroup = CustomerGroup::orderBy('groupName', 'asc')->get();

        return view('admin.clientEntry.add')->with(compact('title', 'customerGroup'));
    }

    public function save(Request $request)
    {
        $dob = date('Y-m-d', strtotime($request->dob));

        $this->validate(request(), [
            'customer_name' => 'required',
            'phone_number' => 'required',
            'client_group' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $customer = Customer::create([
            'name' => $request->customer_name,
            'gender' => $request->gender,
            'dob' => $dob,
            'clientGroup' => $request->client_group,
            'mobile' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect(route('clientEntry.index'))->with('msg', 'Customer Successfuly Saved');
    }

    public function edit($id)
    {
        $title = "Customer";
        $customerGroup = CustomerGroup::orderBy('groupName', 'asc')->get();
        $customer = Customer::where('id', $id)->first();

        return view('admin.clientEntry.edit')->with(compact('title', 'customerGroup', 'customer'));
    }

    public function update(Request $request)
    {
        $dob = date('Y-m-d', strtotime($request->dob));

        $this->validate(request(), [
            'customer_name' => 'required',
            'phone_number' => 'required',
            'client_group' => 'required',
        ]);

        // $data = $request->all();
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // exit();

        $customerId = $request->customerId;
        $customer = Customer::find($customerId);

        $customer->update([
            'name' => $request->customer_name,
            'gender' => $request->gender,
            'dob' => $dob,
            'clientGroup' => $request->client_group,
            'mobile' => $request->phone_number,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect(route('clientEntry.index'))->with('msg', 'Client Successfuly Updated');
    }

    public function destroy(Request $request)
    {

        Customer::where('id', $request->clientEntryId)->delete();
    }

    public function editPassword($id)
    {
        $title = "Edit Password";
        $client = ClientEntry::where('id', $id)->first();
        return view('admin.clientEntry.changePassword')->with(compact('title', 'client'));
    }

    public function updatePassword(Request $request)
    {

        $this->validate(request(), [
            'password' => 'required',
        ]);

        $clientId = $request->clientId;
        $password =  bcrypt($request->password);
        $client = ClientEntry::find($clientId);

        $client->update([
            'password' => $password,
        ]);


        if ($client) {
            $user = User::find($client->user_id);

            $user->update([
                'password' => $password,
            ]);
        }

        return redirect(route('clientEntry.index'))->with('msg', 'Password Updated Successfully');
    }


    public function toggleActivation($id)
    {
        $customer = Customer::findOrFail($id);

        $is_active = 1;
        if ($customer->is_active == 1) {
            $is_active = 0;
        }

        $customer->update([
            'is_active' => $is_active,
        ]);

        return back();
    }
}
