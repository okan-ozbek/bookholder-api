<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelanceTime extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'start_time',
        'stop_time',
        'hours_worked',
        'description',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'stop_time' => 'datetime',
        'hours_worked' => 'integer',
        'description' => 'string',
    ];

    public function getStartTimeAttribute($value): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse($value);
    }

    public function getStopTimeAttribute($value): \Carbon\Carbon
    {
        return \Carbon\Carbon::parse($value);
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
