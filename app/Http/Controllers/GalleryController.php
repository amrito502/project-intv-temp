<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Project Gallery')) {
            return redirect(route('home'));
        }

        // if ($request->ajax()) {
        //     return Gallery::datatable();
        // }

        $data = (object)[
            'galleries' => Gallery::where('company_id', Auth::user()->company_id)->get(),
        ];

        return view('dashboard.gallery.gallery_index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     if (!Auth::user()->can('create gallery')) {
    //         return redirect(route('home'));
    //     }

    //     $data = (object)[];

    //     return view('dashboard.gallery.create_gallery', compact('data'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     if (!Auth::user()->can('create gallery')) {
    //         return redirect(route('home'));
    //     }

    //     $request->validate([
    //         'name' => 'required',
    //     ]);

    //     $data['company_id'] = Auth::user()->company_id;
    //     $data['title'] = $request->name;
    //     $data['created_by'] = Auth::user()->id;

    //     Gallery::create($data);

    //     return redirect(route('gallery.index'));
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($gallery)
    {
        return redirect(route('galleryDates.index', $gallery));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    // public function edit(Gallery $gallery)
    // {
    //     if (!Auth::user()->can('edit gallery')) {
    //         return redirect(route('home'));
    //     }

    //     if ($gallery->company_id != Auth::user()->company_id) {
    //         return back();
    //     }

    //     $data = (object) [
    //         'gallery' => $gallery,
    //     ];

    //     return view('dashboard.gallery.edit_gallery', compact('data'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        if (!Auth::user()->can('edit gallery')) {
            return redirect(route('home'));
        }

        $request->validate([
            'name' => 'required',
        ]);

        $data['title'] = $request->name;

        $gallery->update($data);

        return redirect(route('gallery.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return 1;
    }
}
