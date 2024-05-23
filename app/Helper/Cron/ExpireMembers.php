<?php

namespace App\Helper\Cron;

use App\Models\User;
use App\Models\BusinessSetting;

class ExpireMembers
{

    public static function runSchedule()
    {

        $businessSettings = BusinessSetting::where('id', 1)->select(['account_expire_after_joining'])->first();

        $users = User::select('id')->where('status', 1)->get();

        foreach ($users as $userId) {

            $user = User::findOrFail($userId->id);

            if ($user->DaysSinceJoined() > $businessSettings->account_expire_after_joining) {
                
                $user->update([
                    'status' => 0
                ]);
                
            }

        }

    }
}
