<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_pendaftaran', 'no_invoice', 'jumlah_pembayaran',
        'tanggal_pembayaran', 'metode_pembayaran', 'bukti_pembayaran',
        'status_pembayaran', 'verified_by', 'tanggal_verifikasi', 'keterangan'
    ];

    public function pendaftaran() {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function verifikator() {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
