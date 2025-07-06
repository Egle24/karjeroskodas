<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    public function index()
    {
        $galleries = Gallery::all();
        $camps = Camp::all();
        return view('admin.gallery.index', compact('galleries', 'camps'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'camp_id' => 'required|exists:camps,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'required|array|min:1|max:10240',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ], [
            'camp_id.required' => 'Pasirinkite stovyklą.',
            'images.required' => 'Galerijoje turi būti bent viena nuotrauka.',
        ]);

        // Create a slug and ensure it's unique
        $slug = Str::slug($request->input('title')) . '-karjeroskodas';

        $gallery = new Gallery([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'camp_id' => $request->input('camp_id')
        ]);

        $gallery->slug = $slug;
        $gallery->save();

        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            $imageInstance = $manager->read($image->getPathname()); 

            if ($imageInstance->width() > 2000) {
                $imageInstance->scale(width: 2000);
            }

            $imageName = $slug . '.webp';

             $counter = 1;

            while (Storage::disk('public')->exists('gallery_images/' . $imageName)) {
                $imageName = $slug . '-' . $counter . '.webp';
                $counter++;
            }

            Storage::disk('public')->put('gallery_images/' . $imageName, $imageInstance->toWebp());

            GalleryImages::create([
                'gallery_id' => $gallery->id,
                'image_path' => 'gallery_images/' . $imageName, // Save the correct path
            ]);
        }

        return redirect()->back()->with('success', 'Galerija sukurta sėkmingai');
    }


    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        $galleryImages = $gallery->images;
        $camps = Camp::all();

        return view('admin.gallery.edit', compact('gallery', 'galleryImages', 'camps'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'camp_id' => 'required|exists:camps,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $selectedImagesIds = $request->selected_images ?? [];

        $slug = Str::slug($request->input('title')) . '-karjeroskodas';


        $gallery->images()->whereIn('id', $selectedImagesIds)->get()->each(function ($image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        });

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $manager = new ImageManager(new Driver());

                $imageInstance = $manager->read($image->getPathname());

                if ($imageInstance->width() > 2000) {
                    $imageInstance->scale(width: 2000);
                }

                $imageWebp = $imageInstance->toWebp();

                $imageName = $slug . '.webp';
                
                $counter = 1;

                while (Storage::disk('public')->exists('gallery_images/' . $imageName)) {
                    $imageName = $slug . '-' . $counter . '.webp';
                    $counter++;
                }

                Storage::disk('public')->put('gallery_images/' . $imageName, $imageWebp);

                // Save the image path in the database
                GalleryImages::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'gallery_images/' . $imageName,
                ]);
            }
        }

        // Update the gallery
        $gallery->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'camp_id' => $request->input('camp_id')
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Galerija sėkmingai atnaujinta');
    }

    public function deleteImages(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.delete', compact('gallery'));
    }

    public function destroy(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $selectedImagesIds = $request->selected_images ?? [];

        if (count($selectedImagesIds) === 0) {
            return redirect()->back()->with('error', 'Nepasirinkote jokių nuotraukų.');
        }

        $gallery->images()->whereIn('id', $selectedImagesIds)->get()->each(function ($image) {
            Storage::delete('gallery_images/' . $image->image_path);
            $image->delete();
        });

        if ($gallery->images()->count() === 0) {
            $gallery->delete();
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Sėkmingai pašalinote nuotraukas');
    }
}
