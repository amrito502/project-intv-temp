<?php

namespace App\Helper\Cron;

use App\User;
use App\Wallet;


class ConvertPoints
{

    public static function runSchedule()
    {

        $users = User::where('status', 1)->get();

        foreach ($users as $user) {

            $userPoint = $user->PointWallet();

            while($userPoint >= 100){

                // reduct point
                Wallet::create([
                    'from_id' => $user->id,
                    'pp' => 100,
                    'remarks' => 'ConversionToCash',
                    'status' => 1,
                ]);

                // add cash
                Wallet::create([
                    'from_id' => $user->id,
                    'amount' => 150,
                    'remarks' => 'Cash',
                    'status' => 1,
                ]);

                $userPoint -= 100;
            }

        }

    }


}
