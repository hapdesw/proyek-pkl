<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisLayanan extends Model
{
    use HasFactory;

    protected $table = 'jenis_layanan';
    protected $primaryKey = 'id';

    protected $fillable = ['nama_jenis_layanan',];

}
