<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\ProjectTower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helper\Ui\ProjectOverAllCards;
use Illuminate\Support\Facades\Storage;
use App\Helper\Ui\FlashMessageGenerator;
use App\Helper\Ui\ProjectDetailsOverAll;

class HomeController extends Controller
{

    // public function selectProject()
    // {

    //     if (Auth::user()->hasRole('Software Admin')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object) [
    //         'projects' => Auth::user()->userProject(),
    //     ];

    //     // clear previous selected company cache of this user
    //     Cache::forget('user_project_' . Auth::user()->id);

    //     if ($data->projects->count() == 1) {
    //         Cache::rememberForever('user_project_' . Auth::user()->id, function () use ($data) {
    //             return $data->projects->first()->id;
    //         });

    //         return redirect(route('home'));
    //     }


    //     return view('dashboard.layouts.selectProject', compact('data'));
    // }

    // public function selectProjectSave(Request $request)
    // {

    //     $request->validate([
    //         'project' => 'required',
    //     ]);

    //     Cache::rememberForever('user_project_' . Auth::user()->id, function () use ($request) {
    //         return $request->project;
    //     });

    //     return redirect(route('home'));
    // }

    public function index()
    {

        $data = (object) [
            // 'dashboard_project_overall_cards' => ProjectOverAllCards::getAllCards(),
            'dashboardProjectDetailsOverAll' => ProjectDetailsOverAll::generate(),
        ];

        return view('dashboard.layouts.home', compact('data'));
    }

    public function siteSettingView()
    {

        if (!Auth::user()->can('Site Setting')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'settings' => SiteSetting::findOrFail(1),
        ];

        return view('dashboard.SiteSetting', compact('data'));
    }

    public function siteSetting(Request $request)
    {

        if (!Auth::user()->can('Site Setting')) {
            return redirect(route('home'));
        }

        $setting = SiteSetting::findOrFail(1);

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

        if ($request->has('favicon_img')) {

            // delete old file
            Storage::delete($request->old_favicon_img);

            // upload new file
            $faviconFile = $request->file('favicon_img')->store('public/sitesetting');
            $faviconFile = explode('/', $faviconFile);
            $faviconFile = end($faviconFile);
        } else {
            $faviconFile = $request->old_favicon_img;
        }

        // save data

        $setting->update([
            'website_name' => $request->website_name,
            'website_logo' => $file,
            'favicon_img' => $faviconFile,
        ]);

        FlashMessageGenerator::generate('primary', 'Site Setting Updated');

        return back();
    }


    public function companySetupView()
    {
        // if (!Auth::user()->can('Company Setup')) {
        //     return redirect(route('home'));
        // }

        $data = (object) [
            'company' => Company::findOrFail(Auth::user()->company_id),
        ];

        return view('dashboard.company_setup', compact('data'));
    }

}
