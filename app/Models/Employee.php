<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'work_unit_id',
        'user_id',
        'head_id',
        'position',
        'letter_reference',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function workUnit(): BelongsTo
    {
        return $this->belongsTo(WorkUnit::class);
    }

    public function headOf(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'head_id', 'id');
    }
}
