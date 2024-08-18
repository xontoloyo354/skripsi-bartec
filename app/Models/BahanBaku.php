<?php

namespace App\Models;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

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
        'nama_barang',
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
    
    public static function booted()
    {
        parent::boot();

        // static::saving(function ($model) {
        //     $model->kode_material = self::generateKodeMaterial($model);
        //     $model->nama_barang = "{$model->golongan->name} - {$model->jenis->name} - {$model->sub_jenis} - {$model->material}";
        // });

        static::deleted(function ($model) {
            static::reorderNomor();
        });

        static::created(function ($model) {
            static::reorderNomor();
        });


        self::creating(function($model){
        $model->kode_material = self::generateKodeMaterial($model);
      });
      
    static::updated(function ($bahanBaku) {
        try {
            // Check if the stock field is dirty and actually changed
            if ($bahanBaku->isDirty('stock')) {
                // Make sure stock change is significant
                if ($bahanBaku->getOriginal('stock') !== $bahanBaku->stock) {
                    $lowStockItems = BahanBaku::where('stock', '<=', 10)->count();
                    $users = User::where('role', 'Admin')->get();
    
                    foreach ($users as $user) {
                        Notification::make()
                            ->title('Bahan Baku Updated')
                            ->success()
                            ->icon('heroicon-o-exclamation-circle')
                            ->iconColor('warning')
                            ->body("There are {$lowStockItems} items with low stock.")
                            ->actions([
                                Action::make('view')
                                    ->button()
                                    ->url(route('filament.admin.resources.bahan-bakus.index'), shouldOpenInNewTab: true) // Adjust this route as necessary
                                    ->markAsRead(),
                            ])
                            ->sendToDatabase($user);    
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in BahanBaku Updated Event', ['exception' => $e]);
        }
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
