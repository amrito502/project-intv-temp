<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\UserMenu;
use App\Vendors;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $title = $this->title;
        $vendors = Vendors::orderBy('id','ASC')->get();
        return view('admin.vendors.index')->with(compact('title','vendors'));
    }

    public function add(){
        $title = "Vendor";
        return view('admin.vendors.add')->with(compact('title'));
    }

     public function save(Request $request){

        $this->validate(request(), [
             'vendorName' => 'required',
             //'vendorEmail' => 'unique:vendors,vendorEmail',
             'vendorPhone' => 'unique:vendors,vendorPhone',
        ]);
        $menu = Vendors::create( [
            'vendor_serial' => $request->vendor_serial,
            'vendorName' => $request->vendorName,
            'contactPerson' => $request->contactPerson,
            'vendorAddress' => $request->vendorAddress,
            'vendorPhone' => $request->vendorPhone,
            'vendorEmail' => $request->vendorEmail,
            /*'accountCode' => $request->accountCode, */
            'orderBy' => $request->orderBy,
            'vendorStatus' => $request->vendorStatus,

        ]);

       return redirect(route('vendor.index'))->with('msg','Vendor Added Successfully');
    }

    public function edit($id){
        $title = "Vendor";
        $vendors = Vendors::where('id',$id)->first();
        return view('admin.vendors.edit')->with(compact('title','vendors'));
    }

     public function update(Request $request){
        $vendorId = $request->vendorId;
        $vendor = vendors::find($vendorId);

        $vendor->update( [
            'vendor_serial' => $request->vendor_serial,
            'vendorName' => $request->vendorName,
            'contactPerson' => $request->contactPerson,
            'vendorAddress' => $request->vendorAddress,
            'vendorPhone' => $request->vendorPhone,
            'vendorEmail' => $request->vendorEmail,
            /*'accountCode' => $request->accountCode, */
            'orderBy' => $request->orderBy,
            'vendorStatus' => $request->vendorStatus,
        ]);

        return redirect(route('vendor.index'))->with('msg','Vendor Updated Successfully');
    }

    public function status(Request $request)
    {
        if($request->ajax())
        {
            $data = Vendors::find($request->vendor_id);
            $data->vendorStatus = $data->vendorStatus ^ 1;
            $data->update();
            print_r(1);
            return;
        }

    }

    public function destroy(Request $request)
    {
        Vendors::where('id',$request->vendorId)->delete();
    }
}
