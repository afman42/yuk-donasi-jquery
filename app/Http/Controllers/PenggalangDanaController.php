<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Pengguna;
use Validator;
class PenggalangDanaController extends Controller
{
    public function beranda()
    {
        return view('penggalang-dana.beranda');
    }

    public function login(Request $request)
    {
        $rules = array(
            'username' => 'required',
            'password' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            // return redirect(route('penggalang-dana.beranda'))
            //             ->withErrors($error)
            //             ->withInput();
            return response()->json(['errors' => $error->errors()->all()]);

        }

        $atribut = $request->only(['username','password']);
        
        if (Auth::attempt($atribut)) {
            $request->session()->put('login', Auth::user()->username);
            return response()->json(['success' => 'Berhasil Login.']);
        }else{
            return response()->json(['error' => 'Username dan Password Gagal']);
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


    public function pengaturan_akun()
    {
        return view('penggalang-dana.pengaturan-akun');
    }

    public function store_pengaturan_akun(Request $request)
    {
        $rules = array(
            'password' => 'required',
            'password-ulang' => 'required|same:password'
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'same' => ':attribute harus sama.',
        ];

        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return redirect(route('penggalang-dana.pengaturan-akun'))
                        ->withErrors($error)
                        ->withInput();
        }
        
        $model = Pengguna::whereId(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        if($model) {
            $request->session()->flash('status', 'Password Berhasil diubah');
        }

        return view('penggalang-dana.pengaturan-akun');
    }
}
