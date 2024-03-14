<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitBudget extends Model
{
    use HasFactory;

    protected $fillable = ['pagu', 'work_unit_id'];

    public function workUnit()
    {
        return $this->belongsTo(WorkUnit::class);
    }
}
