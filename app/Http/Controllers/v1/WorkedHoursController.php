<?php

namespace app\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateWorkedHourRequest;
use App\Http\Requests\v1\UpdateWorkedHourRequest;
use App\Models\WorkedHour;
use app\Services\v1\WorkedHourService;
use Illuminate\Http\JsonResponse;

class WorkedHoursController extends Controller
{
    public function __construct(private readonly WorkedHourService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->listWorkedHours());
    }

    public function show(WorkedHour $workedHours): JsonResponse
    {
        return response()->json($workedHours->toArray());
    }

    public function store(CreateWorkedHourRequest $request): JsonResponse
    {
        $workedHours = $this->service->createWorkedHours($request->validated()->toArray());

        return response()->json([
            'message' => 'Worked hours entry created successfully',
            'url' => route('workedHours.show', ['id' => $workedHours->id])
        ], 201);
    }

    public function update(UpdateWorkedHourRequest $request, WorkedHour $workedHours): JsonResponse
    {
        $this->service->updateWorkedHours($workedHours, $request->validated()->toArray());

        return response()->json([
            'message' => 'Worked hours entry updated successfully',
            'url' => route('workedHours.show', ['id' => $workedHours->id])
        ]);
    }

    public function destroy(WorkedHour $workedHours): JsonResponse
    {
        $this->service->deleteWorkedHours($workedHours);

        return response()->json(['message' => 'Worked hours entry deleted successfully']);
    }
}
