<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Jenis extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'golongan_id',
    ];
    
    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class);
    }
    public static function boot()
    {
        parent::boot();}
}
