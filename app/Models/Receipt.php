<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'amount',
        'activity_date',
        'provider',
        'activity_implementer',
        'ppk_id',
        'treasurer_id',
        'budget_implementation_detail_id',
    ];

    public function ppk(): BelongsTo
    {
        return $this->belongsTo(PPK::class);
    }
    public function treasurer(): BelongsTo
    {
        return $this->belongsTo(Treasurer::class);
    }
    public function detail(): BelongsTo
    {
        return $this->belongsTo(BudgetImplementationDetail::class, 'budget_implementation_detail_id', 'id');
    }
}
