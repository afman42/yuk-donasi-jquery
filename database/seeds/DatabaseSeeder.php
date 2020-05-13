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
        $user = new Pengguna();
        $user->username = "admin";
        $user->password = Hash::make('admin123');
        $user->hak_akses = 1;
        $user->status_aktif = 0;
        $user->save();
    }
}
