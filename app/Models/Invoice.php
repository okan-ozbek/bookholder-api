<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'company_id',
        'client_id',
        'status',
        'from_time',
        'to_time',
        'due_time'
    ];

    public function getFreelanceTimesAttribute(): \Illuminate\Database\Eloquent\Collection
    {
        return FreelanceTime::where('company_id', $this->company_id)
            ->where('start_time', '>=', $this->from_time)
            ->where('stop_time', '<=', $this->to_time)
            ->get();
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
