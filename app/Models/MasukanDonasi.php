<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasukanDonasi extends Model
{
    protected $table = 'masukan_donasi';
    protected $fillable = ['photo_struk','donasi_masuk' ,'user_id','posting_id','nama_bank'];

    public function user()
    {
        return $this->belongsTo('App\Models\Pengguna');
    }
}
