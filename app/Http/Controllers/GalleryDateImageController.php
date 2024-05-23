<?php

namespace App\Http\Controllers;

use App\Models\GalleryDate;
use Illuminate\Http\Request;
use App\Models\GalleryDateImage;
use Illuminate\Support\Facades\Auth;

class GalleryDateImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, GalleryDate $gallerydate)
    {
        if (!Auth::user()->can('Project Gallery')) {
            return redirect(route('home'));
        }

        // if ($request->ajax()) {
        //     return GalleryDateImage::datatable($gallerydate->id);
        // }

        $data = (object)[
            'gallerydate' => $gallerydate,
            'images' => GalleryDateImage::where('gallery_date_id', $gallerydate->id)->get(),
        ];

        return view('dashboard.gallerydateimage.gallerydateimage_index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GalleryDate $gallerydate)
    {

        if (!Auth::user()->can('create gallery')) {
            return redirect(route('home'));
        }

        $data = (object)[
            'gallerydate' => $gallerydate,
        ];

        return view('dashboard.gallerydateimage.create_gallerydateimage', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $gallerydate)
    {

        if (!Auth::user()->can('create gallery')) {
            return redirect(route('home'));
        }

        $request->validate([
            'information' => 'required',
            'images.*' => 'required|file',
        ]);


        if ($request->has('images')) {

            foreach ($request->images as $image) {

                // upload new file
                $image = $image->store('public/gallery_image');
                $image = explode('/', $image);
                $image = end($image);

                $data['created_by'] = Auth::user()->id;
                $data['gallery_date_id'] = $gallerydate;
                $data['information'] = $request->information;
                $data['image'] = $image;

                GalleryDateImage::create($data);

            }

        }

        return redirect(route('gallerydateimages.index', $gallerydate));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GalleryDateImage  $galleryDateImage
     * @return \Illuminate\Http\Response
     */
    public function show(GalleryDateImage $galleryDateImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GalleryDateImage  $galleryDateImage
     * @return \Illuminate\Http\Response
     */
    public function edit($gallerydate, $gallerydateimage)
    {
        if (!Auth::user()->can('edit gallery')) {
            return redirect(route('home'));
        }

        $galleryDateimage = GalleryDateImage::find($gallerydateimage);

        $data = (object) [
            'gallerydate' => $gallerydate,
            'gallerydateimage' => $galleryDateimage,
        ];

        return view('dashboard.gallerydateimage.edit_gallerydateimage', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GalleryDateImage  $galleryDateImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $gallerydate, $gallerydateimage)
    {

        if (!Auth::user()->can('edit gallery')) {
            return redirect(route('home'));
        }

        $request->validate([
            'information' => 'required',
        ]);

        if ($request->has('image')) {

            // upload new file
            $image = $request->file('image')->store('public/gallery_image');
            $image = explode('/', $image);
            $image = end($image);
        } else {
            $image = $request->old_image;
        }

        $gallerydateimage = GalleryDateImage::find($gallerydateimage);

        $data['information'] = $request->information;
        $data['image'] = $image;

        $gallerydateimage->update($data);

        return redirect(route('gallerydateimages.index', $gallerydate));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GalleryDateImage  $galleryDateImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($gallerydateimage)
    {

        $gallerydateimage = GalleryDateImage::find($gallerydateimage);

        $gallerydateimage->delete();

        return true;
    }
}
