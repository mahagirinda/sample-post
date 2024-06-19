<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with("error", "You must be logged in to access this page.");
        }

        $user_role = Auth::user()->role;
        if ($user_role != $role && $role != 'all') {
            return redirect()->route('home')
                ->with("error", "You are not allowed to access this page!");
        }

        View::share('role', $user_role);
        return $next($request);
    }
}
