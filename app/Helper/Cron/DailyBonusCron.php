<?php

namespace App\Helper\Cron;

use App\User;
use App\Wallet;
use App\BusinessSetting;
use Illuminate\Support\Carbon;

class DailyBonusCron
{


    public static function checkNewEligibleMembers()
    {
        $users = User::select('id')->where('status', 1)->whereNull('daily_bonus_end_date')->get();

        foreach ($users as $user) {

            $eligible = false;

            $hands = [
                'hand1' => $user->referActiveMemberCount(1),
                'hand2' => $user->referActiveMemberCount(2),
                'hand3' => $user->referActiveMemberCount(3),
            ];

            $tempBoolArr = [];
            foreach ($hands as $key => $value) {

                if ($value >= 4) {
                    array_push($tempBoolArr, true);
                } else {
                    array_push($tempBoolArr, false);
                }
            }

            if ($tempBoolArr[0] && $tempBoolArr[1] && $tempBoolArr[2]) {
                $eligible = true;
            }


            if ($eligible) {

                $now = Carbon::now();
                $endDate = $now->addMonths(6);

                $user->update([
                    'daily_bonus_end_date' => $endDate,
                ]);
            }
        }
    }

    public static function AddBonusAmount()
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['daily_bonus'])->first();
        $now = Carbon::now();

        $users = User::where('status', 1)->where('daily_bonus_end_date', '>=', $now->format('Y-m-d h:i:s'))->get();


        foreach ($users as $user) {

            // check if already added
            $already_added = Wallet::where('remarks', 'DailyBonus')->where('from_id', $user->id)->whereDate('created_at', $now->format('Y-m-d'))->count();

            if($already_added){
                continue;
            }


            // add amount
            Wallet::create([
                'from_id' => $user->id,
                'amount' => $businessSettings->daily_bonus,
                'remarks' => 'DailyBonus',
                'status' => 1,
            ]);
        }
    }

    public static function runSchedule()
    {

        self::checkNewEligibleMembers();

        self::AddBonusAmount();

    }

}
