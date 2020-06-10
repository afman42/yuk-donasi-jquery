<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasukanDonasi;
use Validator;
use Illuminate\Support\Facades\Auth;

class MasukanDonasiController extends Controller
{
    public function masukan_donasi(Request $request)
    {
        $rules = array(
            'photo_struk' => 'required|mimes:jpeg,jpg,png',
            'donasi_masuk' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'photo_struk.mimes' => 'Gambar berektensi jpeg,jpg,png'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $foto = $request->file('photo_struk');
        $ext = $foto->getClientOriginalExtension();
        $newName = "image/photo-struk/photo-struk-".rand(10,100).".".$ext;
        $foto->move('image/photo-struk',$newName);
        MasukanDonasi::create([
            'photo_struk' => $newName,
            'donasi_masuk' => $request->donasi_masuk,
            'user_id' => Auth::user()->id,
            'posting_id' => $request->posting_id
        ]);

        return response()->json(['success' => 'Masukan Donasi Berhasil.']);
    }
}
