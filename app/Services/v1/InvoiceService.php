<?php

namespace app\Services\v1;

use App\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use App\Models\WorkedHours;
use Illuminate\Support\Collection;

class InvoiceService
{
    /***
     * Calculate the total amount for the given invoice based on worked hours
     * If a worked hour overlaps with the invoice period, only the overlapping portion is counted
     * If a worked hour is completely outside the invoice period, it is ignored
     * If it is partially overlapping, only the overlapping portion is counted
     *
     * @param Invoice $invoice
     * @return float Total amount in dollars
     */
    public function totalAmount(Invoice $invoice): float
    {
        $workedHours = WorkedHours::where('company_id', $invoice->company_id)
            ->where('user_id', $invoice->client_id)
            ->where(function ($query) use ($invoice) {
                $query->whereBetween('start_time', [$invoice->from_time, $invoice->to_time])
                    ->orWhereBetween('stop_time', [$invoice->from_time, $invoice->to_time])
                    ->orWhere(function ($q) use ($invoice) {
                        $q->where('start_time', '<', $invoice->from_time)
                            ->where('stop_time', '>', $invoice->to_time);
                    });
            })
            ->get();

        $totalCents = 0;
        foreach ($workedHours as $workedHour) {
            if ($workedHour->start_time >= $invoice->from_time && $workedHour->stop_time <= $invoice->to_time) {
                $totalCents += $workedHour->total_cents;
                continue;
            }

            $startTime = max($workedHour->start_time, $invoice->from_time);
            $stopTime = min($workedHour->stop_time, $invoice->to_time);

            $duration = $stopTime->diffInSeconds($startTime);
            $hourlyRatePerSecond = $workedHour->hourly_rate_cents / 3600;

            $totalCents += $duration * $hourlyRatePerSecond;
        }

        return $totalCents / 100;
    }

    /***
     * @param array $data
     * @return Invoice
     */
    public function createInvoice(array $data): Invoice
    {
        return Invoice::create($data);
    }

    /***
     * @param Invoice $invoice
     * @param array $data
     * @return bool True if updated, false otherwise
     */
    public function updateInvoice(Invoice $invoice, array $data): bool
    {
        return $invoice->update($data);
    }

    /***
     * @param Invoice $invoice
     * @return bool True if deleted, false otherwise
     */
    public function deleteInvoice(Invoice $invoice): bool
    {
        return $invoice->delete();
    }

    /***
     * @param int $id
     * @return Invoice|null
     */
    public function findInvoiceById(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    /***
     *  Possible filters:
     *  - status: InvoiceStatusEnum
     *  - date_from: string (YYYY-MM-DD)
     *  - date_to: string (YYYY-MM-DD)
     *
     * @param array $filters
     * @return Collection
     */
    public function listInvoices(array $filters = []): Collection
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

    /***
     * @param Invoice $invoice
     * @param InvoiceStatusEnum $status
     * @return bool True if status changed, false if not (e.g. already final status)
     */
    public function changeInvoiceStatus(Invoice $invoice, InvoiceStatusEnum $status): bool
    {
        if (InvoiceStatusEnum::isFinalStatus($invoice->status)) {
            return false;
        }

        $invoice->status = $status->value;

        return $invoice->save();
    }
}
