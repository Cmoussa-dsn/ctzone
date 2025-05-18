<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Simple direct role check without dependency injection
        if (!Auth::check() || Auth::user()->role_id != 1) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
/*handle admin middleware
fjg
*/
