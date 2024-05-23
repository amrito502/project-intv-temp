<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

   
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index')->with(compact('contacts'));
    }

    public function contacts(Request $request){
    	$this->validate(request(), [
            'contactName' => 'required',
            'contactPhone' => 'required',
            'contactEmail' => 'required|email',
            'contactTitle' => 'required',
            'contactMessage' => 'required',
        ]);

         $contact = Contact::create( [     
            'contactName' => $request->contactName,             
            'contactPhone' => $request->contactPhone, 
            'contactEmail' => $request->contactEmail, 
            'contactTitle' => $request->contactTitle,            
            'contactMessage' => $request->contactMessage,            
                      
        ]);

         return redirect(route('contactpage'))->with('msg','Your Message Successfully Sent');

    }

    public function contactDetails($id){
        $contacts = Contact::where('id',$id)->first();
        return view('admin.contacts.contactDetails')->with(compact('contacts'));
    }

    public function destroy(Contact $contact, Request $request)
    {
        if($request->ajax())
        {
            $contact->delete();
            print_r(1);       
            return;
        }

        $customer->delete();
        return redirect(route('categories.index')) -> with( 'message', 'Deleted Successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $message = \App\helperClass::_writeFile($request->message);
        
        ContactUs::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'message'=>$message,
        ]);

        if($request->ajax())
            {
                echo true;
                return ;
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUs $contactUs, Request $request)
    {
        $contactUs = ContactUs::find($request->contact_us_id);
        if($contactUs->status != 'starred') $contactUs->update(['status'=>'seen']);
        $contactUs = ContactUs::find($request->contact_us_id);
        if($request->ajax())
            {
                return response()->json([
                    'contactUs'=>$contactUs
                ]);
            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        $this->validation($request);

        $contactUs->update($request->all());

        if($request->ajax())
            {
                return response()->json([
                    'contactUs'=>$contactUs
                ]);
            }        
        return redirect(route('categories.index')) -> with( 'message', 'Updated Successfully');//
    }

  

    public function delete($id, Request $request)
    {
        if($request->ajax())
        {
            ContactUs::find($id)->delete();
            print_r(1);       
            return;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContactUs  $contactUs
     * @return \Illuminate\Http\Response
     */
    public function starred($id, Request $request)
    {
        if($request->ajax())
        {
            $contactUs = ContactUs::find($id);
            $contactUs->update(['status'=>'starred']);
            return response()->json([
                    'contactUs'=>$contactUs
                ]);    
        }
    }
    public function seen($id, Request $request)
    {
        if($request->ajax())
        {
            $contactUs = ContactUs::find($id);
            $contactUs->update(['status'=>'seen']);
            return response()->json([
                    'contactUs'=>$contactUs
                ]);    
        }
    }
    public function unseen($id, Request $request)
    {
        if($request->ajax())
        {
            $contactUs = ContactUs::find($id);
            $contactUs->update(['status'=>'unseen']);
            return response()->json([
                    'contactUs'=>$contactUs
                ]);    
        }
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
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:100',
            'message' => 'required|string|max:500',
            'email' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:150',
        ]);
    }
}