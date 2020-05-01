<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use Validator;

class BankController extends Controller
{
    public function index()
    {
        if (Request()->ajax()) {
            $model = Bank::all();
            return datatables()->of($model)
                // ->addColumn('wilayah', function (WilayahBagian $wilayahbagian) {
                //     return $wilayahbagian->wilayah->nama_wilayah;
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
        return view('bank.index');
    }

    public function store(Request $request)
    {
        $rules = array(
            'no_rek' => 'required|integer',
            'nama_bank' => 'required',
            'atas_nama' => 'required'
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus angka'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Bank::create([
            'no_rekening' => $request->no_rek,
            'nama_bank' => $request->nama_bank,
            'atas_nama' => $request->atas_nama,
            'user_id' => 1
        ]);

        return response()->json(['success' => 'Data Bank Berhasil Ditambah.']);
    }

    public function show($id)
    {
        $bank = Bank::find($id);
        return response()->json($bank);
    }

    public function update(Request $request)
    {
        $rules = array(
            'no_rek' => 'required|integer',
            'nama_bank' => 'required',
            'atas_nama' => 'required'
        );

        $messages = [
            'required' => ':attribute harus diisi.',
            'integer' => ':attribute harus angka'
        ];

        $error = Validator::make($request->all(), $rules,$messages);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'no_rekening' => $request->no_rek,
            'nama_bank' => $request->nama_bank,
            'atas_nama' => $request->atas_nama,
            'user_id' => 1
        );

        Bank::whereId($request->id_bank)->update($form_data);

        return response()->json(['success' => 'Data Bank Telah Diperbaharui']);
    }

    public function getbank($id)
    {
        $bank = Bank::where('id', $id)->first();
        return response()->json($bank);
    }


    public function destroy($id)
    {
        Bank::find($id)->delete();

        return response()->json(['success' => 'Data Bank Sukses Terhapus']);
    }

}
