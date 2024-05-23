<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Cron\RankBonus;
use App\Helper\Cron\SetUserRank;
use App\Helper\Cron\ConvertPoints;
use App\Http\Controllers\Controller;

class AdminButtonsController extends Controller
{

    public function buttonsView()
    {

        $title = "Admin Buttons";
        $data = (object)[];

        return view('admin.admin_buttons')->with(compact('title', 'data'));
    }

    public function setUserRanks()
    {
        SetUserRank::runSchedule();

        return back()->with('msg', "Ranks Updated");
    }


    public function convertUserPoints()
    {
        ConvertPoints::runSchedule();
        return back()->with('msg', "Points Converted");
    }

    public function rankUserBonus()
    {

        RankBonus::runSchedule();

        return back()->with('msg', "Bonus Added");
    }
}
