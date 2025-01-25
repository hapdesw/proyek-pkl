<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemohon extends Model
{
    use HasFactory;

    protected $table = 'pemohon';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_pemohon', 'instansi', 'no_kontak', 'email'];

    public function permohonan(){
        return $this->hasMany(Permohonan::class, 'id_pemohon', 'id')->withTrashed();
    }
}
