<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['asset_item_id', 'brand', 'year_acquisition', 'code', 'condition', 'description'];

    protected $casts = [
        'year_acquisition' => 'int',
    ];

    public function assetItem()
    {
        return $this->belongsTo(AssetItem::class);
    }
}
