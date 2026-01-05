<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    protected $fillable = [
        'id_pendaftaran', 'nama_bahan', 'jenis_bahan', 'asal_bahan',
        'supplier', 'no_sertifikat_halal_bahan', 'status_halal', 'keterangan'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }
}
