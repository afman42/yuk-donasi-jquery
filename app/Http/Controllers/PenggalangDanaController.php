<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
