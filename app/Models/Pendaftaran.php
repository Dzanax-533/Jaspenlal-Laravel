<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $fillable = [
        'id_klien',
        'id_paket',
        'no_pendaftaran',
        'status_pendaftaran',
        'skala_usaha',
        'jumlah_menu',
        'jumlah_fasilitas',     
        'lokasi_perusahaan',
        'total_biaya',
        'catatan',
        'tanggal_pendaftaran',
    ];

    // Relasi Balik ke Klien
    public function klien() {
        return $this->belongsTo(Klien::class, 'id_klien');
    }

    // Relasi Balik ke Paket
    public function paket() {
        return $this->belongsTo(PaketPendampingan::class, 'id_paket');
    }

    // Relasi Balik ke Konsultan
    public function konsultan() {
        return $this->belongsTo(Konsultan::class, 'id_konsultan');
    }

    // Relasi ke tabel dokumen_persyaratans
    public function pembayaran() {
        return $this->hasOne(Pembayaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
    public function dokumen() {
        return $this->hasMany(DokumenPersyaratan::class, 'id_pendaftaran', 'id_pendaftaran');
    }

    /**
     * Tambahan: Relasi ke tabel progres_pendampingans
     * Digunakan untuk menggerakkan Progress Tracker di Dashboard Klien
     */
    public function progres(): HasMany {
        // Relasi One-to-Many ke model ProgresPendampingan
        return $this->hasMany(ProgresPendampingan::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
