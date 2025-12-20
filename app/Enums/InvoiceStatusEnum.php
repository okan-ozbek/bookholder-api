<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';

    public static function isFinalStatus(InvoiceStatusEnum $status): bool
    {
        return in_array($status, [self::PAID, self::CANCELLED]);
    }

    public static function values(): array
    {
        return array_map(static fn($case) => $case->value, self::cases());
    }
}
