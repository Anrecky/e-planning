<?php

namespace App\Models;

use App\Enums\Month;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'activity_id', // assuming this is the name of the foreign key for Activity
        'month',
        'year',
        'amount_withdrawn',
        'notes',
    ];

    /**
     * The activity that the withdrawal plan is associated with.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    /**
     * Get the month as a Month enum instance.
     */
    public function getMonthAttribute($value): Month
    {
        return Month::from($value);
    }

    /**
     * Set the month using a Month enum instance.
     */
    public function setMonthAttribute(Month $value): void
    {
        $this->attributes['month'] = $value->value;
    }

    /**
     * Calculate the total sum of amount withdrawn for an activity in a specific year.
     *
     * @param  int  $activityId
     * @param  int  $year
     * @return float
     */
    public static function calculateTotalWithdrawnForActivity($activityId, $year)
    {
        return self::where('activity_id', $activityId)
            ->where('year', $year)
            ->sum('amount_withdrawn');
    }
}
