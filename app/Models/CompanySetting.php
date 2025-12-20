<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $company_id
 * @property string $currency
 * @property int $vat_value
 * @property int $payment_terms_days
 * @property int $hourly_rate_cents
 * @property string $language
 * @property string $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereHourlyRateCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting wherePaymentTermsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CompanySetting whereVatValue($value)
 * @mixin \Eloquent
 */
class CompanySetting extends Model
{
    protected $fillable = [
        'company_id',
        'invoice_prefix',
        'default_payment_terms',
        'currency',
        'tax_rate',
    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
