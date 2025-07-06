<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ArticleController extends Controller
{
    // Display all articles
    public function index()
    {
        $articles = Articles::orderBy('date', 'desc')->get();
        $categories = Category::all();


        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.partials.create', compact('categories'));
    }

    // Store a new article
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'content.*' => 'string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'date' => 'required|date',
            'link' => 'nullable|string|max:250',
            'status' => 'required|in:new,old',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $slug = Str::slug($request->input('title'), '-');


        $article = Articles::create([
            'title' => $request->input('title'),
            'slug' => $slug, // Add this line to insert the slug
            'content' => $request->input('content'), // Store as raw HTML
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id')
        ]);


        //Working method


        $manager = new ImageManager(new Driver());

        $image = $manager->read($request->file('image')->getPathname());

        if ($image->width() > 2000) {
            $image->resize(2000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }


        $imageName = $slug . '.webp';
        $counter = 1;

        while (Storage::disk('public')->exists('article_images/' . $imageName)) {
            $imageName = $slug . '-' . $counter . '.webp';
            $counter++;
        }

        Storage::disk('public')->put('article_images/' . $imageName, (string) $image->toWebp());

        $article->image = $imageName;
       
        $article -> save();

        return redirect()->route('admin.articles.index')->with('success', 'Straipsnis sukurtas sėkmingai');
    }

    // Edit an existing article
    public function edit($id)
    {
        $article = Articles::findOrFail($id);
        $categories = Category::all();

        return view('admin.articles.edit', compact('article', 'categories'));
    }

    // Update an existing article
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string', // No need for JSON validation here
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10000',
            'date' => 'required|date',
            'link' => 'nullable|string|max:250',
            'status' => 'required|in:new,old',
            'category_id' => 'required|exists:categories,id'
        ]);
    
        $article = Articles::findOrFail($id);
    
        $article->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'), // Store as raw HTML
            'date' => $request->input('date'),
            'link' => $request->input('link'),
            'status' => $request->input('status'),
            'category_id' => $request->input('category_id')
        ]);

        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $imageFile = $request->file('image');
            $image = $manager->read($imageFile->getRealPath());
    
            if ($image->width() > 2000) {
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
    
            // Build a unique filename without deleting old images
            $imageName =  $article->slug . '.webp';
            $counter = 1;
    
            while (Storage::disk('public')->exists('article_images/' . $imageName)) {
                $imageName =  $article->slug . '-' . $counter . '.webp';
                $counter++;
            }
    
            Storage::disk('public')->put('article_images/' . $imageName, (string) $image->toWebp());
            $article->image = $imageName;
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Sėkmingai atnaujinote straipsnį');
    }

    // Delete an article
    public function destroy($id)
    {
        try {
            $article = Articles::findOrFail($id);

            // Delete the associated image
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            // Delete the article
            $article->delete();

            return redirect()->route('admin.articles.index')->with('success', 'Straipsnis ištrintas sėkmingai');
        } catch (\Exception $e) {
            return redirect()->route('admin.articles.index')->with('error', 'Straipsnio ištrinti nepavyko, bandykite vėl');
        }
    }
}
