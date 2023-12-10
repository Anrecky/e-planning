<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetImplementation extends Model
{
    use HasFactory;
    protected $fillable = ['activity_code'];

    public function accountCode()
    {
        return $this->belongsTo(AccountCode::class);
    }

    public function expenditureDetail()
    {
        return $this->belongsTo(ExpenditureDetail::class);
    }
}
