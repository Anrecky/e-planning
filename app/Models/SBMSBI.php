<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SBMSBI extends Model
{
    use HasFactory;

    protected $fillable = ['sbm_path', 'sbi_path'];

    protected $table = 'sbmsbis';
}
