<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanBiaya extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara spesifik
    protected $table = 'pengaturan_biaya';

    // Kolom yang boleh diisi
    protected $fillable = [
        'key',
        'value',
        'keterangan'
    ];
}
