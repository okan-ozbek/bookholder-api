<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereHoursWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereRateCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereStopTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkedHour whereUserId($value)
 * @mixin \Eloquent
 */
class WorkedHour extends Model
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
