<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:categories|string|max:100'
        ], [
            'title.required' => 'Privalote užpildyti pavadinimo lauką.',
            'title.string' => 'Pavadinimas turi būti sudarytas iš raidžių',
            'title.max' => 'Pavadinimas negali būti ilgesnis nei 100 simbolių.',
        ]);

        $category = Category::create([
            'title' => $request->input('title')
        ]);

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Kategorija sukurta sėkmingai');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:categories|string|max:100'
        ]);

        $category = Category::findOrFail($id);

        $category->update([
            'title' => $request->input('title')
        ]);

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Sėkmingai atnaujinote kategoriją');
    }

    public function destroy($id){

        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Kategorija pašalinta sėkmingai');
        }
        catch (\Exception $e){
            return redirect()->route('admin.categories.index')->with('error', 'Kategorijos ištrinti nepavyko, bandykite vėl');

        }
    }
}
