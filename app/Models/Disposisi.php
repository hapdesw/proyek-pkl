<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan', 'nip_pegawai', 'tanggal_disposisi'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class, 'nip_pegawai', 'nip');
    }

    public function hasilLayanan(){
        return $this->hasOne(HasilLayanan::class, 'id_permohonan', 'id_permohonan');
    }
    
}


