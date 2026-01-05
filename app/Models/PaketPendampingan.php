<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketPendampingan extends Model
{
    use HasFactory;

    protected $table = 'paket_pendampingan';
    protected $primaryKey = 'id_paket';
    protected $fillable = ['nama_paket', 'deskripsi', 'harga', 'durasi_hari', 'benefit', 'status'];

    // Relasi: Satu paket bisa dipilih di banyak pendaftaran
    public function pendaftaran() {
        return $this->hasMany(Pendaftaran::class, 'id_paket');
    }
}
