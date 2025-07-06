<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Camp;
use App\Models\Feedback;
use App\Models\Gallery;
use App\Models\Memberships;
use App\Models\Programme;
use App\Models\User;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        $camps = Camp::all();
        $articles = Articles::all();
        $memberships = Memberships::all();
        $programmes = Programme::all();
        $feedbacks = Feedback::all();

        return view('admin.layouts.adminHome',compact('galleries','camps','articles','memberships','programmes','feedbacks'));
    }
}
