<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'program_target_id'];

    public function getValueAsPercentageAttribute()
    {
        return $this->value * 100 .'%';
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = $value / 100;
    }

    public function scopeAboveValue($query, $minValue)
    {
        return $query->where('value', '>', $minValue);
    }

    public function programTarget()
    {
        return $this->belongsTo(ProgramTarget::class);
    }

    public function isAboveThreshold($threshold)
    {
        return $this->value > $threshold;
    }
}
