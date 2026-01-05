<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultan extends Model
{
    use HasFactory;

    protected $table = 'konsultan';
    protected $primaryKey = 'id_konsultan';
    protected $fillable = ['user_id', 'no_sertifikat', 'spesialisasi', 'status', 'keterangan'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
