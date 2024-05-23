<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Notice;
use App\Models\Wallet;
use Carbon\CarbonPeriod;
use App\Models\RankSetting;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use App\Models\RankAchivement;
use App\Models\BusinessSetting;
use App\Models\GenerationSetting;
use App\Helper\Dashboard\CardData;
use Illuminate\Support\Facades\Auth;
use App\Helper\Ui\DiskSizeCalculator;
use Illuminate\Support\Facades\Storage;
use App\Helper\Ui\FlashMessageGenerator;

class HomeController extends Controller
{


    public function dayWiseUserCount()
    {
        $today = Carbon::now();
        $startDate = Carbon::now()->subDays(15);

        $dates = CarbonPeriod::create($startDate->format('Y-m-d'), $today->format('Y-m-d'));

        $dayWiseUsers = [];

        foreach ($dates as $date) {

            $users = User::role(['Customer'])->whereDate('created_at', $date->format('Y-m-d'))->count();

            $dayWiseUsers[] = [
                $date->format('d'), $users
            ];
        }

        return $dayWiseUsers;
    }

    public function dateWisePaymentFlow()
    {
        $today = Carbon::now();
        $startDate = Carbon::now()->subDays(15);

        $dates = CarbonPeriod::create($startDate->format('Y-m-d'), $today->format('Y-m-d'));

        $dayWisePayments = [];

        foreach ($dates as $date) {

            // day Income
            $todayIncomeByAccountCreation = Wallet::where('remarks', 'Account Purchase')->whereDate('created_at', $date->format('Y-m-d'))->sum('amount');
            $todayIncomeByCharges =  Wallet::whereIn('remarks', ['Withdraw', 'Transfer'])->whereDate('created_at', $date->format('Y-m-d'))->sum('charge');
            $todayTotalIncome = $todayIncomeByCharges + $todayIncomeByAccountCreation;

            // today payment
            $todayPayment =  Wallet::whereIn('remarks', ['Withdraw'])->whereDate('created_at', $date->format('Y-m-d'))->sum('amount');

            $dayWisePayments[] = [
                'date' => $date->format('d'),
                'income' => $todayTotalIncome,
                'Expense' => $todayPayment,
            ];
        }

        return $dayWisePayments;
    }


