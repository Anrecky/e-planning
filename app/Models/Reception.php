<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function accountCodeReception()
    {
        $this->belongsTo(AccountCodeReception::class);
    }
}
