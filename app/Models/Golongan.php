<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Golongan extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
    ];
    public function jenis(): HasMany
    {
        return $this->hasMany(Jenis::class);   
    }
    public static function boot()
    {
        parent::boot();
    }
}
