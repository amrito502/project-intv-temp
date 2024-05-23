<?php

namespace App\Helper\Dashboard;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CardData
{

    public static function TotalIncome()
    {
        // total Income
        $TotalIncomeByAccountCreation = Wallet::where('remarks', 'Account Purchase')->sum('amount');
        $TotalIncomeByCharges =  Wallet::whereIn('remarks', ['Transfer'])->sum('charge');
        $withdrawIncome = Wallet::where('to_id', Auth::user()->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');

        $totalIncome = $TotalIncomeByAccountCreation + $TotalIncomeByCharges + $withdrawIncome;

        return $totalIncome;
    }

    public static function TodayTotalIncome()
    {
        // todayIncome
        $todayIncomeByAccountCreation = Wallet::where('remarks', 'Account Purchase')->whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('amount');
        $todayIncomeByCharges =  Wallet::whereIn('remarks', ['Transfer'])->whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('charge');
        $withdrawIncome = Wallet::where('to_id', Auth::user()->id)->whereIn('remarks', ['Withdraw'])->where('status', 1)->whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('charge');
       
        $todayTotalIncome = $todayIncomeByCharges + $todayIncomeByAccountCreation + $withdrawIncome;

        return $todayTotalIncome;
    }

    public static function TotalFundWallet()
    {

        // incomes
        $transferedAmount = Wallet::whereIn('remarks', ['Transfer'])->where('status', 1)->sum('amount');
        $addedFund = Wallet::whereIn('remarks', ['Added Fund'])->where('status', 1)->sum('amount');

        $totalIncomes = $transferedAmount + $addedFund;

        // expenses
        $expense = Wallet::whereIn('remarks', ['Account Purchase'])->where('payment_gateway', 'Account Wallet')->where('status', 1)->sum('amount');
        $transferMinus = Wallet::whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('amount');
        $charges = Wallet::whereIn('remarks', ['Transfer'])->where('transfer_from', 'fund_wallet')->where('status', 1)->sum('charge');

        $totalExpense = $expense + $transferMinus + $charges;

        // final wallet Amount
        $receiveAmount = $totalIncomes - $totalExpense;

        return $receiveAmount;
    }


    public static function TotalSuccessWallet()
    {
        // income
        $totalIncome = Wallet::whereIn('remarks', ['Reference', 'Generation'])->where('status', 1)->sum('amount');

        // expenses
        $Expense = Wallet::whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('amount');
        $Charge = Wallet::whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('charge');
        $transferMinus = Wallet::whereIn('remarks', ['Transfer'])->where('transfer_from', 'success_wallet')->where('status', 1)->sum('amount');

        $totalExpense = $Expense + $Charge + $transferMinus;

        $SuccessWallet = $totalIncome - $totalExpense;

        return $SuccessWallet;
    }
}
