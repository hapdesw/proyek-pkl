<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HasilLayanan extends Model
{
    use HasFactory;
    protected $table = 'hasil_layanan';
    protected $primaryKey = 'id';
    protected $fillable = ['id_permohonan','nama_file_hasil','path_file_hasil'];

    public function permohonan(){
        return $this->belongsTo(Permohonan::class, 'id_permohonan', 'id')->withTrashed();
    }
    public function disposisi(){
        return $this->belongsTo(Disposisi::class, 'id_permohonan', 'id_permohonan');
    }
}
