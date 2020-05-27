<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiodataDonatur extends Model
{
    protected $table = 'biodata_donatur';
    protected $fillable = ['jenis_kelamin','no_hp','alamat','gambar','user_id'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\Pengguna','user_id','id');
    }
}
