<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kuitansi extends Model
{
    use HasFactory;
    protected $table = 'kuitansi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan', 'nama_file_kuitansi', 'path_file_kuitansi'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function tagihan(){
        return $this->belongsTo(Tagihan::class, 'id_permohonan', 'id_permohonan');
    }
}
