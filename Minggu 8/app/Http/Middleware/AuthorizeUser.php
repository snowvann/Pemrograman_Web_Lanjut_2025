<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // $user = $request->user(); // ambil data user yg login
        // if ($user->hasRole($role)) { // cek apakah user memiliki role yg diinginkan
        //     return $next($request);
        // }

        $user_role = $request->user()->getRole();  // Ambil data level_kode dari user yang login
        if (in_array($user_role, $roles)) { // Cek apakah level_kode user ada di dalam array roles
            return $next($request); // Jika ada, maka lanjutkan request
        }

        //jika tidak punya role
        abort(403, 'Forbidden, kamu tidak punya akses ke halaman ini');
    }
}
