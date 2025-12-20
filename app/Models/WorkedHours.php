<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $company_id
 * @property int $rate_cents
 * @property string $start_time
 * @property string|null $stop_time
 * @property int $hours_worked
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read float $full_rate
 * @property-read float $full_total
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereHoursWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereRateCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereStopTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHours whereUserId($value)
 * @mixin \Eloquent
 */
class WorkedHours extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'hourly_rate_cents',
        'start_time',
        'stop_time',
        'hours_worked',
        'minutes_worked',
        'seconds_worked',
        'total_cents',
        'description',
    ];

    public function getFullRateAttribute(): float
    {
        return $this->rate_cents / 100;
    }

    public function getFullTotalAttribute(): float
    {
        return $this->total_cents / 100;
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
