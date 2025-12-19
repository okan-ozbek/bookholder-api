<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'coc_number',
        'vat_number',
        'address',
        'city',
        'postal_code',
        'country',
    ];

    public function settings(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CompanySetting::class);
    }
}
