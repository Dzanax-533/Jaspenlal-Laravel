<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';
    protected $primaryKey = 'id_klien';
    protected $fillable = ['user_id', 'nama_perusahaan', 'alamat_perusahaan', 'npwp', 'no_telepon_perusahaan', 'email_perusahaan', 'keterangan'];

    // Relasi: Klien adalah bagian dari User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
