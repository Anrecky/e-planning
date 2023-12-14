<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityRecap extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id', 'is_valid', 'attachment_path', 'description'];

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
    public static function sortedByActivityCode()
    {
        return self::query()
            ->select('activity_recaps.*')
            ->join('activities', 'activity_recaps.activity_id', '=', 'activities.id')
            ->orderBy('activities.code') // Sorting by activity code
            ->with('activity');
    }
}
