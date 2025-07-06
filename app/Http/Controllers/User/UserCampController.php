<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use Illuminate\Http\Request;

class UserCampController extends Controller
{
    public function index(Request $request)
    {
        $camps = Camp::orderBy('end_date', 'desc')->get();

        return view('main.camps.index', compact('camps'));
    }

    public function show($slug)
    {
        $camp = Camp::where('slug', $slug)->firstOrFail();
        return view('main.camps.camp', compact('camp'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
