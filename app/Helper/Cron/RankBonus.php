<?php

namespace App\Helper\Cron;

use App\User;
use App\Wallet;
use App\RankSetting;

class RankBonus
{

    public static function runSchedule()
    {

        self::ExecutiveBonus('Executive', 'executive_bonus_status');
        self::ExecutiveBonus('Sr. Executive', 'sr_executive_status_bonus');
        self::ExecutiveBonus('Astt. Manager', 'asst_manager_bonus_status');
        self::ExecutiveBonus('Manager', 'manager_bonus_status');
        self::ExecutiveBonus('Sr. Manager', 'sr_manager_bonus_status');
        self::ExecutiveBonus('AGM', 'agm_bonus_status');
        self::ExecutiveBonus('DGM', 'dgm_bonus_status');
        self::ExecutiveBonus('GM', 'gm_bonus_status');
    }


    public static function ExecutiveBonus($rank, $rank_wallet_col)
    {

        $users = User::where('rank', $rank)->get();
        $userCount = $users->count();
        $rank_setting = RankSetting::where('rank_short_name', $rank)->first();

        if ($userCount < 1) {
            return back();
        }

        $totalExecutiveBonusIds = Wallet::where('remarks', 'ConversionToCash')->where($rank_wallet_col, 0)->select('id')->get()->pluck('id')->toArray();
        $totalExecutiveBonusCount = count($totalExecutiveBonusIds);

        if ($totalExecutiveBonusCount < 1) {
            return back();
        }

        $totalExecutiveBonusAmount = $totalExecutiveBonusCount * $rank_setting->cash_bonus;

        $perExecutiveBonus = $totalExecutiveBonusAmount / $userCount;


        foreach ($users as $user) {

            // add executive bonus
            Wallet::create([
                'from_id' => $user->id,
                'amount' => $perExecutiveBonus,
                'remarks' => 'Cash',
                'status' => 1,
            ]);
        }


        // update executive bonus status
        Wallet::whereIn('id', $totalExecutiveBonusIds)->update([
            $rank_wallet_col => 1,
        ]);
    }
}
