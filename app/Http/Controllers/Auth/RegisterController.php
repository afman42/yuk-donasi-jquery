<?php

namespace App\Http\Controllers\Auth;

use App\Models\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'required' => ':attribute harus diisi.',
            'string' => ':attribute harus kalimat',
            'confirmed' => ':attribute harus sama',
            'unique' => ':attribute harus unik',
            'email' => ':attribute harus valid',
        ];
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255','unique:user,username'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'hak_akses' => ['required'],
            'password' => ['required', 'string', 'confirmed'],
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Pengguna
     */
    protected function create(array $data)
    {
        return Pengguna::create([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'hak_akses' => $data['hak_akses'],
            'status_aktif' => 2,
            'password' => Hash::make($data['password']),
        ]);
    }
}
