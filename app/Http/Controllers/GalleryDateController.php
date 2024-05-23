<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryDate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Gallery $gallery)
    {
        if (!Auth::user()->can('Project Gallery')) {
            return redirect(route('home'));
        }

        // if ($request->ajax()) {
        //     return GalleryDate::datatable($gallery->id);
        // }

        $data = (object)[
            'gallery' => $gallery,
            'galleryDates' => GalleryDate::where('gallery_id', $gallery->id)->get(),
        ];

        return view('dashboard.gallerydate.gallerydate_index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Gallery $gallery)
    {
        if (!Auth::user()->can('create gallery')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'gallery' => $gallery,
        ];

        return view('dashboard.gallerydate.create_gallerydate', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Gallery $gallery)
    {

        if (!Auth::user()->can('create gallery')) {
            return redirect(route('home'));
        }


        $request->validate([
            'date' => 'required',
        ]);

        $data['gallery_id'] = $gallery->id;
        $data['date'] = $request->date;

        GalleryDate::create($data);

        return redirect(route('galleryDates.index', $gallery->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GalleryDate  $galleryDate
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryDate $gallerydate)
    {
        return redirect(route('gallerydateimages.index', $gallerydate->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GalleryDate  $galleryDate
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery, GalleryDate $gallerydate)
    {
        if (!Auth::user()->can('edit gallery')) {
            return redirect(route('home'));
        }

        $data = (object) [
            'gallerydate' => $gallerydate,
            'gallery' => $gallery,
        ];

        return view('dashboard.gallerydate.edit_gallerydate', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryDate  $galleryDate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery, GalleryDate $gallerydate)
    {
        if (!Auth::user()->can('edit gallery')) {
            return redirect(route('home'));
        }

        $request->validate([
            'date' => 'required',
        ]);

        $data['date'] = $request->date;

        $gallerydate->update($data);

        return redirect(route('galleryDates.index', $gallery->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GalleryDate  $galleryDate
     * @return \Illuminate\Http\Response
     */
    public function destroy(GalleryDate $gallerydate)
    {
        $gallerydate->delete();
        return 1;
    }
}
