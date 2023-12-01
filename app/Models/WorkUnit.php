<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkUnit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code'];

    public function unitBudgets()
    {
        return $this->hasMany(UnitBudget::class);
    }
}
