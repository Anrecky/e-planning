<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTarget extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function performanceIndicators()
    {
        return $this->hasMany(PerformanceIndicator::class);
    }
}
