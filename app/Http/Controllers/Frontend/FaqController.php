<?php

namespace App\Http\Controllers;

use App\Faq;
use Illuminate\Http\Request;
use URL;
use Session;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::all();
        
        return view('admin.faq.index')->with(compact('faqs'));
    }


    public function addfaq(){
       
        return view('admin.faq.addfaq');
    }

    
    public function destroy(Faq $faq, Request $request)
    {
        if($request->ajax())
        {
            $faq->delete();
            print_r(1);       
            return;
        }

        $faq->delete();
        return redirect(route('faqs.index')) -> with( 'message', 'Deleted Successfully');
    }

    

    public function changeStatus(Request $request)
    {
        if($request->ajax())
        {
            $data = Faq::find($request->faq_id);
            $data->status = $data->status ^ 1;
            $data->update();
            print_r(1);       
            return;
        }
        return redirect(route('faqs.index')) -> with( 'message', 'Wrong move!');
    }

    public function savefaq(Request $request){
        $this->validation($request);

        $faq = Faq::create( [
            'title' => $request->title,
            'description' => $request->description,
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy, 
            'status' => $request->status,
                   
        ]);

        return redirect(route('faqadd.page'))->with('msg','Faq Added Successfully');     
    }

    public function editfaq($id){
        $faq = Faq::where('id',$id)->first();
       
        return view('admin.faq.updatefaq')->with(compact('faq'));
    }

    public function updatefaq(Request $request){
        $this->validation($request);
        $faqId = $request->faqId;

        $faq = Faq::find($faqId);

        $faq->update( [
           	'title' => $request->title,
            'description' => $request->description,
            'metaTitle' => $request->metaTitle,            
            'metaKeyword' => $request->metaKeyword,            
            'metaDescription' => $request->metaDescription,            
            'orderBy' => $request->orderBy, 
            'status' => $request->status,           
        ]);

        // $faq = faq::create($request->all());

        return redirect(route('faqs.index'))->with('msg','FAQ Updated Successfully');     
    }

    //View faq

    public function edit(faq $faq, Request $request)
    {
        $faq = faq::find($request->faq_id);
        if($request->ajax())
            {
                return response()->json([
                    'faq'=>$faq
                    
                ]);
            }
        return view('admin.faqs.edit')->with(compact('faq'));
    }

    public function frontfaq($faqName){
        $faqs = faq::where('faqName',$faqName)->first();

        return view('frontend.faqContents.faqContent')->with(compact('faqs'));
    }

    public function deletefaq($id){
        Faq::where('id',$id)->delete();
        return redirect(route('faqs.index'))->with('msg','FAQ Deleted Successfully');
    }


    /**
     * Internal function for validation.
     *
     * @param  $request
     * @return \validation
     */
    public function validation(Request $request)
    {
        $this->validate(request(), [
             'title' => 'required',
            'description' => 'required',    
        ]);
    }
}