<?php

namespace app\Services\v1;

use App\Models\WorkedHour;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class WorkedHourService
{
    /***
     * @param Carbon $startTime
     * @param Carbon $stopTime
     * @return array{hours: int, minutes: int, seconds: int}
     */
    public function calculateTotalWorkedTime(Carbon $startTime, Carbon $stopTime): array
    {
        $duration = $stopTime->diff($startTime);

        return [
            'hours' => $duration->h + ($duration->d * 24),
            'minutes' => $duration->i,
            'seconds' => $duration->s,
        ];
    }

    /***
     * @param array $workedTime
     * @param int $hourlyRateCents
     * @return int
     */
    public function calculateTotalCents(array $workedTime, int $hourlyRateCents): int
    {
        return (int)round(($workedTime['hours'] + ($workedTime['minutes'] / 60) + ($workedTime['seconds'] / 3600)) * $hourlyRateCents);
    }

    /***
     * @return Collection
     */
    public function listWorkedHours(): Collection
    {
        return WorkedHour::query()->get();
    }

    /***
     * @param array $data
     * @return WorkedHour
     */
    public function createWorkedHours(array $data): WorkedHour
    {
        $totalWorkedTime = $this->calculateTotalWorkedTime(
            Carbon::parse($data['start_time']),
            Carbon::parse($data['stop_time'])
        );

        $hourlyRateCents = $data['hourly_rate_cents'] ?? auth()->user()->settings()->hourly_rate_cents;
        $totalCents = $this->calculateTotalCents($totalWorkedTime, $hourlyRateCents);

        return WorkedHour::create([
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

    /***
     * @param WorkedHour $workedHours
     * @param array $data
     * @return bool
     */
    public function updateWorkedHours(WorkedHour $workedHours, array $data): bool
    {
        if ($this->isWorkedHoursTimeUpdated($workedHours, $data)) {
            $totalWorkedTime = $this->calculateTotalWorkedTime(
                Carbon::parse($data['start_time']),
                Carbon::parse($data['stop_time'])
            );

            $hourlyRateCents = $data['hourly_rate_cents'] ?? $workedHours->hourly_rate_cents;
            $totalCents = $this->calculateTotalCents($totalWorkedTime, $hourlyRateCents);

            $data['hours_worked'] = $totalWorkedTime['hours'];
            $data['minutes_worked'] = $totalWorkedTime['minutes'];
            $data['seconds_worked'] = $totalWorkedTime['seconds'];
            $data['total_cents'] = (int)round($totalCents);
        }

        return $workedHours->update($data);
    }

    /***
     * @param WorkedHour $workedHours
     * @return bool
     */
    public function deleteWorkedHours(WorkedHour $workedHours): bool
    {
        return $workedHours->delete();
    }

    /***
     * @param WorkedHour $workedHours
     * @param array $data
     * @return bool
     */
    public function isWorkedHoursTimeUpdated(WorkedHour $workedHours, array $data): bool
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
