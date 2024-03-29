<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

class PostingDonasi extends Model
{
    use Commentable;
    protected $table = 'posting_donasi';
    protected $fillable = ['judul','deskripsi','gambar','jumlah_donasi','user_id','tanggal_mulai_selesai','tanggal_akhir_selesai','bank_id','masukan_donasi_id','publish'];
    
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank','bank_id','id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\Pengguna','id','user_id');
    }

    public function masukan_donasi()
    {
        return $this->hasMany('App\Models\MasukanDonasi','posting_id','id');
    }
}
