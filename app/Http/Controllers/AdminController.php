<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Session;
use App\Models\PostingDonasi;
use Validator;
class AdminController extends Controller
{   
    public function index()
    {
        return view('admin.index');
    }

    public function penggalang_dana()
    {
        if (Request()->ajax()) {
            $model = Pengguna::where('hak_akses',2)->get();
            return datatables()->of($model)
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-primary btn-sm editProduct"><i class="fas fa-toolbox"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>';
                    return $button;
                })->rawColumns(['action'])->addIndexColumn()->make(true);
        }
        return view('admin.penggalang_dana');
    }

    public function store_penggalang_dana(Request $request)
    {
        $rules = array(
            'username' => 'required|unique:user,username',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute harus unik.'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make('galangdana123'),
            'hak_akses' => 2,
            'status_aktif' => 1
        ]);

        return response()->json(['success' => 'Data Penggalang Dana Berhasil Ditambah.']);
    }

    public function show_penggalang_dana($id)
    {
        $bank = Pengguna::find($id);
        return response()->json($bank);
    }

    public function update_penggalang_dana(Request $request)
    {
        $rules = array(
            'username' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'username' => $request->username,
        );

        Pengguna::whereId($request->id_username)->update($form_data);

        return response()->json(['success' => 'Data Pengguna Telah Diperbaharui']);
    }

    public function destroy_penggalang_dana($id)
    {
        Pengguna::find($id)->delete();

        return response()->json(['success' => 'Data Pengguna Sukses Terhapus']);
    }

    public function getpenggalang_dana($id)
    {
        $bank = Pengguna::where('id', $id)->first();
        return response()->json($bank);
    }
    
    public function donatur()
    {
        if (Request()->ajax()) {
            $model = Pengguna::where('hak_akses',3)->get();
            return datatables()->of($model)
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-primary btn-sm editProduct"><i class="fas fa-toolbox"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>';
                    return $button;
                })->rawColumns(['action'])->addIndexColumn()->make(true);
        }
        return view('admin.donatur');
    }

    public function store_donatur(Request $request)
    {
        $rules = array(
            'username' => 'required|unique:user,username',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'unique' => ':attribute harus unik.'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Pengguna::create([
            'username' => $request->username,
            'password' => Hash::make('donatur123'),
            'hak_akses' => 3,
            'status_aktif' => 1
        ]);

        return response()->json(['success' => 'Data Penggalang Dana Berhasil Ditambah.']);
    }

    public function show_donatur($id)
    {
        $bank = Pengguna::find($id);
        return response()->json($bank);
    }

    public function update_donatur(Request $request)
    {
        $rules = array(
            'username' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'username' => $request->username,
        );

        Pengguna::whereId($request->id_username)->update($form_data);

        return response()->json(['success' => 'Data Pengguna Telah Diperbaharui']);
    }

    public function destroy_donatur($id)
    {
        Pengguna::find($id)->delete();

        return response()->json(['success' => 'Data Pengguna Sukses Terhapus']);
    }

    public function getdonatur($id)
    {
        $bank = Pengguna::where('id', $id)->first();
        return response()->json($bank);
    }

    public function profil()
    {
        return view('admin.pengaturan-akun');
    }

    public function store_profil(Request $request)
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
            return redirect(route('admin.profil'))
                        ->withErrors($error)
                        ->withInput();
        }
        
        $model = Pengguna::whereId(Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        if($model) {
            $request->session()->flash('status', 'Password Berhasil diubah');
        }

        return view('admin.pengaturan-akun');
    }

    public function melihat_posting()
    {
        if (Request()->ajax()) {
            $model = PostingDonasi::all();
            return datatables()->of($model)
                ->addColumn('user_id', function(PostingDonasi $posting){
                    return $posting->user['username'];
                })
                ->editColumn('publish', function(PostingDonasi $posting){
                    return $posting->publish ? 'Publish' : 'Unpublish';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" data-id="' . $data->id . '"
                class="btn btn-primary btn-sm editProduct"><i class="fas fa-toolbox"></i></a>';
                    return $button;
                })->rawColumns(['action'])->addIndexColumn()->make(true);
        }
        return view('admin.postingan-donasi');
    }

    public function update_melihat_posting(Request $request)
    {
        $rules = array(
            'publish' => 'required',
        );

        $messages = [
            'required' => ':attribute harus diisi.',
        ];

        $error = Validator::make($request->all(), $rules,$messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'publish' => $request->publish,
        );

        PostingDonasi::whereId($request->id_posting)->update($form_data);

        return response()->json(['success' => 'Data Posting Donasi Telah Diperbaharui']);
    }
    public function show_melihat_posting($id)
    {
        $bank = PostingDonasi::find($id);
        return response()->json($bank);
    }

    public function postingid()
    {
        $posting = [
            1 => 'Publish',
            0 => 'Unpublish'
        ];
        if ($posting) {
            echo "<option value=''>-- Pilih Posting ---</option>";
            foreach ($posting as $key => $value) {
                echo "<option value=" . $key . ">" . $value . "</option>";
            }
        }
    }

    public function pdf_donatur()
    {
        $data = Pengguna::where('hak_akses',3)->get();
        $pdf = \PDF::loadView('admin.pdf-donatur', ['data' => $data]);
        $pdf->save(storage_path().'_filename.pdf');
        return $pdf->download('donatur.pdf');
    } 

    public function pdf_penggalang()
    {
        $data = Pengguna::where('hak_akses',2)->get();
        $pdf = \PDF::loadView('admin.pdf-penggalang', ['data' => $data]);
        $pdf->save(storage_path().'_filename.pdf');
        return $pdf->download('penggalang-dana.pdf');
    }

    public function login(Request $request)
    {
        $atribut = $request->only(['username','password']);
        if (Auth::attempt($atribut)) {
            $request->session()->put('login', Auth::user()->username);
            return redirect()->route('admin.index');
        }else{
            return redirect()->route('admin.getlogin');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('admin.getlogin'));
    }

    public function show()
    {
        return view('layouts.login');
    }
}
