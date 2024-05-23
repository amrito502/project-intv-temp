<?php

namespace App\Helper\Cron;

use Carbon\Carbon;
use App\User;
use App\Wallet;
use App\RankSetting;
use App\RankAchivement;
use App\BusinessSetting;

class SetUserRank
{

    public static function runSchedule()
    {

        $userids = User::select('id')->where('status', 1)->get();

        foreach ($userids as $userId) {

            $user = User::findOrFail($userId->id);

            $hands = [
                'hand1' => $user->referMemberActivePackage(1),
                'hand2' => $user->referMemberActivePackage(2),
                'hand3' => $user->referMemberActivePackage(3),
            ];


            // check rank achivement and get rank id

            $rankAchivement = RankAchivement::where(function ($q) use ($hands) {

                $q->where('achivement', '<=', $hands['hand1'])
                    ->where('achivement', '<=', $hands['hand2'])
                    ->where('achivement', '<=', $hands['hand3']);

            })->orderBy('id', 'desc')->first();


            if (!$rankAchivement) {
                continue;
            }

            $rank = RankSetting::where('sequence_no', $rankAchivement->rank_sequence_id)->first();

            if(!$rank){
                continue;
            }


            if($rank->rank_short_name ==  $user->rank){
                continue;
            }

            $user->update([
                'rank' => $rank->rank_short_name,
                'rank_date' => Carbon::now()->toDateTimeString(),
            ]);


        }
    }
}
