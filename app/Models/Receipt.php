<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function scopeAccessibility($query, $approval = false, $findId = false, $throw = false)
    {

        $query->select('receipts.*');

        if (Auth::user()->hasRole('SUPER ADMIN PERENCANAAN')) {
        } else
        if (Auth::user()->hasRole('PPK')) {
            if ($approval) {
                $query = $query->where('receipts.status', '=', 'wait-ppk');
            }
            $query = $query->whereIn('receipts.status', ['wait-treasurer', 'reject-treasurer', 'wait-ppk', 'reject-ppk', 'accept'])
                ->where('ppk_id',  Auth::user()->id);
        } else
        if (Auth::user()->hasRole('SPI')) {
            if ($approval) {
                $query = $query->where('receipts.status', '=', 'wait-spi');
            }
            $query = $query->whereIn('receipts.status', ['wait-treasurer', 'reject-treasurer', 'wait-spi', 'reject-spi', 'wait-ppk', 'reject-ppk', 'accept']);
        } else
        if (Auth::user()->hasRole('STAF PPK')) {
            if ($approval) {
                $query = $query->where('receipts.status', '=', 'wait-verificator');
            }
            $query = $query
                ->join('users as u', 'u.id', 'receipts.ppk_id')
                ->leftJoin('employees as p', 'p.user_id', 'u.id')
                ->leftJoin('employees as pp', 'p.head_id', 'pp.id')
                ->leftJoin('users as ss', 'pp.user_id', 'ss.id')
                ->whereIn('receipts.status', ['wait-spi', 'reject-spi', 'wait-treasurer', 'reject-treasurer', 'wait-verificator', 'reject-verificator', 'wait-ppk', 'reject-ppk', 'accept'])
                ->where('ss.id',  Auth::user()->id);
        } else
        if (Auth::user()->hasRole('BENDAHARA')) {
            if ($approval) {
                $query = $query->where('receipts.status', '=', 'wait-treasurer');
            }
            $query = $query->whereIn('receipts.status', ['wait-treasurer', 'reject-treasurer', 'accept'])
                ->where('treasurer_id',  Auth::user()->id);
        } else {
            if ($approval) {
                $query = $query->whereIn('receipts.status', ['reject-verificator', 'reject-spi', 'reject-ppk', 'reject-treasurer', 'draft']);
            }
            $query = $query->where('user_entry',  Auth::user()->id);
        }

        if ($findId) {
            $query = $query->where('receipts.id', $findId);

            if ($throw) {
                if (empty($query->first()))
                    throw new \Exception('Data tidak ditemukan atau bukan hak anda lagi!!');
            }
        }


        return $query;
    }
    public function scopeGenerateNumber($query, $receipt)
    {
        $year = Carbon::createFromFormat('Y-m-d', $receipt->activity_date)->year;
        $number = 'VR/LS/' . $receipt->ppk->employee->letter_reference . '/' . $year;
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
