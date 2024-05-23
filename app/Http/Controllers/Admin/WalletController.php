<?php

namespace App\Http\Controllers\Admin;

use PDF;

use App\User;
use App\Wallet;
use App\Helper\MyStatement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helper\PaymentRequestReport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use App\Helper\Ui\FlashMessageGenerator;

class WalletController extends Controller
{

    public function memberPaymentView()
    {

        $data = (object)[
            'title' => 'Withdraw Balance',
            'users' => User::where('role', 3)->get(),
        ];

        return view('admin.withdraw.withdraw', compact('data'));
    }

    public function memberPayment(Request $request)
    {

        // check if minimum balance is requested
        if ($request->withdraw_amount < 200) {
            return back()->with('msg', 'Minimum withdraw amount is 200');
        }

        // get user balance
        $user = User::findOrFail($request->user);
        $user_balance = $user->CashWallet();

        // check if user have enough balance

        if ($user_balance < $request->withdraw_amount) {
            return back()->with('msg', 'User Does not have sufficient balance');
        }


        // add wallet transaction
        Wallet::create([
            'from_id' => $request->user,
            'amount' => $request->withdraw_amount,
            'remarks' => 'Withdraw',
            'status' => 1,
        ]);

        return back();
    }


    // public function index(Request $request)
    // {

    //     $data = (object)[
    //         'my_wallet_amount' => Auth::user()->InWallet(),
    //     ];

    //     return view('dashboard.my_wallet', compact('data'));
    // }



    public function myStatement(Request $request)
    {

        $title = $this->title;

        $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
        $end_date_ui = Carbon::now()->format('d-m-Y');

        if ($request->has('start_date')) {
            $start_date_ui = date('d-m-Y', strtotime($request->start_date));
        }

        if ($request->has('end_date')) {
            $end_date_ui = date('d-m-Y', strtotime($request->end_date));
        }

        $report = [];

        $previousBalance = 0;

        if ($request->search) {

            // statement for previous balance
            $searchData = [
                "start_date" => "0000-00-00",
                "end_date" => date('Y-m-d', strtotime($request->start_date)),
                'member' => $request->member,
            ];

            $previousMyStatement = new MyStatement($searchData, 0);
            $previousReport = $previousMyStatement->getMyStatement();


            if (count($previousReport)) {
                $lastRow = count($previousReport) - 1;
                $previousBalance = $previousReport[$lastRow]['balance'];
            }

            // current statement

            $searchData = [
                "start_date" => date('Y-m-d', strtotime($request->start_date)),
                "end_date" => date('Y-m-d', strtotime($request->end_date)),
                'member' => $request->member,
            ];

            $myStatement = new MyStatement($searchData, $previousBalance);
            $report = $myStatement->getMyStatement();
        }

        $data = (object)[
            'start_date_ui' => $start_date_ui,
            'end_date_ui' => $end_date_ui,
            'previousBalance' => $previousBalance,
            'report' => $report,
            'users' => User::where('role', 3)->get(),
            'selectedUser' => User::find($request->member),
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.mlm.dashboard.my_statement_print', compact('title', 'data'));
            // ->setPaper('a4', 'landscape');

            return $pdf->stream('my_statement.pdf');
        }

        return view('admin.mlm.dashboard.my_statement', compact('data'));
    }


