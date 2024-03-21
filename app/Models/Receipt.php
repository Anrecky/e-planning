<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'perjadin',
        'status',
        'user_entry',
        'berkas',
        'description',
        'amount',
        'activity_date',
        'provider',
        'provider_organization',
        'activity_implementer',
        'ppk_id',
        'treasurer_id',
        'budget_implementation_detail_id',
    ];

    public function ppk(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'ppk_id', 'id')->with('user');
    }

    public function treasurer(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'treasurer_id', 'id')->with('user');
    }
    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'activity_implementer', 'id')->with('user');
    }

    public function spi(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'spi_id', 'id')->with('user');
    }
    public function detail(): BelongsTo
    {
        return $this->belongsTo(BudgetImplementationDetail::class, 'budget_implementation_detail_id', 'id');
    }

    public function verification(): HasMany
    {
        return $this->hasMany(PaymentVerification::class, 'receipt_id', 'id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ReceiptLog::class, 'receipt_id', 'id');
    }
}
