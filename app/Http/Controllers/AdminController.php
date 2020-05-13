<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;
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
                // ->editColumn('username', function (Pengguna $pengguna) {
                //     if($pengguna->hak_akses == 2){
                //         return $pengguna->username;
                //     }
                // })
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
                // ->editColumn('username', function (Pengguna $pengguna) {
                //     if($pengguna->hak_akses == 2){
                //         return $pengguna->username;
                //     }
                // })
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

    public function pengaturan()
    {
        $pengaturan = 'Pengaturan';
        return view('admin.pengaturan',[
            'pengaturan' => $pengaturan
        ]);
    }

    public function login(Request $request)
    {
        $atribut = $request->only(['username','password']);
        if (Auth::attempt($atribut)) {
            return redirect()->route('admin.index');
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return back();
    }

    public function show()
    {
        return view('layouts.login');
    }
}