    public function incomeStatement(Request $request)
    {

        $title = $this->title;

        $statements = [];

        $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
        $end_date_ui = Carbon::now()->format('d-m-Y');

        if ($request->has('start_date')) {
            $start_date_ui = date('d-m-Y', strtotime($request->start_date));
        }

        if ($request->has('end_date')) {
            $end_date_ui = date('d-m-Y', strtotime($request->end_date));
        }

        $type = $request->type;

        if (Auth::user()->role == 3) {

            $statements = Wallet::where('from_id', Auth::user()->id);

            if ($request->has('type') && $type != '') {
                $statements = $statements->where('remarks', $type);
            } else {
                $statements = $statements->whereIn('remarks', ['ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus']);
            }

            $statements = $statements->get();

            $data = (object)[
                'statements' => $statements,
                'type' => $type,
                'start_date_ui' => $start_date_ui,
                'end_date_ui' => $end_date_ui,
            ];

            if ($request->submitType == "print") {

                $pdf = PDF::loadView('admin.mlm.dashboard.income_statement_print', compact('title', 'data'))->setPaper('a4', 'landscape');

                return $pdf->stream('income_statement.pdf');
            }

            return view('admin.mlm.dashboard.income_statement', compact('data'));
        } else {

            if ($request->has('start_date')) {

                $start_date = date('Y-m-d', strtotime($request->start_date));
                $end_date = date('Y-m-d', strtotime($request->end_date));

                $statements = Wallet::whereDate('created_at', '>=', $start_date)
                    ->whereDate('created_at', '<=', $end_date);


                if ($request->username) {
                    $statements = $statements->where('from_id', $request->username);
                };

                if ($request->has('type') && $type != '') {
                    $statements = $statements->where('remarks', $type);
                } else {
                    $statements = $statements->whereIn('remarks', ['ConversionToCash', 'TeamBonus', 'SalesBonus', 'RePurchaseBonus', 'Entertainment', 'RankBonus', 'LevelBonus']);
                }

                $statements = $statements->orderBy('created_at', 'desc')->get();
            }

            $data = (object)[
                'statements' => $statements,
                'type' => $type,
                'users' => User::where('role', 3)->get(),
                'start_date_ui' => $start_date_ui,
                'end_date_ui' => $end_date_ui,
            ];

            if ($request->submitType == "print") {

                $pdf = PDF::loadView('admin.mlm.dashboard.income_statement_print', compact('title', 'data'))->setPaper('a4', 'landscape');

                return $pdf->stream('income_statement.pdf');
            }

            return view('admin.mlm.dashboard.income_statement_admin', compact('data'));
        }
    }

    // public function fundStatement(Request $request)
    // {

    //     $statements = [];

    //     $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
    //     $end_date_ui = Carbon::now()->format('d-m-Y');

    //     if ($request->has('start_date')) {
    //         $start_date_ui = date('d-m-Y', strtotime($request->start_date));
    //     }

    //     if ($request->has('end_date')) {
    //         $end_date_ui = date('d-m-Y', strtotime($request->end_date));
    //     }


    //     $start_date = date('Y-m-d', strtotime($request->start_date));
    //     $end_date = date('Y-m-d', strtotime($request->end_date));

    //     if (Auth::user()->hasRole(['Customer'])) {

    //         $params = [
    //             'user_id' => Auth::user()->id,
    //             'start_date' => $start_date,
    //             'end_date' => $end_date,
    //         ];

    //         $statements = Statement::fundStatement($params);


    //         $data = (object)[
    //             'statements' => $statements,
    //             'start_date_ui' => $start_date_ui,
    //             'end_date_ui' => $end_date_ui,
    //         ];


    //         return view('dashboard.fund_wallet_statement_member', compact('data'));
    //     } else {

    //         if ($request->has('start_date')) {


    //             $params = [
    //                 'user_id' => $request->username,
    //                 'start_date' => $start_date,
    //                 'end_date' => $end_date,
    //             ];

    //             $statements = Statement::fundStatement($params);

    //         }

    //         $data = (object)[
    //             'statements' => $statements,
    //             'users' => User::select(['id', 'username'])->where('rank', '!=', 'Founder')->get(),
    //             'start_date_ui' => $start_date_ui,
    //             'end_date_ui' => $end_date_ui,
    //         ];

    //         return view('dashboard.fund_wallet_statement_admin', compact('data'));
    //     }
    // }


    // public function SuccessStatement(Request $request)
    // {

    //     $statements = [];

    //     $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
    //     $end_date_ui = Carbon::now()->format('d-m-Y');

    //     if ($request->has('start_date')) {
    //         $start_date_ui = date('d-m-Y', strtotime($request->start_date));
    //     }

    //     if ($request->has('end_date')) {
    //         $end_date_ui = date('d-m-Y', strtotime($request->end_date));
    //     }


    //     if (Auth::user()->hasRole(['Customer'])) {

