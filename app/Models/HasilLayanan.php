<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilLayanan extends Model
{
    use HasFactory;
    protected $table = 'hasil_layanan';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan','nama_file_hasil','path_file_hasil', 'status', 'koreksi', 'pengunggah'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id');
    }
    public function disposisi(){
        return $this->belongsTo(Disposisi::class, 'id_permohonan', 'id_permohonan');
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pengunggah', 'nip');
    }
}
