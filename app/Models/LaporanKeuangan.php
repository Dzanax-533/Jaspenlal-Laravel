<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuangan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuangan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'periode',
        'tanggal_laporan',
        'total_pendapatan',
        'total_pengeluaran',
        'ringkasan',
        'created_by'
    ];

    // Relasi ke User (siapa yang membuat laporan)
    public function pencipta()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi ke Detail (Satu laporan punya banyak detail transaksi)
    public function rincian()
    {
        return $this->hasMany(DetailLaporanKeuangan::class, 'id_laporan');
    }
}
