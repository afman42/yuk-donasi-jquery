<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravelista\Comments\Commenter;

class Pengguna extends Authenticatable
{
    use Notifiable, Commenter;

    protected $table = 'user';
    protected $fillable = [
        'username','name','email', 'hak_akses', 'password','status_aktif'
    ];

    public function isAdmin()
    {
        return ($this->hak_akses == 1);
    }

    public function isPenggalang()
    {
        return ($this->hak_akses == 2);
    }

    public function biodata_donatur()
    {
        return $this->hasOne('App\Models\BiodataDonatur','user_id','id');
    }

    public function bank()
    {
        return $this->hasOne('App\Models\Bank','user_id','id');
    }
}
