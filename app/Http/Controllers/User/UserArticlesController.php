<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = Articles::where('status', 'new')->orderBy('date', 'desc')->get();
        $categories = Category::all();

        return view('main.articles.index', compact('articles', 'categories'));
    }



    public function show($slug)
    {
        // Find the current article by slug
        $article = Articles::where('slug', $slug)->firstOrFail();


        $relatedArticles = Articles::where('id', '!=', $article->id)
            ->orderBy('date', 'desc')
            ->take(2)
            ->get();

        $relatedArticles->transform(function ($article) {
            $article->content = json_decode($article->content, true);
            return $article;
        });

        // Get the category of the current article
        $article_cat = $article->category_id;

        // Fetch other articles from the same category, excluding the current one
        $articles = Articles::where('category_id', '!=', $article_cat)->get();
        $articles->transform(function ($article) {
            $article->content = json_decode($article->content, true);
            return $article;
        });


        return view('main.articles.show', compact('article', 'articles', 'relatedArticles'));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
