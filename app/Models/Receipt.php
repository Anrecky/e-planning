<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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
        'activity_followings',
        'ppk_id',
        'treasurer_id',
        'budget_implementation_detail_id',
    ];

    public function ppk(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ppk_id', 'id')->with('employee');
    }

    public function treasurer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'treasurer_id', 'id')->with('employee');
    }
    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(User::class, 'activity_implementer', 'id')->with('employee');
    }

    public function spi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'spi_id', 'id')->with('employee');
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
    public function pengikut(): HasMany
    {
        return $this->hasMany(ReceiptData::class, 'receipt_id', 'id')->with('user');
    }

    public function scopeGenerateNumber($query, $receipt)
    {
        $receipt->load('ppk');
        $year = Carbon::createFromFormat('Y-m-d', $receipt->activity_date)->year;
        $number = 'VR/LS/' . $receipt->ppk->letter_reference . '/' . $year;
        $tmp = Receipt::where('ppk_id', '=', $receipt->ppk_id)->where('reference_number', 'like', '%' . $number)->orderBy('reference_number', 'desc')->first('reference_number');
        if ($tmp) {
            $splitReference = explode('/', $tmp->reference_number)[0];
            $newNumber = str_pad($splitReference + 1, 3, '0', STR_PAD_LEFT);
            $number =  $newNumber . '/' . $number;
        } else {
            $number = '001/' . $number;
        }

        $receipt->reference_number = $number;
        $receipt->save();
    }
}
