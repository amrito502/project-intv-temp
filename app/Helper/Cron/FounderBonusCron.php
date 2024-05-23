<?php

namespace App\Helper\Cron;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Carbon;
use App\Models\BusinessSetting;
use Illuminate\Support\Facades\Auth;

class FounderBonusCron
{


    public static function runSchedule()
    {
        $todayIncomeByAccountCreation = Wallet::where('remarks', 'Account Purchase')->whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('amount');
        $todayIncomeByCharges =  Wallet::whereIn('remarks', ['Withdraw', 'Transfer'])->whereDate('created_at', Carbon::now()->format('Y-m-d'))->sum('charge');
        $TodayIncome = $todayIncomeByCharges + $todayIncomeByAccountCreation;

        $percentOfTodayIncome = ($TodayIncome / 100) * 1;

        $users = User::where('status', 1)->where('is_founder', 1)->get();

        $totalFounderCountToday = $users->count();

        $bonusPerMember = $percentOfTodayIncome / $totalFounderCountToday;

        foreach ($users as $user) {

            // check if already have founder bonus today
            $haveTodayBonus = Wallet::where('from_id', $user->id)->where('remarks', 'FounderBonus')->whereDate('created_at', Carbon::now()->format('Y-m-d'))->first();

            if ($haveTodayBonus) {
                continue;
            }

            Wallet::create([
                'from_id' => $user->id,
                'amount' => $bonusPerMember,
                'remarks' => 'FounderBonus',
                'status' => 1,
            ]);
        }
    }
}
