<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatHalal extends Model
{
    use HasFactory;
    
    protected $table = 'sertifikat_halal';
    protected $primaryKey = 'id_sertifikat';
    protected $fillable = ['id_pendaftaran', 'no_sertifikat', 'file_path', 'tanggal_terbit', 'tanggal_berlaku', 'tanggal_kadaluarsa', 'uploaded_by', 'tanggal_upload', 'keterangan'];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }
}
