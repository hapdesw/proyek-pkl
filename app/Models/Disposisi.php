<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposisi extends Model
{
    use HasFactory;

    protected $table = 'disposisi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan', 'nip_pegawai1', 'nip_pegawai2', 'nip_pegawai3', 'tanggal_disposisi'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id')->withTrashed();
    }

    public function pegawai1(){
        return $this->belongsTo(Pegawai::class, 'nip_pegawai1', 'nip')->withTrashed();
    }
    public function pegawai2(){
        return $this->belongsTo(Pegawai::class, 'nip_pegawai2', 'nip')->withTrashed();
    }
    public function pegawai3(){
        return $this->belongsTo(Pegawai::class, 'nip_pegawai3', 'nip')->withTrashed();
    }

    public function hasilLayanan(){
        return $this->hasOne(HasilLayanan::class, 'id_permohonan', 'id_permohonan');
    }
    
}


