<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\CustomerGroup;
use App\Http\Controllers\Controller;

class CustomerGroupController extends Controller
{
    
    public function index()
    {
        $title = "Customer Group";
        $customer_groups = CustomerGroup::orderBy('groupName','asc')->get();

        return view('admin.customerGroup.index')->with(compact('title','customer_groups'));
    }

    public function status(Request $request)
    {
        if($request->ajax())
        {
            $data = CustomerGroup::find($request->group_id);
            $data->groupStatus = $data->groupStatus ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('shippingCharges.index')) -> with( 'message', 'Wrong move!');
    }

    
     public function addCustomerGroup(){
        $title = "Customer Group";
        return view('admin.customerGroup.add')->with(compact('title'));
    }

     public function saveCustomerGroup(Request $request){

        $this->validate(request(), [      
            'groupName' => 'required|unique:customer_groups',        
            'groupCode' => 'required|unique:customer_groups',        
        ]);

        $customer_froup = CustomerGroup::create( [     
            'groupName' => $request->groupName,            
            'groupCode' => $request->groupCode,            
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
            'groupStatus' => $request->groupStatus,           
        ]);


        return redirect(url('/admin/customer-group-add'))->with('msg','Group Create Successfully');     
    }

  
    public function edit($id){
        $title = "Customer Group";
        $customer_group = CustomerGroup::where('id',$id)->first();
        return view('admin.customerGroup.edit')->with(compact('title','customer_group'));
    }


    public function updateCustomerGroup(Request $request){
       $this->validate(request(), [      
            'groupName' => 'required',        
            'groupCode' => 'required',        
        ]);
        $customerGroupId = $request->customerGroupId;

        $customer_group = CustomerGroup::find($customerGroupId);
    
        $customer_group->update( [
            'groupName' => $request->groupName,            
            'groupCode' => $request->groupCode,            
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
            'groupStatus' => $request->groupStatus, 
        ]);

        return redirect(url('/admin/edit-customer-group/'.$customerGroupId))->with('msg','Customer Group Updated Successfully');     
    }

    //Delete Category from update page

    public function deleteCharge($id){

        ShippingCharges::where('id',$id)->delete();

        return redirect(route('shippingCharges.index')) -> with( 'msg', 'Deleted Successfully');
    }


    public function destroy(Request $request)
    {   
        CustomerGroup::where('id',$request->group_id)->delete();

    }

}
