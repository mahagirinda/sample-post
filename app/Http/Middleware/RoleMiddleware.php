<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        Log::info("URL yang diakses adalah " . $request->url());

        // $is_authenticated = Auth::check();
        $is_authenticated = true;

        if (!$is_authenticated) {
            $log_error = Log::channel('log-error');
            $log_error->error("Ada akses terlarang belum login ke url : " . $request->url());
            return response('Anda login terlebih dahulu!', 401);
        }

        // $user_role = Auth::user()->role;
        $user_role = "admin";
        if ($user_role != $role && $role != 'all') {
            $log_error = Log::channel('log-error');
            $log_error->error("Ada akses terlarang sebagai admin ke url : " . $request->url());
            return response('Hanya bisa diakses oleh admin!', 401);
        }

        return $next($request);
    }
}
