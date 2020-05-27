<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataDonatur;
use Illuminate\Support\Facades\Auth;

class BiodataDonaturController extends Controller
{
    
    public function index()
    {
        return view('penggalang-dana.biodata');
    }
    
    public function store(Request $request)
    {
        $foto = $request->file('gambar');
        $ext = $foto->getClientOriginalExtension();
        $newName = "image/photo/photo-".rand(10,100).".".$ext;
        $foto->move('image/photo',$newName);
        
        $newUser = BiodataDonatur::updateOrCreate([
            'user_id'   => Auth::user()->id,
        ],[
            'jenis_kelamin' => $request->get('jenis_kelamin'),
            'alamat' => $request->get('alamat'),
            'no_hp'    => $request->get("no_hp"),
            'gambar'   => $newName,
        ]);
        
        $model = BiodataDonatur::where('user_id',Auth::user()->id)->first();
        $request->session()->put('model', $model);
        return redirect(route('penggalang-dana.biodata'));
    }
}
