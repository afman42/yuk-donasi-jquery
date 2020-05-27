<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

            // return redirect()->route('penggalang-dana.beranda');
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
