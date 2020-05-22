<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Pengguna;
class CekLoginPenggalangDana
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
        if(auth()->check() && $request->user()->hak_akses == 2) {
            return $next($request);
            // dd($request->user()->hak_akses ==2);
        }

        return redirect()->route('penggalang.getlogin');
    }
}
