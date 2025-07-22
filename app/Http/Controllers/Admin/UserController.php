<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function show()
    {
        return view('admin.adminHome');
    }
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
}
    
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|exists:roles,name',
        ]);

        $temporaryPassword = Str::random(12);

        // Create the new user
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => bcrypt($temporaryPassword), // Hash the password
        ]);

        // Assign the selected role to the user
        $role = Role::where('name', $request->role)->first();
        $user->assignRole($role);

        // Create an entry in the memberships table
        $user->memberships()->create([
            'status' => 'active', // Membership is active since payment was made directly
            'payment_method' => 'card', // Default payment method
            'payment_status' => 'paid', // Payment has been made
            'subscription_end_date' => now()->format('Y') . '-12-31', // End date: December 31 of the current year
        ]);

        // Send the password to the user's email
        Mail::to($user->email)->send(new \App\Mail\UserPasswordMail($temporaryPassword));

        // Redirect with a success message
        return redirect()->route('admin.users.index')->with('success', 'Naujas narys sukurtas. Laikinas slaptažodis išsiųstas el. paštu.');
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'surname' => $request->surname,
        ]);

        $role = Role::where('name', $request->role)->first();
        $user->syncRoles([$role->id]);

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Nario informacija atnaujinta sėkmingai');
    }

    public function renewMembership(Request $request, User $user)
    {
        $membership = $user->memberships()->latest()->first();

        if (!$membership || $membership->subscription_end_date >= now()) {
            return redirect()->back()->with('error', 'Narystė vis dar aktyvi arba narys neturi narystės');
        }

        // Extend the subscription to the end of the current year
        $membership->update([
            'subscription_end_date' => now()->format('Y') . '-12-31',
            'status' => 'active',
            'payment_status' => 'paid',
        ]);

        return redirect()->back()->with('success', 'Narystė sėkmingai atnaujinta');
    }


    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Narys sėkmingai pašalintas.');
    }
}
