<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class ReCaptchaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $request->validate([
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'reCAPTCHA verification is required.',
        ]);

        if (!NoCaptcha::verify($request->input('g-recaptcha-response'))) {
            return redirect()->back()->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed.']);
        }

        return $next($request);
    }
}
