<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/api/v1')->group(function () {
    Route::get('/status', static function () {
        return response()->json(['status' => 'API is running']);
    });

    Route::get('/invoices', [\app\Http\Controllers\v1\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [\app\Http\Controllers\v1\InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices', [\app\Http\Controllers\v1\InvoiceController::class, 'store'])->name('invoices.store');
    Route::put('/invoices/{id}', [\app\Http\Controllers\v1\InvoiceController::class, 'update'])->name('invoices.update');
    Route::patch('/invoices/{id}/paid', [\app\Http\Controllers\v1\InvoiceController::class, 'setPaid'])->name('invoices.setPaid');
    Route::patch('/invoices/{id}/cancelled', [\app\Http\Controllers\v1\InvoiceController::class, 'setCancelled'])->name('invoices.setCancelled');
    Route::patch('/invoices/{id}/overdue', [\app\Http\Controllers\v1\InvoiceController::class, 'setOverdue'])->name('invoices.setOverdue');
    Route::delete('/invoices/{id}', [\app\Http\Controllers\v1\InvoiceController::class, 'destroy'])->name('invoices.destroy');

    Route::get('/worked-hours', [\app\Http\Controllers\v1\WorkedHoursController::class, 'index'])->name('workedHours.index');
    Route::get('/worked-hours/{id}', [\app\Http\Controllers\v1\WorkedHoursController::class, 'show'])->name('workedHours.show');
    Route::post('/worked-hours', [\app\Http\Controllers\v1\WorkedHoursController::class, 'store'])->name('workedHours.store');
    Route::put('/worked-hours/{id}', [\app\Http\Controllers\v1\WorkedHoursController::class, 'update'])->name('workedHours.update');
    Route::delete('/worked-hours/{id}', [\app\Http\Controllers\v1\WorkedHoursController::class, 'destroy'])->name('workedHours.destroy');
});
