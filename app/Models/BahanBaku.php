<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BahanBaku extends Model
{
    protected $fillable =[
        'kode_material',
        'golongan_id',
        'jenis_id',
        'sub_jenis',
        'material',
        'satuan',
    ];
    use HasFactory;

    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class);
    }
    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class);
    }
}