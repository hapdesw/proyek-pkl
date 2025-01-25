<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;
    protected $table = 'tagihan';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan', 'nama_file_tagihan', 'path_file_tagihan'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id')->withTrashed();
    }

    public function kuitansi(){
        return $this->hasOne(Kuitansi::class, 'id_permohonan', 'id_permohonan');
    }
}
