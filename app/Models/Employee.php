<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'position',
        'work_unit_id',
        'user_id',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
