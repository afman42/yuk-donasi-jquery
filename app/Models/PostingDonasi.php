<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostingDonasi extends Model
{
    protected $table = 'postigng_donasi';
    protected $fillable = ['judul','deskripsi','gambar','jumlah_donasi','user_id','tanggal_mulai_selesai','tanggal_akhir_selesai','bank_id','masukan_donasi_id'];
}
