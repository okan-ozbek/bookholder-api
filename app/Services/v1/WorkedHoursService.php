<?php

namespace app\Services\v1;

use App\Models\WorkedHours;
use Carbon\Carbon;

class WorkedHoursService
{
    public function calculateTotalWorkedTime(Carbon $startTime, Carbon $stopTime): array
    {
        $duration = $stopTime->diff($startTime);

        return [
            'hours' => $duration->h + ($duration->d * 24),
            'minutes' => $duration->i,
            'seconds' => $duration->s,
        ];
    }

    public function calculateTotalCents(array $workedTime, int $hourlyRateCents): int
    {
        return (int)round(($workedTime['hours'] + ($workedTime['minutes'] / 60) + ($workedTime['seconds'] / 3600)) * $hourlyRateCents);
    }

    public function createWorkedHours(array $data): WorkedHours
    {
        $totalWorkedTime = $this->calculateTotalWorkedTime(
            Carbon::parse($data['start_time']),
            Carbon::parse($data['stop_time'])
        );

        $hourlyRateCents = $data['rate_cents'] ?? auth()->user()->settings()->hourly_rate_cents;
        $totalCents = $this->calculateTotalCents($totalWorkedTime, $hourlyRateCents);

        return WorkedHours::create([
            'user_id' => $data['user_id'],
            'company_id' => $data['company_id'],
            'hourly_rate_cents' => $hourlyRateCents,
            'start_time' => $data['start_time'],
            'stop_time' => $data['stop_time'],
            'hours_worked' => $totalWorkedTime['hours'],
            'minutes_worked' => $totalWorkedTime['minutes'],
            'seconds_worked' => $totalWorkedTime['seconds'],
            'total_cents' => (int)round($totalCents),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function updateWorkedHours(WorkedHours $workedHours, array $data): bool
    {
        if ($this->isWorkedHoursTimeUpdated($workedHours, $data)) {
            $totalWorkedTime = $this->calculateTotalWorkedTime(
                Carbon::parse($data['start_time']),
                Carbon::parse($data['stop_time'])
            );

            $hourlyRateCents = $data['rate_cents'] ?? $workedHours->hourly_rate_cents;
            $totalCents = $this->calculateTotalCents($totalWorkedTime, $hourlyRateCents);

            $data['hours_worked'] = $totalWorkedTime['hours'];
            $data['minutes_worked'] = $totalWorkedTime['minutes'];
            $data['seconds_worked'] = $totalWorkedTime['seconds'];
            $data['total_cents'] = (int)round($totalCents);
        }

        return $workedHours->update($data);
    }

    public function deleteWorkedHours(WorkedHours $workedHours): bool
    {
        return $workedHours->delete();
    }

    public function isWorkedHoursTimeUpdated(WorkedHours $workedHours, array $data): bool
    {
        if (isset($data['start_time']) && $data['start_time'] !== $workedHours->start_time) {
            return true;
        }

        if (isset($data['stop_time']) && $data['stop_time'] !== $workedHours->stop_time) {
            return true;
        }

        return false;
    }
}
