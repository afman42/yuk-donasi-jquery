<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $model = Berita::all();
            return datatables()->of($model)
                ->editColumn('judul', function(Berita $berita){
                    return Str::limit($berita->judul,10,'...');
                })
                ->editColumn('deskripsi', function(Berita $berita){
                    return Str::limit($berita->deskripsi,10,'...');
                })
                ->editColumn('gambar', function (Berita $berita) {
                    return '<img src="'.url($berita->gambar).'" width="100" height="100">';
                })
                ->editColumn('publish', function (Berita $berita) {
                    return $berita->publish == 1 ? 'Publish' : 'Unpublish';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-primary btn-sm editProduct"><i class="fas fa-toolbox"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>';
                    return $button;
                })->rawColumns(['gambar','action'])->addIndexColumn()->make(true);
        }
        return view('berita.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'judul' => 'required|max:50',
            'deskripsi' => 'required',
            'gambar' => 'required|mimes:jpeg,jpg,png',
            'publish' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'judul.max' => 'Maksimal Judul 50 huruf',
            'gambar.mimes' => 'Gambar berektensi jpeg,jpg,png'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $foto = $request->file('gambar');
        $ext = $foto->getClientOriginalExtension();
        $newName = "image/berita/berita-".rand(10,100).".".$ext;
        $foto->move('image/berita',$newName);
        $model = new Berita();
        $model->judul = $request->judul;
        $model->deskripsi = $request->deskripsi;
        $model->publish = $request->publish;
        $model->user_id = Auth::user()->id;
        $model->gambar = $newName;
        if ($model->save()) {
            return response()->json(['success' => 'Data Berita Berhasil Ditambah.']);
        }
    }

    public function show($id)
    {
        $berita = Berita::find($id);
        return response()->json($berita);
    }

    public function update(Request $request)
    {
        $rules = array(
            'judul' => 'required|max:50',
            'deskripsi' => 'required',
            'gambar' => 'mimes:jpeg,jpg,png',
            'publish' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'judul.max' => 'Maksimal Judul 50 huruf',
            'gambar.mimes' => 'Gambar berektensi jpeg,jpg,png'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $model = Berita::findOrFail($request->id_berita);
        $model->judul = $request->judul;
        $model->deskripsi = $request->deskripsi;
        $model->publish = $request->publish;
        $model->user_id = Auth::user()->id;

        $foto = $request->file('gambar');
        if (!empty($foto)){
            unlink($model->gambar); //menghapus file lama
            $ext = $foto->getClientOriginalExtension();
            $newName = "image/berita/berita-".rand(10,100).".".$ext;
            $foto->move('image/berita',$newName);
            $model->gambar = $newName;
        }
        if ($model->save()) {
            return response()->json(['success' => 'Data Berita Telah Diperbaharui']);
        }
    }

    public function getbank($id)
    {
        $berita = Berita::where('id', $id)->first();
        return response()->json($berita);
    }

    public function beritaid()
    {
        $berita = [
            1 => 'Publish',
            0 => 'Unpublish'
        ];
        if ($berita) {
            echo "<option value=''>-- Pilih Publish ---</option>";
            foreach ($berita as $key => $value) {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
    }


    public function destroy($id)
    {
        $model = Berita::findOrFail($id);
        // dd($model->gambar);
        unlink($model->gambar);
        Berita::find($id)->delete();        
        return response()->json(['success' => 'Data Bank Sukses Terhapus']);
    }
}
