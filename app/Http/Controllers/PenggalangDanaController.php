<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PenggalangDanaController extends Controller
{
    public function beranda()
    {
        return view('penggalang-dana.beranda');
    }

    public function pengaturan_akun()
    {
        return view('penggalang-dana.pengaturan-akun');
    }

    public function posting_donasi()
    {
        return view('penggalang-dana.posting-donasi');
    }

    public function login(Request $request)
    {
        $atribut = $request->only(['username','password']);
        if (Auth::attempt($atribut)) {
            $request->session()->put('login', Auth::user()->username);
            return redirect()->route('penggalang-dana.beranda');
        }
        else{
            return redirect()->route('penggalang.getlogin');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('penggalang.getlogin'));
    }

    public function show()
    {
        return view('layouts.login-penggalang');
    }
}
