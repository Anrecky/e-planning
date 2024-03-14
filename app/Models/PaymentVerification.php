<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'activity_date',
        'amount',
        'provider',
        'implementer_name',
        'implementer_nip',
        'auditor_name',
        'auditor_nip',
        'ppk_id',
        'verificator_id',
    ];

    public function ppk(): BelongsTo
    {
        return $this->belongsTo(PPK::class);
    }

    public function verificator(): BelongsTo
    {
        return $this->belongsTo(Verificator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verification_user')->select('id', 'name', 'identity_number');
    }
}
