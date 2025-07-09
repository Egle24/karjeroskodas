<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserContactController extends Controller
{
    public function index(){
        return view('main.contact');
    }
    public function send(Request $request)
    {

        if (!empty($request->input('honeypot')) || !empty($request->input('fake_field'))) {
            return redirect()->back()->with('error', 'Spam detected!');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($this->isOnline()) {
            $mail_data = [
                'recipient' => env('MAIL_FROM_ADDRESS'),
                'fromEmail' => $request->email,
                'fromName' => $request->name,
                'subject' => $request->subject,
                'body' => $request->message
            ];

            Mail::to("egle.urbonaitee@gmail.com")->send(new ContactUs($mail_data));


            return redirect()->to(url()->previous() . '#form-anchor')->with('success', 'Laiškas sėkmingai išsiųstas!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Pasitikrinkite interneto ryšį.');
        }
    }

    public function isOnline($site = "https://google.com/"){
        if(@fopen($site, "r")){
            return true;
        }
        else{
            return false;
        }
    }
}
