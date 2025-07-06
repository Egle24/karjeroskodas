<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAfterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if(auth()->user()){
            if(auth()->user()->isUserMember()){
                return redirect()->route('home');
            }

            if(auth()->user()->isUserAdmin()){
                return redirect()->route('admin.index');
            }
            return redirect()->route('home');
        }
        return $response;
    }
}
