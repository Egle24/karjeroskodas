<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Gallery;

class UserGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::paginate(9);
        $camps = Camp::all();
        return view('main.gallery.index', compact('galleries','camps'));
    }

    public function show($slug)
    {
        $gallery = Gallery::where('slug', $slug)->firstOrFail();
        $files = $gallery->camp->files ?? []; // Assuming `Gallery` has a relationship with `Camp`
        return view('main.gallery.show', compact('gallery', 'files'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
