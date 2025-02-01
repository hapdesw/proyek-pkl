<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permohonan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'permohonan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal_diajukan', 
        'kategori_berbayar', 
        'id_jenis_layanan', 
        'deskripsi_keperluan', 
        'status_permohonan',
        'tanggal_selesai',
        'tanggal_diambil',
        'id_pemohon'];

    public function pemohon(){
        return $this->belongsTo(Pemohon::class, 'id_pemohon', 'id');
    }

    public function jenisLayanan(){
        return $this->belongsTo(JenisLayanan::class, 'id_jenis_layanan', 'id')->withTrashed();
    }

    public function hasilLayanan(){
        return $this->hasOne(HasilLayanan::class, 'id_permohonan', 'id');
    }

    public function disposisi(){
        return $this->hasOne(Disposisi::class, 'id_permohonan', 'id');
    }

    public function tagihan(){
        return $this->hasOne(Tagihan::class, 'id_permohonan', 'id');
    }

    public function kuitansi(){
        return $this->hasOne(Kuitansi::class, 'id_permohonan', 'id');
    }

    public function canUploadKuitansi()
    {
        return $this->tagihan()->exists();
    }
}
