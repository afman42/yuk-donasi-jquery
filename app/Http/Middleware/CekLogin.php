<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pengguna;
class CekLogin
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
        // return $next($request);
        if(auth()->check() && $request->user()->isAdmin() && session('login')) {
            return $next($request);
        }

        return redirect()->route('admin.getlogin');
    }
}
