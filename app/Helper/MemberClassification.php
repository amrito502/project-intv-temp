<?php

namespace App\Helper;

use App\User;


class MemberClassification
{

    public static function updateMemberClassification(User $user)
    {
        // get user total income points
        $totalIncomePoints = $user->totalPointIncome();

        // update member classification depending on point

        $memberType = "Customer";

        if ($totalIncomePoints >= 100) {
            $memberType = "Member";
        }


        if ($totalIncomePoints >= 500) {
            $memberType = "Starter";
        }


        // update User Member Type
        if ($memberType == "Member") {

            if ($user->rank != "Member") {
                $user->rank = "Member";
                $user->member_rank_date = date('Y-m-d H:i:s');
            }

        }

        if ($user->member_type != $memberType) {
            $user->rank_date = date('Y-m-d H:i:s');
            $user->member_type = $memberType;
        }

        $user->save();
    }
}
