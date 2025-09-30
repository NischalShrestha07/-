<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') { // Changed to 'role' and 'admin'
                return $next($request);
            } else {
                return redirect()->route('login')->with('error', 'Unauthorized access. Admin privileges required.');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
