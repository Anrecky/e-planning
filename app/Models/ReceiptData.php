<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptData extends Model
{
    use HasFactory;
    protected $fillable = [
        'datas',
        'amount'
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->with('employee');
    }
}
