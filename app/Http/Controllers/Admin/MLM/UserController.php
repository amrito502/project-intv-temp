<?php

namespace App\Http\Controllers\Admin\MLM;

use App\User;

use App\Wallet;
use App\CashSale;
use App\Customer;
use App\District;
use App\UserRoles;
use Carbon\Carbon;
use App\CreditSale;
use App\Models\Notice;
use App\BusinessSetting;
use App\CreditCollection;
use App\Models\NoticeRoles;
use Illuminate\Http\Request;
use App\Helper\RankingHelper;
use App\Helper\SalesFlowHelper;
use App\Helper\Cron\TeamBonusAdd;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helper\RankBonus\addCMRankBonus;
use App\Helper\Ui\FlashMessageGenerator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        if ($request->ajax()) {

            return User::userDatatable();
        }

        return view('admin.mlm.dashboard.user.user_index');
    }


    public function MemberList(Request $request)
    {
        $title = 'Member List';

        $data = (object)[
            'members' => User::with(['refMember', 'placeMember'])->where('role', 3)->orderBy('id', 'desc')->get(),
        ];

        return view('admin.mlm.dashboard.user.member_index', compact('title', 'data'));
    }

    public function DealerList(Request $request)
    {
        $title = 'Dealer List';

        $data = (object)[
            'members' => User::with(['refMember', 'placeMember'])->where('role', 4)->orderBy('id', 'desc')->get(),
        ];

        return view('admin.mlm.dashboard.user.dealer_index', compact('title', 'data'));
    }

    public function FounderList(Request $request)
    {

        $data = (object)[
            'founders' => User::where('is_founder', 1)->get(),
        ];

        return view('dashboard.user.founder_list', compact('data'));
    }

    public function AgentList(Request $request)
    {

        $data = (object)[
            'founders' => User::where('is_agent', 1)->get(),
        ];

        return view('dashboard.user.agent_list', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = (object)[
            'roles' => Role::all(),
            'referrals' => User::role('Customer')->get(),
            'businessSettings' => BusinessSetting::where('id', 1)->select(['person_per_level', 'hand_name'])->first(),
        ];

        return view('dashboard.user.create_user', compact('data'));
    }

    public function MemberRegistration()
    {

        $title = $this->title;

        if (Auth::user()->role == 1) {
            $refId = 1;
            $downLevelMemberIds = User::findOrFail(2)->downLevelMemberIds();
        } else {
            $refId = Auth::user()->id;
            $downLevelMemberIds = Auth::user()->downLevelMemberIds();
        }

        array_push($downLevelMemberIds, $refId);

        $data = (object)[
            // 'referrals' => User::where('role', 3)->get(),
            // 'referrals' => APIController::getReferralReferenceStaticCall($refId),
            'referrals' => User::whereIn('id', $downLevelMemberIds)->get(),
            'businessSettings' => BusinessSetting::where('id', 1)->select(['person_per_level', 'hand_name'])->first(),
            'districts' => District::select(['id', 'name'])->get(),
        ];

        // dd($data);

        return view('admin.mlm.dashboard.user.member_registration', compact('title', 'data'));
    }

    public function DealerRegistration()
    {

        $title = $this->title;

        $data = (object)[
            'districts' => District::select(['id', 'name'])->get(),
        ];

        // dd($data);

        return view('admin.mlm.dashboard.user.dealer_registration', compact('title', 'data'));
    }

    public function MemberEdit($id)
    {

        $data = (object)[
            'member' => User::findOrFail($id),
            // 'roles' => Role::all(),
            'referrals' => User::where('role', 3)->get(),
            'businessSettings' => BusinessSetting::where('id', 1)->select(['person_per_level', 'hand_name'])->first(),
            'districts' => District::select(['id', 'name'])->get(),
        ];

        return view('dashboard.user.member_edit', compact('data'));
    }

    public function DealerEdit($id)
    {

        $title = "Dealer Edit";

        $data = (object)[
            'member' => User::findOrFail($id),
            'districts' => District::select(['id', 'name'])->get(),
        ];

        return view('admin.mlm.dashboard.user.dealer_edit', compact('data', 'title'));
    }

    public function MemberUpdate(Request $request, $id)
    {

        $member = User::findOrFail($id);

        if ($request->has('profile_img')) {

            // delete old file
            Storage::delete($request->old_image);

            // upload new file
            $file = $request->file('profile_img')->store('public/profile_img');
            $file = explode('/', $file);
            $file = end($file);
        } else {
            $file = $request->old_image;
        }


        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'is_founder' => $request->is_founder == 'on' ? 1 : 0,
            'is_agent' => $request->is_agent == 'on' ? 1 : 0,
            'district_id' => $request->district,
            'thana_id' => $request->thana,
            'profile_img' => $file,
        ];

        $member->update($data);


        // update user customer
        $customer = Customer::where('user_id', $id)->first();
        $customer->update([
            'username' => $request->username,
            'name' => $request->name,
            'mobile' => $request->mobile,
        ]);


        return redirect()->route('member.list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:admins,username',
            'mobile' => 'required',
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email',
            // 'roles' => 'required',
            // 'password' => 'min:6|required|confirmed',
            'profile_img' => 'image'
        ]);


        $investor = $request->investor ? 1 : 0;
        $operator = $request->operator ? 1 : 0;

        $data = [
            'username' => $request->username,
            'is_founder' => $request->is_founder == 'on' ? 1 : 0,
            'is_agent' => $request->is_agent == 'on' ? 1 : 0,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'referrence' => $request->referrence,
            'referral' => $request->referral,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hand_id' => $request->hand_id,
            'district_id' => $request->district,
            'thana_id' => $request->thana,
            'status' => 1,
            'investor' => $investor,
            'operator' => $operator,
            'rank' => 'Customer',
            'role' => 3,
        ];


        // save user
        $user = User::create($data);

        if ($request->has('profile_img')) {

            // upload new file
            $img = \App\ImageHelper::UploadImage($request->profile_img, 'admins', 'uploads/profile_images/');

            $user->update([
                'profile_img' => $img,
            ]);
        }


        //Create Ecommerce Customer
        $customer = Customer::create([
            'name' => $request->name,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_id' => $user->id,
            'reference_by' => @$user->referrence,
        ]);

        FlashMessageGenerator::generate('primary', 'User Successfully Added');

        return redirect(route('admin.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        // wallet data
        // success wallet
        $successWallet = $user->SuccessWalletDetails();

        // fund wallet
        $fundWallet = $user->FundWalletDetails();


        $balanceInfo = [
            'fundBalances' => [
                'receive' => $fundWallet['totalIncome'],
                'usage' => $fundWallet['totalExpense'],
                'balance' => $fundWallet['SuccessWallet'],
            ],
            'successBalances' => [
                'receive' => $successWallet['totalIncome'],
                'usage' => $successWallet['totalExpense'],
                'balance' => $successWallet['SuccessWallet'],
            ],
        ];


        $data = (object)[
            'user' => $user,
            'balanceInfo' => $balanceInfo,
        ];

        return view('dashboard.user.profile', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $data = (object)[
            'user' => $user,
            'user_roles' => $user->roles()->get()->pluck(['name'])->toArray(),
            'roles' => Role::all(),
            'referrals' => User::role('Customer')->where('id', '!=', $user->id)->get(),
            'businessSettings' => BusinessSetting::where('id', 1)->select(['person_per_level', 'hand_name'])->first(),
        ];


        return view('dashboard.user.edit_user', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'mobile' => 'required',
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
        ]);

        // update user
        $user = User::findOrFail($id);


        if ($request->has('profile_img')) {

            // delete old file
            Storage::delete($request->old_image);

            // upload new file
            $file = $request->file('profile_img')->store('public/profile_img');
            $file = explode('/', $file);
            $file = end($file);
        } else {
            $file = $request->old_image;
        }


        $data = [
            'username' => $request->username,
            'is_founder' => $request->is_founder == 'on' ? 1 : 0,
            'is_agent' => $request->is_agent == 'on' ? 1 : 0,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'profile_img' => $file,
        ];


        $user->update($data);


        FlashMessageGenerator::generate('primary', 'User Successfully Updated');

        return redirect(route('user.index'));
    }


    public function MemberShow($id)
    {

        $title = "Member Dashboard";

        $user = User::findOrFail($id);

        // get role notices
        $noticeIds = NoticeRoles::where('role_id', $user->role)->pluck('notice_id')->toArray();
        $notices = Notice::whereIn('id', $noticeIds)->where('status', 1)->get();

        $userData = (object)[
            'notices' => $notices,
            'totalPointIncome' => $user->totalPointIncome(),
            'totalPurchaseAmount' => $user->totalPurchaseAmount(),
            'totalCashIncome' => $user->totalCashIncome(),
            'totalCashExpense' => $user->totalCashExpense(),
            'CashWallet' => $user->CashWallet(),
            'ReferenceCount' => $user->ReferenceCount(),
            'achieve' => [
                'sales' => Wallet::where('from_id', $user->id)->where('remarks', 'SalesBonus')->where('status', 1)->sum('amount'),
                'generation' => Wallet::where('from_id', $user->id)->where('remarks', 'TeamBonus')->where('status', 1)->sum('amount'),
                'rank' => Wallet::where('from_id', $user->id)->where('remarks', 'RankBonus')->where('status', 1)->sum('amount'),
                'rePurchase' => Wallet::where('from_id', $user->id)->where('remarks', 'RePurchaseBonus')->where('status', 1)->sum('amount'),
                'incentive' => Wallet::where('from_id', $user->id)->where('remarks', 'Entertainment')->where('status', 1)->sum('amount'),
                'transfer_receive' => Wallet::where('to_id', $user->id)->where('remarks', 'Transfer')->where('status', 1)->sum('amount'),
            ],
            'total_achieve' => $user->totalCashIncome(),
            'total_receive' => $user->totalCashExpense(),
            'total_due' => $user->CashWallet(),
            'active_leaders' => RankingHelper::totalMemberSaleTopCustomers(5),
            'top_team_earners' => RankingHelper::TeamMemberSaleTopCustomers(5, $user->id),
        ];

        $rankData = (object)[
            'thisMonthSoldPackages' => Wallet::thisMonthSoldPackages(),
            'nextRank' => $user->nextRank(),
            'currentRankMemberCount' => $user->currentRankMemberCount(),
            'nextRankMemberCount' => $user->nextRankMemberCount(),
            'currentRankReserve' => $user->currentRankReserve(),
            'nextRankReserve' => $user->nextRankReserve(),
        ];

        return view('admin.dashboard.customer_dashboardByUser')->with(compact('title', 'userData', 'rankData', 'user'));
    }


    public function DealerShow($id)
    {

        $title = "Dealer Dashboard";

        $user = User::findOrFail($id);

        // get role notices
        $noticeIds = NoticeRoles::where('role_id', $user->role)->pluck('notice_id')->toArray();
        $notices = Notice::whereIn('id', $noticeIds)->where('status', 1)->get();

        // stock summary
        $total_receive =   $user->totalCashSaleItemQty();
        $total_distribution = $user->totalMemberSaleItemQty();
        $total_return = $user->totalReturnItemQty();
        $total_balance =   $total_receive - $total_distribution - $total_return;

        $total_receive =   $user->totalCashSaleItemQty();
        $total_distribution = $user->totalMemberSaleItemQty();
        $total_return = $user->totalReturnItemQty();

        // point summary
        $total_authorize = $user->totalCashSalePurchasePoint();
        $point_distribution = $user->totalMemberSalePurchasePoint();


        // transaction summary
        $total_purchase = $user->totalPurchaseAmount();
        $total_pay = $user->totalCashPurchase() + $user->totalCreditCollection();
        $members_pay = $user->totalMemberPay();

        // commission cards
        $commission_achieve = $user->dealerCommissionIncome();

        $commission_payment = Wallet::where('from_id', $user->id)
            ->whereIn('remarks', ['Withdraw'])
            ->where('status', 1)
            ->sum('amount');

        $cashSaleAmount = CashSale::where('customer_id', $user->id)->where('payment_type', 'Cash')->sum('invoice_amount');

        $creditSaleAmount = CreditSale::where('customer_id', $user->id)
            ->sum('invoice_amount');

        $dealerCommission = Wallet::where('to_id', $user->id)
            ->where('remarks', 'Withdraw')
            ->where('status', 1)
            ->sum('charge');

        $creditCollection = CreditCollection::where('client_id', $user->id)->sum('payment_amount');

        // $total_purchase = $cashSaleAmount + $creditSaleAmount;
        $total_payment = $cashSaleAmount + $creditCollection + $dealerCommission;

        $data = (object)[
            'dealerTransactionFlow' => SalesFlowHelper::DealerTransactionFlow($user->id),
            'notices' => $notices,
            'commission_cards' => [
                'commission_achieve' => round($commission_achieve),
                'commission_payment' => round($commission_payment),
                'commission_due' => round($commission_achieve - $commission_payment),
                'total_purchase' => round($total_purchase),
                'total_payment' => round($total_payment),
                'total_due' => round($total_purchase - $total_payment),
            ],
            'stock_summary' => (object) [
                'total_receive' => $total_receive,
                'total_distribution' => $total_distribution,
                'total_balance' => $total_balance,
            ],
            'point_summary' => (object) [
                'total_authorize' => number_format((float)$total_authorize, 2, '.', ''),
                'total_distribution' => number_format((float)$point_distribution, 2, '.', ''),
                'available_balance' => number_format((float)$total_authorize - (float)$point_distribution, 2, '.', ''),
            ],
            'popular_products' => User::totalMemberSaleItemWiseQty($user->id),
        ];

        return view('admin.dashboard.customer_dashboardByDealer')->with(compact('title', 'data'));
    }



    public function destroy(User $user)
    {

        if (!Auth::user()->can('delete user')) {
            return redirect(route('home'));
        }

        $user->delete();
        FlashMessageGenerator::generate('primary', 'User Deleted Successfully');
        return back();
    }

    public function toggleStatus(User $user)
    {

        if (!Auth::user()->can('status user')) {
            return redirect(route('home'));
        }

        $user->toggleStatus();

        return true;
    }

    public function ChangePassView(User $user)
    {

        if (!Auth::user()->can('change_password user')) {
            return redirect(route('home'));
        }

        return view('dashboard.user.password_change', compact('user'));
    }

    public function ChangePass(Request $request, User $user)
    {
        if (!Auth::user()->can('change_password user')) {
            return redirect(route('home'));
        }

        $request->validate([
            // 'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);


        // check old password
        // if (Hash::check($request->password, Auth::user()->password)) {

        // update new
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // }

        FlashMessageGenerator::generate('primary', 'Password Updated Successfully');

        return redirect(route('home'));
    }

    public function ChangeOwnPassView()
    {

        $user = Auth::user();


        return view('dashboard.user.password_change', compact('user'));
    }


    public function withDrawSettingsView()
    {
        return view('admin.mlm.dashboard.withdraw_settings');
    }

    public function withDrawSettings(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $user->update([
            'bKash_no' => $request->bKash_no,
            'rocket_no' => $request->rocket_no,
            'nagad_no' => $request->nagad_no,
            'bank_info' => $request->bank_info,
        ]);

        FlashMessageGenerator::generate('primary', 'Updated !!');

        return back();
    }


    public function accountActivationView()
    {

        // business settings
        $BusinessSetting = BusinessSetting::where('id', 1)->select(['payment_info', 'account_price'])->first();

        // fund wallet amount
        $fundAmount = Auth::user()->FundWallet();

        $showAutoActivationButton = false;

        if (Auth::user()->status != 1) {

            if ($fundAmount >= $BusinessSetting->account_price) {
                $showAutoActivationButton = true;
            }
        }

        $data = (object)[
            'businessSetting' => $BusinessSetting,
            'showAutoActivationButton' => $showAutoActivationButton,
        ];


        return view('dashboard.account_activation', compact('data'));
    }


    public function accountActivationAuto()
    {
        // business settings
        $BusinessSetting = BusinessSetting::where('id', 1)->select(['payment_info', 'account_price'])->first();

        // fund wallet amount

        $fundAmount = Auth::user()->FundWallet();

        $accountActivationStatus = false;

        if (Auth::user()->status != 1) {

            if ($fundAmount >= $BusinessSetting->account_price) {
                $accountActivationStatus = true;
            }
        }


        if ($accountActivationStatus) {

            Auth::user()->update([
                'status' => 1,
                'account_activation_date' => Carbon::now()->toDateTimeString(),
            ]);

            // Add in wallet
            Wallet::create([
                'from_id' => Auth::user()->id,
                'to_id' => Auth::user()->id,
                'amount' => $BusinessSetting->account_price,
                'payment_gateway' => 'Account Wallet',
                'remarks' => 'Account Purchase',
                'status' => 1,
            ]);

            FlashMessageGenerator::generate('success', 'Activated !!');
        }

        return back();
    }


    public function accountActivationSave(Request $request)
    {


        $businessSetting = BusinessSetting::where('id', 1)->select(['account_price', 'reference_bonus'])->first();


        $accountActivationStatus = 0;

        $wallets = ['bKash', 'Nagad', 'Rocket', 'Bank'];

        $validateArr = [
            'username' => 'required',
            'payment_type' => 'required',
        ];


        // if getway add validation.
        if (in_array($request->payment_type, $wallets)) {
            $validateArr['mobile_no'] = 'Required';
            $validateArr['transaction_no'] = 'Required';
        } else {
            $accountActivationStatus = 1;
            $validateArr['password'] = 'Required';
        }

        // form validate
        $request->validate($validateArr);


        // validate username
        $UserToActivate = User::where('username', $request->username)->first();
        if (!$UserToActivate && strlen($request->username) > 10) {
            $UserToActivate = User::where('mobile', $request->username)->first();
        }

        if (!$UserToActivate) {
            FlashMessageGenerator::generate('danger', 'User Not Found !');
            return back();
        }

        // validate if user already activated


        if ($UserToActivate->status == 1) {
            FlashMessageGenerator::generate('danger', 'User Already Activated !');
            return back();
        }


        // if wallet has sufficient amount balance
        if ($accountActivationStatus) {

            if (Auth::user()->FundWallet() < $businessSetting->account_price) {
                FlashMessageGenerator::generate('danger', 'Insufficient Wallet Balance !');
                return back();
            }
        }



        // Add in wallet
        Wallet::create([
            'from_id' => Auth::user()->id,
            'to_id' => $UserToActivate->id,
            'amount' => $businessSetting->account_price,
            'payment_gateway' => $request->payment_type,
            'account_no' => $request->mobile_no,
            'transaction_no' => $request->transaction_no,
            'remarks' => 'Account Purchase',
            'status' => $accountActivationStatus,
        ]);


        // if added from wallet fund

        if ($accountActivationStatus) {

            $UserToActivate->update([
                'status' => 1,
                'account_activation_date' => Carbon::now()->toDateTimeString(),
            ]);

            if ($UserToActivate->referrence) {

                $refUser = User::findOrFail($UserToActivate->referrence);

                if ($refUser->status == 1) {

                    Wallet::create([
                        'from_id' => @$UserToActivate->referrence,
                        'amount' => $businessSetting->reference_bonus,
                        'remarks' => 'Reference',
                        'status' => 1,
                    ]);
                }

                // add generation bonus.
                TeamBonusAdd::addTeamBonusToUpperLevel($UserToActivate->id);
            }
        }

        FlashMessageGenerator::generate('success', 'Activated !!');

        return back();
    }


    public function accountApprovalView()
    {

        $data = (object)[
            'funds' => Wallet::whereIn('remarks', ['Account Purchase'])->with(['from', 'to'])->orderBy('id', 'desc')->get(),
        ];

        return view('dashboard.account_approval', compact('data'));
    }

    public function accountApprovalToggle(Request $request)
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['reference_bonus'])->first();

        $walletId = $request->id;
        $wallet = Wallet::findOrFail($walletId);


        // update wallet
        $wallet->update([
            'status' => 1,
        ]);

        // activate user
        $user = User::findOrFail($wallet->to_id);

        $user->update([
            'status' => 1,
            'account_activation_date' => Carbon::now()->toDateTimeString(),
        ]);


        // add reference bonus
        Wallet::create([
            'from_id' => $user->referrence,
            'amount' => $businessSettings->reference_bonus,
            'remarks' => 'Reference',
            'status' => 1,
        ]);


        // add generation bonus.
        TeamBonusAdd::addTeamBonusToUpperLevel($user->id);

        // add cm rank bonus
        addCMRankBonus::addCmRankBonusToUpperLevel($user->id);

        return $walletId;
    }
}
