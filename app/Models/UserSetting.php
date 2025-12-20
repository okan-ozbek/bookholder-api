<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $currency
 * @property int $vat_value
 * @property int $payment_terms_days
 * @property int $hourly_rate_cents
 * @property string $language
 * @property string $timezone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereHourlyRateCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting wherePaymentTermsDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSetting whereVatValue($value)
 * @mixin \Eloquent
 */
class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_prefix',
        'default_payment_terms',
        'currency',
        'tax_rate',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
