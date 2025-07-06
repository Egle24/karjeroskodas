<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('redirect_after_login')->only('login');
    }

    /**
     * Override the login method to provide custom error messages
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return $this->sendFailedLoginResponse($request, 'email', 'Tokio vartotojo nėra');
        }

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendFailedLoginResponse($request, 'password', 'Neteisingas slaptažodis');
        }

        // If we reached here, credentials are correct
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If login still fails for other reasons
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Custom method to send failed login response with specific field and message
     */
    protected function sendFailedLoginResponse(Request $request, $field = 'email', $message = null)
    {
        $message = $message ?? trans('auth.failed');
        
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $field => $message,
            ]);
    }
}