    //         $start_date = date('Y-m-d', strtotime($request->start_date));
    //         $end_date = date('Y-m-d', strtotime($request->end_date));


    //         $params = [
    //             'user_id' => Auth::user()->id,
    //             'start_date' => $start_date,
    //             'end_date' => $end_date,
    //         ];

    //         $statements = Statement::SuccessStatement($params);

    //         $data = (object)[
    //             'statements' => $statements,
    //             'start_date_ui' => $start_date_ui,
    //             'end_date_ui' => $end_date_ui,
    //         ];

    //         return view('dashboard.success_wallet_statement_member', compact('data'));

    //     } else {

    //         if ($request->has('start_date')) {

    //             $start_date = date('Y-m-d', strtotime($request->start_date));
    //             $end_date = date('Y-m-d', strtotime($request->end_date));


    //             $params = [
    //                 'user_id' => $request->username,
    //                 'start_date' => $start_date,
    //                 'end_date' => $end_date,
    //             ];

    //             $statements = Statement::SuccessStatement($params);

    //         }


    //         $data = (object)[
    //             'statements' => $statements,
    //             'users' => User::select(['id', 'username'])->where('rank', '!=', 'Founder')->get(),
    //             'start_date_ui' => $start_date_ui,
    //             'end_date_ui' => $end_date_ui,
    //         ];

    //         return view('dashboard.success_wallet_statement_admin', compact('data'));
    //     }
    // }

    public function adminIncomeStatement(Request $request)
    {

        $statements = [];

        $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
        $end_date_ui = Carbon::now()->format('d-m-Y');

        if ($request->has('start_date')) {
            $start_date_ui = date('d-m-Y', strtotime($request->start_date));
        }

        if ($request->has('end_date')) {
            $end_date_ui = date('d-m-Y', strtotime($request->end_date));
        }

        $type = $request->type;

        if ($request->has('start_date')) {

            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));

