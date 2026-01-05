<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiProduk extends Model
{
    use HasFactory;
    protected $table = 'evaluasi_produk';
    protected $primaryKey = 'id_evaluasi';
    protected $fillable = ['id_pendaftaran', 'id_konsultan', 'hasil_evaluasi', 'rekomendasi', 'status_evaluasi', 'tanggal_evaluasi', 'catatan'];

    public function pendaftaran() { return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran'); }
    public function konsultan() { return $this->belongsTo(Konsultan::class, 'id_konsultan'); }
}
