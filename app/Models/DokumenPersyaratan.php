<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'dokumen_persyaratan';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = [
        'id_pendaftaran', 'nama_dokumen', 'jenis_dokumen', 'file_path',
        'tanggal_upload', 'status_validasi', 'validated_by',
        'tanggal_validasi', 'catatan_validasi'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