            $statements = Wallet::whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)->with(['from']);


            if ($request->username) {
                $statements = $statements->where('from_id', $request->username);
            };

            if ($request->has('type') && $type != '') {
                $statements = $statements->where('remarks', $type);
            } else {
                $statements = $statements->whereIn('remarks', ['Withdraw', 'Transfer', 'Account Purchase']);
            }

            $statements = $statements->get();

            // dd($request);
            // dd($statements);

        }

        $data = (object)[
            'statements' => $statements,
            'type' => $type,
            'users' => User::select(['id', 'username'])->where('rank', '!=', 'Founder')->get(),
            'start_date_ui' => $start_date_ui,
            'end_date_ui' => $end_date_ui,
        ];

        return view('dashboard.admin_income_statement', compact('data'));
    }

    // public function withdrawHistory(Request $request)
    // {

    //     $statements = [];

    //     $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
    //     $end_date_ui = Carbon::now()->format('d-m-Y');

    //     if (Auth::user()->hasRole(['Customer'])) {

    //         $data = (object)[
    //             'statements' => Wallet::with(['from', 'to', 'ApprovedBy'])->where('from_id', Auth::user()->id)->whereIn('remarks', ['Withdraw'])->get(),
    //         ];

    //         return view('dashboard.withdraw_statement', compact('data'));
    //     } else {

    //         if ($request->has('start_date')) {
    //             $start_date_ui = date('d-m-Y', strtotime($request->start_date));
    //         }

    //         if ($request->has('end_date')) {
    //             $end_date_ui = date('d-m-Y', strtotime($request->end_date));
    //         }

    //         if ($request->has('start_date')) {

    //             $start_date = date('Y-m-d', strtotime($request->start_date));
    //             $end_date = date('Y-m-d', strtotime($request->end_date));

    //             $statements = Wallet::with(['from', 'to', 'ApprovedBy'])
    //                 ->whereIn('remarks', ['Withdraw'])
    //                 ->whereDate('created_at', '>=', $start_date)
    //                 ->whereDate('created_at', '<=', $end_date);

    //             if ($request->username) {
    //                 $statements = $statements->where('from_id', $request->username);
    //             }

    //             $statements = $statements->get();
    //         }

    //         $data = (object)[
    //             'statements' => $statements,
    //             'users' => User::select(['id', 'username'])->where('rank', '!=', 'Founder')->get(),
    //             'start_date_ui' => $start_date_ui,
    //             'end_date_ui' => $end_date_ui,
    //         ];

    //         return view('dashboard.withdraw_statement_admin', compact('data'));
    //     }
    // }

    // public function transferStatement()
    // {

    //     $data = (object)[
    //         'statements' => Wallet::with(['from', 'to'])->where(function ($query) {
    //             $query->where('from_id', Auth::user()->id)
    //                 ->orWhere('to_id', Auth::user()->id);
    //         })->whereIn('remarks', ['Transfer'])->get(),
    //     ];


    //     return view('dashboard.transfer_statement', compact('data'));
    // }

    // public function rechargeStatement()
    // {

    //     $data = (object)[
    //         'statements' => Wallet::with(['from', 'to'])->where('from_id', Auth::user()->id)->whereIn('remarks', ['Recharge'])->get(),
    //     ];


    //     return view('dashboard.recharge_statement', compact('data'));
    // }


    // public function addFund()
    // {

    //     if (!Auth::user()->can('Add Fund')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object)[
    //         'businessSetting' => BusinessSetting::where('id', 1)->select(['payment_info'])->first(),
    //     ];


    //     return view('dashboard.add_fund', compact('data'));
    // }

    // public function saveFund(Request $request)
    // {

    //     if (!Auth::user()->can('Add Fund')) {
    //         return redirect(route('home'));
    //     }

    //     Wallet::create([
    //         'from_id' => Auth::user()->id,
    //         'amount' => $request->amount,
    //         'remarks' => 'Added Fund',
    //         'status' => 0,
    //         'payment_gateway' => $request->payment_type,
    //         'account_no' => $request->account_no,
    //         'transaction_no' => $request->transaction_no,
    //     ]);

    //     FlashMessageGenerator::generate('primary', 'Fund Submitted For Review');

    //     return back();
    // }

    // public function FundAddAdmin()
    // {

    //     if (!Auth::user()->can('Fund Add')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object)[
    //         'businessSetting' => BusinessSetting::where('id', 1)->select(['payment_info'])->first(),
    //     ];


    //     return view('dashboard.fund_add_admin', compact('data'));
    // }

    // public function FundSaveAdmin(Request $request)
    // {

    //     if (!Auth::user()->can('Fund Add')) {
    //         return redirect(route('home'));
    //     }


    //     $request->validate([
    //         'password' => 'required',
    //         'username' => 'required',
    //     ]);



    //     // verify password
    //     $password = $request->password;

    //     if (!Hash::check($password, Auth::user()->password)) {
    //         FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
    //         return back();
    //     }


    //     // validate username
    //     $user = User::where('username', $request->username)->first();

    //     if (!$user) {
    //         FlashMessageGenerator::generate('danger', 'User Not Found !');
    //         return back();
    //     }


    //     // Add in wallet
    //     Wallet::create([
    //         'from_id' => $user->id,
    //         'amount' => $request->amount,
    //         'remarks' => 'Added Fund',
    //         'status' => 1,
    //     ]);


    //     FlashMessageGenerator::generate('success', 'Fund Added !');
    //     return back();
    // }

    // public function verifyFund()
    // {

    //     if (!Auth::user()->can('Fund Verification')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object)[
    //         'funds' => Wallet::whereIn('remarks', ['Added Fund'])->get(),
    //     ];

    //     return view('dashboard.verify_fund', compact('data'));
    // }

    // public function FundVerification(Request $request)
    // {

    //     if (!Auth::user()->can('Fund Verification')) {
    //         return redirect(route('home'));
    //     }

    //     $walletId = $request->id;

    //     Wallet::findOrFail($walletId)->update([
    //         'status' => 1,
    //     ]);

    //     return $walletId;
    // }

    // public function memberPaymentViewAgent()
    // {

    //     $data = (object)[
    //         'funds' => Wallet::whereIn('remarks', ['Withdraw'])->with(['from', 'to'])->where('to_id', Auth::user()->id)->get(),
    //     ];

    //     return view('dashboard.verify_withdraws', compact('data'));
    // }


    // public function balanceTransferView()
    // {

    //     if (!Auth::user()->can('Balance Transfer')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object)[];

    //     return view('dashboard.balance_transfer', compact('data'));
    // }

    public function balanceTransfer(Request $request)
    {

        $request->validate([
            'transfer_amount' => 'required',
            'transfer_account' => 'required',
        ]);


        // verify password
        $password = $request->password;

        if (!Hash::check($password, Auth::user()->password)) {
            FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
            return back();
        }


        $walletAmount = Auth::user()->CashWallet();

        // verify user
        $user = User::findOrFail($request->transfer_account);

        if (!$user) {
            FlashMessageGenerator::generate('danger', 'Account Not Found !!');
            return back();
        }


        // check if transfer is more than balance

        $transferAmount = (float)$request->transfer_amount;

        if (bccomp($walletAmount, $transferAmount) == -1) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }


        // get transfer Charge
        $transfer_amount = $request->transfer_amount;

        $transferCharge = ($transfer_amount / 100) * 2;

        $transfer_amount = $request->transfer_amount - $transferCharge;


        // transfer balance
        Wallet::create([
            'from_id' => Auth::user()->id,
            'to_id' => $user->id,
            'amount' => $transfer_amount,
            'charge' => $transferCharge,
            'remarks' => 'Transfer',
            'status' => 1,
        ]);

        FlashMessageGenerator::generate('primary', 'Transferred !!');

        // return view
        return back();
    }

    public function balanceWithdrawViewAdmin()
    {

        $data = (object)[
            'withdrawFromUsers' => User::where('role', 4)->get(),
            'users' => User::where('role', 3)->get(),
        ];

        return view('admin.mlm.dashboard.balance_withdraw_admin', compact('data'));
    }


    public function balanceWithdrawAdminSave(Request $request)
    {

        $request->validate(
            [
                'user' => 'required',
                'withdraw_amount' => 'required',
                'password' => 'required',
                'withdraw_type' => 'required',
            ]
        );


        // please verify if user have complete withdraw account information if not hand cash
        $user = User::findOrFail($request->user);

        if ($request->withdraw_type != 'cash') {

            $getwayColumns = [
                'Rocket' => 'rocket_no',
                'bKash' => 'bKash_no',
                'Nagad' => 'nagad_no',
                'Bank' => 'bank_info',
            ];

            $withDrawType = $request->withdraw_type;
            $withDrawColumn = $getwayColumns[$withDrawType];

            if (!$user->$withDrawColumn) {
                FlashMessageGenerator::generate('danger', 'Please complete your withdraw account information !!');
                return back();
            }
        } else {

            // verify user if hand cash selected
            $withdrawUser = User::findOrFail($request->withdraw_from);

            if (!$withdrawUser) {
                FlashMessageGenerator::generate('danger', 'Account Not Found !!');
                return back();
            }
        }

        // verify password
        $password = $request->password;

        if (!Hash::check($password, Auth::user()->password)) {
            FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
            return back();
        }


        // check minimum amount
        if ($request->withdraw_amount < 200) {
            FlashMessageGenerator::generate('danger', 'Minimum withdraw amount is 200!!');
            return back();
        }

        // check if withdraw is more than balance

        $withDrawWalletAmount = $user->CashWallet();

        if ($withDrawWalletAmount < $request->withdraw_amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }




        // get withdraw Charge

        $withdraw_amount = $request->withdraw_amount;

        $withdrawCharge = ($withdraw_amount / 100) * 10;


        $withdraw_amount = $request->withdraw_amount - $withdrawCharge;

        $withdrawUserId = null;

        if ($request->withdraw_type == 'cash') {
            $withdrawUserId = $withdrawUser->id;
        }

        // withdraw balance
        Wallet::create([
            'from_id' => $user->id,
            'to_id' => $withdrawUserId,
            'amount' => $withdraw_amount,
            'charge' => $withdrawCharge,
            'payment_gateway' => $request->withdraw_type,
            'account_no' => $request->account_no,
            'remarks' => 'Withdraw',
            'status' => 1,
        ]);


        // show message
        FlashMessageGenerator::generate('primary', 'Success !!');

        // return view
        return back();
    }


    public function balanceWithdrawView()
    {

        $data = (object)[
            'withdrawFromUsers' => User::where('role', 4)->get(),
            'users' => User::where('role', 3)->orWhere('is_agent', 1)->get(),
        ];

        return view('admin.mlm.dashboard.balance_withdraw', compact('data'));
    }

    public function balanceWithdraw(Request $request)
    {

        $request->validate(
            [
                'withdraw_amount' => 'required',
                'password' => 'required',
                'withdraw_type' => 'required',
            ]
        );

        // please verify if user have complete withdraw account information if not hand cash
        if ($request->withdraw_type != 'cash') {

            $getwayColumns = [
                'Rocket' => 'rocket_no',
                'bKash' => 'bKash_no',
                'Nagad' => 'nagad_no',
                'Bank' => 'bank_info',
            ];

            $user = User::findOrFail(Auth::user()->id);

            $withDrawType = $request->withdraw_type;
            $withDrawColumn = $getwayColumns[$withDrawType];

            if (!$user->$withDrawColumn) {
                FlashMessageGenerator::generate('danger', 'Please complete your withdraw account information !!');
                return back();
            }
        } else {

            // verify user if hand cash selected
            $withdrawUser = User::findOrFail($request->withdraw_from);

            if (!$withdrawUser) {
                FlashMessageGenerator::generate('danger', 'Account Not Found !!');
                return back();
            }
        }

        // verify password
        $password = $request->password;

        if (!Hash::check($password, Auth::user()->password)) {
            FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
            return back();
        }


        // check minimum amount
        // if ($request->withdraw_amount < 200) {
        //     FlashMessageGenerator::generate('danger', 'Minimum withdraw amount is 200!!');
        //     return back();
        // }

        // check if withdraw is more than balance

        $withDrawWalletAmount = Auth::user()->CashWallet();

        if ($withDrawWalletAmount < $request->withdraw_amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }


        // get withdraw Charge

        $withdraw_amount = $request->withdraw_amount;

        $withdrawCharge = ($withdraw_amount / 100) * 10;


        $withdraw_amount = $request->withdraw_amount - $withdrawCharge;



        $withdrawUserId = null;

        if ($request->withdraw_type == 'cash') {
            $withdrawUserId = $withdrawUser->id;
        }

        // withdraw balance
        Wallet::create([
            'from_id' => Auth::user()->id,
            'to_id' => $withdrawUserId,
            'amount' => $withdraw_amount,
            'charge' => $withdrawCharge,
            'payment_gateway' => $request->withdraw_type,
            'account_no' => $request->account_no,
            'remarks' => 'Withdraw',
            'status' => 0,
        ]);


        // show message
        FlashMessageGenerator::generate('primary', 'Withdraw Requested Submitted. Withdraw takes upto 36 hours to process.');

        // return view
        return back();
    }

    public function dealerBalanceWithdrawView()
    {

        $data = (object)[
            'withdrawFromUsers' => User::where('role', 4)->get(),
            'users' => User::where('role', 3)->orWhere('is_agent', 1)->get(),
        ];

        return view('admin.mlm.dashboard.balance_withdraw_dealer', compact('data'));
    }

    public function dealerBalanceWithdraw(Request $request)
    {

        $request->validate(
            [
                'withdraw_amount' => 'required',
                'password' => 'required',
                'withdraw_type' => 'required',
            ]
        );

        // please verify if user have complete withdraw account information if not hand cash
        if ($request->withdraw_type != 'cash') {

            $getwayColumns = [
                'Rocket' => 'rocket_no',
                'bKash' => 'bKash_no',
                'Nagad' => 'nagad_no',
                'Bank' => 'bank_info',
            ];

            $user = User::findOrFail(Auth::user()->id);

            $withDrawType = $request->withdraw_type;
            $withDrawColumn = $getwayColumns[$withDrawType];

            if (!$user->$withDrawColumn) {
                FlashMessageGenerator::generate('danger', 'Please complete your withdraw account information !!');
                return back();
            }
        } else {

            // verify user if hand cash selected
            $withdrawUser = User::findOrFail($request->withdraw_from);

            if (!$withdrawUser) {
                FlashMessageGenerator::generate('danger', 'Account Not Found !!');
                return back();
            }
        }

        // verify password
        $password = $request->password;

        if (!Hash::check($password, Auth::user()->password)) {
            FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
            return back();
        }

        // check if withdraw is more than balance
        $withDrawWalletAmount = Auth::user()->dealerCommissionWallet();

        if ($withDrawWalletAmount < $request->withdraw_amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }


        // get withdraw Charge
        $withdraw_amount = $request->withdraw_amount;

        $withdrawCharge = ($withdraw_amount / 100) * 10;

        $withdraw_amount = $request->withdraw_amount - $withdrawCharge;

        $withdrawUserId = null;

        if ($request->withdraw_type == 'cash') {
            $withdrawUserId = $withdrawUser->id;
        }

        // withdraw balance
        Wallet::create([
            'from_id' => Auth::user()->id,
            'to_id' => $withdrawUserId,
            'amount' => $withdraw_amount,
            'charge' => $withdrawCharge,
            'payment_gateway' => $request->withdraw_type,
            'account_no' => $request->account_no,
            'remarks' => 'Withdraw',
            'status' => 0,
        ]);

        // show message
        FlashMessageGenerator::generate('primary', 'Withdraw Requested Submitted. Withdraw takes upto 36 hours to process.');

        // return view
        return back();
    }

    // withdraw approve start
    public function balanceWithdrawApproveView()
    {

        $data = (object)[
            'withdraws' => Wallet::with(['from'])->where('remarks', 'Withdraw')->whereNull('approved_by')->get(),
        ];

        return view('admin.mlm.dashboard.withdraw_approve', compact('data'));
    }


    public function balanceWithdrawApprove($withdrawId)
    {

        Wallet::findOrFail($withdrawId)->update([
            'approved_by' => Auth::user()->id,
        ]);

        FlashMessageGenerator::generate('primary', 'Withdraw Approved Successfully !!');

        return back();
    }

    public function balanceWithdrawReject($withdrawId)
    {

        Wallet::findOrFail($withdrawId)->delete();

        FlashMessageGenerator::generate('primary', 'Withdraw Rejected Successfully !!');

        return back();
    }


    // withdraw approve end


    // withdraw payment start
    public function balanceWithdrawPaymentView()
    {

        if (auth::user()->role == 4) {

            $withdraws = Wallet::with(['from', 'to'])
                ->where('remarks', 'Withdraw')
                ->where('to_id', auth::user()->id)
                ->where('payment_gateway', 'cash')
                ->whereNotNull('approved_by')
                ->where('status', 0)
                ->get();
        } else {

            $withdraws = Wallet::with(['from', 'to'])
                ->where('remarks', 'Withdraw')
                ->whereNotNull('approved_by')
                // ->where('payment_gateway', '!=', 'cash')
                ->where('status', 0)
                ->get();
        }

        $data = (object)[
            'withdraws' => $withdraws,
        ];

        return view('admin.mlm.dashboard.withdraw_payment', compact('data'));
    }

    public function balanceWithdrawPaymentVoucherPrint($withdrawId)
    {

        $title = "Payment Voucher";
        $wallet = Wallet::with(['from'])->where('id', $withdrawId)->first();

        $pdf = PDF::loadView('admin.mlm.dashboard.paymentVoucher', ['title' => $title, 'wallet' => $wallet], []);
        return $pdf->stream('payment-10000' . $wallet->id . '.pdf');
    }

    public function balanceWithdrawPayment(Request $request, $withdrawId)
    {

        $wallet = Wallet::findOrFail($withdrawId);

        $commissionAmount = ((float)$wallet->charge / 100) * 20;

        $withdrawUser = User::find($wallet->from_id);

        if ($withdrawUser->role != 4) {

            // add dealer commission
            Wallet::create([
                'from_id' => $wallet->to_id,
                'to_id' => $wallet->from_id,
                'amount' => $commissionAmount,
                'remarks' => 'DealerCommission',
                'status' => 1,
            ]);
        }


        // update payment status
        $wallet->update([
            'transaction_no' => $request->transaction_no,
            'status' => 1,
        ]);

        FlashMessageGenerator::generate('primary', 'Withdraw paid Successfully !!');

        return back();
    }
    // withdraw payment end



    // transfer approve start

    public function balanceTransferApproveView()
    {
        $data = (object)[
            'transfers' => Wallet::with(['from', 'to'])->where('remarks', 'Transfer')->where('status', 0)->get(),
        ];

        return view('admin.mlm.dashboard.transfer_approve', compact('data'));
    }


    function balanceTransferApprove($transferId)
    {
        Wallet::findOrFail($transferId)->update([
            'status' => 1,
        ]);

        FlashMessageGenerator::generate('primary', 'Transfer Approved Successfully !!');

        return back();
    }

    // transfer approve end




    // public function FundHistory(Request $request)
    // {

    //     if (!Auth::user()->can('Fund History')) {
    //         return redirect(route('home'));
    //     }

    //     $funds = [];

    //     $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
    //     $end_date_ui = Carbon::now()->format('d-m-Y');

    //     if ($request->has('start_date')) {
    //         $start_date_ui = date('d-m-Y', strtotime($request->start_date));
    //     }

    //     if ($request->has('end_date')) {
    //         $end_date_ui = date('d-m-Y', strtotime($request->end_date));
    //     }

    //     if ($request->has('start_date')) {

    //         $start_date = date('Y-m-d', strtotime($request->start_date));
    //         $end_date = date('Y-m-d', strtotime($request->end_date));

    //         $funds = Wallet::where('remarks', 'Added Fund')
    //             ->with(['from'])
    //             ->whereDate('created_at', '>=', $start_date)
    //             ->whereDate('created_at', '<=', $end_date);



    //         if ($request->username != "") {

    //             $funds = $funds->where('from_id', $request->username);
    //         }

    //         $funds = $funds->get();
    //     }

    //     $data = (object)[
    //         'start_date_ui' => $start_date_ui,
    //         'end_date_ui' => $end_date_ui,
    //         'users' => User::select(['id', 'username'])->where('rank', '!=', 'Founder')->get(),
    //         'funds' => $funds,
    //         'totalFunds' => Wallet::where('remarks', 'Added Fund')
    //             ->sum('amount'),
    //     ];

    //     return view('dashboard.fund_history', compact('data'));
    // }

    // public function FundDelete($id)
    // {

    //     Wallet::findOrFail($id)->delete();
    // }


    public function paymentRequestReport(Request $request)
    {

        $title = "Payment Request Report";

        $reports = [];

        $start_date_ui = Carbon::now()->startOfMonth()->format('d-m-Y');
        $end_date_ui = Carbon::now()->format('d-m-Y');

        if ($request->searched) {

            if ($request->has('start_date')) {
                $start_date_ui = date('d-m-Y', strtotime($request->start_date));
            }

            if ($request->has('end_date')) {
                $end_date_ui = date('d-m-Y', strtotime($request->end_date));
            }

            $params = [
                'dateRange' => [
                    'start_date' => date('Y-m-d', strtotime($request->start_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                ],
                'user_type' => $request->user_type,
                'payment_way' => $request->payment_way,
                'payment_status' => $request->payment_status,
                'dealer' => $request->dealer,
            ];

            $paymentRequestReport = new PaymentRequestReport($params);

            $reports = $paymentRequestReport->getReport();

        }

        $data = (object)[
            'start_date_ui' => $start_date_ui,
            'end_date_ui' => $end_date_ui,
            'reports' => $reports,
            'dealers' => User::where('role', 4)->get(),
        ];

        if ($request->submitType == "print") {

            $pdf = PDF::loadView('admin.paymentLog.payment_request_print', compact('title', 'data'))->setPaper('a4', 'landscape');

            return $pdf->stream('payment_request.pdf');
        }

        return view('admin.paymentLog.payment_request_report', compact('title', 'data'));
    }
}
