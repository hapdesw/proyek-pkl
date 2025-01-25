<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisLayanan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jenis_layanan';
    protected $primaryKey = 'id';

    protected $fillable = ['nama_jenis_layanan'];

    public function permohonan(){
        return $this->hasMany(Permohonan::class, 'id_jenis_layanan', 'id')->withTrashed();
    }

}
