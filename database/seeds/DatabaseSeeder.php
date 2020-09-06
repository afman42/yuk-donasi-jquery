<?php

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Admin
        $user = new Pengguna();
        $user->name = 'admin';
        $user->email = 'admin@example.com';
        $user->username = "admin";
        $user->password = Hash::make('admin123');
        $user->hak_akses = 1;
        $user->status_aktif = 0;
        $user->save();

        //Penggalang Dana
        $penggalang = new Pengguna();
        $penggalang->name = 'afif';
        $penggalang->email = 'afif@example.com';
        $penggalang->username = "afif";
        $penggalang->password = Hash::make('afif123');
        $penggalang->hak_akses = 2;
        $penggalang->status_aktif = 0;
        $penggalang->save();

        //Donatur
        $donatur = new Pengguna();
        $donatur->name = 'donatur';
        $donatur->email = 'donatur@example.com';
        $donatur->username = "donatur";
        $donatur->password = Hash::make('donatur123');
        $donatur->hak_akses = 3;
        $donatur->status_aktif = 0;
        $donatur->save();
    }
}
