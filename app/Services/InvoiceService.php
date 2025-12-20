<?php

namespace App\Services;

use App\Enums\InvoiceStatusEnum;
use App\Models\Invoice;

class InvoiceService
{
    public function totalAmount(Invoice $invoice): float
    {
        return ($invoice->freelance_times->sum('hours_worked') * auth()->user()->settings()->hourly_rate_cents) / 100;
    }

    public function createInvoice(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function updateInvoice(Invoice $invoice, array $data): bool
    {
        return $invoice->update($data);
    }

    public function deleteInvoice(Invoice $invoice): bool
    {
        return $invoice->delete();
    }

    public function findInvoiceById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function listInvoices(array $filters = []): \Illuminate\Database\Eloquent\Collection
    {
        $query = Invoice::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['date_from'])) {
            $query->where('created_at', '>=', $filters['date_from']);
        }

        if (isset($filters['date_to'])) {
            $query->where('created_at', '<=', $filters['date_to']);
        }

        return $query->get();
    }

    public function markInvoiceAsPaid(Invoice $invoice): bool
    {
        $invoice->status = InvoiceStatusEnum::PAID->value;

        return $invoice->save();
    }

    public function markInvoiceAsCancelled(Invoice $invoice): bool
    {
        $invoice->status = InvoiceStatusEnum::CANCELLED->value;

        return $invoice->save();
    }

    public function markInvoiceAsOverdue(Invoice $invoice): bool
    {
        $invoice->status = InvoiceStatusEnum::OVERDUE->value;

        return $invoice->save();
    }

    public function isInvoiceOverdue(Invoice $invoice): bool
    {
        if ($invoice->status === InvoiceStatusEnum::OVERDUE->value) {
            return true;
        }

        if ( $invoice->status !== InvoiceStatusEnum::PAID->value && $invoice->due_date < now()) {
            return true;
        }

        return false;
    }
}
