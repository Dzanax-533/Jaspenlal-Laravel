<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresPendampingan extends Model
{
    use HasFactory;

    protected $table = 'progres_pendampingan';
    protected $primaryKey = 'id_progres';
    protected $fillable = [
        'id_pendaftaran', 'tahap_progres', 'deskripsi_progres',
        'persentase_selesai', 'tanggal_progres', 'updated_by', 'catatan', 'id_klien'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'id_pendaftaran');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
