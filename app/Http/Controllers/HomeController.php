<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\PostingDonasi;
use App\Models\BiodataDonatur;
use Validator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $berita = Berita::where('publish',1)->paginate(4,['*'],'halaman_berita');
        $posting = PostingDonasi::when($request->q, function ($query) use ($request) {
            $query->where('judul', 'LIKE', "%{$request->q}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$request->q}%");
            })->where('tanggal_mulai_selesai','<=',now())
              ->where('tanggal_akhir_selesai','>=',now())
              ->where('publish',1)
              ->paginate(4,['*'],'halaman_donasi');
        return view('home',['posting' => $posting, 'berita' => $berita]);
    }

    public function berita($id)
    {
        $berita = Berita::findOrFail($id);
        // dd(now());
        return view('frontend.berita',['berita' => $berita]);
    }
    
    public function posting($id)
    {
        $posting = PostingDonasi::with(['masukan_donasi','bank'])
                    ->findOrFail($id);
        $user = BiodataDonatur::with('user')->first();
        return view('frontend.posting',['posting' => $posting,'user' => $user]);
    }
}
