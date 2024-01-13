<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCodeReception extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function receptions()
    {
        return $this->hasMany(Reception::class);
    }
}
