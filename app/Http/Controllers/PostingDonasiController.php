<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostingDonasi;
use App\Models\MasukanDonasi;
use App\Models\Pengguna;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Str;

class PostingDonasiController extends Controller
{
    public function index()
    {
        $data = Pengguna::withCount(['bank','biodata_donatur'])->where('id',Auth::user()->id)->first();
        // dd($data);
        if (Request()->ajax()) {
            $model = PostingDonasi::withCount(['masukan_donasi'])->with(['bank'])->where('user_id',Auth::user()->id)->get();
            return datatables()->of($model)
                ->editColumn('judul', function(PostingDonasi $posting){
                    return Str::limit($posting->judul,10,'...');
                })
                ->editColumn('deskripsi', function(PostingDonasi $posting){
                    return Str::limit($posting->deskripsi,10,'...');
                })
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
                    if ($data->masukan_donasi_count > 0) {
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '" 
                        class="btn btn-info btn-sm pdf-download"><i class="fas fa-file-pdf"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<a href="'.url('/penggalang-dana/posting-donasi/'.$data->id).'"
                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    return $button;
                })->rawColumns(['gambar','action'])->addIndexColumn()->make(true);
        }
        return view('posting-donasi.index',['data' => $data ]);
    }

    public function pdf_posting($id)
    {
        // $data = PostingDonasi::with(['bank','masukan_donasi','user'])->where('user_id',Auth::user()->id)->get();
        $data = \DB::table('masukan_donasi')
                ->select('*')
                ->join('posting_donasi', 'posting_donasi.id', '=', 'masukan_donasi.posting_id')
                ->join('user', 'user.id', '=', 'masukan_donasi.user_id')
                ->where('masukan_donasi.posting_id', $id)
                ->get();
        $pdf = \PDF::loadView('posting-donasi.pdf-posting', ['data' => $data]);
        // $pdf->save(storage_path().'_filename.pdf');
        return $pdf->download('dana-posting-donasi.pdf');
    }

    public function store(Request $request)
    {
        $rules = array(
            'judul' => 'required|max:50',
            'deskripsi' => 'required',
            'gambar' => 'required|mimes:jpeg,jpg,png',
            'jumlah_donasi' => 'required',
            'tanggal_mulai_selesai' => 'required',
            'tanggal_akhir_selesai' => 'required',
            'bank_id' => 'required',
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
            'judul' => 'required|max:50',
            'deskripsi' => 'required',
            'jumlah_donasi' => 'required',
            'tanggal_mulai_selesai' => 'required',
            'tanggal_akhir_selesai' => 'required',
            'bank_id' => 'required',
            'gambar' => 'mimes:jpeg,jpg,png',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute harus unik',
            'judul.max' => 'Maksimal Judul 50 huruf',
            'gambar.mimes' => 'Gambar berektensi jpeg,jpg,png'
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


    public function lihat_donasi($id)
    {
        $masukan = MasukanDonasi::with(['user'])->where('posting_id',$id)->get();
        $posting = PostingDonasi::where('id',$id)->first();
        return view('posting-donasi.lihat-donasi',['masukan' => $masukan, 'posting' => $posting ]);
    }

    public function destroy($id)
    {
        PostingDonasi::find($id)->delete();
        $model = PostingDonasi::find($id)->first();
        unlink($model->gambar);
        return response()->json(['success' => 'Data Posting Donasi Sukses Terhapus']);
    }
}
