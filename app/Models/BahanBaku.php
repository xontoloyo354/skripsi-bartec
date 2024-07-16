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
        'nomor',
        'stock',
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

    public function getNamaBarangAttribute()
    {
        return "{$this->golongan->name} - {$this->jenis->name} - {$this->sub_jenis} - {$this->material}";
    }
    
    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            static::reorderNomor();
        });

        static::created(function ($model) {
            static::reorderNomor();
        });


        self::creating(function($model){
        $model->kode_material = self::generateKodeMaterial($model);
      });
    }

    public static function reorderNomor()
    {
        $items = static::orderBy('golongan_id')
                        ->orderBy('jenis_id')         
                        ->orderBy('created_at')
                        ->get();

        foreach ($items as $index => $item) {
            $item->nomor = $index + 1;
            $item->saveQuietly();
        }
    }
    
    public static function generateKodeMaterial($model)
{
    $lastRecord = self::where('golongan_id', $model->golongan_id)
                      ->where('jenis_id', $model->jenis_id)
                      ->orderBy('id', 'desc')
                      ->first();
    if ($lastRecord) {
        $lastKodeMaterial =explode('.', $lastRecord->kode_material);
        $count = isset($lastKodeMaterial[3]) ? (int)$lastKodeMaterial[3] + 1 : 1;
        } else {
            $count = 1;
        }
    return '1.' . $model->golongan_id . '.' . $model->jenis_id . '.' . $count;
    }
}
