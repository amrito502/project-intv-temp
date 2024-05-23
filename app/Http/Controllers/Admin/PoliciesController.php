<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Policy;
use Illuminate\Http\Request;

class PoliciesController extends Controller
{
    
    public function index()
    {
        $title = "Manage Policies";
        $policies = Policy::all();
        return view('admin.policies.index')->with(compact('title','policies'));
    }

   

    
    public function destroy(Policy $policy, Request $request)
    {
        if($request->ajax())
        {
            $policy->delete();
            print_r(1);       
            return;
        }

        $policy->delete();
        return redirect(route('policies.index')) -> with( 'message', 'Deleted Successfully');
    }

   
    public function changepolicyStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = Policy::find($request->policy_id);
            $data->policiesStatus = $data->policiesStatus ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('policies.index')) -> with( 'message', 'Wrong move!');
    }

  

    
     public function addpolicies()
     {
        $title = "Add New Policies";
        return view('admin.policies.addpolicies')->with(compact('title','policies'));
    }

     public function savepolicy(Request $request){
        $this->validation($request);

        $policies = Policy::create( [     
            'title' => $request->title,           
            'description' => $request->description,           
            'icon' => $request->icon,           
            'policiesStatus' => $request->policiesStatus, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,           
        ]);

        // $product = Product::create($request->all());

        return redirect(route('policyadd.page'))->with('msg','Policy Added Successfully');     
    }

  
    public function editPolicy($id)
    {
        $title = "Edit New Policies";
        $policies = Policy::where('id',$id)->first();
        return view('admin.policies.updatepolicy')->with(compact('title','policies'));
    }


    public function updatePolicy(Request $request){
        $this->validation($request);
        $policyId = $request->policyId;

        $policies = Policy::find($policyId);


        $policies->update( [
            'title' => $request->title,           
            'description' => $request->description,           
            'icon' => $request->icon,           
            'policiesStatus' => $request->policiesStatus, 
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy,         
        ]);

        // $product = Product::create($request->all());

        return redirect(route('policies.index'))->with('msg','Policy Updated Successfully');     
    }

   

    public function deletePolicy($id){
        Policy::where('id',$id)->delete();
        return redirect(route('policies.index'))->with('msg','Policy Deleted Successfully');
    }

    public function validation(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required'
           
            
        ]);
    }
}
