<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCode extends Model
{
    use HasFactory;

    public function budgetImplementations()
    {
        return $this->hasMany(BudgetImplementation::class);
    }

    public function scopeCode(Builder $query, string $code): void
    {
        $query->where('code', $code);
    }

    public function calculateTotalSum()
    {
        return $this->budgetImplementations->sum(function ($budgetImplementation) {
            return $budgetImplementation->details->sum('total');
        });
    }
}
