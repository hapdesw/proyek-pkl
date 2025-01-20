<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'nip';
    public $incrementing = false;

    protected $fillable = ['nip', 'id_user', 'nama', 'no_kontak', 'peran_pegawai'];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function disposisi(){
        return $this->hasMany(Disposisi::class, 'nip_pegawai', 'nip');
    }
}
