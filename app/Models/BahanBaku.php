<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $fillable =[
        'kode_material',
        'golongan',
        'jenis',
        'material',
        'satuan',
    ];
    use HasFactory;
}
