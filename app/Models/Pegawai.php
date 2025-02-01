<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pegawai';
    protected $primaryKey = 'nip';
    public $incrementing = false;

    protected $fillable = ['nip', 'id_user', 'nama', 'no_kontak', 'peran_pegawai'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function disposisi1(){
        return $this->hasMany(Disposisi::class, 'nip_pegawai1', 'nip')->withTrashed();
    }
    public function disposisi2(){
        return $this->hasMany(Disposisi::class, 'nip_pegawai2', 'nip')->withTrashed();
    }
    public function disposisi3(){
        return $this->hasMany(Disposisi::class, 'nip_pegawai3', 'nip')->withTrashed();
    }
}
