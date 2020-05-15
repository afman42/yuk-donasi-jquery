<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostingDonasi extends Model
{
    protected $table = 'posting_donasi';
    protected $fillable = ['judul','deskripsi','gambar','jumlah_donasi','user_id','tanggal_mulai_selesai','tanggal_akhir_selesai','bank_id','masukan_donasi_id','publish'];
    
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank','bank_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Pengguna','user_id','id');
    }
}
