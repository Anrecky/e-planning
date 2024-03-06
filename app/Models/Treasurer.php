<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasurer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'nik', 'position'];
}
