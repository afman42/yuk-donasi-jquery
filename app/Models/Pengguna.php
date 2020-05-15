<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $fillable = [
        'username', 'hak_akses', 'password','status_aktif'
    ];

    public function isAdmin()
    {
        return ($this->hak_akses == 1);
    }

    public function isPenggalang()
    {
        return ($this->hak_akses == 2);
    }
}
