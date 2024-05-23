<?php

namespace App\Http\Controllers\Admin;

use DB;
use Session;
use App\User;
use App\Admin;
use App\Order;
use Exception;
use App\Product;
use App\Checkout;
use App\Customer;
use App\Settings;
use App\Shipping;
use App\CustomerGroup;
use App\VerifyCustomer;
use App\CustomerAddress;
use Illuminate\Http\Request;
use App\Helper\Flatten\Flatten;
use App\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class CustomerController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $title = "Customer";
        $customers = Customer::orderBy('id', 'dsc')->get();
        return view('admin.customers.index')->with(compact('title', 'customers'));
    }

    public function customerAdd()
    {
        $title = 'Customer';
        $customerGroup = CustomerGroup::orderBy('groupName', 'asc')->get();
        return view('admin.customers.add')->with(compact('title', 'customerGroup'));
    }

    public function customerSave(Request $request)
    {
        $dob = date('Y-m-d', strtotime($request->dob));

        $this->validate(request(), [
            'customer_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
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
            'clientGroup' => '0'
        ]);

        return redirect(route('customers.index'))->with('msg', 'Customer Successfuly Saved');
    }

    public function customerEdit($id)
    {
        $title = "Customer";
        $customerGroup = CustomerGroup::orderBy('groupName', 'asc')->get();
        $customer = Customer::where('id', $id)->first();
        return view('admin.customers.edit')->with(compact('title', 'customerGroup', 'customer'));
    }

    public function customerUpdate(Request $request)
    {
        $dob = date('Y-m-d', strtotime($request->dob));

        $this->validate(request(), [
            'customer_name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
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
            'clientGroup' => '0'
        ]);

        return redirect(route('customers.index'))->with('msg', 'Customer Successfuly Updated');
    }

    public function customerDelete(Request $request)
    {
        Customer::where('id', $request->customerId)->delete();
    }

    public function customerDetails($id)
    {
        $customers = Customer::where('id', $id)->first();
        $customer_groups = CustomerGroup::where('groupStatus', 1)->get();
        return view('admin.customers.customerDetails')->with(compact('customers', 'customer_groups'));
    }

    public function updateClientGroup(Request $request)
    {
        $customerId = $request->customerId;
        $customers = Customer::find($customerId);
        $clientGroup = implode(',', $request->clientGroup);
        $customers->update([
            'clientGroup' => $clientGroup,
        ]);
        return redirect(route('customers.index'))->with('msg', 'Customer Add to Group Successfully');
    }

    // public function destroy(Customer $customer, Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $customer->delete();
    //         print_r(1);
    //         return;
    //     }
    //     $customer->delete();
    //     return redirect(route('categories.index')) -> with( 'message', 'Deleted Successfully');
    // }

    public function showLoginForm()
    {

        // dd(Auth::user());
        $setReview = @$_GET['setReview'];
        return view('frontend.pages.frontend_login')->with(compact('setReview'));
    }

    public function login(Request $request)
    {
        //validate data
        $this->validate($request, [
            'custemail' => 'required',
            'password' => 'required',
        ]);



        // check status
        $customer = Customer::where(function ($q) use ($request) {
            $q->orWhere('username', $request->custemail)
                ->orWhere('mobile', $request->custemail);
        })->first();


        if ($customer) {

            if (Hash::check($request->password, $customer->password)) {

                Auth::guard('customer')->loginUsingId($customer->id);

                $user = User::findOrFail($customer->user_id);

                if ($user) {
                    Auth::guard('admin')->login($user);
                }

                return redirect(route('home.index'));
            }
        }

        // if (!$customer) {

        //     $user = User::where('username', $request->custemail)->orWhere('mobile', $request->custemail)->with(['CustomerAccount'])->first();

        //     if ($user) {


        //         if (Hash::check($request->password, $user->password)) {
        //             Auth::loginUsingId($user->id);

        //             if ($user->CustomerAccount) {
        //                 Auth::guard('customer')->loginUsingId($user->CustomerAccount->id);
        //             }
        //             return redirect(route('home.index'));
        //         }
        //     }


        //     $message = "User Not Found";
        //     return back()->with('msg', $message)->withInput();
        // }


        if ($request->redirectTo) {
            return redirect(route('cart.index'));
        }

        return back()->with('msg', 'The provided credentials do not match our records.');
    }

    public function passwordForget()
    {
        return view('frontend.customer.passwordforget');
    }

    public function passwordMail(Request $request)
    {
        $email = $request->email;

        $countCustomer = Customer::where('email', $email)->count();
        $customerEmail = Customer::where('email', $email)->first();

        // @$password = $customerEmail->storePassword;

        // $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
        // $paramArray = array(
        //   'userName' => "01832967276",
        //   'userPassword' => "3e3198",
        //   'messageText' => "Your Driver Vara Password:".$password,
        //   'numberList' => $phone,
        //   'smsType' => "TEXT",
        //   'maskName' => 'DemoMask',
        //   'campaignName' => '', );

        if ($countCustomer < 1) {
            $message = "<h4 style='display:inline-block;width:auto;' class='alert alert-danger'>Email Addresss is Not Registered</h4>";

            return redirect(route('password.forget'))->with('msg', $message)->withInput();
        } else {
            $message = "<h4 style='display:inline-block;width:auto;' class='alert alert-success'>Check your email inbox or spam</h4>";
            $subject = "Your Password Reset Link";

            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <piqood@web.com>' . "\r\n";
            $headers .= 'Cc: superbnexus@gmail.com' . "\r\n";

            $link = "Your password reset <a href=" . url('/customer/new-password/' . $email) . ">link</a>";

            $subject = "Password Reset Mak64wholesaleclub";

            $this->sendNotificationMail($customerEmail->name, $customerEmail->email, $link, $subject);


            // mail($email, $subject, $link);
            return redirect(route('password.forget'))->with('msg', $message)->withInput();
        }
    }

    public function newPassword($email)
    {
        @$customer = Customer::where('email', $email)->first();
        if ($customer) {
            return view('frontend.customer.newpassword', ['customer' => $customer]);
        } else {
            return redirect('/customer/login');
        }
    }

    public function changePasswordSave(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|same:confirmPassword',
            'confirmPassword' => 'required|min:6'
        ]);

        $allCustomer = Customer::where('email', $request->email)->first();
        $customerId = $allCustomer->id;
        $customer = Customer::find($customerId);
        $customer->password = md5($request->password);
        $customer->save();

        Session::put('customerId', $customerId);
        return redirect(route("customer.order"));
    }

    public function showRegistrationForm(Request $request)
    {
        $reference = User::find($request->reference);
        // dd($reference);
        return view('frontend.pages.frontend_registration')->with(compact('reference'));
    }

    public function chekUsername(Request $request)
    {
        $username = '';
        $user = Customer::where('username', $request->username)->first();
        if ($user) {
            $username =  $user->username;
        }
        return $username;
    }

    public function customerRegister(Request $request)
    {
        $name = $request->input('name');
        $username = $request->input('username');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $address = $request->input('address');
        $reference = $request->input('reference');
        $password = $request->input('password');
        $confirmPassword = $request->input('confirmPassword');

        @$getcustomerEmail = Customer::where('email', $email)->count();
        @$getcustomerPhone = Customer::where('mobile', $mobile)->count();
        @$getcustomerUsername = Customer::where('username', $username)->count();

        $verifyCode = rand(100000, 999999);


        if ($getcustomerEmail > 0 && $email != '') {
            $message = "This email address already registered";

            return redirect(route('customer.registration'))->with('msg', $message)->withInput();
        } elseif ($getcustomerPhone > 0) {
            $message = "This phone number already registered";

            return redirect(route('customer.registration'))->with('msg', $message)->withInput();
        } elseif ($getcustomerUsername > 0) {
            $message = "This Username already taken";

            return redirect(route('customer.registration'))->with('msg', $message)->withInput();
        } elseif ($password != $confirmPassword) {
            $message = "Password and Confirm Password Not Matched";

            return redirect(route('customer.registration'))->with('msg', $message)->withInput();
        } else {

            // Customer Registration
            $customers = new Customer();
            $customers->name = $name;
            $customers->username = $username;
            $customers->email = $email;
            $customers->mobile = $mobile;
            $customers->address = $address;
            $customers->password = Hash::make($request->password);
            $customers->confirmPassword = Hash::make($request->confirmPassword);
            $customers->save();

            $user = User::where('username', $reference)->first();
            if (!$user) {
                $user = User::where('id', 17)->first();
            }

            //User Hand Check
            $data = (object)[];

            $handOne = $this->DownLevelMemberAllIdsWithHandCount(1, $user->id);
            if ($handOne == 0) {
                $data = (object)[
                    'hand' => 1,
                    'referral' => $user->id
                ];
            }

            $handTwo = $this->DownLevelMemberAllIdsWithHandCount(2, $user->id);
            if ($handTwo == 0) {
                $data = (object)[
                    'hand' => 2,
                    'referral' => $user->id
                ];
            }

            $handThree = $this->DownLevelMemberAllIdsWithHandCount(3, $user->id);
            if ($handThree == 0) {
                $data = (object)[
                    'hand' => 3,
                    'referral' => $user->id
                ];
            }


            if (!isset($data)) {
                //Under User Hand CHeck
                $referrals = $this->members($user->id);

                foreach ($referrals as $referral) {

                    $handOne = $this->DownLevelMemberAllIdsWithHandCount(1, $referral->id);
                    if ($handOne == 0) {
                        $data = (object)[
                            'hand' => 1,
                            'referral' => $referral->id
                        ];
                        break;
                    }

                    $handTwo = $this->DownLevelMemberAllIdsWithHandCount(2, $referral->id);
                    if ($handTwo == 0) {
                        $data = (object)[
                            'hand' => 2,
                            'referral' => $referral->id
                        ];
                        break;
                    }


                    $handThree = $this->DownLevelMemberAllIdsWithHandCount(3, $referral->id);
                    if ($handThree == 0) {
                        $data = (object)[
                            'hand' => 3,
                            'referral' => $referral->id
                        ];
                        break;
                    }
                }
            }

            $mlmUser = User::create([
                'is_founder' => 0,
                'is_agent' => 0,
                'rank' => 'Customer',
                'name' => $name,
                'username' => $username,
                'mobile' => $mobile,
                'email' => $email,
                'referrence' => @$user->id,
                'referral' => @$data->referral,
                'password' => Hash::make($request->password),
                'hand_id' => @$data->hand,
                'status' => 1,
                'role' => 3
            ]);

            $customers->update([
                'user_id' => $mlmUser->id,
                'reference_by' => $mlmUser->referrence
            ]);

            $message = "You Registration Successfully Completed";

            return redirect(route('customer.login'))->with('msg', $message)->withInput();
        }
    }

    public function members($id)
    {
        $ids = $this->DownLevelMemberIds($id);

        $members = User::whereIn('id', $ids)->get();
        return $members;
    }

    public function DownLevelMemberIds($id)
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['number_of_level'])->first();


        $ids = [];

        $ReferenceId = $id;

        $level1Ids = User::where('referral', $ReferenceId)->select(['id'])->get()->pluck('id')->toArray();

        array_push($ids, $level1Ids);

        $lastLevelIds = $level1Ids;


        for ($i = 1; $i < $businessSettings->number_of_level + 1; $i++) {

            $levelIds = User::whereIn('referral', $lastLevelIds)->select(['id'])->get()->pluck('id')->toArray();

            $lastLevelIds = $levelIds;

            array_push($ids, $levelIds);
        }

        $ids = Flatten::ArrayFlatten($ids);

        // dd($ids);

        return $ids;
    }



    public function DownLevelMemberAllIdsWithHandCount($handId, $id)
    {
        $ids = $this->DownLevelMemberAllIdsWithHand($handId, $id);
        return count($ids);
    }


    public function DownLevelMemberAllIdsWithHand($handId, $id)
    {

        $totalUserCount = User::count();

        $ids = [];

        $ReferenceId = $id;

        $level1Id = User::where('referral', $ReferenceId)->where('hand_id', $handId)->select(['id', 'hand_id'])->first();

        if (!$level1Id) {
            return $ids;
        }

        array_push($ids, $level1Id->id);

        $lastLevelId = $level1Id->id;

        for ($i = 1; $i < $totalUserCount + 1; $i++) {

            if (gettype($lastLevelId) == 'array') {

                $levelId = User::whereIn('referral', $lastLevelId)->select(['id'])->get()->pluck(['id'])->toArray();
            } else {

                $levelId = User::where('referral', $lastLevelId)->select(['id'])->get()->pluck(['id'])->toArray();
            }

            if (!count($levelId)) {
                continue;
            }

            array_push($ids, $levelId);

            $lastLevelId = $levelId;
        }

        $ids = Flatten::ArrayFlatten($ids);

        return $ids;
    }


    public function customerRegisterFacebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function customerRegisterFacebook(Request $request)
    {

        try {

            $user = Socialite::driver('facebook')->user();
            $isUser = Customer::where('fb_id', $user->id)->first();

            if ($isUser) {
                Auth::guard('customer')->loginUsingId($isUser->id);
                return redirect(route('home.index'));
            } else {
                $createUser = Customer::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    'password' => encrypt('facebook_password')
                ]);

                Auth::guard('customer')->loginUsingId($createUser->id);
                return redirect(route('home.index'));
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function sendNotificationMail($name, $email, $password, $subject)
    {
        Mail::send([], [], function ($message) use ($name, $email, $password, $subject) {
            $message->from('info@mak64wholesaleclub.com');
            $message->to($email);
            $message->subject($subject);
            $message->setBody($this->NotificationTemplate($name, $email, $password), 'text/html');
        });
    }


    public function NotificationTemplate($name, $email, $body)
    {

        $website_information = Settings::where('id', 1)->first();

        $message_body =
            '
                <html>
                    <head>
                        <title>Email Verification</title>
                    </head>
                    <body>
                        <div>
                            <table border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto; background-color: #fff; border: 1px solid #ddd;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="650">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <div style="padding: 20px;">
                                                                <h3><b>Dear ' . $name . '</b></h3>
                                                                <p>
                                                                   ' . $body . '
                                                                </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="background-color: #0e4168;" height="40">
                                        <a href="' . url('/') . '">
                                            <p style="padding: 0; margin: 0; color: #fff; font-size: 15px; line-height: 22px; font-weight: 700; text-align: center;">' . $website_information->siteTitle . '</p>
                                        </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </body>
                </html>
            ';

        return $message_body;
    }


    public function verficationBox()
    {
        return view('frontend.customer.registerverify');
    }

    public function registerSave($verifyCode)
    {
        $getCustomer = VerifyCustomer::where('verifyCode', $verifyCode)->first();

        $countCustomer = VerifyCustomer::where('verifyCode', $verifyCode)->count();

        if (!$countCustomer) {

            // $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'></h5>";
            $message = "Wrong Confirmation Code";
            return redirect(route('customer.login'))->with('error', $message);
        } else {

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

            Session::put('customerId', $customerId);
            Session::put('customerName', $getCustomer->name);

            $deleteverify = VerifyCustomer::where('email', $getCustomer->email);
            $deleteverify->delete();

            // Session::set('customerId', $customerId);
            // $getCustomer = Customer::where('id',$customerId)->first();

            return redirect(route('customer.login'));
        }
    }

    public function profileHome()
    {

        $id = Auth::guard('customer')->user()->id;

        $customers = Customer::findOrFail($id);

        $bodyClass = 'subpage lang-en country-us currency-usd layout-full-width page-my-account tax-display-disabled';

        return view('frontend.pages.profile.customer_profile')->with(compact('customers', 'bodyClass'));
    }

    public function profile()
    {

        $id = Auth::guard('customer')->user()->id;
        $customers = Customer::findOrFail($id);

        return view('frontend.pages.profile.profile_information')->with(compact('customers'));
    }

    public function address()
    {

        $id = Auth::guard('customer')->user()->id;
        $customer = Customer::where('id', $id)->with('addresses')->first();


        $bodyId = 'addresses';
        $bodyClass = 'subpage lang-en country-us currency-usd layout-full-width page-addresses tax-display-disabled';

        return view('frontend.pages.profile.customer_addresses')->with(compact('customer', 'bodyId', 'bodyClass'));
    }

    public function addressSave(Request $request)
    {

        $request->validate([
            'address' => 'required',
        ]);

        $customerId = Auth::guard('customer')->user()->id;

        CustomerAddress::create([
            'customer_id' => $customerId,
            'address' => $request->address,
        ]);

        return back()->with('msg', "New address added!");
    }


    public function addressUpdate($id, Request $request)
    {

        CustomerAddress::findorFail($id)->update([
            'address' => $request->address,
        ]);

        return back()->with('msg', "Address Updated!");
    }


    public function addressDelete($id)
    {

        CustomerAddress::where('id', $id)->delete();

        return back()->with('msg', "Address deleted!");
    }



    public function updateProfile(Request $request)
    {
        $customerId = $request->customerId;

        $customers = Customer::find($customerId);

        $customers->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
        ]);

        $message = "Profile Updated Successfully";

        return redirect(route('customer.profile', $customerId))->with('msg', $message);
    }

    public function shippingEmail()
    {
        // return view('frontend.order.shippingEmail');
        return view('frontend.pages.shippings_search');
    }

    public function viewOrder(Request $request)
    {
        if ($request) {
            $email = $request->input('custemail');
            $getEmail = Customer::where('email', $email)->orWhere('mobile', $email)->first();
            @$countEmail = count($getEmail);
            if ($email == "") {
                $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Field must not be empty</h5>";
                Session::put('message', $message);
                return redirect('/shipping-email')->withInput();
            } elseif ($countEmail < 1) {
                $message = "<h5 style='display:inline-block;width:auto;' class='alert alert-danger'>Your Email or Phone No Not Matched</h5>";
                Session::put('message', $message);
                return redirect('/shipping-email')->withInput();
            } else {
                if ($countEmail > 0) {
                    Session::put('customerId', $getEmail->id);
                    Session::put('password', $getEmail->password);
                    return redirect(route('customer.order'));
                }
            }
        }
    }

    public function orderList()
    {
        $customerId = Session::get('customerId');

        $already_logged_id = 0;

        if (Auth::guard('customer')->check()) {
            $customerId = Auth::guard('customer')->user()->id;
        }

        $orderlist = DB::table('checkouts')
            ->join('transactions', 'checkouts.id', '=', 'transactions.checkout_id')
            ->where('transactions.reference', $customerId)
            ->select('checkouts.*', 'transactions.*')
            ->get();

        $bodyClass = 'subpage lang-en country-us currency-usd layout-full-width page-history tax-display-disabled page-customer-account';
        $bodyID = 'history';


        //        return view('frontend.order.orderlist')->with(compact('orderlist'));
        return view('frontend.pages.profile.order_history')->with(compact('orderlist', 'bodyClass', 'bodyID'));
    }

    public function orderDetails($id)
    {
        $orderlist = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('orders.checkout_id', $id)
            ->select('orders.*', 'products.name', 'products.deal_code', 'products.slug')
            ->get();

        $checkout = Checkout::find($id);
        $shipping = Shipping::findOrFail($checkout->shipping_id);

        $customer = Customer::find($checkout->customer_id);

        $bodyClass = 'subpage lang-en country-us currency-usd layout-full-width page-history tax-display-disabled page-customer-account';
        $bodyID = 'history';

        //        return view('frontend.order.orderDetails')->with(compact('orderlist'));
        return view('frontend.pages.profile.order_details')->with(compact('orderlist', 'checkout', 'shipping', 'customer', 'bodyClass', 'bodyID'));
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        Auth::guard('admin')->logout();
        return redirect(route('home.index'));
    }


    public function customerBusinessPanel(Request $request)
    {

        $is_logged_in_as_customer = Auth::guard('customer')->check();

        if (!$is_logged_in_as_customer) {
            return back();
        }

        $customer = Auth::guard('customer')->user();

        $user = User::findOrFail($customer->user_id);

        // Auth::guard('admin')->loginUsingId($user->id);
        Auth::guard('admin')->login($user);

        return redirect(route('admin.index'));
    }
}
