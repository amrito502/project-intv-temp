<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\User;
use App\Thana;
use App\Wallet;
use Illuminate\Http\Request;
use App\Helper\Flatten\Flatten;
use App\Helper\Cron\RankBonus;
use App\BusinessSetting;
use App\Helper\Cron\SetUserRank;
use App\Helper\Cron\ExpireMembers;
use Illuminate\Support\Collection;
use App\Helper\Cron\DailyBonusCron;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helper\Cron\FounderBonusCron;
use App\Helper\Ui\FlashMessageGenerator;

class APIController extends Controller
{

    public function usernameExists(Request $request)
    {

        $username = $request->data['username'];

        $user = User::where('username', $username)->count();

        $userExists = $user > 0 ? 'yes' : 'no';

        return $userExists;

    }

    public function getUserById($id)
    {

        $user = User::findOrFail($id);
        $balance = $user->SuccessWallet();

        return [
            'user' => $user,
            'balance' => $balance,
        ];

    }

    public function getReferenceHands(Request $request)
    {

        $ReferenceId = $request->ReferenceId;

        $referenceHands = User::where('referral', $ReferenceId)->select(['hand_id'])->get()->pluck('hand_id')->toArray();

        return $referenceHands;
    }

    public function getUserHandCount($userId)
    {

        $user = User::findOrFail($userId);

        $hands = [
            $user->DownLevelMemberAllIdsWithHandCount(1),
            $user->DownLevelMemberAllIdsWithHandCount(2),
            $user->DownLevelMemberAllIdsWithHandCount(3)
        ];

        return $hands;
    }

    public function getUserRankPoint($userId)
    {

        $user = User::findOrFail($userId);

        $hands = [
            $user->downLevelAllReferWhereRankIsMemberPoint(1),
            $user->downLevelAllReferWhereRankIsMemberPoint(2),
            $user->downLevelAllReferWhereRankIsMemberPoint(3)
        ];

        return $hands;
    }


    public static function getReferralReferenceStaticCall($ReferenceId = null)
    {

        if ($ReferenceId == null) {
            return [];
        }

        $businessSettings = BusinessSetting::where('id', 1)->select(['person_per_level'])->first();

        $selectedUser = User::findOrFail($ReferenceId);

        $ids = $selectedUser->DownLevelMemberIds();

        $userWhereHandIsFree = [];

        $users = User::whereIn('id', $ids)->select(['username', 'id'])->get();


        foreach ($users as $user) {

            $hands = $user->hands();

            if ($hands->count() != $businessSettings->person_per_level) {
                array_push($userWhereHandIsFree, $user);
            }

        }

        if ($selectedUser->hands()->count() != $businessSettings->person_per_level) {
            array_push($userWhereHandIsFree, $selectedUser);
        }

        return $userWhereHandIsFree;
    }

    public function getReferralReference(Request $request)
    {

        $ReferenceId = $request->ReferenceId;

        if ($ReferenceId == null) {
            return [];
        }

        // $businessSettings = BusinessSetting::where('id', 1)->select(['person_per_level'])->first();

        $selectedUser = User::findOrFail($ReferenceId);

        $ids = $selectedUser->DownLevelMemberIds();


        $userWhereHandIsFree = [];

        $users = User::whereIn('id', $ids)->select(['username', 'id'])->get();


        foreach ($users as $user) {

            $hands = $user->hands();

            if ($hands->count() != 10) {
                array_push($userWhereHandIsFree, $user);
            }

        }

        if ($selectedUser->hands()->count() != 10) {
            array_push($userWhereHandIsFree, $selectedUser);
        }

        return $userWhereHandIsFree;
    }

    public function rankBonus()
    {
        RankBonus::runSchedule();
    }

    public function getDistrictWiseThanas(Request $request)
    {

        $thanas = Thana::select(['id', 'name'])->where('district_id', $request->districtId)->get();

        return $thanas;
    }


    public function removeAdvFromCookie($adID)
    {

        $todayAds = json_decode($_COOKIE['TodayAds_'. Auth::user()->id], true);
        $todayAds = new Collection($todayAds);

        $todayAds = $todayAds->filter(function ($item) use ($adID) {
            return $item['id'] != $adID;
        });

        setcookie('TodayAds_'. Auth::user()->id, $todayAds, time() + (3600 * 24), "/");

        // $_COOKIE['todayAds'] = $todayAds;

        // dd($_COOKIE);
    }

    public function convertWalletFunds(Request $request)
    {


        $walletTypes = [
            'dailyWallet' => ['Daily', 'ADV BONUS'],
            'rankWallet' => ['RankBonus'],
            'FounderWallet' => ['FounderBonus'],
        ];

        $remarks = [
            'success' => 'Reference',
            'fund' => 'Added Fund',
            'founder' => 'FounderBonus',
        ];

        // dd($request);


        // verify password
        $password = $request->password;


        // add converted
        $amount = $request->amount;

        if (!Hash::check($password, Auth::user()->password)) {
            FlashMessageGenerator::generate('danger', 'Incorrect Password !!');
            return back();
        }

        $totalCurrentSum = Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', $walletTypes[$request->wallet])->where('status', 1)->sum('amount');

        // check if transfer is more than balance
        if ($totalCurrentSum < $request->amount) {
            FlashMessageGenerator::generate('danger', 'Insufficient fund !!');
            return back();
        }


        // if amount is minimum
        if ($request->wallet == 'dailyWallet') {

            if ($request->amount < 200) {

                FlashMessageGenerator::generate('danger', 'Minimum Convert Amount is 200!!');
                return back();
            }
        }

        if ($request->wallet == 'FounderWallet') {

            if ($request->amount < 200) {

                FlashMessageGenerator::generate('danger', 'Minimum Convert Amount is 200!!');
                return back();
            }
        }

        // transfer charge on convert to fund

        $transferCharge = 0;

        if ($request->type == 'fund') {
            $businessSettings = BusinessSetting::findOrFail(1);

            $transferCharge = $businessSettings->transferChargeOf($request->amount);

        }

        $amount = $amount - $transferCharge;

        // remove all
        Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', $walletTypes[$request->wallet])->where('status', 1)->delete();

        Wallet::create([
            'from_id' => Auth::user()->id,
            'amount' => $amount,
            'charge' => $transferCharge,
            'remarks' => $remarks[$request->type],
            'status' => 1,
        ]);


        // add rest of the amount

        $restOftheBalance = $totalCurrentSum - $request->amount;

        Wallet::create([
            'from_id' => Auth::user()->id,
            'amount' => $restOftheBalance,
            'remarks' => $walletTypes[$request->wallet][0],
            'status' => 1,
        ]);


        FlashMessageGenerator::generate('success', 'Balance Converted');
        return back();

        // dd($request);
    }

}
