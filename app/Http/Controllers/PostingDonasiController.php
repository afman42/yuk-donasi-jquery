<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostingDonasi;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Validator;
class PostingDonasiController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $model = PostingDonasi::with(['bank'])->where('user_id',Auth::user()->id)->get();
            return datatables()->of($model)
                ->editColumn('gambar', function (PostingDonasi $posting) {
                    return '<img src="'.url($posting->gambar).'" width="100" height="100">';
                })
                ->addColumn('bank_id', function (PostingDonasi $posting) {
                    return $posting->bank['nama_bank'];
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
        return view('posting-donasi.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'judul' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required',
            'jumlah_donasi' => 'required',
            'tanggal_mulai_selesai' => 'required',
            'tanggal_akhir_selesai' => 'required',
            'bank_id' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $foto = $request->file('gambar');
        $ext = $foto->getClientOriginalExtension();
        $newName = "image/posting-donasi/posting-donasi-".rand(10,100).".".$ext;
        $foto->move('image/posting-donasi',$newName);
        $model = new PostingDonasi();
        $model->judul = $request->judul;
        $model->deskripsi = $request->deskripsi;
        $model->bank_id = $request->bank_id;
        $model->jumlah_donasi = $request->jumlah_donasi;
        $model->publish = 1;
        $model->tanggal_mulai_selesai = $request->tanggal_mulai_selesai;
        $model->tanggal_akhir_selesai = $request->tanggal_akhir_selesai;
        $model->user_id = Auth::user()->id;
        $model->gambar = $newName;
        if ($model->save()) {
            return response()->json(['success' => 'Data Posting Donasi Berhasil Ditambah.']);
        }
    }

    public function show($id)
    {
        $posting = PostingDonasi::find($id);
        return response()->json($posting);
    }

    public function update(Request $request)
    {
        $rules = array(
            'judul' => 'required',
            'deskripsi' => 'required',
            'jumlah_donasi' => 'required',
            'tanggal_mulai_selesai' => 'required',
            'tanggal_akhir_selesai' => 'required',
            'bank_id' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute harus unik'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $model = PostingDonasi::findOrFail($request->id_posting_donasi);
        $model->judul = $request->judul;
        $model->deskripsi = $request->deskripsi;
        $model->tanggal_mulai_selesai = $request->tanggal_mulai_selesai;
        $model->tanggal_akhir_selesai = $request->tanggal_akhir_selesai;
        $model->bank_id = $request->bank_id;
        $model->jumlah_donasi = $request->jumlah_donasi;

        $foto = $request->file('gambar');
        if (!empty($foto)){
            unlink($model->gambar); //menghapus file lama
            $ext = $foto->getClientOriginalExtension();
            $newName = "image/posting-donasi/posting-donasi-".rand(10,100).".".$ext;
            $foto->move('image/posting-donasi',$newName);
            $model->gambar = $newName;
        }
        if ($model->save()) {
            return response()->json(['success' => 'Data Posting Donasi Telah Diperbaharui']);
        }
    }

    public function getposting($id)
    {
        $posting = PostingDonasi::where('id', $id)->first();
        return response()->json($posting);
    }

    public function postingid()
    {
        $Bank = Bank::where('user_id',Auth::user()->id)->get();
        if ($Bank) {
            echo "<option value=''>-- Pilih Bank ---</option>";
            foreach ($Bank as $key => $value) {
                echo "<option value=" . $value['id'] . ">" . $value['nama_bank'] . "</option>";
            }
        }
    }


    public function destroy($id)
    {
        PostingDonasi::find($id)->delete();
        $model = PostingDonasi::find($id)->first();
        unlink($model->gambar);
        return response()->json(['success' => 'Data Posting Donasi Sukses Terhapus']);
    }
}
