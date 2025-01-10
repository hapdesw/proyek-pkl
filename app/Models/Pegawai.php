<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id';

    protected $fillable = ['username', 'status_petugas', 'status_kapokja', 'status_analis', 'status_bendahara'];

    public function user(){
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function disposisi(){
        return $this->hasMany(Disposisi::class, 'id', 'id_pegawai');
    }


}
