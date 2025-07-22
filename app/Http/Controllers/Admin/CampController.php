<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Programme;
use App\Models\User;
use App\Models\UserCamps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CampController extends Controller
{
    public function getCampData($id)
    {
        $camp = Camp::findOrFail($id);
        return response()->json([
            'title' => $camp->title,
            'description' => $camp->description
        ]);
    }

    public function index()
    {
        $camps = Camp::all();
        $programmes = Programme::all();
        return view('admin.camps.index', compact('camps', 'programmes'));
    }

    public function edit($id)
    {
        $camp = Camp::findOrFail($id);
        $programmes = Programme::all();

        return view('admin.camps.edit', compact('camp','programmes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:stovykla,seminaras,projektas',
            'start_date' => 'required|date_format:Y-m-d\TH:i',
            'end_date' => 'required|date_format:Y-m-d\TH:i',
            'address' => 'required|string|max:255',
            'priceForGuests' => 'required|numeric|min:0',
            'priceForMembers' => 'required|numeric|min:0',
            'foodChoice' => 'nullable|string',
            'accommodation' => 'nullable|string',
            'clothing' => 'nullable|string',
            'worth' => 'nullable|string',
            'audience' => 'nullable|string',
            'programme_id' => 'nullable|numeric|min:0',
            'status' => 'nullable|integer|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif'

        ]);

        try {
            $camp = Camp::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'address' => $request->input('address'),
            'priceForGuests' => $request->input('priceForGuests'),
            'priceForMembers' => $request->input('priceForMembers'),
            'foodChoice' => $request->input('foodChoice'),
            'accommodation' => $request->input('accommodation'),
            'clothing' => $request->input('clothing'),
            'worth' => $request->input('worth'),
            'audience' => $request->input('audience'),
            'programme_id' => $request->input('programme_id'),
            'status' => $request->input('status')
        ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['slug' => 'Tokia stovykla jau egzistuoja.'])->withInput();
            }
        
            throw $e; 
        }
        

        if ($request->hasFile('main_image')) {
            $imageFile = $request->file('main_image');
        
            $manager = new ImageManager(new Driver());
            $image = $manager->read($imageFile->getPathname());
        
            if ($image->width() > 2000) {
                $image->resize(2000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
        
            $imageName = $camp->title . '.webp';
            $counter = 1;
        
            while (Storage::disk('public')->exists('camp_images/' . $imageName)) {
                $imageName = $camp->title . '-' . $counter . '.webp';
                $counter++;
            }
        
            Storage::disk('public')->put('camp_images/' . $imageName, (string) $image->toWebp());
        
            $camp->main_image = $imageName;
            $camp->save();
        }
        $camp->save();

        return redirect()->route('admin.camps.index')->with('success', 'Stovykla sukurta sėkmingai!');
    }


    public function update(Request $request, $id)
{
    $camp = Camp::findOrFail($id);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'type' => 'required|in:stovykla,seminaras,projektas',
        'start_date' => 'nullable|date_format:Y-m-d\TH:i',
        'end_date' => 'nullable|date_format:Y-m-d\TH:i',
        'address' => 'nullable|string|max:255',
        'priceForGuests' => 'nullable|numeric|min:0',
        'priceForMembers' => 'nullable|numeric|min:0',
        'foodChoice' => 'nullable|string',
        'accommodation' => 'nullable|string',
        'clothing' => 'nullable|string',
        'worth' => 'nullable|string',
        'audience' => 'nullable|string',
        'programme_id' => 'nullable|numeric|min:0',
        'status' => 'nullable|integer|min:0',
        'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
    ]);

    // Custom status validation
    $request->validate([
        'status' => [
            'nullable',
            'integer',
            'min:0',
            // In your update method, after the main validation:
            if ($request->input('status') == 1 && !$camp->gallery()->exists()) {
                return redirect()->back()
                    ->with('warning', 'Stovykla pažymėta kaip praėjusi, bet galerija dar nesukurta. Rekomenduojame sukurti galeriją.')
                    ->with('success', 'Stovykla atnaujinta sėkmingai');
            }
        ]
    ]);

    $camp->fill($request->except('main_image'));

    if ($request->hasFile('main_image')) {
        $manager = new ImageManager(new Driver());
        $imageFile = $request->file('main_image');
        $image = $manager->read($imageFile->getRealPath());

        if ($image->width() > 2000) {
            $image->resize(2000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Build a unique filename without deleting old images
        $imageName = $camp->title . '.webp';
        $counter = 1;

        while (Storage::disk('public')->exists('camp_images/' . $imageName)) {
            $imageName = $camp->title . '-' . $counter . '.webp';
            $counter++;
        }

        Storage::disk('public')->put('camp_images/' . $imageName, (string) $image->toWebp());
        $camp->main_image = $imageName;
    }

    $camp->save();

    return redirect()->route('admin.camps.index')->with('success', 'Stovykla atnaujinta sėkmingai');
}

    public function destroy(Request $request, $id){

        $camp = Camp::findOrFail($id);
        $camp->registrations()->delete();

        if ($request->hasFile('main_image')) {
            Storage::disk('public')->delete('camp_images' . $camp->main_image);
        }
        $camp->delete();

        return redirect()->route('admin.camps.index')->with('success', 'Stovykla ištrinta sėkmingai');
    }
}
