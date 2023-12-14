<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function budgetImplementations()
    {
        return $this->hasMany(BudgetImplementation::class);
    }

    /**
     * Calculate the total sum of a specific field in BudgetImplementation.
     *
     * @return float
     */
    public function calculateTotalSum()
    {
        return $this->budgetImplementations->sum(function ($budgetImplementation) {
            return $budgetImplementation->details->sum('total');
        });
    }
    public function activityRecap()
    {
        return $this->hasOne(ActivityRecap::class);
    }
    /**
     * Scope a query to sort activities by code in a case-sensitive manner.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortedByCode($query)
    {
        return $query->orderBy('code');
    }
}
