<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\PostingDonasi;
use Validator;

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
        $berita = Berita::where('publish',1)->paginate(4);
        $posting = PostingDonasi::when($request->q, function ($query) use ($request) {
            $query->where('judul', 'LIKE', "%{$request->q}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$request->q}%");
            })->paginate(4);
        return view('home',['posting' => $posting, 'berita' => $berita]);
    }

    public function berita($id)
    {
        $berita = Berita::find($id);
        // dd($berita);
        return view('frontend.berita',['berita' => $berita]);
    }
    
    public function posting($id)
    {
        $posting = PostingDonasi::with('masukan_donasi')->find($id);
        return view('frontend.posting',['posting' => $posting]);
    }

}
