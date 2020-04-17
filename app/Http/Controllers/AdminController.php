<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function penggalang_dana()
    {
        $title = 'Penggalang Dana';
        return view('admin.penggalang_dana',[
            'title' => $title
        ]);
    }

    public function donatur()
    {
        $donatur = 'Donatur';
        return view('admin.donatur',[
            'donatur' => $donatur
        ]);
    }

    public function pengaturan()
    {
        $pengaturan = 'Pengaturan';
        return view('admin.pengaturan',[
            'pengaturan' => $pengaturan
        ]);
    }
}
