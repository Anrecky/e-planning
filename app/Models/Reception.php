<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => 'array',
    ];

    public function accountCodeReception()
    {
        return $this->belongsTo(AccountCodeReception::class);
    }
}