    public function index()
    {

        // $time_start = microtime(true);

        $data = (object)[];

        $rankCardColors = [
            ['#9a9a9a', '#bbbaba'],
            ['#A46629', '#CD7F34'],
            ['#018549', '#01A65A'],
            ['#B45564', '#E06064'],
            ['#5298a0', '#56B6C2'],
            ['#3D6Ca0', '#3D6CD1'],
            ['#dea485', '#FFC1a0'],
            ['#4d12b9', '#722DF0'],
        ];

        if (Auth::user()->hasRole(['Customer'])) {


            $data = (object)[
                // 'disksize_data' => DiskSizeCalculator::getDiskSize()[0],
                'successWallet' => Auth::user()->SuccessWallet(),
                'rankWallet' => Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', ['RankBonus'])->where('status', 1)->sum('amount'),
                'dailyIncome' => Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', ['Daily', 'ADV BONUS'])->where('status', 1)->sum('amount'),
                'earningIncome' => Auth::user()->earningIncome(),
                // 'totalWithdraw' => Auth::user()->totalExpense(),
                'receiveAmount' => Auth::user()->FundWallet(),
                // 'rechargeAmount' => Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', ['Recharge'])->where('status', 1)->sum('amount'),
                // 'transferAmount' => Wallet::where('from_id', Auth::user()->id)->whereIn('remarks', ['Transfer'])->where('status', 1)->sum('amount'),
                'withdrawAmount' => Auth::user()->withdrawWallet(),

                'pp' => Auth::user()->pp(),

                'ranks' => RankSetting::select(['rank_name', 'id'])->get(),
                'rankCardColors' => $rankCardColors,

                'lastNotice' => Notice::orderBy('id', 'desc')->first(),

            ];
        }

        if (Auth::user()->hasRole(['Software Admin', 'System Admin'])) {

            // today payment
            $todayPayment =  Wallet::whereIn('remarks', ['Withdraw'])->whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('status', 1)->sum('amount');

            // total payment
            $totalPayment =  Wallet::whereIn('remarks', ['Withdraw'])->where('status', 1)->sum('amount');

            // total withdraw Request
            $totalWithdrawRequestPending =  Wallet::whereIn('remarks', ['Withdraw'])->where('status', 0)->sum('amount');


            $data = (object)[
                'ranks' => RankSetting::select(['rank_name', 'id'])->get(),
                'totalMembers' => User::role(['Customer'])->count(),
                'todayMembers' => User::role(['Customer'])->whereDate('created_at', Carbon::now()->format('Y-m-d'))->count(),
                'todayIncome' => CardData::TodayTotalIncome(),
                'totalIncome' => CardData::TotalIncome(),
                'todayPayment' => $todayPayment,
                'totalPayment' => $totalPayment,
                // 'dateWiseUsers' => $this->dayWiseUserCount(),
                'dateWisePaymentFlow' => $this->dateWisePaymentFlow(),
                'rankCardColors' => $rankCardColors,
                'totalFundWallet' => CardData::TotalFundWallet(),
                'totalSuccessWallet' => CardData::TotalSuccessWallet(),
                'totalWithdrawRequestPending' => $totalWithdrawRequestPending,
            ];
        }

        // $time_end = microtime(true);

        //dividing with 60 will give the execution time in minutes otherwise seconds
        // $execution_time = ($time_end - $time_start);
        // $execution_time = ($time_end - $time_start) / 60;

        // dd($execution_time);

        return view('dashboard.layouts.home', compact('data'));
    }

    public function rankWiseMembers($id)
    {

        $data = (object)[];

        if (Auth::user()->hasRole(['Customer'])) {

            $rankWMembers = RankSetting::where('id', $id)->with(['members'])->whereHas('members', function ($q) {
                $q->orWhereIn('id', Auth::user()->DownLevelMemberIds());
            })->first();

            $data->rankWMembers =  $rankWMembers;

            $data->rank =  RankSetting::where('id', $id)->first();
        } else {
            $data->rank =  RankSetting::where('id', $id)->with(['members'])->first();
            $data->rankWMembers =  RankSetting::where('id', $id)->with(['members'])->first();
        }

        return view('dashboard.rank_wise_members', compact('data'));
    }

    public function siteSettingView()
    {

        if (!Auth::user()->can('System Settings')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'settings' => SiteSetting::findOrFail(1),
        ];

        return view('dashboard.SiteSetting', compact('data'));
    }

    public function siteSetting(Request $request)
    {

        if (!Auth::user()->can('System Settings')) {
            return redirect(route('home'));
        }

        $setting = SiteSetting::findOrFail(1);

        // dd($request);

        if ($request->has('site_logo')) {

            // delete old file
            Storage::delete($request->old_image);

            // upload new file
            $file = $request->file('site_logo')->store('public/sitesetting');
            $file = explode('/', $file);
            $file = end($file);
        } else {
            $file = $request->old_image;
        }

        // save data

        $setting->update([
            'website_name' => $request->website_name,
            'website_logo' => $file,
        ]);

        FlashMessageGenerator::generate('primary', 'Site Setting Updated');

        return back();
    }

    public function walletwiseMembers(Request $request)
    {

        if (!Auth::user()->can('WalletWise Members')) {
            return redirect(route('home'));
        }

        $members = User::role('Customer')->orderBy('id', 'desc')->with(['refMember'])->select(['id', 'username', 'name', 'mobile'])->get();

        $data = (object)[
            'members' => $members,
        ];

        return view('dashboard.user.walletwise_members', compact('data'));
    }
}
