<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verificator extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nik', 'position'];
}
