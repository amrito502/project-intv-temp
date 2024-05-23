<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Order;
use App\VerifyCustomer;
use DB;
use Session;

class CustomerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index')->with(compact('customers'));
    }

    public function customerDetails($id){
          $customers = Customer::where('id',$id)->first();
        return view('admin.customers.customerDetails')->with(compact('customers'));
    }

    public function updateClientGroup(Request $request){
            $customerId = $request->customerId;
            $customers = Customer::find($customerId);
            $clientGroup = implode(',', $request->clientGroup);
            $customers->update( [
                'clientGroup' => $clientGroup,          
            ]);
        return redirect(route('customers.index'))->with('msg','Customer Add to Group Successfully');
    
}

   public function destroy(Customer $customer, Request $request)
    {
        if($request->ajax())
        {
            $customer->delete();
            print_r(1);       
            return;
        }

        $customer->delete();
        return redirect(route('categories.index')) -> with( 'message', 'Deleted Successfully');
    }

    public function showLoginForm(){
        return view('frontend.customer.login');
    }

    public function login(Request $request){
        if ($request) {
             $email = $request->input('custemail');
          $password = $request->input('password');
          $hasPassword = md5($request->input('password'));

          @$getEmail= DB::table('customers')->where(['email'=>$email])->first();

          @$countEmail= DB::table('customers')->where(['email'=>$email])->count();

          @$countPassword = DB::table('customers')->where(['password'=>$hasPassword])->count();

          @$customerId = $getEmail->id;
          @$customername = $getEmail->name;

          if ($email == "" || $password == "") {
          $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Field must not be empty</h5>"; 
          Session::put('message',$message); 
          return redirect('/customer/login')->withInput();
          }elseif ($countEmail < 1) {
            $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Your Email Address Not Matched</h5>"; 
            Session::put('message',$message); 
            return redirect('/customer/login')->withInput();
          }elseif($countPassword < 1){
            $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Sorry, Password Not Matched</h5>"; 
              Session::put('message',$message); 
              return redirect('/customer/login')->withInput();
          }else{
            if ($countEmail > 0) {
              Session::put('customerId',$customerId);
              Session::put('customerName',$customername);

              return redirect(route('customer.order'));

            }
          }
        }
         
        }

    public function customerRegister(Request $request){
     $customers = new VerifyCustomer();
     $name = $request->input('name');
     $email = $request->input('email');
     $mobile = $request->input('mobile');
     $address = $request->input('address');
     $password = $request->input('password');
     $confirmPassword = $request->input('confirmPassword');

     @$getcustomerEmail = Customer::where('email',$email)->count();
     @$getcustomerPhone = Customer::where('mobile',$mobile)->count();

     $verifyCode = rand(100000,999999);

     $subject = "Email Confirmation";
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <naksighar@web.com>' . "\r\n";
            $headers .= 'Cc: superbnexus@gmail.com' . "\r\n";
            
           $message = $name." Confirm your email..Click given link <a href='https:".url('/confirm-link/').$verifyCode."'>Confirm</a>";
           

      if ($getcustomerEmail > 0) {
        $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>This email address already registered</h5>"; 
         
        return redirect(route('customer.login'))->with('msg',$message)->withInput();
      }elseif ($getcustomerPhone > 0) {
        $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>This phone number already registered</h5>"; 
         
        return redirect(route('customer.login'))->with('msg',$message)->withInput();
      }elseif ($password != $confirmPassword) {
        $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Password and Confirm Password Not Matched</h5>"; 
        return redirect(route('customer.login'))->with('msg',$message)->withInput();
      }else{

        $customers->name = $name;
        $customers->email = $email;
        $customers->mobile = $mobile;
        $customers->address = $address;
        $customers->password = md5($request->password);
        $customers->confirmPassword = md5($request->confirmPassword);
        $customers->verifyCode = $verifyCode;
        $customers->save();

        mail($email, $subject, $message ,$headers);
        $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-success'>Please check your email for confirmation</h5>"; 
        return redirect(route('customer.login'))->with('msg',$message)->withInput();
      }   
    }

    public function verficationBox(){
        return view('frontend.customer.registerverify');
    }

    public function registerSave($verifyCode){
        $getCustomer = VerifyCustomer::where('verifyCode',$verifyCode)->first();

        $countCustomer = VerifyCustomer::where('verifyCode',$verifyCode)->count();

        if ($countCustomer <1) {
            
            $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Wrong Confirmation Code</h5>"; 
             
          }else{
            $custmomer = new Customer();

            $custmomer->name = $getCustomer->name;
            $custmomer->email = $getCustomer->email;
            $custmomer->mobile = $getCustomer->mobile;
            $custmomer->address = $getCustomer->address;
            $custmomer->gender = $getCustomer->gender;
            $custmomer->password = $getCustomer->password;
            $custmomer->confirmPassword = $getCustomer->confirmPassword;
            $custmomer->save();

            $customerId = $custmomer->id;

            Session::put('customerId',$customerId);
            Session::put('customerName',$customername);

            $deleteverify = VerifyCustomer::where('verifyCode', $verifyCode);
            $deleteverify->delete();

            /*$customerId = Session::get('customerId');
            $getCustomer = Customer::where('id',$customerId)->first();*/
          
            return redirect(route('custmomer.order'));
              
          }
     
    }

    public function profile($id){
        $customers = Customer::where('id',$id)->first();
        return view('frontend.customer.profile')->with(compact('customers'));
    }

    public function updateProfile(Request $request){
         $customerId = $request->customerId;

        $customers = Customer::find($customerId);
       
        $customers->update( [           
            'name' => $request->name,              
            'email' => $request->email, 
            'mobile' => $request->mobile,            
            'address' => $request->address,                         
        ]);

        $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-success'>Profile Updated Successfully</h5>"; 
        
        return redirect(route('customer.profile',$customerId))->with('msg',$message);     
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */

    public function orderList(){
        $customerId = Session::get('customerId');
        //$orderlist = Checkout::where('customer_id',$customerId)->get();

        $orderlist = DB::table('checkouts')
            ->join('transactions', 'checkouts.id', '=', 'transactions.checkout_id')
            ->where('checkouts.customer_id',$customerId)
            ->select('checkouts.*', 'transactions.*')
            ->get();

        return view('frontend.customer.orderlist')->with(compact('orderlist'));
    }

    public function orderDetails($id){
        $customerId = Session::get('customerId');

        $orderlist = DB::table('orders')
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->where('orders.checkout_id',$id)
        ->select('orders.*', 'products.*')
        ->get();

        
        return view('frontend.order.orderDetails')->with(compact('orderlist'));
    }



    public function logout(){
        $customerId = Session::get('customerId');
        $customerName = Session::get('customerName');
        Session::forget('customerId');
        Session::forget('customerName');
        return redirect(route('home.index'));
    }
}
