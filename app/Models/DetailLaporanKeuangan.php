<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'detail_laporan_keuangan';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_laporan',
        'id_pembayaran',
        'jenis_transaksi',
        'jumlah',
        'keterangan'
    ];

    // Relasi balik ke Header Laporan
    public function laporan()
    {
        return $this->belongsTo(LaporanKeuangan::class, 'id_laporan');
    }

    // Relasi ke Pembayaran (untuk melacak asal uangnya)
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran');
    }
}
