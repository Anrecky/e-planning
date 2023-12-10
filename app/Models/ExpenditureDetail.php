<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureDetail extends Model
{
    use HasFactory;

    public function expenditureUnit()
    {
        return $this->belongsTo(ExpenditureUnit::class);
    }
}
