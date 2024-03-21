<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenstraIndicator extends Model
{
    use HasFactory;
    protected $fillable = ['renstra_mission_id', 'description'];

    public function mission()
    {
        return $this->belongsTo(RenstraMission::class, 'renstra_mission_id');
    }
}
