<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Camp;
use App\Models\Feedback;
use App\Models\Gallery;
use App\Models\Memberships;
use App\Models\Programme;

class UserHomeController extends Controller
{
    public function index()
    {
        $camps = Camp::all();
        $galleries = Gallery::all();
        $articles = Articles::all();
        $feedbacks = Feedback::all();

        $articles->transform(function ($article) {
            $article->content = json_decode($article->content, true);
            return $article;
        });

        return view('main.home', compact('camps','galleries', 'articles', 'feedbacks'));
    }
}
