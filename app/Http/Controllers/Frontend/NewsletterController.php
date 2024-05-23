<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Newsletters;

class NewsletterController extends Controller
{
	public function index()
    {
        $subscribers = Newsletters::all();
        return view('admin.newsletters.index')->with(compact('subscribers'));
    }

    public function saveSubscribe(Request $request){
    	$this->validate(request(), [
            'subscribeEmail' => 'required|unique:newsletters',
        ]);

         $contact = Newsletters::create( [     
            'subscribeEmail' => $request->subscribeEmail,             
                       
                      
        ]);

         return redirect(route('home.index'))->with('msg','You are Successfully Subscribed');

    }

    public function destroy(Newsletters $newsletters, Request $request)
    {
        if($request->ajax())
        {
            $newsletters->delete();
            print_r(1);       
            return;
        }

        $newsletters->delete();
        return redirect(route('subscribers.index')) -> with( 'message', 'Deleted Successfully');
    }
}
