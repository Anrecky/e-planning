<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renstra extends Model
{
    use HasFactory;

    protected $fillable = ['vision', 'mission', 'iku', 'capaian'];

    protected $casts = [
        'mission' => 'array',
        'iku' => 'array',
        'capaian' => 'array',
    ];

    public function missions()
    {
        return $this->hasMany(RenstraMission::class);
    }
}
