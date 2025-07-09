<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;


class UserProfileController extends Controller
{
    public function index()
    {
        $camps = Camp::all();
        return view('home', compact('camps'));
    }

    public function show()
    {
        $user = auth()->user();
        $userCamps = $user->registrations()->get();
        $userMemberships = $user->memberships()->get();

        return view('profile.index', compact('userCamps','userMemberships'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_image' => ['image', 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp', 'max:2048']
        ]);
        
        $user = Auth::user();

        if ($request->hasFile('profile_image')) {

            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
    
            $image = $request->file('profile_image');
            $manager = new ImageManager(new Driver());
    
            $imageInstance = $manager->read($image->getPathname());
    
    
            $userFullName = $user->name . ' ' . $user->surname;
            $userSlug = Str::slug($userFullName);

            $baseName = 'profile_images/' . $userSlug;
            $imageName = $baseName . '.webp';

            $counter = 1;
            while (Storage::disk('public')->exists($imageName)) {
                $imageName = $baseName . '-' . $counter . '.webp';
                $counter++;
            }
    
            Storage::disk('public')->put($imageName, $imageInstance->toWebp());
    
            $user->profile_image = $imageName;
            $user->save();
        }

        return redirect()->route('profile.show')->with('success', 'Profilio nuotrauka sėkmingai pakeista');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Dabartinis slaptažodis neteisingas.');
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Slaptažodis sėkmingai atnaujintas.');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->save();

        return redirect()->back()->with('success', 'Vardas ir pavardė sėkmingai atnaujinti.');
    }

    public function delete(){

        $user = Auth::user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);

            $user->update(['profile_image' => null]);
            return redirect()->route('profile.show')->with('success', 'Profilio nuotrauka sėkmingai ištrinta');
        }

        return redirect()->route('profile.show')->with('errors', 'Profilio nuotraukos nepavyko ištrinti. Bandykite vėl');

    }

}
