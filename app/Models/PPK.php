<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\PPKFactory;

class PPK extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nik', 'position'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ppks';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PPKFactory::new();
    }
}
