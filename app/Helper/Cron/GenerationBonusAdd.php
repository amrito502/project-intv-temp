<?php

namespace App\Helper\Cron;

use App\Models\BusinessSetting;
use App\Models\GenerationSetting;
use App\Models\User;
use App\Models\Wallet;

class TeamBonusAdd
{

    public static function addTeamBonusToUpperLevel($userId)
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['number_of_level'])->first();
        $generationSettings = GenerationSetting::all();
        $user = User::findOrFail($userId);

        $referralId = $user->referral;

        for ($i = 1; $i < $businessSettings->number_of_level + 1; $i++) {


            // get current level bonus
            $levelBonus = $generationSettings->where('level_no', $i)->first()->bonus_amount;

            // get reference user
            $refUser = User::where('id', $referralId)->select(['referral', 'status'])->first();

            if ($refUser->status == 0) {
                continue;
            }

            Wallet::create([
                'from_id' => $referralId,
                'amount' => $levelBonus,
                'remarks' => 'Generation',
                'status' => 1,
            ]);


            if ($refUser->referral == null || $refUser->referral == '') {
                break;
            }

            // set referralId to upper level ref id.
            $referralId = $refUser->referral;
        }
    }
}
