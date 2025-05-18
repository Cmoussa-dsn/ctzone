<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        if (Auth::user()->role_id != 1) {
            return redirect('/')->with('error', 'You do not have admin privileges.');
        }
        
        return $next($request);
    }
} 