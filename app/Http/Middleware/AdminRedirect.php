<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Check if the user is an admin
            if (!$user->is_admin) {
                return redirect()->route('front.category');
                // Redirect admin to the admin dashboard or backend
            }
            return $next($request);
        }

        // If the user is not authenticated, allow the request to proceed
        return $next($request);
    }
}
