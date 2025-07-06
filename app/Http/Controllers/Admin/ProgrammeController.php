<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Programme;
use App\Models\ProgrammeImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ProgrammeController extends Controller
{
    public function index()
    {
        $programmes = Programme::get();
        return view('admin.camps.programmes.show', compact('programmes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $programme = new Programme([
            'title' => $request->input('title')
        ]);

        $programme->save();

        $slug = Str::slug($programme->title);

        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            $imageInstance = $manager->read($image->getPathname());

            if ($imageInstance->width() > 2000) {
                $imageInstance->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $imageName = $slug . '.webp';
            $counter = 1;

            while (Storage::disk('public')->exists('programme_images/' . $imageName)) {
                $imageName = $slug . '-' . $counter . '.webp';
                $counter++;
            }

            Storage::disk('public')->put('programme_images/' . $imageName, (string) $imageInstance->toWebp());

            ProgrammeImages::create([
                'programme_id' => $programme->id,
                'image_path' => 'programme_images/' . $imageName,
            ]);
        }

        return redirect()->back()->with('success', 'Programa sukurta sėkmingai');
    }

    public function edit($id)
    {
        $programme = Programme::findOrFail($id);
        $programmeImages = $programme->images;
        $camps = Camp::all();

        return view('admin.camps.programmes.edit', compact('programme', 'programmeImages', 'camps'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $programme = Programme::findOrFail($id);
    $programme->update([
        'title' => $request->input('title'),
    ]);

    // Delete old images
    foreach ($programme->images as $image) {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
    }

    if ($request->hasFile('images')) {
        $slug = Str::slug($programme->title);
        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            $imageInstance = $manager->read($image->getPathname());

            if ($imageInstance->width() > 2000) {
                $imageInstance->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $imageName = $slug . '.webp';
            $counter = 1;

            while (Storage::disk('public')->exists('programme_images/' . $imageName)) {
                $imageName = $slug . '-' . $counter . '.webp';
                $counter++;
            }

            Storage::disk('public')->put('programme_images/' . $imageName, (string) $imageInstance->toWebp());

            ProgrammeImages::create([
                'programme_id' => $programme->id,
                'image_path' => 'programme_images/' . $imageName,
            ]);
        }
    }

    return redirect()->route('admin.camps.programmes.index')->with('success', 'Programa atnaujinta');
}

    public function destroy($id)
    {
        $programme = Programme::findOrFail($id);

        // Unlink the programme from camps
        $campsWithProgramme = Camp::where('programme_id', $id)->get();
        foreach ($campsWithProgramme as $camp) {
            $camp->update(['programme_id' => null]);
        }

        // Delete programme images
        foreach ($programme->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete the programme
        $programme->delete();

        return redirect()->route('admin.camps.programmes.index')->with('success', 'Programa ir jos nuotraukos sėkmingai ištrintos');
    }
}
