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
    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
        $model->kode_material = self::generateKodeMaterial($model);
      });
    }
    
    public static function generateKodeMaterial($model)
{
    $lastRecord = self::where('golongan_id', $model->golongan_id)
                      ->where('jenis_id', $model->jenis_id)
                      ->orderBy('id', 'desc')
                      ->first();

    $count = $lastRecord ? (int)explode('.', $lastRecord->kode_material)[3] + 1 : 1;

    // Using a placeholder for ID as it is not available yet
    return '1.' . $model->golongan_id . '.' . $model->jenis_id . '.' . $count;
}

} 