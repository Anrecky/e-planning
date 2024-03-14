<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'category', 'brand'];

    public function scopeIT(Builder $query): void
    {
        // $query->where();
    }
}
