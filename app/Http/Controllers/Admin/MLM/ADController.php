<?php

namespace App\Http\Controllers\Admin\MLM;

use App\Http\Controllers\Controller;

use App\Models\AD;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

use App\Helper\Ui\FlashMessageGenerator;
use function Symfony\Component\String\b;
use Yajra\DataTables\Facades\DataTables;

class ADController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (!Auth::user()->can('AD List')) {
            return redirect(route('home'));
        }

        if ($request->ajax()) {

            $roles = AD::query();

            return DataTables::eloquent($roles)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {

                    $img = '<img src="' . asset('/storage/ad/' . $row->img) . '" class="img-fluid w-25" alt="ad">';

                    return $img;
                })
                ->addColumn('action', function ($row) {

                    $btn = "";

                    if (Auth::user()->can('edit ad')) {
                        $btn = $btn . '<a href="' . route('ad.edit', $row->id) . '" class="edit btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
                        Edit</a> &nbsp;';
                    }

                    if (Auth::user()->can('delete ad')) {
                        $btn = $btn . "<button type='button' onclick='deleteRow(" . $row->id . ")' class='edit btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i>Delete</button>";
                    }


                    return $btn;
                })
                ->rawColumns(['image', 'action'])
                ->toJson();
        }

        return view('dashboard.ad.ad_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (!Auth::user()->can('ad create')) {
            return redirect(route('home'));
        }

        $data = (object) [];

        return view('dashboard.ad.create_ad', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->can('ad create')) {
            return redirect(route('home'));
        }

        $request->validate([
            'image' => 'required'
        ]);

        if ($request->has('image')) {
            // upload new file
            $file = $request->file('image')->store('public/ad');
            $file = explode('/', $file);
            $file = end($file);
        }

        AD::create([
            'img' => $file,
        ]);

        FlashMessageGenerator::generate('success', 'Ad Added !');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AD  $aD
     * @return \Illuminate\Http\Response
     */
    public function show(AD $aD)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AD  $aD
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (!Auth::user()->can('edit ad')) {
            return redirect(route('home'));
        }

        $ad = AD::findOrFail($id);

        $data = (object) [
            'ad' => $ad,
        ];

        return view('dashboard.ad.ad_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AD  $aD
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'image' => 'required'
        ]);

        $ad = AD::findOrFail($id);

        Storage::delete($ad->img);

        if ($request->has('image')) {
            // upload new file
            $file = $request->file('image')->store('public/ad');
            $file = explode('/', $file);
            $file = end($file);
        }

        $ad->update([
            'img' => $file,
        ]);

        return redirect(route('ad.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AD  $aD
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ad = AD::findOrFail($id);

        // delete old file
        Storage::delete($ad->img);

        $ad->delete();
    }


    public function MemberADS(Request $request)
    {

        if (!Auth::user()->can('View Advertise')) {
            return redirect(route('home'));
        }

        // dd(date('d-m-Y h:i:s', strtotime(now())));

        if (!array_key_exists('timeNow', $_COOKIE)) {

            setcookie('timeNow', now(), time() + (3600 * 24), "/");
            return redirect(route('ad.list.member'));
        }

        $cookieDate = date('d', strtotime($_COOKIE['timeNow']));
        $todayDate = date('d', strtotime(now()));


        if (!array_key_exists('TodayAds_' . Auth::user()->id, $_COOKIE)) {

            // unset old ads
            unset($_COOKIE['TodayAds_' . Auth::user()->id]);
            unset($_COOKIE['timeNow']);

            $businessSettings = BusinessSetting::where('id', 1)->select(['ad_per_day'])->first();

            $ads = AD::inRandomOrder()->limit($businessSettings->ad_per_day)->get();

            setcookie('TodayAds_' . Auth::user()->id, $ads, time() + (3600 * 24), "/");
            setcookie('timeNow', now(), time() + (3600 * 24), "/");
            return redirect(route('ad.list.member'));
        }

        if ($cookieDate != $todayDate) {

            // unset old ads
            unset($_COOKIE['TodayAds_' . Auth::user()->id]);
            unset($_COOKIE['timeNow']);

            $businessSettings = BusinessSetting::where('id', 1)->select(['ad_per_day'])->first();

            $ads = AD::inRandomOrder()->limit($businessSettings->ad_per_day)->get();


            setcookie('TodayAds_' . Auth::user()->id, $ads, time() + (3600 * 24), "/");
            setcookie('timeNow', now(), time() + (3600 * 24), "/");


            return redirect(route('ad.list.member'));
        }

        $data = (object) [
            // 'ads' => $ads,
        ];

        return response(view('dashboard.ad_view_member', compact('data')));
    }


    public function MemberGetAdBonus($id)
    {


        $businessSettings = BusinessSetting::where('id', 1)->select(['bonus_per_ad'])->first();

        // Add in wallet
        Wallet::create([
            'from_id' => Auth::user()->id,
            'amount' => $businessSettings->bonus_per_ad,
            'remarks' => 'ADV BONUS',
            'status' => 1,
        ]);


        // remove ad
        $todayAds = json_decode($_COOKIE['TodayAds_' . Auth::user()->id], true);
        $todayAds = new Collection($todayAds);



        $todayAds = $todayAds->filter(function ($item) use ($id) {
            return $item['id'] != $id;
        });

        setcookie('TodayAds_' . Auth::user()->id, $todayAds, time() + (3600 * 24), "/");
        return back();
    }
}
