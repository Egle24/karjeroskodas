<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserFeedbacksController extends Controller
{
    public function index(){

        $feedbacks = Feedback::where('status', 'confirmed')->get();
        return view('main.feedbacks.index', compact('feedbacks'));
    }

    public function store(Request $request)
    {
        if (!empty($request->input('honeypot')) || !empty($request->input('fake_field'))) {
            return redirect()->back()->with('error', 'Spam detected!');
        }

        $request->validate([
            'name' => 'required|string',
            'feedback' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',

        ]);

        $userId = Auth::check() ? auth()->user()->id : null;

        $feedback = new Feedback([
            'user_id' => $userId,
            'name' => $request->input('name'),
            'feedback' => $request->input('feedback')
        ]);

        $feedback->save();

        return redirect()->to(url()->previous() . '#form-anchor')
    ->with('success', 'Dėkojame už parašytą atsiliepimą! Jūsų atsiliepimas bus peržiūrėtas administratoriaus.');

        
    }
}
