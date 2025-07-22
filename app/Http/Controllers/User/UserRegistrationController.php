<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\CampRegistrationMail;
use App\Models\Camp;
use App\Models\UserCamps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class UserRegistrationController extends Controller
{
    public function index(Camp $camp)
    {
        return view('main.camps.register.registration', ['camp' => $camp]);
    }

    

    public function register(Request $request, Camp $camp)
    {
        
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'required|email',
            'workplace' => 'required|string',
            'invoice' => 'required|in:pre_invoice,no,post_invoice',
            'food_choice' => 'required|in:everything,vegetarian_no_meat,vegetarian_fish_only,vegan',
            'special_needs' => 'nullable|string',
            'g-recaptcha-response' => 'required|captcha',

        ]);

        // Get the authenticated user's ID if available
        $userId = Auth::check() ? auth()->user()->id : null;

        $userCamp = new UserCamps();
        $userCamp->user_id = $userId;
        $userCamp->camp_id = $camp->id;
        $userCamp->name = $request->input('name');
        $userCamp->surname = $request->input('surname');
        $userCamp->phone_number = $request->input('phone_number');
        $userCamp->email = $request->input('email');
        $userCamp->workplace = $request->input('workplace');
        $userCamp->invoice = $request->input('invoice');
        $userCamp->food_choice = $request->input('food_choice');
        $userCamp->special_needs = $request->input('special_needs') ?: 'Nėra';
        $userCamp->paid = 'no';  // Automatically mark as paid or use 'no' if necessary
        $userCamp->save();

        // Save the registration (optional: store it in the database)
        $registrationData = $request->only([
            'name', 'surname', 'email', 'payment', 'invoice', 'food_choice', 'special_needs'
        ]);

        if (!auth()->check()) {
            Mail::to($request->email)->send(new CampRegistrationMail($camp, $registrationData));
        }

        return view('main.camps.register.success', ['camp' => $camp]);
    }

}
