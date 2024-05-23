<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Models\BalanceReduceLog;
use App\Models\BalanceTransferLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helper\Ui\FlashMessageGenerator;

class BalanceTransferController extends Controller
{

    public function index()
    {

        if (!Auth::user()->can('Admin Balance Transfer')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'members' => User::role('Customer')->get(),
        ];


        return view('dashboard.balance_transfer_admin', compact('data'));
    }


    public function AdminBalanceTransfer(Request $request)
    {

        if (!Auth::user()->can('Admin Balance Transfer')) {
            return redirect(route('home'));
        }

        $request->validate([
            'from' => 'required',
            'to' => 'required',
            'transfer_amount' => 'required',
        ]);

        $fromUser = User::findOrFail($request->from);

        $walletAmount = $fromUser->SuccessWallet();

        // check if transfer is more than balance
        if ($walletAmount < $request->transfer_amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }


        $transferCharge = 0;
        $transfer_amount = $request->transfer_amount - $transferCharge;

        // transfer balance
        Wallet::create([
            'from_id' => $request->from,
            'to_id' => $request->to,
            'amount' => $transfer_amount,
            'charge' => $transferCharge,
            'remarks' => 'Transfer',
            'transfer_from' => 'success_wallet',
            'status' => 1,
        ]);


        // add log
        BalanceTransferLog::create([
            'from_id' => $request->from,
            'to_id' => $request->to,
            'amount' => $transfer_amount,
        ]);



        // show message
        FlashMessageGenerator::generate('primary', 'Balance Transferred Successfully !!');


        // return view
        return back();
    }


    public function reduceIndex()
    {

        if (!Auth::user()->can('Admin Balance Reduce')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'members' => User::role('Customer')->get(),
        ];


        return view('dashboard.balance_reduce_admin', compact('data'));
    }


    public function AdminBalanceReduce(Request $request)
    {

        $user = User::findOrFail($request->from);

        $walletAmount = $user->SuccessWallet();
        $reduceAmount = $request->amount;
        $newBalance = $walletAmount - $reduceAmount;


        // if reduce is more than wallet
        if ($walletAmount < $request->amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }

        // remove all
        Wallet::where('from_id', $user->id)->whereIn('remarks', ['Reference', 'Generation'])->where('status', 1)->delete();
        // $count = Wallet::where('from_id', $user->id)->whereIn('remarks', ['Reference', 'Generation'])->where('status', 1)->sum('amount');

        // create with new balance
        Wallet::create([
            'from_id' => $user->id,
            'amount' => $newBalance,
            'remarks' => 'Generation',
            'status' => 1,
        ]);


        // add log
        BalanceReduceLog::create([
            'from_id' => $user->id,
            'amount' => $reduceAmount,
        ]);

        return back();
    }


    public function balanceReductionLog()
    {

        $logs = BalanceReduceLog::with(['from'])->get();

        $data = (object)[
            'members' => User::role('Customer')->get(),
            'logs' => $logs,
        ];

        return view('dashboard.admin_balance_reduce_log', compact('data'));
    }

    public function balanceTransferLog()
    {

        $logs = BalanceTransferLog::with(['from', 'to'])->get();

        $data = (object)[
            'members' => User::role('Customer')->get(),
            'logs' => $logs,
        ];

        return view('dashboard.admin_balance_transfer_log', compact('data'));
    }
}
