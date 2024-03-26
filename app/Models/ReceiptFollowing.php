<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptFollowing extends Model
{
    use HasFactory;
    protected $fillable = [
        'datas'
    ];
    public function user()
    {
        return $this->belongsTo(User::class)->with('employee');
    }
}
